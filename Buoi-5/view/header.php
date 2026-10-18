<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
</head>
<body>

<h1>QUẢN LÝ SẢN PHẨM</h1>

<?php if (isset($_SESSION['username'])): ?>
    <p>
        Xin chào, <b><?= htmlspecialchars($_SESSION['username']) ?></b>
        |
        <a href="logout.php">Đăng xuất</a>
    </p>
<?php endif; ?>

<hr>
