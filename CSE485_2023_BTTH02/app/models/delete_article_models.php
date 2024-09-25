<?php
$this_id = $_GET['this_id'];

include "../../config/connect.php";

$sql = "DELETE FROM baiviet WHERE ma_bviet = '$this_id '";

mysqLi_query($conn, $sql);

header('location: ../views/article_views.php');

?>

