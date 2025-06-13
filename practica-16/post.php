<?php
require_once 'includes/functions.php';

$slug = $_GET['slug'] ?? '';
if (empty($slug)) {
    header('Location: index.php');
    exit;
}

$post = getPostBySlug($slug);
if (!$post) {
    http_response_code(404);
    include '404.php';
    exit;
}

$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['titulo']) ?> - Tecnologías Web Dinámicas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .post-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        .post-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }
        .post-meta {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
        }
        .footer {
            background-color: #343a40;
            color: white;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-code-slash"></i> TechWeb Dinámicas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categorías
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($categories as $category): ?>
                                <li><a class="dropdown-item" href="index.php#category-<?= $category['slug'] ?>"><?= htmlspecialchars($category['nombre']) ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php">
                            <i class="bi bi-person-lock"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header del Post -->
    <header class="post-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb justify-content-center bg-transparent">
                            <li class="breadcrumb-item"><a href="index.php" class="text-light">Inicio</a></li>
                            <li class="breadcrumb-item text-light"><?= htmlspecialchars($post['categoria']) ?></li>
                            <li class="breadcrumb-item active text-light" aria-current="page">Artículo</li>
                        </ol>
                    </nav>
                    <h1 class="display-5 mb-4"><?= htmlspecialchars($post['titulo']) ?></h1>
                    <div class="post-meta text-light">
                        <span class="badge bg-light text-dark me-2"><?= htmlspecialchars($post['categoria']) ?></span>
                        <span class="me-3">
                            <i class="bi bi-person"></i> <?= htmlspecialchars($post['autor']) ?>
                        </span>
                        <span class="me-3">
                            <i class="bi bi-calendar3"></i> <?= formatDate($post['fecha_creacion']) ?>
                        </span>
                        <?php if (!empty($post['tags'])): ?>
                            <span>
                                <i class="bi bi-tags"></i> <?= htmlspecialchars($post['tags']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido del Post -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article>
                    <?php if (!empty($post['imagen'])): ?>
                        <div class="mb-4">
                            <img src="<?= htmlspecialchars($post['imagen']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($post['titulo']) ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="post-content">
                        <?= nl2br(htmlspecialchars($post['contenido'])) ?>
                    </div>
                </article>

                <!-- Navegación entre posts -->
                <div class="mt-5 pt-4 border-top">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="index.php" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left"></i> Volver al inicio
                            </a>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <button class="btn btn-outline-secondary" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                                <i class="bi bi-arrow-up"></i> Ir arriba
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información del autor -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-person-circle display-4 text-primary"></i>
                            </div>
                            <h5 class="card-title">Acerca del autor</h5>
                            <h6 class="text-muted"><?= htmlspecialchars($post['autor']) ?></h6>
                            <p class="card-text">
                                Especialista en tecnologías web dinámicas con experiencia en desarrollo 
                                con PHP, JavaScript y frameworks modernos. Apasionado por compartir 
                                conocimiento sobre las últimas tendencias en desarrollo web.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ---------------------------------------------------------------------------------------------------- -->
    <?php
    if (isset($_POST['enviar_comentario'])) {
        include('config/database.php');
        $post_id = $_GET['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $comentario = $_POST['comentario'];

        $stmt = $conn->prepare("INSERT INTO comentarios (post_id, nombre, email, comentario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $post_id, $nombre, $email, $comentario);
        $stmt->execute();
        echo "<p>Comentario enviado y pendiente de aprobación.</p>";
    }
    ?>

    <h3>Comentarios</h3>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Tu nombre" required><br>
        <input type="email" name="email" placeholder="Tu email" required><br>
        <textarea name="comentario" placeholder="Escribe tu comentario..." required></textarea><br>
        <button type="submit" name="enviar_comentario">Enviar comentario</button>
    </form>

    <?php
    $post_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT nombre, comentario, fecha_creacion FROM comentarios WHERE post_id = ? AND aprobado = 1 ORDER BY fecha_creacion DESC");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($c = $result->fetch_assoc()) {
        echo "<div><strong>{$c['nombre']}</strong> dijo: <p>{$c['comentario']}</p><em>{$c['fecha_creacion']}</em></div><hr>";
    }
    ?>
    <!-- ---------------------------------------------------------------------------------------------------- -->

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-code-slash"></i> TechWeb Dinámicas</h5>
                    <p class="mb-0">Tu fuente de información sobre tecnologías web modernas.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        &copy; <?= date('Y') ?> Tecnologías Web Dinámicas. 
                        <a href="admin/login.php" class="text-light text-decoration-none">Panel Admin</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 