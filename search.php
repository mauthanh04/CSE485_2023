<?php
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["search"])){
        $search = $_POST["search"];

        if($search == "đăng nhập"){
            header('location: login.php');
        } else if($search == "thể loại"){
            header('location: admin/category.php');
        } else if($search == "trang chủ"){
            header('location: admin/index.php');
        } else if($search == "tác giả"){
            header('location: admin/author.php');
        } else if($search == "bài viết"){
            header('location: admin/article.php');
        } else if($search == "cây, lá và gió"){
            header('location: detail1.php');
        } else if($search == "cuộc sống mến thương"){
            header('location: detail2.php');
        } else if($search == "lòng mẹ"){
            header('location: detail3.php');
        } else if($search == "phôi pha"){
            header('location: detail4.php');
        } else if($search == "nơi tình yêu bắt đầu"){
            header('location: detail5.php');
        } else {
            echo '<div class="alert alert-danger" role="alert"> Không tìm thấy từ khóa tìm kiếm </div>';
        }
    }
}
?>
