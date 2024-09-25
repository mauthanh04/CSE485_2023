<?php
include "../../config/connect.php";

// Lấy thông tin bài viết từ cơ sở dữ liệu
function get_baiviet_by_id($this_id) {
    global $conn;
    $sql = "SELECT * FROM baiviet WHERE ma_bviet = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $this_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Cập nhật thông tin bài viết
function update_baiviet($this_id, $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh) {
    global $conn;
    $sql = "UPDATE baiviet SET 
        tieude = ?, 
        ten_bhat = ?, 
        ma_tloai = ?, 
        tomtat = ?, 
        noidung = ?, 
        ma_tgia = ?, 
        ngayviet = ?, 
        hinhanh = ? 
        WHERE ma_bviet = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssi", $tieude, $ten_bhat, $ma_tloai, $tomtat, $noidung, $ma_tgia, $ngayviet, $hinhanh, $this_id);
    return mysqli_stmt_execute($stmt);
}