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
    $titulo = isset($_POST['titulo']) ? sanitizarTexto($_POST['titulo']) : '';
    $autor = isset($_POST['autor']) ? sanitizarTexto($_POST['autor']) : '';
    $isbn = isset($_POST['isbn']) ? sanitizarTexto($_POST['isbn']) : '';
    $paginas = isset($_POST['paginas']) ? filter_var($_POST['paginas'], FILTER_SANITIZE_NUMBER_INT) : '';
    $fecha_publicacion = isset($_POST['fecha_publicacion']) ? sanitizarTexto($_POST['fecha_publicacion']) : '';
    $ejemplares = isset($_POST['ejemplares']) ? filter_var($_POST['ejemplares'], FILTER_SANITIZE_NUMBER_INT) : '';

    // Guardar valores para poder mostrarlos en caso de error
    $valores = [
        'titulo' => $titulo,
        'autor' => $autor,
        'isbn' => $isbn,
        'paginas' => $paginas,
        'fecha_publicacion' => $fecha_publicacion,
        'ejemplares' => $ejemplares
    ];

    // Validar campos obligatorios
    if (!validarRequerido($titulo)) {
        $errores['titulo'] = "El título es obligatorio";
    } elseif (strlen($titulo) > 150) {
        $errores['titulo'] = "El título no puede exceder los 150 caracteres";
    }

    if (!validarRequerido($autor)) {
        $errores['autor'] = "El autor es obligatorio";
    } elseif (strlen($autor) > 100) {
        $errores['autor'] = "El nombre del autor no puede exceder los 100 caracteres";
    }

    // Validar ISBN
    if (!validarRequerido($isbn)) {
        $errores['isbn'] = "El ISBN es obligatorio";
    } elseif (!validarISBN($isbn)) {
        $errores['isbn'] = "El formato de ISBN no es válido (debe tener 10 o 13 dígitos)";
    } else {
        // Verificar que el ISBN no exista ya en la base de datos
        $isbn_limpio = str_replace(['-', ' '], '', $isbn);
        $stmt = $conexion->prepare("SELECT COUNT(*) FROM libros WHERE REPLACE(REPLACE(isbn, '-', ''), ' ', '') = :isbn");
        $stmt->bindParam(':isbn', $isbn_limpio);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            $errores['isbn'] = "Este ISBN ya está registrado en la biblioteca";
        }
    }

    // Validar número de páginas si se proporciona
    if (!empty($paginas) && !validarEnteroPositivo($paginas)) {
        $errores['paginas'] = "El número de páginas debe ser un número entero positivo";
    }

    // Validar fecha de publicación si se proporciona
    if (!empty($fecha_publicacion) && !validarFecha($fecha_publicacion)) {
        $errores['fecha_publicacion'] = "La fecha de publicación no es válida";
    }

    // Validar ejemplares
    if (!validarRequerido($ejemplares)) {
        $errores['ejemplares'] = "El número de ejemplares es obligatorio";
    } elseif (!validarEnteroPositivo($ejemplares)) {
        $errores['ejemplares'] = "El número de ejemplares debe ser un número entero positivo";
    }

    // Si hay errores, redirigir de vuelta al formulario
    if (count($errores) > 0) {
        $errores_encoded = urlencode(json_encode($errores));
        $valores_encoded = urlencode(json_encode($valores));
        header("Location: libro_crear.php?errores=$errores_encoded&valores=$valores_encoded");
        exit();
    }

    // Si no hay errores, insertar en la base de datos
    $stmt = $conexion->prepare("INSERT INTO libros (titulo, autor, isbn, paginas, fecha_publicacion, ejemplares)
    VALUES (:titulo, :autor, :isbn, :paginas, :fecha_publicacion, :ejemplares)");

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':isbn', $isbn);

    // Manejar campos opcionales
    if (empty($paginas)) {
        $stmt->bindValue(':paginas', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindParam(':paginas', $paginas);
    }

    if (empty($fecha_publicacion)) {
        $stmt->bindValue(':fecha_publicacion', null, PDO::PARAM_NULL);
    } else {
        $stmt->bindValue(':fecha_publicacion', $fecha_publicacion);
    }

    $stmt->bindParam(':ejemplares', $ejemplares);

    $stmt-> execute();

    // Redirigir con mensaje de éxito
    header("Location: index.php?mensaje=Libro registrado exitosamente&tipo=exito");
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