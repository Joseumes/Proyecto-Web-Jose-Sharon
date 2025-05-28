<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}
require_once __DIR__ . '/../private/db.php';
$habitacion = isset($_GET['habitacion']) ? $_GET['habitacion'] : '';
$mensaje_exito = '';
$total_servicios = 0;
$total_final = 0;

// Función para obtener datos del cliente y calcular totales
function getClienteData($conn, $habitacion, &$cliente, &$dias, &$total_base, &$total_servicios, &$total_final) {
    $query_hospedaje = "
        SELECT h.id_cliente, c.Nombre, c.Nit, hs.FECHA_CHECKIN 
        FROM HABITACION h
        JOIN CLIENTE c ON h.id_cliente = c.ID
        JOIN HOSPEDAJE hs ON hs.ID_CLIENTE = c.ID AND hs.NUMERO_HABITACION = h.Numero
        WHERE h.Numero = ?
        ORDER BY hs.FECHA_CHECKIN DESC
        LIMIT 1
    ";
    $stmt = $conn->prepare($query_hospedaje);
    $stmt->bind_param("i", $habitacion);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
        $id_cliente = $cliente['id_cliente'];
        $fecha_checkin = new DateTime($cliente['FECHA_CHECKIN']);
        $dias = $fecha_checkin->diff(new DateTime())->days;
        $dias = $dias === 0 ? 1 : $dias;
        $total_base = $dias * 350;

        // Servicios extras
        $query_servicios = "
            SELECT cs.Cantidad, s.Precio
            FROM CLIENTESERVICIO cs
            JOIN SERVICIO s ON cs.ID_Servicio = s.ID
            WHERE cs.id_hospedaje IN (
                SELECT ID FROM HOSPEDAJE WHERE ID_Cliente = ?
            )
        ";
        $stmt_servicios = $conn->prepare($query_servicios);
        $stmt_servicios->bind_param("i", $id_cliente);
        $stmt_servicios->execute();
        $result_servicios = $stmt_servicios->get_result();
        $total_servicios = 0;
        while ($row = $result_servicios->fetch_assoc()) {
            $total_servicios += $row['Cantidad'] * $row['Precio'];
        }
        $total_final = $total_base + $total_servicios;
        return true;
    } else {
        return false;
    }
}

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitacion = $_POST['habitacion'];
    $cliente = [];
    $dias = 0;
    $total_base = 0;
    $total_servicios = 0;
    $total_final = 0;

    if (getClienteData($conn, $habitacion, $cliente, $dias, $total_base, $total_servicios, $total_final)) {
        $id_cliente = $cliente['id_cliente'];

        // Actualizar estado de la habitación
        $update_habitacion = $conn->prepare("UPDATE HABITACION SET Estado = 'disponible', id_cliente = NULL WHERE Numero = ?");
        $update_habitacion->bind_param("i", $habitacion);
        $update_habitacion->execute();

        // Actualizar checkout
        $update_checkout = $conn->prepare("UPDATE HOSPEDAJE SET fecha_checkout = NOW(), Total_Pagado = ? WHERE ID_Cliente = ?");
        $update_checkout->bind_param("di", $total_final, $id_cliente);
        $update_checkout->execute();

        // Limpiar servicios del cliente
        $delete_servicios = $conn->prepare("DELETE FROM CLIENTESERVICIO WHERE id_hospedaje IN (SELECT ID FROM HOSPEDAJE WHERE ID_Cliente = ?)");
        $delete_servicios->bind_param("i", $id_cliente);
        $delete_servicios->execute();

        // Guardar mensaje y redirigir
        $_SESSION['mensaje'] = "Salida registrada. Habitación $habitacion liberada.";
        $_SESSION['total_pagar'] = $total_final;
        header("Location: habitaciones.php");
        exit;
    } else {
        die("No hay cliente hospedado en esta habitación.");
    }
}

// Cargar datos si viene desde GET
if (isset($_GET['habitacion'])) {
    $cliente = [];
    $dias = 0;
    $total_base = 0;
    $total_servicios = 0;
    $total_final = 0;

    if (!getClienteData($conn, $habitacion, $cliente, $dias, $total_base, $total_servicios, $total_final)) {
        $cliente = null;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Salida - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css ">
    <style>
        body.bg-dark.text-white {
            background-color: #1e1e1e;
            color: white;
        }
        .form-control {
            background-color: #2c2c2c;
            color: white;
            border: 1px solid #444;
        }
    </style>
</head>
<body class="bg-dark text-white">
<div class="container-fluid">
    <div class="row">
        <?php include('sidebar.php'); ?>
        <div class="col-md-9 col-lg-10 p-4">
            <h2><i class="fas fa-sign-out-alt me-2"></i> Registrar Salida de Cliente</h2>
            <div class="card shadow mt-4">
                <div class="card-body">
                    <form method="POST" action="salida_cliente.php">
                        <input type="hidden" name="habitacion" value="<?= $habitacion; ?>">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Número de Habitación</label>
                                <input type="text" class="form-control" value="<?= $habitacion; ?>" readonly required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Salida*</label>
                                <input type="datetime-local" class="form-control" name="fecha_salida" required>
                            </div>
                        </div>

                        <?php
                        require_once __DIR__ . '/../private/db.php';
                        $query_cliente = "
                            SELECT h.id_cliente, c.Nombre, c.Nit, hs.FECHA_CHECKIN 
                            FROM HABITACION h
                            JOIN CLIENTE c ON h.id_cliente = c.ID
                            JOIN HOSPEDAJE hs ON hs.ID_CLIENTE = c.ID AND hs.NUMERO_HABITACION = h.Numero
                            WHERE h.Numero = ?
                            ORDER BY hs.FECHA_CHECKIN DESC
                            LIMIT 1
                        ";
                        $stmt_cliente = $conn->prepare($query_cliente);
                        $stmt_cliente->bind_param("i", $habitacion);
                        $stmt_cliente->execute();
                        $cliente_result = $stmt_cliente->get_result();

                        if ($cliente_result->num_rows > 0):
                            $cliente = $cliente_result->fetch_assoc();
                            $fecha_checkin = new DateTime($cliente['FECHA_CHECKIN']);
                            $dias = $fecha_checkin->diff(new DateTime())->days;
                            $dias = $dias === 0 ? 1 : $dias;
                            $total_base = $dias * 350;
                        ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del Cliente</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($cliente['Nombre']); ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIT</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($cliente['Nit']); ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Ingreso</label>
                                <input type="text" class="form-control" value="<?= $cliente['FECHA_CHECKIN']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Noches de Hospedaje</label>
                                <input type="text" class="form-control" value="<?= $dias; ?>" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Costo por Noche</label>
                                <input type="text" class="form-control" value="Q350.00" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total Hospedaje</label>
                                <input type="text" class="form-control" value="Q<?= number_format($total_base, 2); ?>" readonly>
                            </div>
                        </div>

                        <!-- Servicios Adicionales -->
                        <div class="card mb-3">
                            <div class="card-header bg-light text-dark">
                                <h6 class="mb-0">Servicios Adicionales</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Servicio</th>
                                                <th>Cantidad</th>
                                                <th>Precio Unitario</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query_servicios = "
                                                SELECT cs.Cantidad, s.Nombre, s.Precio
                                                FROM CLIENTESERVICIO cs
                                                JOIN SERVICIO s ON cs.ID_Servicio = s.ID
                                                WHERE cs.id_hospedaje IN (
                                                    SELECT ID FROM HOSPEDAJE WHERE ID_Cliente = {$cliente['id_cliente']}
                                                )";

                                            $servicios_result = $conn->query($query_servicios);

                                            if ($servicios_result && $servicios_result->num_rows > 0):
                                                while ($servicio = $servicios_result->fetch_assoc()):
                                                    $subtotal = $servicio['Cantidad'] * $servicio['Precio'];
                                                    ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($servicio['Nombre']); ?></td>
                                                        <td><?= $servicio['Cantidad']; ?></td>
                                                        <td>Q<?= number_format($servicio['Precio'], 2); ?></td>
                                                        <td>Q<?= number_format($subtotal, 2); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr><td colspan="4" class="text-center">Sin servicios adicionales</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3">Total Servicios</th>
                                                <th>Q<?= number_format($total_servicios, 2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Totales -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Total a Pagar</label>
                                <input type="text" class="form-control fw-bold fs-4" value="Q<?= number_format($total_final, 2); ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Método de Pago</label>
                                <select class="form-select" name="metodo_pago" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                                    <option value="transferencia">Transferencia Bancaria</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Comentarios/Notas</label>
                            <textarea class="form-control" name="comentarios" rows="2"></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="habitaciones.php" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Registrar Salida</button>
                                                    <div class="text-end">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-check-circle me-2"></i> Registrar Salida
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">No hay cliente en esta habitación.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const now = new Date();
        const fechaHora = now.toISOString().slice(0, 16);
        document.querySelector('input[name="fecha_salida"]').value = fechaHora;
    });
</script>
</body>
</html>