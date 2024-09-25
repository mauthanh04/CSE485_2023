<?php
include "../../config/connect.php";

function themBaiViet($tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh) {
    global $conn;
    
    $sql = "INSERT INTO baiviet (tieude, ten_bhat, ma_tloai, tomtat, noidung, ma_tgia, ngayviet, hinhanh) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    $formatted_ngayviet = date("Y-m-d", strtotime($ngayviet));
    mysqli_stmt_bind_param($stmt, "ssssssss", $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $formatted_ngayviet, $hinhanh);
    
    return mysqli_stmt_execute($stmt);
}

function kiemTraTonTai($table, $field, $value) {
    global $conn;
    
    $sql = "SELECT * FROM $table WHERE $field = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $value);
    mysqli_stmt_execute($stmt);
    
    return mysqli_stmt_get_result($stmt);
}
?>
