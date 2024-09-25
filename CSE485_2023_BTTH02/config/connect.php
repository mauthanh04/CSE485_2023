<?php
    $server = 'localhost';
    $use = 'root';
    $pass = '';
    $database = 'btth01_cse485';

    $conn = new mysqli($server, $use, $pass, $database);

    if($conn){
        mysqLi_query($conn, "SET NAMES 'utf8' ");
        //echo "Đã kết nối database"; 
        //echo "<br>";
    }
    else{
        //echo "Kết nối thất bại";
    }
?>