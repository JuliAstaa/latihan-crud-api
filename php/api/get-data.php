<?php

    header("Content-Type: application/json");

    require_once '../includes/koneksi.php';
    require_once '../models/mahasiswa.php';

    $respone = [
        'status' => null,
        'message' => '',
        'data' => null
    ];

    $id = $_GET['id'] ?? null; //apakah ada id atau tidak

    // get data by id
    if ($id) {
        $dataMahasiswaByID = getDataMahasiswaByID($conn, (int)$id);
        

        if($dataMahasiswaByID) {
            http_response_code(200);
            $respone['status'] = 200;
            $respone['message'] = "Data mahasiswa ditemukan";
            $respone['data'] = $dataMahasiswaByID;
        } else {
            http_response_code(404); // 404 Not Found
            $respone['status'] = 404;
            $respone['message'] = "Data mahasiswa dengan ID $id tidak ditemukan";
            $respone['data'] = [];
        }
    
    // get all data
    } else {
        $data_mahasiswa = getAllDataMahasiswa($conn);
        if(!empty($data_mahasiswa)) {
            http_response_code(200);
            $respone['status'] = 200;
            $respone['message'] = "Semua data mahasiswa ditemukan";
            $respone['data'] = $data_mahasiswa;
        } else {
            http_response_code(200);
            $respone['status'] = 200;
            $respone['message'] = "Tidak ada data mahasiswa yang ditemukan";
            $respone['data'] = $data_mahasiswa;
        }
    }

    echo json_encode($respone);
    mysqli_close($conn);
?>