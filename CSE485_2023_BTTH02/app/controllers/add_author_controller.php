<?php
include "../../config/connect.php";
include "../Models/add_author_model.php";

if (isset($_POST['them'])) {
    // Escape input
    $ten_tgia = mysqli_real_escape_string($conn, $_POST['ten_tgia']);

    // Upload ảnh
    if (isset($_FILES['hinh_tgia']) && $_FILES['hinh_tgia']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $temp = explode(".", $_FILES["hinh_tgia"]["name"]);
        $extension = strtolower(end($temp));

        if (!in_array($extension, $allowed_types)) {
            echo "Chỉ chấp nhận các định dạng ảnh JPG, JPEG, PNG, GIF.";
            exit();
        }

        $new_filename = uniqid() . "." . $extension;
        $target_dir = "../../public/images/songs/";
        $target_file = $target_dir . $new_filename;

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES["hinh_tgia"]["tmp_name"], $target_file)) {
            if (themtacgia($ten_tgia, $target_file)) {
                header('Location: ../views/author_view.php');
                exit();
            } else {
                echo "Lỗi khi thêm tác giả.";
            }
        } else {
            echo "Lỗi khi tải lên ảnh.";
        }
    } else {
        echo "Vui lòng chọn một file ảnh!";
    }
}
