<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $habitacion = $_POST['habitacion'];
    $nombre = $_POST['nombre'];
    $nit = $_POST['nit'];
    
    $_SESSION['mensaje'] = "Cliente registrado exitosamente en habitación $habitacion";
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
    <title>Registrar Cliente - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('sidebar.php'); ?>

            <div class="col-md-9 col-lg-10 p-4">
                <h2 class="mb-4"><i class="fas fa-user-plus me-2"></i> Registrar Nuevo Cliente</h2>
                
                <div class="card shadow">
                    <div class="card-body">
                        <form method="POST" action="registrar_cliente.php">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Número de Habitación</label>
                                    <input type="text" class="form-control" name="habitacion" value="<?php echo $habitacion; ?>" required readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Registro</label>
                                    <input type="datetime-local" class="form-control" name="fecha_registro" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre Completo*</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIT*</label>
                                    <input type="text" class="form-control" name="nit" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de Nacimiento*</label>
                                    <input type="date" class="form-control" name="fecha_nacimiento" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Teléfono*</label>
                                    <input type="tel" class="form-control" name="telefono" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" name="direccion">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Comentarios/Requerimientos Especiales</label>
                                <textarea class="form-control" name="comentarios" rows="3"></textarea>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="habitaciones.php" class="btn btn-secondary me-md-2">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Registrar Cliente</button>
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
            document.querySelector('input[name="fecha_registro"]').value = fechaHora;
        });
    </script>
</body>
</html>