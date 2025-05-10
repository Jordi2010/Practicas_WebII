<?php
require_once 'conexion/db.php';
require_once 'validacion/funciones.php';

// Inicializar arrays para errores y valores
$errores = [];
$valores = [];

// Validar que sea una solicitud POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php?mensaje=Acceso no permitido&tipo=error");
    exit();
}

try {
    // Obtener y sanitizar datos del formulario
    $libro_id = isset($_POST['libro_id']) ? filter_var($_POST['libro_id'], FILTER_SANITIZE_NUMBER_INT) : '';
    $nombre_lector = isset($_POST['nombre_lector']) ? sanitizarTexto($_POST['nombre_lector']) : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $fecha_prestamo = isset($_POST['fecha_prestamo']) ? sanitizarTexto($_POST['fecha_prestamo']) : '';
    $fecha_devolucion = isset($_POST['fecha_devolucion']) ? sanitizarTexto($_POST['fecha_devolucion']) : '';

    // Guardar valores para poder mostrarlos en caso de error
    $valores = [
        'libro_id' => $libro_id,
        'nombre_lector' => $nombre_lector,
        'email' => $email,
        'fecha_prestamo' => $fecha_prestamo,
        'fecha_devolucion' => $fecha_devolucion
    ];

    // Validar libro
    if (!validarRequerido($libro_id) || !validarEnteroPositivo($libro_id)) {
        $errores['libro_id'] = "Debe seleccionar un libro válido";
    } else {
        // Verificar que el libro exista y esté disponible
        if (!libroDisponible($conexion, $libro_id)) {
            $errores['libro_id'] = "Este libro no está disponible para préstamo";
        }
    }

    // Validar nombre del lector
    if (!validarRequerido($nombre_lector)) {
        $errores['nombre_lector'] = "El nombre del lector es obligatorio";
    } elseif (strlen($nombre_lector) > 100) {
        $errores['nombre_lector'] = "El nombre no puede exceder los 100 caracteres";
    }

    // Validar email
    if (!validarRequerido($email)) {
        $errores['email'] = "El email es obligatorio";
    } elseif (!validarEmail($email)) {
        $errores['email'] = "El formato del email no es válido";
    }

    // Validar fecha de préstamo
    if (!validarRequerido($fecha_prestamo)) {
        $errores['fecha_prestamo'] = "La fecha de préstamo es obligatoria";
    } elseif (!validarFecha($fecha_prestamo)) {
        $errores['fecha_prestamo'] = "La fecha de préstamo no es válida";
    }

    // Validar fecha de devolución
    if (!validarRequerido($fecha_devolucion)) {
        $errores['fecha_devolucion'] = "La fecha de devolución es obligatoria";
    } elseif (!validarFecha($fecha_devolucion)) {
        $errores['fecha_devolucion'] = "La fecha de devolución no es válida";
    } elseif (!validarFechaPosterior($fecha_prestamo, $fecha_devolucion)) {
        $errores['fecha_devolucion'] = "La fecha de devolución debe ser posterior a la fecha de prestámo";
    }

    // Si hay errores, redirigir de vuelta al formulario
    if (count($errores) > 0) {
        $errores_encoded = urlencode(json_encode($errores));
        $valores_encoded = urlencode(json_encode($valores));
        header("Location: prestamo_crear.php?errores=$errores_encoded&valores=$valores_encoded");
        exit();
    }

    // Si no hay errores, insertar en la base de datos
    $stmt = $conexion->prepare("INSERT INTO prestamos (libro_id, nombre_lector, email, fecha_prestamo, fecha_devolucion, estado)
    VALUES (:libro_id, :nombre_lector, :email, :fecha_prestamo, :fecha_devolucion, 'prestado')");

    $stmt->bindParam(':libro_id', $libro_id);
    $stmt->bindParam(':nombre_lector', $nombre_lector);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':fecha_prestamo', $fecha_prestamo);
    $stmt->bindParam(':fecha_devolucion', $fecha_devolucion);

    $stmt->execute();

    // Redirigir con mensaje de éxito
    header("Location: index.php?mensaje=Préstamo registrado exitosamente&tipo=exito");
    exit();

} catch(PDOException $e) {
    // Manejar errores de la base de datos
    header("Location: index.php?mensaje=Error en la base de datos: ".$e->getMessage()."&tipo=error");
    exit();
} catch(Exception $e) {
    // Manejar otros errores
    header("Location: index.php?mensaje=Error inesperado: ".$e->getMessage()."&tipo=error");
    exit();
}
?>