<?php

require_once __DIR__ . '/../common/dbConnect.php';

function getAllProducts()
{
    global $conn;

    $sql = "SELECT * FROM products ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProductById($id)
{
    global $conn;

    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addProduct($name, $price, $quantity)
{
    global $conn;

    $sql = "INSERT INTO products (name, price, quantity)
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        $name,
        $price,
        $quantity
    ]);
}

function updateProduct($id, $name, $price, $quantity)
{
    global $conn;

    $sql = "UPDATE products
            SET name = ?, price = ?, quantity = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        $name,
        $price,
        $quantity,
        $id
    ]);
}

function deleteProduct($id)
{
    global $conn;

    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);

    return $stmt->execute([$id]);
}
