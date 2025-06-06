<?php

    // dapatkan semua data mahasiswa
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

    // dapatkat data mahasiswa berdasarkan id
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

    //dapatkan data mahasiswa berdasarkan NIM
    function getDataMahasiswaByNIM($conn, $nim){
        $query = "SELECT * FROM mahasiswa WHERE nim = ? AND status = 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $nim);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $dataMahasiswaByNIM = null;

        if($result && mysqli_num_rows($result) > 0) {
            $dataMahasiswaByNIM = mysqli_fetch_assoc($result);
        }
        
        mysqli_stmt_close($stmt);
        return $dataMahasiswaByNIM;
    }

    // dapatkan data mahasiswa berdasarkan email
    function getDataMahasiswaByEmail($conn, $email){
        $query = "SELECT * FROM mahasiswa WHERE email = ? AND status = 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $dataMahasiswaByEmail = null;

        if($result && mysqli_num_rows($result) > 0) {
            $dataMahasiswaByEmail= mysqli_fetch_assoc($result);
        }

        mysqli_stmt_close($stmt);
        return $dataMahasiswaByEmail;
    }

    // create data mahasiswa
    function createDataMahasiswa($conn, $data) {
        // data adalah array assostiatif
        $nim = $data['nim'] ?? null;
        $nama = $data['nama'] ?? null;
        $id_prodi = $data['id_prodi'] ?? null;
        $email = $data['email'] ?? null;

        $query = "INSERT INTO mahasiswa(nim, nama_mhs, id_prodi, email) VALUES(?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);

        // cek statement
        if($stmt === false) {
            error_log("Model: Gagal mempersiakan statement INSERT ". mysqli_error($conn));
            mysqli_stmt_close($stmt);
            return false;
        }

        $bindResult = mysqli_stmt_bind_param($stmt, 'ssis', $nim, $nama, $id_prodi, $email);

        // cek binding / ikatan
        if($bindResult === false) {
            error_log("Model: Gagal bind parameter untuk statement INSERT - ". mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            return false;
        }

        // execute statement
        if(mysqli_stmt_execute($stmt)){
            $new_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);
            return $new_id;
        } else {
            error_log("Model: Gagal eksekusi statement INSERT - ". mysqli_stmt_error($stmt));
            mysqli_stmt_close($stmt);
            return false;
        }

    }

    


?>