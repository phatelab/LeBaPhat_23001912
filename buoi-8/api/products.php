
<?php
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$dbname = 'php_vue_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Không thể kết nối cơ sở dữ liệu'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function response($success, $message = '', $data = null, $code = 200) {
    http_response_code($code);

    $result = ['success' => $success];

    if ($message !== '') {
        $result['message'] = $message;
    }

    if ($data !== null) {
        $result['data'] = $data;
    }

    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

function getInput() {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!is_array($data)) {
        response(false, 'Dữ liệu JSON không hợp lệ', null, 400);
    }

    return $data;
}

function validate($data) {
    $name = trim($data['name'] ?? '');

    if (mb_strlen($name) < 1 || mb_strlen($name) > 100) {
        response(false, 'Tên sản phẩm phải từ 1 đến 100 ký tự', null, 400);
    }

    $price = $data['price'] ?? null;
    $stock = $data['stock'] ?? null;

    if (
        !is_int($price) ||
        $price <= 0
    ) {
        response(false, 'Đơn giá phải là số nguyên lớn hơn 0', null, 400);
    }

    if (
        !is_int($stock) ||
        $stock < 0
    ) {
        response(false, 'Số lượng tồn phải là số nguyên không âm', null, 400);
    }

    return [$name, $price, $stock];
}

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {

        case 'GET':
            $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
            response(true, '', $stmt->fetchAll());
            break;

        case 'POST':
            $data = getInput();
            [$name, $price, $stock] = validate($data);

            $stmt = $pdo->prepare(
                "INSERT INTO products (name, price, stock)
                 VALUES (:name, :price, :stock)"
            );

            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':stock' => $stock
            ]);

            response(true, 'Thêm sản phẩm thành công');
            break;

        case 'PUT':
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if (!$id || $id < 1) {
                response(false, 'ID không hợp lệ', null, 400);
            }

            $data = getInput();
            [$name, $price, $stock] = validate($data);

            $stmt = $pdo->prepare(
                "UPDATE products
                 SET name = :name, price = :price, stock = :stock
                 WHERE id = :id"
            );

            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':stock' => $stock,
                ':id' => $id
            ]);

            if ($stmt->rowCount() === 0) {
                $check = $pdo->prepare(
                    "SELECT id FROM products WHERE id = ?"
                );
                $check->execute([$id]);

                if (!$check->fetch()) {
                    response(false, 'Sản phẩm không tồn tại', null, 404);
                }
            }

            response(true, 'Cập nhật sản phẩm thành công');
            break;

        case 'DELETE':
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

            if (!$id || $id < 1) {
                response(false, 'ID không hợp lệ', null, 400);
            }

            $stmt = $pdo->prepare(
                "DELETE FROM products WHERE id = ?"
            );

            $stmt->execute([$id]);

            if ($stmt->rowCount() === 0) {
                response(false, 'Sản phẩm không tồn tại', null, 404);
            }

            response(true, 'Xóa sản phẩm thành công');
            break;

        default:
            response(false, 'Phương thức không được hỗ trợ', null, 405);
    }

} catch (PDOException $e) {
    response(false, 'Lỗi cơ sở dữ liệu', null, 500);
}
