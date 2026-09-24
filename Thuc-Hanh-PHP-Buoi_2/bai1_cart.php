<?php

class CartItem
{
    private string $name;
    private float $price;
    private int $quantity;

    public function __construct($name, $price, $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getTotal()
    {
        return $this->price * $this->quantity;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}

class ShoppingCart
{
    private array $items = [];

    public function addItem($item)
    {
        if (!$item instanceof CartItem) {
            echo "Lỗi: Chỉ được thêm object CartItem vào giỏ hàng.<br>";
            return;
        }

        if ($item->getPrice() <= 0) {
            echo "Lỗi: Giá sản phẩm phải lớn hơn 0.<br>";
            return;
        }

        if ($item->getQuantity() <= 0) {
            echo "Lỗi: Số lượng sản phẩm phải lớn hơn 0.<br>";
            return;
        }

        $this->items[] = $item;

        echo "Đã thêm sản phẩm: " . htmlspecialchars($item->getName()) . "<br>";
    }

    public function removeItem($name)
    {
        foreach ($this->items as $index => $item) {
            if ($item->getName() === $name) {
                unset($this->items[$index]);

                // Đánh lại chỉ số mảng sau khi xóa
                $this->items = array_values($this->items);

                echo "Đã xóa sản phẩm: " . htmlspecialchars($name) . "<br>";
                return;
            }
        }

        echo "Không tìm thấy sản phẩm \"" .
             htmlspecialchars($name) .
             "\" trong giỏ hàng.<br>";
    }

    public function calculateTotal()
    {
        $total = 0;

        foreach ($this->items as $item) {
            // Không tính price * quantity trực tiếp ở đây.
            $total += $item->getTotal();
        }

        return $total;
    }

    public function displayCart()
    {
        echo "<h2>THÔNG TIN GIỎ HÀNG</h2>";

        if (empty($this->items)) {
            echo "Giỏ hàng hiện đang trống.<br>";
            echo "Tổng tiền: 0 VNĐ<br>";
            return;
        }

        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>";
        echo "<th>Tên sản phẩm</th>";
        echo "<th>Đơn giá</th>";
        echo "<th>Số lượng</th>";
        echo "<th>Thành tiền</th>";
        echo "</tr>";

        foreach ($this->items as $item) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($item->getName()) . "</td>";
            echo "<td>" . number_format($item->getPrice()) . " VNĐ</td>";
            echo "<td>" . $item->getQuantity() . "</td>";
            echo "<td>" . number_format($item->getTotal()) . " VNĐ</td>";
            echo "</tr>";
        }

        echo "</table>";

        echo "<p><strong>Tổng tiền: "
            . number_format($this->calculateTotal())
            . " VNĐ</strong></p>";
    }
}


// =======================
// CHƯƠNG TRÌNH CHÍNH
// =======================

echo "<h1>BÀI 1 - QUẢN LÝ GIỎ HÀNG</h1>";

$cart = new ShoppingCart();

// Tạo ít nhất 04 sản phẩm
$item1 = new CartItem("Laptop", 15000000, 1);
$item2 = new CartItem("Chuột không dây", 350000, 2);
$item3 = new CartItem("Bàn phím", 750000, 1);
$item4 = new CartItem("Tai nghe", 1200000, 2);

// Thêm sản phẩm vào giỏ hàng
echo "<h3>1. Thêm sản phẩm</h3>";

$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);
$cart->addItem($item4);

// Kiểm tra dữ liệu không hợp lệ
echo "<h3>2. Kiểm tra dữ liệu không hợp lệ</h3>";

$invalidPriceItem = new CartItem("Sản phẩm lỗi giá", 0, 1);
$cart->addItem($invalidPriceItem);

$invalidQuantityItem = new CartItem("Sản phẩm lỗi số lượng", 100000, 0);
$cart->addItem($invalidQuantityItem);

// Hiển thị giỏ hàng
echo "<h3>3. Giỏ hàng ban đầu</h3>";
$cart->displayCart();

// Tính tổng tiền
echo "<h3>4. Tổng tiền</h3>";

$total = $cart->calculateTotal();

echo "Tổng tiền giỏ hàng: <strong>"
    . number_format($total)
    . " VNĐ</strong><br>";

// Xóa sản phẩm
echo "<h3>5. Xóa sản phẩm</h3>";

$cart->removeItem("Bàn phím");

// Thử xóa sản phẩm không tồn tại
$cart->removeItem("Điện thoại");

// Hiển thị lại giỏ hàng
echo "<h3>6. Giỏ hàng sau khi xóa</h3>";
$cart->displayCart();

?>
