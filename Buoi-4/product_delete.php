<?php

require_once __DIR__ . '/model/product.php';

$id = $_GET['id'] ?? '';

if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die('ID sản phẩm không hợp lệ.');
}

$product = getProductById($id);

require_once __DIR__ . '/view/header.php';

if (!$product) {
    echo '<p style="color: red;">Sản phẩm không tồn tại.</p>';
    echo '<a href="product_list.php">Quay lại danh sách</a>';

    require_once __DIR__ . '/view/footer.php';
    exit;
}

deleteProduct($id);

echo '<p style="color: green;">Xóa sản phẩm thành công.</p>';
echo '<a href="product_list.php">Quay lại danh sách</a>';

require_once __DIR__ . '/view/footer.php';
?>
