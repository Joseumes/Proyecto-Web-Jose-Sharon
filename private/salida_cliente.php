<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitacion = $_POST['habitacion'];
    
    $_SESSION['mensaje'] = "Salida del cliente registrada correctamente. Habitación $habitacion liberada.";
    header("Location: habitaciones.php");
    exit;
}

$habitacion = isset($_GET['habitacion']) ? $_GET['habitacion'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida de Cliente - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('sidebar.php'); ?>

            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4"><i class="fas fa-sign-out-alt me-2"></i> Registrar Salida de Cliente</h2>
                
                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" action="salida_cliente.php">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Número de Habitación</label>
                                    <input type="text" class="form-control" name="habitacion" value="<?php echo $habitacion; ?>" required readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Salida*</label>
                                    <input type="datetime-local" class="form-control" name="fecha_salida" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre del Cliente</label>
                                    <input type="text" class="form-control" value="Juan Pérez" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIT</label>
                                    <input type="text" class="form-control" value="1234567-8" readonly>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Ingreso</label>
                                    <input type="text" class="form-control" value="2023-10-15" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Noches de Hospedaje</label>
                                    <input type="text" class="form-control" value="2" readonly>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Costo por Noche</label>
                                    <input type="text" class="form-control" value="Q350.00" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Total Hospedaje</label>
                                    <input type="text" class="form-control" value="Q700.00" readonly>
                                </div>
                            </div>
                            
                            <div class="card mb-3">
                                <div class="card-header bg-light">
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
                                                <tr>
                                                    <td>Desayuno</td>
                                                    <td>2</td>
                                                    <td>Q30.00</td>
                                                    <td>Q60.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Almuerzo</td>
                                                    <td>1</td>
                                                    <td>Q65.00</td>
                                                    <td>Q65.00</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3">Total Servicios</th>
                                                    <th>Q125.00</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Total a Pagar</label>
                                    <input type="text" class="form-control fw-bold fs-4" value="Q825.00" readonly>
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const fechaHora = now.toISOString().slice(0, 16);
            document.querySelector('input[name="fecha_salida"]').value = fechaHora;
        });
    </script>
</body>
</html>