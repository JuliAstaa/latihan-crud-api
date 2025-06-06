<?php

    require_once __DIR__ . '/../config/database_config.php';

    $conn = mysqli_connect($host, $user, $pw, $db);

    if(!$conn){
        die("Koneksi gagal");
    }

?>