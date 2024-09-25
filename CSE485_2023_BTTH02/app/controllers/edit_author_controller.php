<?php
include "../models/edit_author_model.php";

// Lấy ID từ URL
$this_id = $_GET['this_id'] ?? '';

if (!$this_id) {
    die("ID tác giả không tồn tại.");
}

// Lấy thông tin tác giả
$row = get_tacgia_by_id($this_id);

if (!$row) {
    die("Tác giả không tồn tại.");
}

// Kiểm tra nếu form được submit
if (isset($_POST['luulai'])) {
    $ten_tgia = mysqli_real_escape_string($conn, $_POST['ten_tgia']);
    $hinh_tgia = $row['hinh_tgia']; // Dùng hình ảnh hiện tại mặc định

    // Kiểm tra và xử lý hình ảnh
    if (isset($_FILES['hinh_tgia']) && $_FILES['hinh_tgia']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['hinh_tgia']['name'];
        $image_tmp = $_FILES['hinh_tgia']['tmp_name'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($image_ext, $valid_extensions)) {
            $upload_dir = '../../public/images/songs/';
            $image_path = $upload_dir . uniqid() . "_" . basename($image_name);

            // Xóa hình ảnh cũ nếu có
            if (file_exists($row['hinh_tgia'])) {
                unlink($row['hinh_tgia']);
            }

            if (move_uploaded_file($image_tmp, $image_path)) {
                $hinh_tgia = $image_path; // Cập nhật đường dẫn hình ảnh mới
            } else {
                die("Lỗi tải ảnh lên.");
            }
        } else {
            die("Chỉ chấp nhận các định dạng jpg, jpeg, png, gif.");
        }
    }

    // Cập nhật thông tin tác giả
    if (update_tacgia($this_id, $ten_tgia, $hinh_tgia)) {
        header('Location: ../views/author_view.php');
        exit();
    } else {
        die("Lỗi khi cập nhật tác giả.");
    }
}
