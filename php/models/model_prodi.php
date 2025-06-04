<?php

    function getAllDataProdi($conn) {
        $query = "SELECT * FROM prodi";
        $result = mysqli_query($conn, $query);

        $dataProdi = [];

        if($result && mysqli_num_rows($result) > 0) {
            while($rows = mysqli_fetch_assoc($result)){
                $dataProdi[] = $rows;
            }
        }

        return $dataProdi;
    }

    function getDataProdiByID($conn, $id) {
        $query = "SELECT * FROM prodi WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $dataProdiByID = null;
        if($result && mysqli_num_rows($result) > 0) {
            $dataProdiByID = mysqli_fetch_assoc($result);
        }

        return $dataProdiByID;
    }

?>