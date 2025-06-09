<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET");

    require_once __DIR__ . '/../includes/koneksi.php';
    require_once __DIR__ . '/../models/model_prodi.php';

    $response = [
        'status' => null,
        'message' => '',
        'data' => null,
        'error' => null

    ];

    
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        
        $allDataProdi = getAllDataProdi($conn);

        if(!$allDataProdi) {
            http_response_code(200);
            $response['status'] = 200;
            $response['message'] = "Data prodi tidak ditemukan";
        } else {
            http_response_code(200);
            $response['status'] = 200;
            $response['message'] = "Data prodi ditemukan";
            $response['data'] = $allDataProdi;
        }

       

    } else {
        http_response_code(405);
        $response['status'] = 405;
        $response['message'] = "Method tidak diizikan, Gunakan GET";
    }

    echo json_encode($response);

?>