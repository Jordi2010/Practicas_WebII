<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireLogin();

$user = getCurrentUser();
$posts = getAllPosts(); // Todos los posts (publicados y no publicados)
$categories = getCategories();

// Estadísticas
$total_posts = count($posts);
$published_posts = count(array_filter($posts, function($post) { return $post['publicado']; }));
$draft_posts = $total_posts - $published_posts;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .stat-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
        }
        .stat-card.posts { border-left-color: #007bff; }
        .stat-card.published { border-left-color: #28a745; }
        .stat-card.drafts { border-left-color: #ffc107; }
        .stat-card.categories { border-left-color: #6f42c1; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar p-0">
                <div class="position-sticky pt-3">
                    <div class="text-center text-white mb-4">
                        <i class="bi bi-speedometer2 display-6"></i>
                        <h5 class="mt-2">Panel Admin</h5>
                        <small>Bienvenido, <?= htmlspecialchars($user['nombre']) ?></small>
                    </div>
                    
                    <ul class="nav flex-column px-3">
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="dashboard.php">
                                <i class="bi bi-house-door me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="posts.php">
                                <i class="bi bi-journal-text me-2"></i> Gestionar Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="new-post.php">
                                <i class="bi bi-plus-circle me-2"></i> Nuevo Post
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../index.php" target="_blank">
                                <i class="bi bi-globe me-2"></i> Ver Sitio
                            </a>
                        </li>
                    </ul>
                    
                    <hr class="text-white-50 mx-3">
                    
                    <div class="px-3">
                        <a href="logout.php" class="btn btn-outline-light btn-sm w-100">
                            <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                        </a>
                    </div>
                </div>
            </nav>
            
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="new-post.php" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Nuevo Post
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Estadísticas -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card posts shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-muted">Total Posts</h6>
                                        <h3 class="card-title mb-0"><?= $total_posts ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-journal-text display-6 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card published shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-muted">Publicados</h6>
                                        <h3 class="card-title mb-0"><?= $published_posts ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-check-circle display-6 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card drafts shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-muted">Borradores</h6>
                                        <h3 class="card-title mb-0"><?= $draft_posts ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-clock display-6 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="card stat-card categories shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-muted">Categorías</h6>
                                        <h3 class="card-title mb-0"><?= count($categories) ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-tags display-6 text-purple"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Posts recientes -->
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history me-2"></i>Posts Recientes
                        </h5>
                        <a href="posts.php" class="btn btn-outline-primary btn-sm">Ver todos</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($posts)): ?>
                            <div class="text-center py-4">
                                <i class="bi bi-journal-x display-4 text-muted"></i>
                                <p class="text-muted mt-2">No hay posts disponibles</p>
                                <a href="new-post.php" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i> Crear primer post
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Categoría</th>
                                            <th>Estado</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array_slice($posts, 0, 5) as $post): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= htmlspecialchars($post['titulo']) ?></strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary"><?= htmlspecialchars($post['categoria']) ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($post['publicado']): ?>
                                                        <span class="badge bg-success">Publicado</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Borrador</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= formatDate($post['fecha_creacion']) ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="edit-post.php?id=<?= $post['id'] ?>" class="btn btn-outline-primary btn-sm">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <?php if ($post['publicado']): ?>
                                                            <a href="../post.php?slug=<?= $post['slug'] ?>" class="btn btn-outline-success btn-sm" target="_blank">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- ---------------------------------------------------------------------------------------------------- -->
    <a href="comentarios.php">Moderar Comentarios</a>
    <!-- ---------------------------------------------------------------------------------------------------- -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>