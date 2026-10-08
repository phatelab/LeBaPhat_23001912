<?php

require_once __DIR__ . '/model/product.php';

$id = $_GET['id'] ?? '';

if (!filter_var($id, FILTER_VALIDATE_INT)) {
    die('ID sản phẩm không hợp lệ.');
}

$product = getProductById($id);

if (!$product) {
    die('Không tìm thấy sản phẩm.');
}

$error = '';

$name = $product['name'];
$price = $product['price'];
$quantity = $product['quantity'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $price = $_POST['price'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    if ($name === '') {
        $error = 'Tên sản phẩm không được rỗng.';
    } elseif (!is_numeric($price) || $price <= 0) {
        $error = 'Giá sản phẩm phải lớn hơn 0.';
    } elseif (
        filter_var($quantity, FILTER_VALIDATE_INT) === false
        || $quantity < 0
    ) {
        $error = 'Số lượng phải là số nguyên >= 0.';
    } else {

        updateProduct(
            $id,
            $name,
            $price,
            $quantity
        );

        header('Location: product_list.php');
        exit;
    }
}

require_once __DIR__ . '/view/header.php';
?>

<h2>Sửa sản phẩm</h2>

<?php if ($error !== ''): ?>

    <p style="color: red;">
        <?= htmlspecialchars($error) ?>
    </p>

<?php endif; ?>

<form method="post">

    <p>
        <label>ID:</label><br>
        <input
            type="text"
            value="<?= htmlspecialchars($product['id']) ?>"
            disabled
        >
    </p>

    <p>
        <label>Tên sản phẩm:</label><br>
        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($name) ?>"
        >
    </p>

    <p>
        <label>Giá:</label><br>
        <input
            type="number"
            name="price"
            step="0.01"
            min="0.01"
            value="<?= htmlspecialchars($price) ?>"
        >
    </p>

    <p>
        <label>Số lượng:</label><br>
        <input
            type="number"
            name="quantity"
            min="0"
            value="<?= htmlspecialchars($quantity) ?>"
        >
    </p>

    <button type="submit">Cập nhật</button>

    <a href="product_list.php">Quay lại</a>

</form>

<?php
require_once __DIR__ . '/view/footer.php';
?>
