<?php
require_once __DIR__ . '/../config/database.php';

class PostManager {
    
    public static function getAllPosts($published_only = false) {
        try {
            $db = getDB();
            $sql = "SELECT p.*, u.nombre as autor FROM posts p 
                    LEFT JOIN usuarios u ON p.autor_id = u.id ";
            if ($published_only) {
                $sql .= "WHERE p.publicado = 1 ";
            }
            $sql .= "ORDER BY p.fecha_creacion DESC";
            
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error obteniendo posts: " . $e->getMessage());
            return [];
        }
    }
    
    public static function getPostById($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT p.*, u.nombre as autor FROM posts p 
                                 LEFT JOIN usuarios u ON p.autor_id = u.id 
                                 WHERE p.id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Error obteniendo post: " . $e->getMessage());
            return null;
        }
    }
    
    public static function getPostBySlug($slug) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT p.*, u.nombre as autor FROM posts p 
                                 LEFT JOIN usuarios u ON p.autor_id = u.id 
                                 WHERE p.slug = ? AND p.publicado = 1");
            $stmt->execute([$slug]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Error obteniendo post por slug: " . $e->getMessage());
            return null;
        }
    }
    
    public static function createPost($data) {
        try {
            $db = getDB();
            $slug = self::generateSlug($data['titulo']);
            
            $stmt = $db->prepare("INSERT INTO posts (titulo, slug, contenido, categoria, tags, autor_id, publicado, imagen) 
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['titulo'],
                $slug,
                $data['contenido'],
                $data['categoria'],
                $data['tags'] ?? '',
                $data['autor_id'],
                $data['publicado'] ?? 0,
                $data['imagen'] ?? ''
            ]);
            
            return $db->lastInsertId();
        } catch (Exception $e) {
            error_log("Error creando post: " . $e->getMessage());
            return false;
        }
    }
    
    public static function updatePost($id, $data) {
        try {
            $db = getDB();
            $slug = self::generateSlug($data['titulo']);
            
            $stmt = $db->prepare("UPDATE posts SET titulo = ?, slug = ?, contenido = ?, categoria = ?, 
                                 tags = ?, publicado = ?, imagen = ?, fecha_actualizacion = NOW() 
                                 WHERE id = ?");
            $stmt->execute([
                $data['titulo'],
                $slug,
                $data['contenido'],
                $data['categoria'],
                $data['tags'] ?? '',
                $data['publicado'] ?? 0,
                $data['imagen'] ?? '',
                $id
            ]);
            
            return true;
        } catch (Exception $e) {
            error_log("Error actualizando post: " . $e->getMessage());
            return false;
        }
    }
    
    public static function deletePost($id) {
        try {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM posts WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (Exception $e) {
            error_log("Error eliminando post: " . $e->getMessage());
            return false;
        }
    }
    
    public static function getCategories() {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM categorias ORDER BY nombre");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            error_log("Error obteniendo categorías: " . $e->getMessage());
            return [];
        }
    }
    
    private static function generateSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return trim($slug, '-');
    }
    
    public static function truncateText($text, $length = 150) {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }
    
    public static function formatDate($date) {
        return date('d/m/Y H:i', strtotime($date));
    }
}

// Funciones helper
/*function getAllPosts($published_only = false) {
    return PostManager::getAllPosts($published_only);
}*/

/* ----------------------------------------------------------------------------------------------------- */
function getAllPosts($published_only = true, $limit = null, $offset = 0, $q = null) {
    global $conn;
    $where = $published_only ? "WHERE publicado = 1" : "WHERE 1";
    if ($q) {
        $q = $conn->real_escape_string($q);
        $where .= " AND (titulo LIKE '%$q%' OR contenido LIKE '%$q%' OR tags LIKE '%$q%')";
    }
    $sql = "SELECT posts.*, categorias.nombre AS categoria FROM posts
            LEFT JOIN categorias ON posts.categoria_id = categorias.id
            $where
            ORDER BY fecha_creacion DESC";
    if (!is_null($limit)) {
        $sql .= " LIMIT $limit OFFSET $offset";
    }
    return $conn->query($sql);
}

function countPosts($q = null) {
    global $conn;
    $where = "WHERE publicado = 1";
    if ($q) {
        $q = $conn->real_escape_string($q);
        $where .= " AND (titulo LIKE '%$q%' OR contenido LIKE '%$q%' OR tags LIKE '%$q%')";
    }
    $sql = "SELECT COUNT(*) FROM posts $where";
    $res = $conn->query($sql);
    return $res ? $res->fetch_row()[0] : 0;
}
/* ----------------------------------------------------------------------------------------------------- */

function getPostById($id) {
    return PostManager::getPostById($id);
}

function getPostBySlug($slug) {
    return PostManager::getPostBySlug($slug);
}

function getCategories() {
    return PostManager::getCategories();
}

function truncateText($text, $length = 150) {
    return PostManager::truncateText($text, $length);
}

function formatDate($date) {
    return PostManager::formatDate($date);
}
?> 