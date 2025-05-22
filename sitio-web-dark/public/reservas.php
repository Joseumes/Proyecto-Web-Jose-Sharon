<?php
session_start();

// Incluir archivo de conexión a la base de datos
require_once __DIR__ . '/../private/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpiar y obtener los datos del formulario
    $nombre = isset($_POST['nombre']) ? $conn->real_escape_string(trim($_POST['nombre'])) : '';
    $nit = isset($_POST['nit']) ? $conn->real_escape_string(trim($_POST['nit'])) : '';
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $conn->real_escape_string(trim($_POST['fecha_nacimiento'])) : '';
    $telefono = isset($_POST['telefono']) ? $conn->real_escape_string(trim($_POST['telefono'])) : '';
    $fecha_ingreso = isset($_POST['fecha_ingreso']) ? $conn->real_escape_string(trim($_POST['fecha_ingreso'])) : '';
    $fecha_salida = isset($_POST['fecha_salida']) ? $conn->real_escape_string(trim($_POST['fecha_salida'])) : '';
    $comentarios = isset($_POST['comentarios']) ? $conn->real_escape_string(trim($_POST['comentarios'])) : '';

    $errores = [];

    if (empty($nombre)) {
        $errores[] = "El nombre es requerido";
    }

    if (empty($nit)) {
        $errores[] = "El NIT es requerido";
    }

    if (empty($fecha_nacimiento) || !strtotime($fecha_nacimiento)) {
        $errores[] = "Fecha de nacimiento inválida";
    } else {
        $nacimiento = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($nacimiento)->y;

        if ($edad < 18) {
            $errores[] = "Debe ser mayor de 18 años para reservar";
        }
    }

    if (empty($fecha_ingreso) || !strtotime($fecha_ingreso) || empty($fecha_salida) || !strtotime($fecha_salida)) {
        $errores[] = "Fechas de estadía inválidas";
    } else {
        $ingreso = new DateTime($fecha_ingreso);
        $salida = new DateTime($fecha_salida);

        if ($salida < $ingreso) {
            $errores[] = "La fecha de salida no puede ser anterior a la de ingreso";
        }
    }

    if (empty($errores)) {
        // Calcular días y total
        $dias = $ingreso->diff($salida)->days;
        if ($dias == 0) $dias = 1;
        $total = $dias * 350;

        // Insertar en la base de datos
        $estado = 'pendiente'; // Estado inicial de la reserva
        $query = "INSERT INTO RESERVA (
                    nombre, nit, fecha_nacimiento, telefono, 
                    fecha_ingreso, fecha_salida, estado, fecha_creacion
                  ) VALUES (
                    '$nombre', '$nit', '$fecha_nacimiento', '$telefono',
                    '$fecha_ingreso', '$fecha_salida', '$estado', NOW()
                  )";

        if ($conn->query($query) === TRUE) {
            // Guardar datos en sesión para mostrar en confirmación
            $_SESSION['reserva'] = [
                'nombre' => $nombre,
                'nit' => $nit,
                'edad' => $edad,
                'telefono' => $telefono,
                'fecha_ingreso' => $fecha_ingreso,
                'fecha_salida' => $fecha_salida,
                'dias' => $dias,
                'total' => $total,
                'comentarios' => $comentarios
            ];

            // Redirigir a página de confirmación
            header("Location: confirmacion_reserva.php");
            exit();
        } else {
            $errores[] = "Error al guardar la reserva: " . $conn->error;
        }
    }

    // Si hay errores, puedes almacenarlos en sesión o mostrarlos
    $_SESSION['errores'] = $errores;
}

// Si algo falló, regresa al index
header("Location: index.php");
exit();
?>