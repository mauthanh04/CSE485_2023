<?php
//lấy id của sản phẩm
$this_id = $_GET['this_id'];

include "connect.php";

$sql = "DELETE FROM theloai WHERE ma_tloai = '$this_id '";

mysqLi_query($conn, $sql);

header('location: category.php');
