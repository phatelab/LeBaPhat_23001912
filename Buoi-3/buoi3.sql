
/*BÀI 1 - QUẢN LÝ GIỎ HÀNG */

/* 1. Tạo database shopping_cart */
CREATE DATABASE IF NOT EXISTS shopping_cart;

USE shopping_cart;

/* 2. Tạo bảng cart_items */
CREATE TABLE IF NOT EXISTS cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);


/* 1. Thêm ít nhất 5 sản phẩm */

INSERT INTO cart_items (name, price, quantity)
VALUES
    ('Laptop Dell Inspiron', 15000000, 2),
    ('Chuột Logitech', 450000, 10),
    ('Bàn phím cơ Keychron', 1800000, 6),
    ('Tai nghe Bluetooth', 1200000, 4),
    ('USB 64GB', 250000, 8),
    ('Màn hình Samsung 24 inch', 3500000, 3);


/* Kiểm tra dữ liệu sau khi INSERT */
SELECT * FROM cart_items;


/* 2. Hiển thị toàn bộ sản phẩm*/

SELECT *
FROM cart_items;


/* 3. Hiển thị sản phẩm có giá lớn hơn 100000*/

SELECT *
FROM cart_items
WHERE price > 100000;


/* 4. Hiển thị sản phẩm có số lượng lớn hơn 5 */

SELECT *
FROM cart_items
WHERE quantity > 5;


/* 5. Sắp xếp sản phẩm theo giá giảm dần*/

SELECT *
FROM cart_items
ORDER BY price DESC;


/* 6. Cập nhật giá của một sản phẩm */

UPDATE cart_items
SET price = 500000
WHERE name = 'Chuột Logitech';


/* Kiểm tra sau khi UPDATE */
SELECT *
FROM cart_items
WHERE name = 'Chuột Logitech';


/* 7. Cập nhật số lượng của một sản phẩm */

UPDATE cart_items
SET quantity = 12
WHERE name = 'Chuột Logitech';


/* Kiểm tra sau khi UPDATE */
SELECT *
FROM cart_items
WHERE name = 'Chuột Logitech';


/* 8. Xóa một sản phẩm */

DELETE FROM cart_items
WHERE name = 'USB 64GB';


/* Kiểm tra sau khi DELETE */
SELECT *
FROM cart_items;


/* 9. Hiển thị tên sản phẩm, giá, số lượng và thành tiền (price * quantity) */

SELECT
    name,
    price,
    quantity,
    price * quantity AS total
FROM cart_items;


/* 10. Tính tổng tiền của toàn bộ giỏ hàng */

SELECT
    SUM(price * quantity) AS total_cart
FROM cart_items;


/* BÀI 2 - QUẢN LÝ VÉ XEM PHIM */

CREATE DATABASE IF NOT EXISTS movie_ticket;

USE movie_ticket;


/* 1. Tạo bảng movies */

CREATE TABLE IF NOT EXISTS movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);


/* 2. Thêm ít nhất 5 bộ phim */

INSERT INTO movies
    (title, price, total_seats, available_seats)
VALUES
    ('Avengers: Endgame', 120000, 120, 40),
    ('Spider-Man: No Way Home', 110000, 100, 30),
    ('Doraemon: Nobita va Vung Dat Ly Tuong', 90000, 150, 80),
    ('The Batman', 130000, 100, 25),
    ('Avatar: The Way of Water', 150000, 200, 120),
    ('Interstellar', 100000, 80, 20);


/* Kiểm tra dữ liệu sau khi INSERT */
SELECT *
FROM movies;


/* 3. Hiển thị toàn bộ danh sách phim */

SELECT *
FROM movies;


/* 4. Hiển thị phim có giá vé lớn hơn 100000 */

SELECT *
FROM movies
WHERE price > 100000;


/* 5. Hiển thị phim còn nhiều hơn 50 ghế */

SELECT *
FROM movies
WHERE available_seats > 50;


/* 6. Sắp xếp phim theo giá vé giảm dần */

SELECT *
FROM movies
ORDER BY price DESC;


/* 7. Cập nhật số ghế còn lại của một phim */

UPDATE movies
SET available_seats = 100
WHERE title = 'Avatar: The Way of Water';


/* Kiểm tra sau khi UPDATE */
SELECT *
FROM movies
WHERE title = 'Avatar: The Way of Water';


/* 8. Xóa một phim */

DELETE FROM movies
WHERE title = 'Interstellar';


/* Kiểm tra sau khi DELETE */
SELECT *
FROM movies;


/* 9. Hiển thị số vé đã bán của từng phim total_seats - available_seats */

SELECT
    title,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_tickets
FROM movies;


/* 10. Tính doanh thu của từng phim (total_seats - available_seats) * price */

SELECT
    title,
    price,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_tickets,
    (total_seats - available_seats) * price AS revenue
FROM movies;


/* 11. Tính tổng doanh thu của tất cả các phim */

SELECT
    SUM((total_seats - available_seats) * price) AS total_revenue
FROM movies;


/* 12. Tìm phim có số vé bán ra nhiều nhất Sử dụng MAX theo đúng yêu cầu đề bài */

SELECT
    MAX(total_seats - available_seats) AS max_sold_tickets
FROM movies;


/* Hiển thị thông tin phim có số vé bán ra nhiều nhất */

SELECT
    title,
    total_seats,
    available_seats,
    total_seats - available_seats AS sold_tickets
FROM movies
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats)
    FROM movies
);

