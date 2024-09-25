<?php
    include "../../config/connect.php";

    $sql = "SELECT * FROM theloai";

    $result = mysqLi_query($conn, $sql);
?>