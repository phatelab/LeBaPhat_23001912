<?php
$prices = [15000000, 500000, 1200000, 800000, 5000000];
function calculateTotal($arr)
{
    $total = 0;
    foreach ($arr as $price) {
        $total += $price;
    }
    return $total;
}

function findMaxPrice($arr)
{
    $max = $arr[0];
    foreach ($arr as $price) {
        if ($price > $max) {
            $max = $price;
        }
    }
    return $max;
}
$total = calculateTotal($prices);
$maxPrice = findMaxPrice($prices);

echo "Danh sách giá sản phẩm: " . implode(", ", $prices) . "<br>";
echo "Tổng giá trị sản phẩm: " . $total . "<br>";
echo "Giá sản phẩm cao nhất: " . $maxPrice . "<br>";
?>
