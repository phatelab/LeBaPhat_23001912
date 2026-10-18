<?php

require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/user.php';

// Đã đăng nhập thì không cần đăng ký
if (isLoggedIn()) {
    header('Location: product_list.php');
    exit;
}

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Tên đăng nhập và mật khẩu không được để trống.';
    } elseif (strlen($username) > 50) {
        $error = 'Tên đăng nhập tối đa 50 ký tự.';
    } elseif (getUserByUsername($username)) {
        $error = 'Tên đăng nhập đã tồn tại.';
    } else {

        addUser($username, $password);

        $_SESSION['flash'] = 'Đăng ký thành công! Vui lòng đăng nhập.';

        header('Location: login.php');
        exit;
    }
}

require_once __DIR__ . '/view/header.php';
?>

<h2>Đăng ký tài khoản</h2>

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
            maxlength="50"
            value="<?= htmlspecialchars($username) ?>"
        >
    </p>

    <p>
        <label>Mật khẩu:</label><br>
        <input type="password" name="password">
    </p>

    <button type="submit">Đăng ký</button>

    <a href="login.php">Đã có tài khoản? Đăng nhập</a>

</form>

<?php
require_once __DIR__ . '/view/footer.php';
?>
