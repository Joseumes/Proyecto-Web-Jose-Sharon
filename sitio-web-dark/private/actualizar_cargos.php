<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

// Conectar a la base de datos
require_once __DIR__ . '/../private/db.php';

// Cargar servicios desde la base de datos
$servicios = [];
$sql = "SELECT ID, NOMBRE, PRECIO FROM SERVICIO";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $servicios[$row['ID']] = ['nombre' => $row['NOMBRE'], 'precio' => $row['PRECIO']];
}

$mensaje = "";
$clienteSeleccionado = null;
$habitacionSeleccionada = null;

// Procesar formulario de agregar servicios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_servicios'])) {
    $habitacion = $conn->real_escape_string($_POST['habitacion']);
    $id_cliente = null;

    // Obtener id_cliente desde la habitación
    $sql = "SELECT id_cliente FROM HABITACION WHERE NUMERO = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $habitacion);
    $stmt->execute();
    $stmt->bind_result($id_cliente);
    $stmt->fetch();
    $stmt->close();

    if (!$id_cliente) {
        $mensaje = "Cliente no encontrado para la habitación seleccionada.";
    } else {
        // Obtener hospedaje activo
        $sql = "SELECT ID FROM HOSPEDAJE WHERE ID_Cliente = ? AND FECHA_CHECKOUT IS NULL ORDER BY FECHA_CHECKIN DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $stmt->bind_result($id_hospedaje);
        $stmt->fetch();
        $stmt->close();

        if (!$id_hospedaje) {
            $mensaje = "No se encontró un hospedaje activo para este cliente.";
        } else {
            $totalExtras = 0;
            $selectedServices = $_POST['cargos'] ?? [];

            foreach ($selectedServices as $id_servicio) {
                if (isset($servicios[$id_servicio])) {
                    $precio = $servicios[$id_servicio]['precio'];
                    $totalExtras += $precio;

                    // Insertar servicio en CLIENTESERVICIO
                    $sql = "INSERT INTO CLIENTESERVICIO (ID_HOSPEDAJE, ID_SERVICIO, FECHA) VALUES (?, ?, NOW())";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $id_hospedaje, $id_servicio);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            // Actualizar total_cargos en CLIENTE
            $sql = "UPDATE CLIENTE SET total_cargos = total_cargos + ? WHERE ID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $totalExtras, $id_cliente);
            $stmt->execute();
            $stmt->close();

            $mensaje = "Servicios agregados correctamente a la habitación $habitacion. Total: Q$totalExtras.00";
        }
    }
}

// Obtener clientes que están en habitaciones ocupadas
$clientesEnHabitaciones = [];

$sql = "SELECT c.ID, c.NOMBRE, h.NUMERO 
        FROM CLIENTE c
        INNER JOIN HABITACION h ON c.ID = h.id_cliente
        WHERE h.ESTADO = 'ocupada'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clientesEnHabitaciones[$row['ID']] = [
            'nombre' => $row['NOMBRE'],
            'habitacion' => $row['NUMERO']
        ];
    }
} else {
    $mensajeNoClientes = "No hay clientes en habitaciones ocupadas.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cargos - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css ">
</head>
<body class="bg-dark text-white">
    <div class="container-fluid">
        <div class="row">
            <?php include('sidebar.php'); ?>
            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4"><i class="fas fa-money-bill-wave me-2"></i> Actualizar Cargos por Servicios</h2>
                <?php if ($mensaje): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= htmlspecialchars($mensaje); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <!-- Seleccionar Cliente -->
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Seleccionar Cliente</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="actualizar_cargos.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Cliente en Habitación Ocupada</label>
                                    <select class="form-select" name="cliente_id" required>
                                        <option value="">Seleccionar cliente...</option>
                                        <?php foreach ($clientesEnHabitaciones as $id => $cliente): ?>
                                        <option value="<?= $id ?>" <?= (isset($_GET['cliente_id']) && $_GET['cliente_id'] == $id) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cliente['nombre']) ?> - Hab. <?= $cliente['habitacion'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i> Buscar Cliente
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Formulario de Agregar Servicios -->
                <?php if (isset($_GET['cliente_id']) && array_key_exists($_GET['cliente_id'], $clientesEnHabitaciones)): 
                    $clienteDatos = $clientesEnHabitaciones[$_GET['cliente_id']];
                    $clienteSeleccionado = $clienteDatos['nombre'];
                    $habitacionSeleccionada = $clienteDatos['habitacion'];

                    // Obtener historial de cargos del cliente
                    $cargosBD = [];
                    $totalCargos = 0;

                    $sql = "SELECT s.NOMBRE, s.PRECIO, cs.FECHA 
                            FROM CLIENTESERVICIO cs
                            JOIN SERVICIO s ON cs.ID_SERVICIO = s.ID
                            WHERE cs.ID_HOSPEDAJE IN (
                                SELECT ID FROM HOSPEDAJE 
                                WHERE ID_Cliente = ?
                            )";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $_GET['cliente_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $cargosBD[] = $row;
                        $totalCargos += $row['PRECIO'];
                    }
                ?>
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Agregar Servicios a <?= htmlspecialchars($clienteSeleccionado) ?> (Hab. <?= $habitacionSeleccionada ?>)</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="actualizar_cargos.php">
                            <input type="hidden" name="habitacion" value="<?= $habitacionSeleccionada ?>">
                            <input type="hidden" name="nombre_cliente" value="<?= htmlspecialchars($clienteSeleccionado) ?>">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <p class="fw-bold">Seleccione los servicios consumidos:</p>
                                    <div class="row">
                                        <?php foreach ($servicios as $id => $s): ?>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="cargos[]" value="<?= $id ?>" id="serv-<?= $id ?>">
                                                <label class="form-check-label" for="serv-<?= $id ?>">
                                                    <?= htmlspecialchars($s['nombre']) ?> (Q<?= number_format($s['precio'], 2) ?>)
                                                </label>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="form-label">Comentarios/Notas</label>
                                    <textarea class="form-control" name="comentarios" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" name="agregar_servicios" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Guardar Cargos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Historial de cargos -->
                <?php if (!empty($cargosBD)): ?>
                <div class="card shadow mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Historial de Cargos</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Servicio</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cargosBD as $cargo): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cargo['FECHA']) ?></td>
                                        <td><?= htmlspecialchars($cargo['NOMBRE']) ?></td>
                                        <td>Q<?= number_format($cargo['PRECIO'], 2) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th>Q<?= number_format($totalCargos, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>