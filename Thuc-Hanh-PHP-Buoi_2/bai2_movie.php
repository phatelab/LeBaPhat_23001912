<?php

class Movie
{
    private int $id;
    private string $title;
    private float $price;
    private int $totalSeats;
    private int $availableSeats;

    public function __construct($id, $title, $price, $totalSeats)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }

    public function bookTicket($quantity)
    {
        if ($quantity <= 0) {
            echo "Lỗi: Số lượng vé đặt phải lớn hơn 0.<br>";
            return false;
        }

        if ($quantity > $this->availableSeats) {
            echo "Lỗi: Không đủ ghế. Phim \"" .
                 htmlspecialchars($this->title) .
                 "\" chỉ còn " .
                 $this->availableSeats .
                 " ghế.<br>";
            return false;
        }

        $this->availableSeats -= $quantity;

        echo "Đặt thành công "
            . $quantity
            . " vé phim \""
            . htmlspecialchars($this->title)
            . "\".<br>";

        return true;
    }

    public function cancelTicket($quantity)
    {
        if ($quantity <= 0) {
            echo "Lỗi: Số lượng vé hủy phải lớn hơn 0.<br>";
            return false;
        }

        $soldSeats = $this->getSoldSeats();

        if ($quantity > $soldSeats) {
            echo "Lỗi: Không thể hủy "
                . $quantity
                . " vé. Phim \""
                . htmlspecialchars($this->title)
                . "\" chỉ có "
                . $soldSeats
                . " vé đã bán.<br>";

            return false;
        }

        $this->availableSeats += $quantity;

        echo "Hủy thành công "
            . $quantity
            . " vé phim \""
            . htmlspecialchars($this->title)
            . "\".<br>";

        return true;
    }

    public function getSoldSeats()
    {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue()
    {
        return $this->getSoldSeats() * $this->price;
    }

    public function displayInfo()
    {
        echo "<div style='margin-bottom: 20px;'>";

        echo "<strong>Mã phim:</strong> " . $this->id . "<br>";
        echo "<strong>Tên phim:</strong> "
            . htmlspecialchars($this->title)
            . "<br>";
        echo "<strong>Giá vé:</strong> "
            . number_format($this->price)
            . " VNĐ<br>";
        echo "<strong>Tổng số ghế:</strong> "
            . $this->totalSeats
            . "<br>";
        echo "<strong>Số ghế còn lại:</strong> "
            . $this->availableSeats
            . "<br>";
        echo "<strong>Số vé đã bán:</strong> "
            . $this->getSoldSeats()
            . "<br>";
        echo "<strong>Doanh thu:</strong> "
            . number_format($this->getRevenue())
            . " VNĐ<br>";

        echo "</div>";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }
}


// ======================================
// FUNCTION XỬ LÝ DANH SÁCH PHIM
// ======================================

function findMovieById($movies, $id)
{
    foreach ($movies as $movie) {
        if ($movie instanceof Movie && $movie->getId() == $id) {
            return $movie;
        }
    }

    return null;
}


function getTotalRevenue($movies)
{
    if (empty($movies)) {
        return 0;
    }

    $totalRevenue = 0;

    foreach ($movies as $movie) {
        if ($movie instanceof Movie) {
            $totalRevenue += $movie->getRevenue();
        }
    }

    return $totalRevenue;
}


function getBestSellingMovie($movies)
{
    if (empty($movies)) {
        return null;
    }

    $bestSellingMovie = null;
    $maxSoldSeats = -1;

    foreach ($movies as $movie) {
        if (!$movie instanceof Movie) {
            continue;
        }

        $soldSeats = $movie->getSoldSeats();

        if ($soldSeats > $maxSoldSeats) {
            $maxSoldSeats = $soldSeats;
            $bestSellingMovie = $movie;
        }
    }

    return $bestSellingMovie;
}


// ======================================
// CHƯƠNG TRÌNH CHÍNH
// ======================================

echo "<h1>BÀI 2 - QUẢN LÝ VÉ XEM PHIM</h1>";


// 1. Tạo danh sách phim
$movies = [
    new Movie(1, "Avengers", 100000, 100),
    new Movie(2, "Avatar", 120000, 80),
    new Movie(3, "Batman", 90000, 120)
];


// 2. Tìm phim Avengers và đặt vé
echo "<h3>1. Đặt vé Avengers</h3>";

$avengers = findMovieById($movies, 1);

if ($avengers !== null) {
    $avengers->bookTicket(30);
} else {
    echo "Không tìm thấy phim Avengers.<br>";
}


// 3. Tìm phim Avatar và đặt vé
echo "<h3>2. Đặt vé Avatar</h3>";

$avatar = findMovieById($movies, 2);

if ($avatar !== null) {
    $avatar->bookTicket(40);
} else {
    echo "Không tìm thấy phim Avatar.<br>";
}


// 4. Hủy một số vé Avengers
echo "<h3>3. Hủy vé Avengers</h3>";

if ($avengers !== null) {
    $avengers->cancelTicket(5);
}


// 5. Kiểm tra các trường hợp không hợp lệ
echo "<h3>4. Kiểm tra trường hợp không hợp lệ</h3>";

if ($avengers !== null) {
    // Đặt số vé <= 0
    $avengers->bookTicket(0);

    // Đặt vượt quá số ghế còn lại
    $avengers->bookTicket(1000);

    // Hủy số vé <= 0
    $avengers->cancelTicket(0);

    // Hủy vượt quá số vé đã bán
    $avengers->cancelTicket(1000);
}


// 6. Tìm phim không tồn tại
echo "<h3>5. Tìm phim không tồn tại</h3>";

$movieNotFound = findMovieById($movies, 999);

if ($movieNotFound === null) {
    echo "Không tìm thấy phim có ID = 999.<br>";
}


// 7. Hiển thị tất cả phim
echo "<h3>6. Thông tin tất cả các phim</h3>";

if (empty($movies)) {
    echo "Danh sách phim đang trống.<br>";
} else {
    foreach ($movies as $movie) {
        $movie->displayInfo();
        echo "<hr>";
    }
}


// 8. Tính tổng doanh thu
echo "<h3>7. Tổng doanh thu</h3>";

$totalRevenue = getTotalRevenue($movies);

echo "Tổng doanh thu của tất cả phim: <strong>"
    . number_format($totalRevenue)
    . " VNĐ</strong><br>";


// 9. Tìm phim bán được nhiều vé nhất
echo "<h3>8. Phim có số vé bán ra nhiều nhất</h3>";

$bestSellingMovie = getBestSellingMovie($movies);

if ($bestSellingMovie === null) {
    echo "Danh sách phim đang trống hoặc không có phim hợp lệ.<br>";
} else {
    echo "Phim có số vé bán ra nhiều nhất: <strong>"
        . htmlspecialchars($bestSellingMovie->getTitle())
        . "</strong><br>";

    echo "Số vé đã bán: "
        . $bestSellingMovie->getSoldSeats()
        . "<br>";
}


// 10. Kiểm tra các function với danh sách rỗng
echo "<h3>9. Kiểm tra danh sách phim rỗng</h3>";

$emptyMovies = [];

$totalEmptyRevenue = getTotalRevenue($emptyMovies);

echo "Tổng doanh thu khi danh sách rỗng: "
    . number_format($totalEmptyRevenue)
    . " VNĐ<br>";

$bestEmptyMovie = getBestSellingMovie($emptyMovies);

if ($bestEmptyMovie === null) {
    echo "Không có phim nào trong danh sách.<br>";
}

$emptyFindMovie = findMovieById($emptyMovies, 1);

if ($emptyFindMovie === null) {
    echo "Không tìm thấy phim vì danh sách đang rỗng.<br>";
}

?>
