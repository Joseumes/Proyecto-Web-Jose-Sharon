<?php

session_start();

if (ob_get_level()) ob_end_clean();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
    $nit = isset($_POST['nit']) ? htmlspecialchars(trim($_POST['nit'])) : '';
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? htmlspecialchars(trim($_POST['fecha_nacimiento'])) : '';
    $telefono = isset($_POST['telefono']) ? htmlspecialchars(trim($_POST['telefono'])) : '';
    $fecha_ingreso = isset($_POST['fecha_ingreso']) ? htmlspecialchars(trim($_POST['fecha_ingreso'])) : '';
    $fecha_salida = isset($_POST['fecha_salida']) ? htmlspecialchars(trim($_POST['fecha_salida'])) : '';
    $comentarios = isset($_POST['comentarios']) ? htmlspecialchars(trim($_POST['comentarios'])) : '';

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
       
        $dias = $ingreso->diff($salida)->days;
    
        if ($dias == 0) $dias = 1;
        $total = $dias * 350;
    
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
        
      
        header("Location: confirmacion_reserva.php");
        exit(); 
    } 
}


header("Location: index.php");
exit();
?>