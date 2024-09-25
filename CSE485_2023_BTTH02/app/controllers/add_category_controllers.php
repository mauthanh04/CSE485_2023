<?php
    include "../models/add_category_models.php";

    if(isset($_POST['them'])){
        $ten_tloai = $_POST['ten_tloai'];

        
        $sql = "INSERT INTO theloai (ten_tloai)
        VALUES('$ten_tloai')";
        mysqLi_query($conn, $sql);
    header('Location: ../views/category_views.php');
    }
?>