<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

$servicios = [
    'Desayuno' => 30,
    'Almuerzo' => 65,
    'Cena' => 75,
    'Masaje' => 150,
    'Spa' => 300,
    'Lavanderia' => 50,
    'Tour guiado' => 120,
    'Transporte' => 100
];


$mensaje = "";
$clienteSeleccionado = null;
$habitacionSeleccionada = null;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar_servicios'])) {
        $habitacion = $_POST['habitacion'];
        $nombreCliente = $_POST['nombre_cliente'];
        $cargosSeleccionados = $_POST['cargos'] ?? [];
        
        $totalExtras = 0;
        foreach ($cargosSeleccionados as $cargo) {
            if (isset($servicios[$cargo])) {
                $totalExtras += $servicios[$cargo];
            }
        }
        
        if (!isset($_SESSION['cargos_clientes'])) {
            $_SESSION['cargos_clientes'] = [];
        }
        
        if (!isset($_SESSION['cargos_clientes'][$habitacion])) {
            $_SESSION['cargos_clientes'][$habitacion] = [];
        }
        
        foreach ($cargosSeleccionados as $cargo) {
            $_SESSION['cargos_clientes'][$habitacion][] = [
                'servicio' => $cargo,
                'precio' => $servicios[$cargo],
                'fecha' => date('Y-m-d H:i:s')
            ];
        }
        
        $mensaje = "Servicios agregados correctamente a la habitación $habitacion. Total: Q$totalExtras.00";
    }
}

$habitacionesOcupadas = [
    '101' => 'Juan Pérez',
    '102' => 'María Gómez',
    '105' => 'Carlos Ruiz',
    '107' => 'Ana Martínez',
    '108' => 'Luis Díaz'
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Cargos - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('sidebar.php'); ?>

            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4"><i class="fas fa-money-bill-wave me-2"></i> Actualizar Cargos por Servicios</h2>
                
                <?php if ($mensaje): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo $mensaje; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Seleccionar Cliente</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="actualizar_cargos.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Habitación</label>
                                    <select class="form-select" name="habitacion" required>
                                        <option value="">Seleccionar habitación...</option>
                                        <?php foreach ($habitacionesOcupadas as $num => $nombre): ?>
                                        <option value="<?php echo $num; ?>" <?php echo (isset($_GET['habitacion']) && $_GET['habitacion'] == $num) ? 'selected' : ''; ?>>
                                            <?php echo "$num - $nombre"; ?>
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

                <?php if (isset($_GET['habitacion']) && array_key_exists($_GET['habitacion'], $habitacionesOcupadas)): 
                    $habitacionSeleccionada = $_GET['habitacion'];
                    $clienteSeleccionado = $habitacionesOcupadas[$habitacionSeleccionada];
                ?>
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Agregar Servicios a <?php echo $clienteSeleccionado; ?> (Hab. <?php echo $habitacionSeleccionada; ?>)</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="actualizar_cargos.php">
                            <input type="hidden" name="habitacion" value="<?php echo $habitacionSeleccionada; ?>">
                            <input type="hidden" name="nombre_cliente" value="<?php echo $clienteSeleccionado; ?>">
                            
                            <div class="row mb-3">
                                <div class="col-12">
                                    <p class="fw-bold">Seleccione los servicios consumidos:</p>
                                    <div class="row">
                                        <?php foreach ($servicios as $nombre => $precio): ?>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="cargos[]" 
                                                    value="<?php echo $nombre; ?>" id="serv-<?php echo strtolower(str_replace(' ', '-', $nombre)); ?>">
                                                <label class="form-check-label" for="serv-<?php echo strtolower(str_replace(' ', '-', $nombre)); ?>">
                                                    <?php echo $nombre; ?> (Q<?php echo $precio; ?>.00)
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

                <?php if (isset($_SESSION['cargos_clientes'][$habitacionSeleccionada])): ?>
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
                                    <?php 
                                    $totalCargos = 0;
                                    foreach ($_SESSION['cargos_clientes'][$habitacionSeleccionada] as $cargo): 
                                        $totalCargos += $cargo['precio'];
                                    ?>
                                    <tr>
                                        <td><?php echo $cargo['fecha']; ?></td>
                                        <td><?php echo $cargo['servicio']; ?></td>
                                        <td>Q<?php echo $cargo['precio']; ?>.00</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th>Q<?php echo $totalCargos; ?>.00</th>
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