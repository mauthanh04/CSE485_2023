<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["search"])) {
        $search = $_POST["search"];

        if ($search == "đăng nhập") {
            header('location: ../app/views/login_views.php');
        } else if ($search == "thể loại") {
            header('location: ../app/views/category_views.php');
        } else if ($search == "trang chủ") {
            header('location: ../app/views/index.php');
        } else if ($search == "tác giả") {
            header('location: ../app/views/author_view.php');
        } else if ($search == "bài viết") {
            header('location: ../app/views/article_views.php');
        } else if ($search == "cây, lá và gió") {
            header('location: ../app/views/detail.php');
        } else if ($search == "cuộc sống mến thương") {
            header('location: ../app/views/detail2.php');
        } else if ($search == "lòng mẹ") {
            header('location: ../app/views/detail3.php');
        } else if ($search == "phôi pha") {
            header('location: ../app/views/detail4.php');
        } else if ($search == "nơi tình yêu bắt đầu") {
            header('location: ../app/views/detail5.php');
        } else {
            echo '<div class="alert alert-danger" role="alert"> Không tìm thấy từ khóa tìm kiếm </div>';
        }
    }
}