<?php
include "../../config/connect.php";

// Lấy thông tin tác giả từ cơ sở dữ liệu
function get_tacgia_by_id($this_id)
{
    global $conn;
    $sql = "SELECT * FROM tacgia WHERE ma_tgia = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $this_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Cập nhật thông tin tác giả
function update_tacgia($this_id, $ten_tgia, $hinh_tgia)
{
    global $conn;
    $sql = "UPDATE tacgia SET ten_tgia=?, hinh_tgia=? WHERE ma_tgia=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $ten_tgia, $hinh_tgia, $this_id);
    return mysqli_stmt_execute($stmt);
}
