<?php
include "../models/add_article_models.php";

if (isset($_POST['them'])) {
    $tieude = mysqli_real_escape_string($conn, $_POST['tieude']);
    $ten_bhat = mysqli_real_escape_string($conn, $_POST['ten_bhat']);
    $ma_tloai = mysqli_real_escape_string($conn, $_POST['ma_tloai']);
    $tomtat = mysqli_real_escape_string($conn, $_POST['tomtat']);
    $noidung = mysqli_real_escape_string($conn, $_POST['noidung']);
    $ma_tgia = mysqli_real_escape_string($conn, $_POST['ma_tgia']);
    $ngayviet = mysqli_real_escape_string($conn, $_POST['ngayviet']);
    
    // Kiểm tra mã thể loại và mã tác giả
    $theloai_result = kiemTraTonTai("theloai", "ma_tloai", $ma_tloai);
    $tacgia_result = kiemTraTonTai("tacgia", "ma_tgia", $ma_tgia);
    
    if (mysqli_num_rows($theloai_result) == 0 || mysqli_num_rows($tacgia_result) == 0) {
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
        $target_dir = "../../public/images/songs/";
        $target_file = $target_dir . $new_filename;
        
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        if (move_uploaded_file($_FILES["hinhanh"]["tmp_name"], $target_file)) {
            if (themBaiViet($tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $target_file)) {
                header('Location: ../views/article_views.php');
                exit();
            } else {
                echo "Lỗi khi thêm bài viết.";
            }
        } else {
            echo "Lỗi khi tải lên ảnh.";
        }
    } else {
        echo "Vui lòng chọn một file ảnh!";
    }
}
?>