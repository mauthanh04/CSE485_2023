<?php
    if(isset($_POST['dangnhap'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if($username == 'admin' && $password == '123'){
            header('location: ../views/index.php');

        }
        elseif($username == 'user1' && $password == '123'){
            header('location: ../../public/index.php');
        }
        elseif($username == 'user2' && $password == '123'){
            header('location: ../../public/index.php');
        }
        else{
            echo '<div class="alert alert-danger" role="alert"> Tài khoản hoặc mật khẩu sai! </div>';
        }
    }
?>