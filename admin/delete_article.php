<?php
//lấy id của sản phẩm
$this_id = $_GET['this_id'];

include "connect.php";

$sql = "DELETE FROM baiviet WHERE ma_bviet = '$this_id '";

mysqLi_query($conn, $sql);

header('location: article.php');
