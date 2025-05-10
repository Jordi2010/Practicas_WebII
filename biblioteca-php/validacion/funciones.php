<?php
/**
 * Funciones de validación y sanitización
*/

// Sanitizar texto general
function sanitizarTexto($texto) {
    $texto = trim($texto);
    $texto = stripslashes($texto);
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// Validar que un campo no esté vacío
function validarRequerido($valor) {
    return !empty(trim($valor));
}

// Validar email
function validarEmail($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validar ISBN (formato simple: 10 o 13 dígitos, puede contener guiones)
function validarISBN($isbn) {
    // Eliminar guiones y espacios
    $isbn = str_replace(['-', ' '], '', $isbn);

    // Validar longitud (ISBN-10 o ISBN-13)
    if (strlen($isbn) != 10 && strlen($isbn) != 13) {
        return false;
    }

    // Verificar que solo contenga números (y posiblemente X al final para ISBN-10)
    if (strlen($isbn) == 10) {
        return preg_match('/^[0-9]{9}[0-9X]$/', $isbn);
    } else {
        return preg_match('/^[0-9]{13}$/', $isbn);
    }
}

// Validar número entero positivo
function validarEnteroPositivo($numero) {
    return filter_var($numero, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) !== false;
}

// Validar fecha en formato YYYY-MM-DD
function validarFecha($fecha) {
    $fechaArray = explode('-', $fecha);

    // Verificar formato básico
    if (count($fechaArray) != 3) {
        return false;
    }

    // Verificar que sea una fecha válida
    return checkdate((int)$fechaArray[1], (int)$fechaArray[2], (int)$fechaArray[0]);
}

// Validar que una fecha sea posterior a otra
function validarFechaPosterior($fecha1, $fecha2) {
    $timestamp1 = strtotime($fecha1);
    $timestamp2 = strtotime($fecha2);

    return ($timestamp1 && $timestamp2 && $timestamp2 > $timestamp1);
}

// Verificar si un libro está disponible para préstamo
function libroDisponible($conexion, $libroId) {
    try {
        // Contar ejemplares totales
        $stmtTotal = $conexion->prepare("SELECT ejemplares FROM libros WHERE id = :id");
        $stmtTotal->bindParam(':id', $libroId, PDO::PARAM_INT);
        $stmtTotal->execute();
        $total = $stmtTotal->fetchColum();

        // Contar préstamos activos
        $stmtPrestados = $conexion->prepare("SELECT COUNT(*) FROM prestamos WHERE libro_id = :id AND estado = 'prestado'");
        $stmtPrestados->bindParam(':id', $libroId, PDO::PARAM_INT);
        $stmtPrestados->execute();
        $prestados = $stmtPrestados->fetchColum();

        return ($total > $prestados);
    } catch(PDOException $e) {
        return false;
    }
}
?>