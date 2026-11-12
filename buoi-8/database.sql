
CREATE DATABASE IF NOT EXISTS php_vue_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE php_vue_db;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL CHECK (price > 0),
    stock INT NOT NULL CHECK (stock >= 0)
);

INSERT INTO products (name, price, stock) VALUES
('Bút bi', 5000, 20),
('Vở ô ly', 12000, 15),
('Thước kẻ', 8000, 0);
