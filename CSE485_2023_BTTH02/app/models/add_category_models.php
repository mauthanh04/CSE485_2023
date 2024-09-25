<?php

    include "../../config/connect.php";

    function themTheLoai($ten_tloai) {
        global $conn;
        $sql = "INSERT INTO theloai (ten_tloai) VALUES('$ten_tloai')";
        $stmt = mysqli_prepare($conn, $sql);
        return mysqli_stmt_execute($stmt);
    }
?>
