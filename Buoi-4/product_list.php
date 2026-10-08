<?php

require_once __DIR__ . '/model/product.php';

$products = getAllProducts();

require_once __DIR__ . '/view/header.php';
?>

<h2>Danh sách sản phẩm</h2>

<a href="product_add.php">+ Thêm sản phẩm</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Chức năng</th>
    </tr>

    <?php if (count($products) > 0): ?>

        <?php foreach ($products as $product): ?>

            <tr>
                <td><?= $product['id'] ?></td>

                <td><?= htmlspecialchars($product['name']) ?></td>

                <td>
                    <?= number_format($product['price'], 2, ',', '.') ?> VNĐ
                </td>

                <td><?= $product['quantity'] ?></td>

                <td>
                    <a href="product_edit.php?id=<?= $product['id'] ?>">
                        Sửa
                    </a>

                    |

                    <a
                        href="product_delete.php?id=<?= $product['id'] ?>"
                        onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?');"
                    >
                        Xóa
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>
            <td colspan="5">Chưa có sản phẩm.</td>
        </tr>

    <?php endif; ?>

</table>

<?php
require_once __DIR__ . '/view/footer.php';
?>
