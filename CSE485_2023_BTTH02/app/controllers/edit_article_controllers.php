<?php
include "../models/edit_article_models.php";

// Lấy ID từ URL
$this_id = $_GET['this_id'] ?? '';

if (!$this_id) {
    die("ID bài viết không tồn tại.");
}

// Lấy thông tin bài viết
$row = get_baiviet_by_id($this_id);

if (!$row) {
    die("Bài viết không tồn tại.");
}

// Kiểm tra nếu form được submit
if (isset($_POST['luulai'])) {
    $tieude = $_POST['tieude'];
    $ten_bhat = $_POST['ten_bhat'];
    $ma_tloai = $_POST['ma_tloai'];
    $tomtat = $_POST['tomtat'];
    $noidung = $_POST['noidung'];
    $ma_tgia = $_POST['ma_tgia'];
    $ngayviet = $_POST['ngayviet'];
    
    // Kiểm tra và xử lý hình ảnh
    $hinhanh = $row['hinhanh'];
    if (isset($_FILES['hinhanh']) && $_FILES['hinhanh']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../public/images/songs/";
        $target_file = $target_dir . uniqid() . "_" . basename($_FILES["hinhanh"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $max_size = 500000;

        if (in_array($imageFileType, $allowed_types) && $_FILES["hinhanh"]["size"] <= $max_size) {
            if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
                $hinhanh = $target_file;
            } else {
                die("Lỗi upload hình ảnh.");
            }
        } else {
            die("Chỉ chấp nhận các định dạng jpg, jpeg, png, gif, tối đa 500KB.");
        }
    }

    // Cập nhật bài viết
    if (update_baiviet($this_id, $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh)) {
        header('Location: ../views/article_views.php');
        exit();
    } else {
        die("Lỗi khi cập nhật bài viết.");
    }
}

?>