<?php
    include "../models/edit_category_models.php";

    $this_id = $_GET['this_id'];
    $row = get_Theloai_by_id($this_id);
    if(isset($_POST['luulai'])){
        $ten_tloai = $_POST['ten_tloai'];
        if (update_TheLoai($this_id, $ten_tloai)) {
            header('Location: ../views/category_views.php');
            exit();
        } else {
            die("Lỗi khi cập nhật thể loại.");
        }
    }
    

?>