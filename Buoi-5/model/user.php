<?php

require_once __DIR__ . '/../common/dbConnect.php';

function getUserByUsername($username)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addUser($username, $password)
{
    global $conn;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    return $stmt->execute([
        $username,
        $hashedPassword
    ]);
}
