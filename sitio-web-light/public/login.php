<?php
session_start();

// Incluir la conexión a la base de datos
require_once __DIR__ . '/../private/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar consulta (evitar inyección SQL)
    $stmt = $conn->prepare("SELECT ID, USERNAME, CONTRASEÑA, NOMBRE, ROL FROM USUARIO WHERE USERNAME = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        // Vincular resultados
        $stmt->bind_result($id, $db_username, $db_password, $nombre, $rol);

        if ($stmt->fetch() && $password === $db_password) {
            // Credenciales correctas
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $db_username;
            $_SESSION['nombre'] = $nombre;
            $_SESSION['rol'] = $rol;

            // Redirigir según el rol
            if ($rol === 'admin') {
                header("Location: ../private/dashboard.php");
            } else {
                header("Location: ../private/dashboard.php");
            }
            exit;
        }
    }

    // Si llegamos aquí, credenciales inválidas
    $error = "Usuario o contraseña incorrectos";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hotel "El Paraíso"</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-logo img {
            width: 100px;
        }
    </style>
</head>
<body style="background-image: url('assets/img/hotel.png'); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="container">
        <div class="login-container">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="login-logo">
                        <img src="assets/img/logo.png" alt="Hotel El Paraíso">
                        <h4 class="mt-2">Hotel "El Paraíso"</h4>
                        <p class="text-muted">Acceso para empleados</p>
                    </div>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="index.php" class="btn btn-primary">Volver al sitio público</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>