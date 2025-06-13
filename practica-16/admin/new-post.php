<?php
require_once '../includes/auth.php';
require_once '../includes/functions.php';

requireLogin();

$user = getCurrentUser();
$categories = getCategories();

$error = '';
$success = '';

if ($_POST) {
    $titulo = trim($_POST['titulo'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $tags = trim($_POST['tags'] ?? '');
    $imagen = trim($_POST['imagen'] ?? '');
    $publicado = isset($_POST['publicado']) ? 1 : 0;
    
    // Validaciones
    if (empty($titulo)) {
        $error = 'El título es obligatorio.';
    } elseif (empty($contenido)) {
        $error = 'El contenido es obligatorio.';
    } elseif (empty($categoria)) {
        $error = 'La categoría es obligatoria.';
    } else {
        $post_data = [
            'titulo' => $titulo,
            'contenido' => $contenido,
            'categoria' => $categoria,
            'tags' => $tags,
            'imagen' => $imagen,
            'autor_id' => $user['id'],
            'publicado' => $publicado
        ];
        
        $post_id = PostManager::createPost($post_data);
        if ($post_id) {
            header('Location: posts.php?created=1');
            exit;
        } else {
            $error = 'Error al crear el post. Por favor, inténtalo de nuevo.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Post - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
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
                            <a class="nav-link text-white" href="dashboard.php">
                                <i class="bi bi-house-door me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="posts.php">
                                <i class="bi bi-journal-text me-2"></i> Gestionar Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white active" href="new-post.php">
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
                        <i class="bi bi-plus-circle me-2"></i>Nuevo Post
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <a href="posts.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Volver a Posts
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Mensajes -->
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Formulario -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-pencil-square me-2"></i>Detalles del Post
                                </h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="titulo" class="form-label">Título *</label>
                                        <input type="text" class="form-control" id="titulo" name="titulo" 
                                               value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>" 
                                               placeholder="Ingresa el título del post" required>
                                        <div class="form-text">El título aparecerá como encabezado principal del artículo.</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="categoria" class="form-label">Categoría *</label>
                                        <select class="form-select" id="categoria" name="categoria" required>
                                            <option value="">Selecciona una categoría</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= htmlspecialchars($category['nombre']) ?>"
                                                        <?= (($_POST['categoria'] ?? '') === $category['nombre']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($category['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- ---------------------------------------------------------------------------------------------------- -->
                                    <select name="categoria_id">
                                        <option value="">Sin categoría</option>
                                        <?php
                                        $cats = $conn->query("SELECT * FROM categorias");
                                        while ($cat = $cats->fetch_assoc()) {
                                            $selected = isset($post['categoria_id']) && $post['categoria_id'] == $cat['id'] ? 'selected' : '';
                                            echo "<option value='{$cat['id']}' $selected>{$cat['nombre']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <!-- ---------------------------------------------------------------------------------------------------- -->
                                    
                                    <div class="mb-3">
                                        <label for="contenido" class="form-label">Contenido *</label>
                                        <textarea class="form-control" id="contenido" name="contenido" rows="12" 
                                                  placeholder="Escribe el contenido del post aquí..." required><?= htmlspecialchars($_POST['contenido'] ?? '') ?></textarea>
                                        <div class="form-text">Puedes usar párrafos múltiples. Los saltos de línea se convertirán automáticamente.</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input type="text" class="form-control" id="tags" name="tags" 
                                               value="<?= htmlspecialchars($_POST['tags'] ?? '') ?>" 
                                               placeholder="Ej: php, desarrollo, backend">
                                        <div class="form-text">Separa los tags con comas. Opcional pero recomendado para SEO.</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="imagen" class="form-label">URL de Imagen</label>
                                        <input type="url" class="form-control" id="imagen" name="imagen" 
                                               value="<?= htmlspecialchars($_POST['imagen'] ?? '') ?>" 
                                               placeholder="https://ejemplo.com/imagen.jpg">
                                        <div class="form-text">URL de una imagen para acompañar el post (opcional).</div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="publicado" name="publicado" 
                                                   <?= (isset($_POST['publicado'])) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="publicado">
                                                <strong>Publicar inmediatamente</strong>
                                            </label>
                                            <div class="form-text">Si no marcas esta opción, el post se guardará como borrador.</div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="posts.php" class="btn btn-secondary me-md-2">
                                            <i class="bi bi-x-circle me-1"></i>Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-1"></i>Crear Post
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sidebar de ayuda -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-lightbulb me-2"></i>Consejos para escribir
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <strong>Título claro:</strong> Usa un título descriptivo y atractivo
                                    </li>
                                    <li class="mb-3">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <strong>Categoría apropiada:</strong> Elige la categoría que mejor represente el contenido
                                    </li>
                                    <li class="mb-3">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <strong>Contenido estructurado:</strong> Organiza el texto en párrafos claros
                                    </li>
                                    <li class="mb-3">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <strong>Tags relevantes:</strong> Ayudan con la búsqueda y organización
                                    </li>
                                    <li class="mb-0">
                                        <i class="bi bi-check-circle text-success me-2"></i>
                                        <strong>Imagen representativa:</strong> Mejora el aspecto visual del post
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="card shadow-sm mt-3">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-info-circle me-2"></i>Información
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="small mb-2"><strong>Autor:</strong> <?= htmlspecialchars($user['nombre']) ?></p>
                                <p class="small mb-0"><strong>Fecha:</strong> <?= date('d/m/Y H:i') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>