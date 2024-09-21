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
$sql = "SELECT * FROM tacgia WHERE ma_tgia = '$this_id'";

// Thực thi câu lệnh SQL và lưu kết quả vào biến $query
$query = mysqli_query($conn, $sql);

// Lấy hàng đầu tiên từ kết quả truy vấn và lưu vào biến $row
$row = mysqli_fetch_assoc($query);

if (isset($_POST['luulai'])) {
    $ten_tgia = mysqli_real_escape_string($conn, $_POST['ten_tgia']);
    $hinh_tgia = $row['hinh_tgia']; // Dùng hình ảnh hiện tại mặc định

    // Kiểm tra nếu ảnh mới được chọn
    if (isset($_FILES['hinh_tgia']) && $_FILES['hinh_tgia']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['hinh_tgia']['name'];
        $image_tmp = $_FILES['hinh_tgia']['tmp_name'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($image_ext, $valid_extensions)) {
            $upload_dir = 'uploads/';
            $image_path = $upload_dir . basename($image_name);

            // Xóa hình ảnh cũ nếu có
            if (file_exists($row['hinh_tgia'])) {
                unlink($row['hinh_tgia']);
            }

            if (move_uploaded_file($image_tmp, $image_path)) {
                $hinh_tgia = $image_path; // Cập nhật đường dẫn hình ảnh mới
            } else {
                echo "Lỗi tải ảnh lên!";
            }
        } else {
            echo "Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG, GIF.";
        }
    }

    // Cập nhật thông tin tác giả
    $sql = "UPDATE tacgia SET ten_tgia='$ten_tgia', hinh_tgia='$hinh_tgia' WHERE ma_tgia='$this_id'";

    if (mysqli_query($conn, $sql)) {
        header('Location: author.php');
        exit();
    } else {
        echo "Lỗi: " . mysqli_error($conn);
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
                            <a class="nav-link active fw-bold" href="author.php">Tác giả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="article.php">Bài viết</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-sm">
                <h3 class="text-center text-uppercase fw-bold">Sửa thông tin tác giả</h3>
                <form method="post" enctype="multipart/form-data">
                    <?php
                    if ($row) {
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text" id="lblCatId">Mã tác giả</span>
                            <input type="text" class="form-control" name="ma_tgia" value="' . htmlspecialchars($row['ma_tgia']) . '" readonly>
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text" id="lblCatName">Tên tác giả</span>
                            <input type="text" class="form-control" name="ten_tgia" value="' . htmlspecialchars($row['ten_tgia']) . '">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Hình ảnh hiện tại</span>
                            <img src="' . htmlspecialchars($row['hinh_tgia']) . '" alt="Hình tác giả" style="width: 100px; height: auto;">
                        </div>';
                        echo '<div class="input-group mt-3 mb-3">
                            <span class="input-group-text">Chọn hình ảnh mới</span>
                            <input type="file" name="hinh_tgia" class="form-control">
                        </div>';
                    } else {
                        echo '<div class="alert alert-danger">Không tìm thấy tác giả.</div>';
                    }
                    ?>
                    <div class="form-group float-end">
                        <input type="submit" value="Lưu lại" name="luulai" class="btn btn-success">
                        <a href="author.php" class="btn btn-warning">Quay lại</a>
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