<?php
//lấy id của sản phẩm
$this_id = $_GET['this_id'];

include "connect.php";

$sql = "DELETE FROM tacgia WHERE ma_tgia = '$this_id '";

mysqLi_query($conn, $sql);

header('location: author.php');
