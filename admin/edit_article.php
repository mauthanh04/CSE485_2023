<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music for Life</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style_login.css">
</head>

<?php
include "connect.php";

// Lấy giá trị của tham số 'this_id' từ URL
$this_id = $_GET['this_id'] ?? '';

// Tạo câu lệnh SQL để lấy thông tin tác giả theo ID
$sql = "SELECT * FROM baiviet WHERE ma_bviet = '$this_id'";

// Thực thi câu lệnh SQL và lưu kết quả vào biến $query
$query = mysqli_query($conn, $sql);

// Lấy hàng đầu tiên từ kết quả truy vấn và lưu vào biến $row
$row = mysqli_fetch_assoc($query);

if (isset($_POST['luulai'])) {
    $tieude = mysqli_real_escape_string($conn, $_POST['tieude']);
    $ten_bhat = mysqli_real_escape_string($conn, $_POST['ten_bhat']);
    $ma_tloai = mysqli_real_escape_string($conn, $_POST['ma_tloai']);
    $tomtat = mysqli_real_escape_string($conn, $_POST['tomtat']);
    $noidung = mysqli_real_escape_string($conn, $_POST['noidung']);
    $ma_tgia = mysqli_real_escape_string($conn, $_POST['ma_tgia']);
    $ngayviet = mysqli_real_escape_string($conn, $_POST['ngayviet']);
    $hinhanh = $row['hinhanh']; // Dùng hình ảnh hiện tại mặc định

    // Kiểm tra nếu ảnh mới được chọn
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['hinhanh']['name'];
        $image_tmp = $_FILES['hinhanh']['tmp_name'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($image_ext, $valid_extensions)) {
            $upload_dir = 'uploads/';
            $image_path = $upload_dir . basename($image_name);

            // Xóa hình ảnh cũ nếu có
            if (file_exists($row['hinhanh'])) {
                unlink($row['hinhanh']);
            }

            if (move_uploaded_file($image_tmp, $image_path)) {
                $hinhanh = $image_path; // Cập nhật đường dẫn hình ảnh mới
            } else {
                echo "Lỗi tải ảnh lên!";
            }
        } else {
            echo "Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG, GIF.";
        }
    }

    // Cập nhật thông tin bài viết bằng prepared statement
    $sql = "UPDATE baiviet SET 
    tieude = ?, 
    ten_bhat = ?, 
    ma_tloai = ?, 
    tomtat = ?, 
    noidung = ?, 
    ma_tgia = ?, 
    ngayviet = ?, 
    hinhanh = ? 
    WHERE ma_bviet='$this_id'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssi", $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Cập nhật bài viết thành công!";
    header('Location: article.php');
    exit();
    } else {
    echo "Lỗi khi cập nhật bài viết: " . mysqli_error($conn);
    }
}
?>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">Trang ngoài</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="category.php">Thể loại</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="author.php">Tác giả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active fw-bold" href="article.php">Bài viết</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Sửa thông bài viết</h3>
                <form method="post" enctype="multipart/form-data">
                    <?php
                    if ($row) {
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Mã bài viết</span>
                            <input type="text" class="form-control" name="ma_bviet" value="' . htmlspecialchars($row['ma_bviet']) . '" readonly>
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Tiêu đề</span>
                            <input type="text" class="form-control" name="tieude" value="' . htmlspecialchars($row['tieude']) . '">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Tên bài hát</span>
                            <input type="text" class="form-control" name="ten_bhat" value="' . htmlspecialchars($row['ten_bhat']) . '">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Mã thể loại</span>
                            <input type="text" class="form-control" name="ma_tloai" value="' . htmlspecialchars($row['ma_tloai']) . '">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Tóm tắt</span>
                            <input type="text" class="form-control" name="tomtat" value="' . htmlspecialchars($row['tomtat']) . '">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Nội dung</span>
                            <input type="text" class="form-control" name="noidung" value="' . htmlspecialchars($row['noidung']) . '">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Mã tác giả</span>
                            <input type="text" class="form-control" name="ma_tgia" value="' . htmlspecialchars($row['ma_tgia']) . '">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Ngày viết</span>
                            <input type="date" class="form-control" name="ngayviet" value="' . htmlspecialchars($row['ngayviet']) . '">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Hình ảnh hiện tại</span>
                            <img src="' . htmlspecialchars($row['hinhanh']) . '" alt="Hình tác giả" style="width: 100px; height: auto;">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Chọn hình ảnh mới</span>
                            <input type="file" name="hinhanh" class="form-control">
                        </div>';
                    } else {
                        echo '<div class="alert alert-danger">Không tìm thấy tác giả.</div>';
                    }
                    ?>
                    <div class="form-group float-end">
                        <input type="submit" value="Lưu lại" name="luulai" class="btn btn-success">
                        <a href="article.php" class="btn btn-warning">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>