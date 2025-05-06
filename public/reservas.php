<?php
// Iniciar sesión
session_start();

// Configuración básica para manejo de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y sanitizar los datos de entrada
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $nit = filter_input(INPUT_POST, 'nit', FILTER_SANITIZE_STRING);
    $fecha_nacimiento = filter_input(INPUT_POST, 'fecha_nacimiento', FILTER_SANITIZE_STRING);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $fecha_ingreso = filter_input(INPUT_POST, 'fecha_ingreso', FILTER_SANITIZE_STRING);
    $fecha_salida = filter_input(INPUT_POST, 'fecha_salida', FILTER_SANITIZE_STRING);
    $comentarios = filter_input(INPUT_POST, 'comentarios', FILTER_SANITIZE_STRING);

    // Validaciones adicionales
    $errores = [];

    if (empty($nombre)) {
        $errores[] = "El nombre es requerido";
    }

    if (empty($nit)) {
        $errores[] = "El NIT es requerido";
    }

    if (!strtotime($fecha_nacimiento)) {
        $errores[] = "Fecha de nacimiento inválida";
    } else {
        // Calcular edad
        $nacimiento = new DateTime($fecha_nacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($nacimiento)->y;
        
        if ($edad < 18) {
            $errores[] = "Debe ser mayor de 18 años para reservar";
        }
    }

    if (!strtotime($fecha_ingreso) || !strtotime($fecha_salida)) {
        $errores[] = "Fechas de estadía inválidas";
    } else {
        $ingreso = new DateTime($fecha_ingreso);
        $salida = new DateTime($fecha_salida);
        
        if ($salida <= $ingreso) {
            $errores[] = "La fecha de salida debe ser posterior a la de ingreso";
        }
    }

    // Si no hay errores, procesar la reserva
    if (empty($errores)) {
        // Aquí iría la conexión a la base de datos y el INSERT
        // Por ahora simulamos el proceso
        
        // Calcular días y total
        $dias = $ingreso->diff($salida)->days;
        $total = $dias * 350;
        
        // Guardar datos en sesión para mostrar
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
        exit;
    }
}

// Si hay errores o acceso directo, volver al formulario
header("Location: index.php");
exit;
?>