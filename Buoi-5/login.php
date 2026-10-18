<?php

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/user.php';

// Đã đăng nhập thì chuyển thẳng vào trang quản lý
if (isLoggedIn()) {
    header('Location: product_list.php');
    exit;
}

$error = '';
$username = '';

// Thông báo từ trang đăng ký (nếu có)
$message = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Vui lòng nhập tên đăng nhập và mật khẩu.';
    } else {

        $user = getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {

            // Tạo session id mới để tránh session fixation
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header('Location: product_list.php');
            exit;
        }

        $error = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    }
}

require_once __DIR__ . '/view/header.php';
?>

<h2>Đăng nhập</h2>

<?php if ($message !== ''): ?>
    <p style="color: green;">
        <?= htmlspecialchars($message) ?>
    </p>
<?php endif; ?>

<?php if ($error !== ''): ?>
    <p style="color: red;">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="post">

    <p>
        <label>Tên đăng nhập:</label><br>
        <input
            type="text"
            name="username"
            value="<?= htmlspecialchars($username) ?>"
        >
    </p>

    <p>
        <label>Mật khẩu:</label><br>
        <input type="password" name="password">
    </p>

    <button type="submit">Đăng nhập</button>

    <a href="register.php">Chưa có tài khoản? Đăng ký</a>

</form>

<?php
require_once __DIR__ . '/view/footer.php';
?>
