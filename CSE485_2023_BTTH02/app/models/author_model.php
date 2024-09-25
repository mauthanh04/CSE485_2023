<?php
include '../../config/connect.php'; // Đảm bảo đường dẫn chính xác

$sql = "SELECT * FROM tacgia";

$result = mysqLi_query($conn, $sql);
