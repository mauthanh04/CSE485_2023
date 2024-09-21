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

if (isset($_POST['them'])) {
    // Lấy dữ liệu từ form và thoát các ký tự đặc biệt
    $tieude = mysqli_real_escape_string($conn, $_POST['tieude']);
    $ten_bhat = mysqli_real_escape_string($conn, $_POST['ten_bhat']);
    $ma_tloai = mysqli_real_escape_string($conn, $_POST['ma_tloai']);
    $tomtat = mysqli_real_escape_string($conn, $_POST['tomtat']);
    $noidung = mysqli_real_escape_string($conn, $_POST['noidung']);
    $ma_tgia = mysqli_real_escape_string($conn, $_POST['ma_tgia']);
    $ngayviet = mysqli_real_escape_string($conn, $_POST['ngayviet']);

    // Kiểm tra sự tồn tại của mã thể loại và mã tác giả
    $sql_check_theloai = "SELECT * FROM theloai WHERE ma_tloai = ?";
    $sql_check_tacgia = "SELECT * FROM tacgia WHERE ma_tgia = ?";

    $stmt_theloai = mysqli_prepare($conn, $sql_check_theloai);
    mysqli_stmt_bind_param($stmt_theloai, "i", $ma_tloai);
    mysqli_stmt_execute($stmt_theloai);
    $result_theloai = mysqli_stmt_get_result($stmt_theloai);

    $stmt_tacgia = mysqli_prepare($conn, $sql_check_tacgia);
    mysqli_stmt_bind_param($stmt_tacgia, "i", $ma_tgia);
    mysqli_stmt_execute($stmt_tacgia);
    $result_tacgia = mysqli_stmt_get_result($stmt_tacgia);

    if (mysqli_num_rows($result_theloai) == 0 || mysqli_num_rows($result_tacgia) == 0) {
        echo "Mã thể loại hoặc mã tác giả không tồn tại. Vui lòng kiểm tra lại.";
        exit();
    }

    // Upload ảnh
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $temp = explode(".", $_FILES["hinhanh"]["name"]);
        $extension = end($temp);

        if (!in_array($extension, $allowed_types)) {
            echo "Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG, GIF.";
            exit();
        }

        $new_filename = uniqid() . "." . $extension;
        $target_dir = "uploads/";
        $target_file = $target_dir . $new_filename;

        // Tạo thư mục uploads nếu chưa tồn tại
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
            // Chèn dữ liệu vào bảng baiviet
            $sql = "INSERT INTO baiviet (tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet, hinhanh) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            // Định dạng lại ngày viết và liên kết các biến
            $formatted_ngayviet = date("Y-m-d", strtotime($ngayviet));
            mysqli_stmt_bind_param($stmt, "ssssssss", $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $formatted_ngayviet, $target_file);

            if (mysqli_stmt_execute($stmt)) {
                echo "Thêm bài viết thành công!";
                header('Location: article.php'); // Chuyển hướng về trang danh sách bài viết
                exit();
            } else {
                echo "Lỗi khi thêm bài viết: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Lỗi khi tải lên ảnh.";
        }
    } else {
        echo "Vui lòng chọn một file ảnh!";
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
                <h3 class="text-center text-uppercase fw-bold">Thêm mới bài viết</h3>
                <form action="add_article.php" method="post" enctype="multipart/form-data">
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Tiêu đề</span>
                        <input type="text" class="form-control" name="tieude" >
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" >Tên bài hát</span>
                        <input type="text" class="form-control" name="ten_bhat" >
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" >Mã thể loại</span>
                        <input type="text" class="form-control" name="ma_tloai" >
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" >Tóm tắt</span>
                        <input type="text" class="form-control" name="tomtat" >
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Nội dung</span>
                        <input type="text" class="form-control" name="noidung" >
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" >Mã tác giả</span>
                        <input type="text" class="form-control" name="ma_tgia" >
                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text">Ngày viết</span>
                        <input type="date" class="form-control" name="ngayviet">  

                    </div>
                    <div class="input-group mt-3 mb-3">
                        <span class="input-group-text" >Hình bài viết</span>
                        <input type="file" name="hinhanh" required>
                    </div>

                    <div class="form-group  float-end ">
                        <input type="submit" value="Thêm" name='them' class="btn btn-success">
                        <a href="article.php" class="btn btn-warning ">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary  border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

