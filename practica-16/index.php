<?php
require_once 'includes/functions.php';

//-------------------------------------------------------------------------------------------------------------
$por_pagina = 6;
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($pagina - 1) * $por_pagina;

$q = $_GET['q'] ?? null;
$posts = getAllPosts(true, $por_pagina, $offset, $q);
$total = countPosts($q); // Necesitas esta función en functions.php
$paginas = ceil($total / $por_pagina);
//-------------------------------------------------------------------------------------------------------------
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnologías Web Dinámicas - Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }

        .post-card {
            transition: transform 0.2s;
            height: 100%;
        }

        .post-card:hover {
            transform: translateY(-5px);
        }

        .category-badge {
            font-size: 0.8rem;
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
                        <a class="nav-link active" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categorías
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($categories as $category): ?>
                                <li><a class="dropdown-item" href="#category-<?= $category['slug'] ?>"><?= htmlspecialchars($category['nombre']) ?></a></li>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 mb-4">Tecnologías Web Dinámicas</h1>
            <p class="lead mb-4">Explorando el mundo del desarrollo web moderno</p>
            <p class="fs-5">PHP, JavaScript, Frameworks, Bases de Datos y más</p>
        </div>
    </section>

    <!-- Contenido Principal -->
    <div class="container my-5">
        <?php if (empty($posts)): ?>
            <div class="text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted"></i>
                <h3 class="mt-3 text-muted">No hay artículos disponibles</h3>
                <p class="text-muted">Vuelve pronto para ver nuevo contenido</p>
            </div>
        <?php else: ?>
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="mb-4">
                        <i class="bi bi-newspaper"></i> Últimos Artículos
                    </h2>
                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------- -->
            <form method="GET" action="">
                <input type="text" name="q" value="<?= $_GET['q'] ?? '' ?>" placeholder="Buscar...">
                <button type="submit">Buscar</button>
            </form>
            <!-- ---------------------------------------------------------------------------------------------------- -->

            <div class="row g-4">
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card post-card shadow-sm h-100">
                            <?php if (!empty($post['imagen'])): ?>
                                <img src="<?= htmlspecialchars($post['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($post['titulo']) ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-code-square display-4 text-muted"></i>
                                </div>
                            <?php endif; ?>

                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-primary category-badge"><?= htmlspecialchars($post['categoria']) ?></span>
                                    <small class="text-muted ms-2">
                                        <i class="bi bi-calendar3"></i> <?= formatDate($post['fecha_creacion']) ?>
                                    </small>
                                </div>

                                <h5 class="card-title"><?= htmlspecialchars($post['titulo']) ?></h5>
                                <p class="card-text flex-grow-1"><?= truncateText(strip_tags($post['contenido']), 150) ?></p>

                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> <?= htmlspecialchars($post['autor']) ?>
                                        </small>
                                        <a href="post.php?slug=<?= htmlspecialchars($post['slug']) ?>" class="btn btn-outline-primary btn-sm">
                                            Leer más <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- -------------------------------------------------------------------------------------- -->
                    <div class="mt-4 d-flex justify-content-center">
                        <nav>
                            <ul class="pagination">
                                <?php if ($pagina > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=<?= $pagina - 1 ?>&q=<?= urlencode($q) ?>">Anterior</a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $paginas; $i++): ?>
                                    <li class="page-item <?= $pagina == $i ? 'active' : '' ?>">
                                        <a class="page-link" href="?pagina=<?= $i ?>&q=<?= urlencode($q) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($pagina < $paginas): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=<?= $pagina + 1 ?>&q=<?= urlencode($q) ?>">Siguiente</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <!-- -------------------------------------------------------------------------------------- -->
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sección de Categorías -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">
                <i class="bi bi-tags"></i> Categorías
            </h2>
            <div class="row g-4">
                <?php foreach ($categories as $category): ?>
                    <div class="col-md-6 col-lg-4" id="category-<?= $category['slug'] ?>">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bi bi-folder2-open display-5 text-primary mb-3"></i>
                                <h5 class="card-title"><?= htmlspecialchars($category['nombre']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars($category['descripcion']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

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