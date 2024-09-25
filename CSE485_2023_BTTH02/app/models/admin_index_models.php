<?php
        include "../../config/connect.php";

        //đếm số lượng người dùng
        $sql_users = "SELECT COUNT(id) AS count_users from users";
        $result_users = $conn->query($sql_users);
        $count_users = $result_users->fetch_assoc()['count_users'];

        //đếm số lượng thể loại
        $sql_theloai = "SELECT COUNT(ma_tloai) AS count_theloai from theloai";
        $result_theloai = $conn->query($sql_theloai);
        $count_theloai = $result_theloai->fetch_assoc()['count_theloai'];

        //đếm số lượng tác giả
        $sql_tacgia = "SELECT COUNT(ma_tgia) AS count_tacgia from tacgia";
        $result_tacgia = $conn->query($sql_tacgia);
        $count_tacgia = $result_tacgia->fetch_assoc()['count_tacgia'];

        //đếm số lượng bài viết
        $sql_baiviet = "SELECT COUNt(ma_bviet) AS count_baiviet from baiviet";
        $result_baiviet = $conn->query($sql_baiviet);
        $count_baiviet = $result_baiviet->fetch_assoc()['count_baiviet'];
?>
