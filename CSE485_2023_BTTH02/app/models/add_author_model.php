<?php
include '../../config/connect.php';

// Thêm tác giả
function themtacgia($ten_tgia, $hinh_tgia)
{
    global $conn;

    $sql = "INSERT INTO tacgia (ten_tgia, hinh_tgia) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $ten_tgia, $hinh_tgia);

    return mysqli_stmt_execute($stmt);
}

// Kiểm tra tồn tại (nếu cần, có thể bỏ)
function kiemTraTonTai($table, $field, $value)
{
    global $conn;

    $sql = "SELECT * FROM $table WHERE $field = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $value);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}
