CREATE DATABASE IF NOT EXISTS metalteco;
USE metalteco;

-- Crear la tabla productos
CREATE TABLE productos (
    id CHAR(36) PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stockminimo INT NOT NULL,
    unidadmedida VARCHAR(50) NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

INSERT INTO productos (id, descripcion, categoria, precio, stockminimo, unidadmedida, activo, created_at, updated_at)
VALUES 
(UUID(), 'Monitor 24 pulgadas', 'Tecnología', 599.99, 10, 'unidad', true, NOW(), NOW()),
(UUID(), 'Teclado mecánico', 'Accesorios', 199.50, 5, 'unidad', true, NOW(), NOW()),
(UUID(), 'Silla ergonómica', 'Muebles', 999.99, 3, 'unidad', false, NOW(), NOW());
