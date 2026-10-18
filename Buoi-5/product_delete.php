<?php

require_once __DIR__ . '/common/auth.php';
requireLogin();

require_once __DIR__ . '/model/product.php';

$id = $_GET['id'] ?? '';

if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die('ID sản phẩm không hợp lệ.');
}

$product = getProductById($id);

require_once __DIR__ . '/view/header.php';

// Sản phẩm không tồn tại
if (!$product) {
    echo '<p style="color: red;">Sản phẩm không tồn tại.</p>';
    echo '<a href="product_list.php">Quay lại danh sách</a>';

    require_once __DIR__ . '/view/footer.php';
    exit;
}

// Người dùng đã bấm xác nhận xóa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    deleteProduct($id);

    echo '<p style="color: green;">Xóa sản phẩm thành công.</p>';
    echo '<a href="product_list.php">Quay lại danh sách</a>';

    require_once __DIR__ . '/view/footer.php';
    exit;
}
?>

<h2>Xác nhận xóa sản phẩm</h2>

<p>
    Bạn có chắc muốn xóa sản phẩm
    <b><?= htmlspecialchars($product['name']) ?></b>
    (ID: <?= $product['id'] ?>) không?
</p>

<form method="post">
    <button type="submit">Xóa</button>
    <a href="product_list.php">Hủy</a>
</form>

<?php
require_once __DIR__ . '/view/footer.php';
?>
