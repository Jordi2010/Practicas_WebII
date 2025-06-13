-- Base de datos para CMS de Tecnologías Web Dinámicas
CREATE DATABASE IF NOT EXISTS cms_web_dinamicas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE cms_web_dinamicas;

-- Tabla de usuarios administradores
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE
);

-- Tabla de posts/artículos
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    contenido TEXT NOT NULL,
    imagen VARCHAR(255),
    categoria VARCHAR(100),
    tags TEXT,
    autor_id INT NOT NULL,
    ----------------------------------------------------------------------------------------------------
    categoria_id INT NULL,
    ----------------------------------------------------------------------------------------------------
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    publicado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (autor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    ----------------------------------------------------------------------------------------------------
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
    ----------------------------------------------------------------------------------------------------
);

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    descripcion TEXT,
    slug VARCHAR(100) UNIQUE NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar usuario administrador por defecto
INSERT INTO usuarios (username, email, password, nombre) VALUES 
('admin', 'admin@webdinamicas.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador');
-- Contraseña: password

-- Insertar categorías por defecto
INSERT INTO categorias (nombre, descripcion, slug) VALUES 
('PHP', 'Artículos sobre PHP y desarrollo backend', 'php'),
('JavaScript', 'Contenido sobre JavaScript y frameworks', 'javascript'),
('Bases de Datos', 'Artículos sobre MySQL, PostgreSQL y NoSQL', 'bases-datos'),
('Frameworks', 'Información sobre Laravel, Symfony, React, etc.', 'frameworks'),
('Desarrollo Web', 'Temas generales de desarrollo web', 'desarrollo-web');

-- Insertar posts de ejemplo
INSERT INTO posts (titulo, slug, contenido, categoria, tags, autor_id, categoria_id, publicado) VALUES 
('Introducción a PHP 8.0', 'introduccion-php-8', 'PHP 8.0 introduce nuevas características revolucionarias que cambian la forma en que desarrollamos aplicaciones web. Entre las novedades más destacadas encontramos los Union Types, que permiten especificar múltiples tipos para un parámetro, Named Arguments para mayor legibilidad del código, y las JIT Compilation que mejora significativamente el rendimiento.', 'PHP', 'php, desarrollo, backend', 1, 1, TRUE),

('Frameworks JavaScript Modernos', 'frameworks-javascript-modernos', 'El ecosistema JavaScript ha evolucionado enormemente con frameworks como React, Vue.js y Angular. Cada uno ofrece ventajas únicas: React con su Virtual DOM y ecosistema robusto, Vue.js con su curva de aprendizaje suave y flexibilidad, y Angular con su arquitectura empresarial y TypeScript integrado.', 'JavaScript', 'javascript, react, vue, angular', 1, 2, TRUE),

('Bases de Datos NoSQL vs SQL', 'nosql-vs-sql', 'La elección entre bases de datos relacionales (SQL) y NoSQL depende de las necesidades específicas del proyecto. Las bases SQL como MySQL y PostgreSQL ofrecen consistencia ACID y queries complejas, mientras que NoSQL como MongoDB y Redis proporcionan escalabilidad horizontal y flexibilidad de esquemas.', 'Bases de Datos', 'database, sql, nosql, mysql, mongodb', 1, 3, TRUE),

('Laravel: El Framework PHP Moderno', 'laravel-framework-php', 'Laravel se ha convertido en el framework PHP más popular gracias a su sintaxis elegante, ORM Eloquent, sistema de migraciones, y herramientas como Artisan CLI. Facilita el desarrollo de aplicaciones web robustas con características como autenticación, caching, y queue management integradas.', 'Frameworks', 'laravel, php, framework, desarrollo', 1, 4, TRUE);

----------------------------------------------------------------------------------------------------

-- Crear tabla de comentarios
CREATE TABLE IF NOT EXISTS comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    comentario TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    aprobado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);