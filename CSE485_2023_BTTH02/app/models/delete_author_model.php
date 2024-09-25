<?php
$this_id = $_GET['this_id'];

include "../../config/connect.php";

$sql = "DELETE FROM tacgia WHERE ma_tgia = '$this_id '";

mysqLi_query($conn, $sql);

header('location: ../views/author_view.php');
