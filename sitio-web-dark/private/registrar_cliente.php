<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../login.php");
    exit;
}

// Incluir conexión a la base de datos
require_once __DIR__ . '/../private/db.php';

$nombre = $nit = $fecha_nacimiento = '';
$telefono = $email = $direccion = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $conn->real_escape_string(trim($_POST['nombre']));
    $nit = $conn->real_escape_string(trim($_POST['nit']));
    $fecha_nacimiento = $conn->real_escape_string(trim($_POST['fecha_nacimiento']));
    $telefono = $conn->real_escape_string(trim($_POST['telefono']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $direccion = $conn->real_escape_string(trim($_POST['direccion']));
    $fecha_registro = $conn->real_escape_string(trim($_POST['fecha_registro'])); // Nuevo campo

    // Validar edad
    $nacimiento = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($nacimiento)->y;

    if ($edad < 18) {
        die("Solo se aceptan huéspedes mayores de 18 años.");
    }

    // Llamar al procedimiento almacenado
    $stmt = $conn->prepare("CALL asignar_habitacion(?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssss", // 7 parámetros
        $nombre,
        $nit,
        $fecha_nacimiento,
        $telefono,
        $email,
        $direccion,
        $fecha_registro
    );

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (isset($row['HabitacionAsignada'])) {
            $_SESSION['mensaje'] = "Cliente registrado en habitación " . $row['HabitacionAsignada'];
            header("Location: habitaciones.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'>" . $row['mensaje'] . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error al llamar al procedimiento</div>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cliente - Hotel El Paraíso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css ">
</head>
<body class="bg-dark text-white">
<div class="container-fluid">
    <div class="row">
        <?php include('sidebar.php'); ?>
        <div class="col-md-9 col-lg-10 p-4">
            <h2><i class="fas fa-user-plus me-2"></i>Registrar Nuevo Cliente</h2>
            <div class="card shadow mt-4">
                <div class="card-body">
                    <form method="POST" action="registrar_cliente.php">
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

                        <!-- Campo nuevo: Fecha de Registro -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Registro</label>
                                <input type="datetime-local" class="form-control" name="fecha_registro" id="fecha_registro" required readonly>
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

<!-- Script para rellenar automáticamente la fecha y hora -->
<script>
    function setDateTimeNow() {
        const now = new Date();
        const offset = now.getTimezoneOffset() * 60000; // Milisegundos
        const localDate = new Date(now - offset); // Ajuste para hora local
        document.getElementById('fecha_registro').value = localDate.toISOString().slice(0, 16);
    }

    window.onload = setDateTimeNow;
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>