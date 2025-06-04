<?php

    header("Content-Type: application/json");

    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "belajar";

    $conn = mysqli_connect($host, $user, $password, $database);
                                                                                                         
    $query = "SELECT * FROM mahasiswa WHERE status = 1";

    $result = mysqli_query($conn, $query);

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode($rows)

?>