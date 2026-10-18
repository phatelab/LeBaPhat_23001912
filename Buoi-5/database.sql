CREATE DATABASE IF NOT EXISTS shopping_cart
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE shopping_cart;

-- ===================== BẢNG PRODUCTS =====================
DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

INSERT INTO products (name, price, quantity) VALUES
('Laptop Dell', 15000000, 10),
('Chuột Logitech', 500000, 20),
('Bàn phím cơ', 1200000, 15),
('Tai nghe Bluetooth', 800000, 12),
('Màn hình Samsung', 5000000, 8);

-- ===================== BẢNG USERS =====================
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tài khoản mẫu: admin / 123456
-- Mật khẩu đã được mã hóa bằng password_hash('123456', PASSWORD_DEFAULT)
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$u0aZKFa2qiLStE3QSgXDuO4yRjH2QySCj2.EzyVKbeV6x6TuaGl7K');
