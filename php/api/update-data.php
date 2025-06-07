<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-ALlow-Methods: PATCH");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers");

    //require
    require_once __DIR__.'/../includes/koneksi.php';
    require_once __DIR__.'/../models/mahasiswa.php';
    require_once __DIR__.'/../models/model_prodi.php';
    require_once __DIR__.'/../includes/validator.php';

    // buat response
    $response = [
        'status' => null,
        'message' => '',
        'data' => null,
        'errors' => null
    ];

    // $exampleData = [
    //     'id_mhs' => 15,
    //     'nama' => 'Budi Mayun Wahyu',
    //     'id_prodi' => 2,
    //     'email' => "mayun@gmail.com"
    // ];

    if($_SERVER["REQUEST_METHOD"] == "PATCH"){

        $jsonInputRaw = file_get_contents('php://input');
        $dataMahasiswaToUpdate = json_decode($jsonInputRaw, true);

        if(json_last_error() !== JSON_ERROR_NONE && $dataMahasiswaToUpdate !== null) {
            http_response_code(404);
            $response['status'] = 400;
            $response['message'] = "Input JSON tidak valid, pastikan format JSON sudah benar!";

        } else {
            $validationError = validateInputUpdateDataMahasiswa($dataMahasiswaToUpdate ?? []);

            // validasi prodi
            if(isset($dataMahasiswaToUpdate['id_prodi']) && empty($validationError['id_prodi'])){
                if(!getDataProdiByID($conn, $dataMahasiswaToUpdate['id_prodi'])) {
                    http_response_code(400); // bad request
                    $response['status'] = 400;
                    $response['message'] = "Program studi yang dipilih tidak ditemukan atau tidak valid!";
                    $validationError['id_prodi'][] = "Prodi tidak valid!";
                }
            }

            // validasi email apakah sudah ada apa belum, dan apakah mau diganti apa tidak
            if(isset($dataMahasiswaToUpdate['email']) && empty($validationError['email'])) {
                if(isEmailTakenByOther($conn, $dataMahasiswaToUpdate['email'], $dataMahasiswaToUpdate['id_mhs'])) {
                    http_response_code(400);
                    $respone['status'] = 400;
                    $respone['message'] = "Email tersebut telah digunakan";
                    $validationError['email'][] = "Email tersebut telah digunakan!"; 
                }
            }

            //kalau semua error tidak kosong, kembalikan bad request
            if(!empty($validationError['id_mhs']) || !empty($validationError['nama']) || !empty($validationError['id_prodi']) || !empty($validationError['email'])) {
                // kembalikan nilai bad request
                http_response_code(400);
                $response['status'] = 400;
                $response['message'] = "Data input tidak valid!";
                $response['errors'] = $validationError;
            } else {
                // jika semua data sudah tervalidasi, lakukan sanitasi
                $sanitizedData = [];
                $sanitizedData['nama'] = sanitizeString($dataMahasiswaToUpdate['nama']);
                $sanitizedData['id_prodi'] = sanitizeNumber($dataMahasiswaToUpdate['id_prodi']);
                $sanitizedData['email'] = sanitizeString($dataMahasiswaToUpdate['email']);
                $sanitizedData['id_mhs'] = sanitizeNumber($dataMahasiswaToUpdate['id_mhs']);

                $isUpdated = patchDataMahasiswa($conn, $sanitizedData);

                if($isUpdated) {
                    http_response_code(200);
                    $response['status'] = 200;
                    $response['message'] = "Berhasil update data dengan ID " . $sanitizedData['id_mhs'];
                    $response['data'] = $sanitizedData;
                }
            }


        }

        

    } else { 
         // JIKA PAKAI METHOD SELAIN PATCH
        http_response_code(405);
        $response['status'] = 405;
        $response['message'] = "Method Request TIDAK diijinkan, hanya method PATCH yang diterima!";
    }


    echo json_encode($response);

?>
