<?php

    function getAllDataMahasiswa($conn){
        $query = "SELECT * FROM mahasiswa WHERE status = 1";
        $result = mysqli_query($conn, $query);

        $data_mahasiswa = [];
        if($result && mysqli_num_rows($result) > 0){
            while($rows = mysqli_fetch_assoc($result)){
                $data_mahasiswa[] = $rows;
            }
        }

        return $data_mahasiswa;
    }


    function getDataMahasiswaByID($conn, $id){
        $query = "SELECT * FROM mahasiwsa WHERE id = ? AND status = 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $dataMahasiswaByID = null;
        if($result && mysqli_num_rows($result) > 0){
            $dataMahasiswaByID = mysqli_fetch_assoc($result);
        }

        mysqli_stmt_close($stmt);
        return $dataMahasiswaByID;
    }

    function createDataMahasiswa($conn, $data) {
        // data adalah array assostiatif
        
    }


?>