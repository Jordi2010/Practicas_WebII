<?php
include('config/database.php');

$q = $_GET['q'] ?? '';
$condicion = "1=1";
if ($q !== '') {
    $q = $conn->real_escape_string($q);
    $condicion = "(titulo LIKE '%$q%' OR contenido LIKE '%$q%' OR etiquetas LIKE '%$q%')";
}

$por_pagina = 6;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $por_pagina;

$total = $conn->query("SELECT COUNT(*) FROM posts WHERE $condicion")->fetch_row()[0];
$paginas = ceil($total / $por_pagina);

$posts = $conn->query("SELECT * FROM posts WHERE $condicion ORDER BY fecha DESC LIMIT $inicio, $por_pagina");

while ($p = $posts->fetch_assoc()) {
    echo "<h2>{$p['titulo']}</h2><p>{$p['contenido']}</p><hr>";
}
?>