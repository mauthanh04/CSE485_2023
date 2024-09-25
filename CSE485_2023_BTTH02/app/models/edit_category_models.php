<?php
include "../../config/connect.php";

function get_Theloai_by_id($this_id) {
    global $conn;
    $sql = "SELECT * FROM theloai WHERE ma_tloai = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $this_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function update_TheLoai($this_id, $ten_tloai) {
    global $conn;
    $sql = "UPDATE theloai SET ten_tloai = ? WHERE ma_tloai = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $ten_tloai, $this_id);
    return mysqli_stmt_execute($stmt);
    
}
?>
