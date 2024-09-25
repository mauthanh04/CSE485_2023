<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["search"])) {
        $search = $_POST["search"];


        if ($search == "thể loại") {
            header('location: ./category_views.php');
        } else if ($search == "tác giả") {
            header('location: author_view.php');
        } else if ($search == "bài viết") {
            header('location: article_views.php');
        } else if ($search == "cây, lá và gió") {
            header('location: detail.php');
        } else if ($search == "cuộc sống mến thương") {
            header('location: detail2.php');
        } else if ($search == "lòng mẹ") {
            header('location: detail3.php');
        } else if ($search == "phôi pha") {
            header('location: detail4.php');
        } else if ($search == "nơi tình yêu bắt đầu") {
            header('location:detail5.php');
        } else {
            echo '<div class="alert alert-danger" role="alert"> Không tìm thấy từ khóa tìm kiếm </div>';
        }
    }
}