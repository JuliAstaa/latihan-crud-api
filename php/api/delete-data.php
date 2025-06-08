<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-ALlow-Headers: Content-Type, Access-Control-Allow-Origin, Acess-Control-Allow-Methods, Access-Control-Allow-Headers");

    // require
    require_once __DIR__ .'/../includes/validator.php';
    require_once __DIR__ .'/../models/mahasiswa.php';
    require_once __DIR__ .'/../models/model_prodi.php';
    require_once __DIR__ .'/../includes/koneksi.php';

    $response = [
        'status' => null,
        'message' => '',
        'errors' => null
    ];

    if($_SERVER["REQUEST_METHOD"] === "DELETE") {
        $id = $_GET['id'] ?? null;

        $validationError =  validateIdForDeteleDataMahasiswa($id);


        if($validationError['id_mhs'])  {
            http_response_code(400); // Bad request
            $response['status'] = 400;
            $response['message'] = "ID mahasiswa tidak valid atau tidak ditemukan";
            $response['errors'] = $validationError;
        } else {
            // delete
            if(deleteDataMahasiswa($conn, $id)) {
                http_response_code(200);
                $response['status'] = 200;
                $response['message'] = "Berhasil menghapus data mahasiswa dengan ID ". $id;

            } else {
                http_response_code(500);
                $response['status'] = 500;
                $response['message'] = "Gagal menghapus data dari server";
            }
        }
    } else {
        http_response_code(405);
        $response['status'] = 405;
        $response['message'] = "Method Request TIDAK diijinkan, hanya method DELETE yang diterima!";
    }

    echo json_encode($response)

?>