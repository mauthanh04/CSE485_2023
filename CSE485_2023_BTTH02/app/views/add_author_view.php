<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm mới tác giả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<?php require_once '../Controllers/add_author_controller.php'     ?>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow p-3 bg-white rounded">
            <div class="container-fluid">
                <div class="h3">
                    <a class="navbar-brand" href="#">Administration</a>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="./">Trang chủ</a></li>
                        <li class="nav-item"><a class="nav-link" href="../../public/index.php">Trang ngoài</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/category_views.php">Thể loại</a></li>
                        <li class="nav-item"><a class="nav-link active fw-bold" href="../views/author_view.php">Tác giả</a></li>
                        <li class="nav-item"><a class="nav-link" href="../views/article_views.php">Bài viết</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-5 mb-5">
        <h3 class="text-center text-uppercase fw-bold">Thêm mới tác giả</h3>
        <form action="../Views/add_author_view.php" method="post" enctype="multipart/form-data">


            <div class="input-group mt-3 mb-3">
                <span class="input-group-text" id="lblCatName">Tên tác giả</span>
                <input type="text" class="form-control" name="ten_tgia" required>
            </div>
            <div class="input-group mt-3 mb-3">
                <span class="input-group-text" id="lblCatName">Hình tác giả</span>
                <input type="file" name="hinh_tgia" id="hinh_tgia" required>
            </div>
            <div class="form-group float-end">
                <input type="submit" name="them" value="Thêm" class="btn btn-success">
                <a href="./author_view.php" class="btn btn-warning">Quay lại</a>
            </div>
        </form>
    </main>
    <footer class="bg-white d-flex justify-content-center align-items-center border-top border-secondary border-2" style="height:80px">
        <h4 class="text-center text-uppercase fw-bold">TLU's music garden</h4>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>