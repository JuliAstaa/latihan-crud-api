<?php

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers");

    // require 
    require_once __DIR__.'/../includes/koneksi.php';
    require_once __DIR__.'/../models/mahasiswa.php';
    require_once __DIR__.'/../models/model_prodi.php';
    require_once __DIR__.'/../includes/validator.php';

    // mempersiapkan array untuk respon dari API
    $respone = [
        'status' => null,
        'message' => '',
        'data' => null,
        'errors' => null
    ];

    // $exampleData = [
    //     "NIM" => '2401010111',
    //     "nama" => 'Yanagi',
    //     "id_prodi" => 1,
    //     "email" => 'yanagi@example.com'
    // ];

    // $dataMahasiwa = $exampleData;

    // var_dump($dataMahasiwa);

   // CEK REQUEST METHOD 
    if($_SERVER['REQUEST_METHOD'] == "POST") {

        // ambil data json dari body request wakk
        $jsonInputRaw = file_get_contents('php://input');
        $dataMahasiwa = json_decode($jsonInputRaw, true);   

        // var_dump($dataMahasiwa);

        // $prodi = getDataProdiByID($conn, $dataMahasiwa['id_prodi']);
        // var_dump($prodi);
        // die;
        
       

        // cek apakah json valid dan tidak 
        if(json_last_error() !== JSON_ERROR_NONE && $dataMahasiwa !== null){
            http_response_code(400); // BAAAAAD REQUEST
            $respone['status'] = 400;
            $respone['message'] = "Input JSON tidak valid. Pastikan format JSON benar";
        } else {
            // panggil validasi input dari validator sebelum disanitasi
            $validationError = validateInputDataMahasiswa($dataMahasiwa ?? []);

            //lakunan validasi untuk id_prodi sebelum dikirim ke model
            if(isset($dataMahasiwa['id_prodi']) && empty($validationError['prodi'])) {

                if(!getDataProdiByID($conn, $dataMahasiwa['id_prodi'])){
                    http_response_code(400);
                    $respone['satatus'] = 400;
                    $respone['message'] = "Program studi yang dipilih tidak ditemukan atau tidak valid!";
                    $validationError['id_prodi'][] = "Prodi tidak valid!";
                    
                }

            }

          

            // lakukan pengecekan apakah nim sudah ada apa belum
            if(isset($dataMahasiwa['nim']) && empty($validationError['nim'])) {
                if(getDataMahasiswaByNIM($conn, $dataMahasiwa['nim'])) {
                    http_response_code(400);
                    $respone['statut'] = 400;
                    $respone['message'] = "NIM tersebut sudah digunakan";
                    $validationError['nim'][] = "NIM tersbut sudah digunakan!";
                }
            }



            // lakukan pengecekan, apakah email sudah ada apa belum
            if(isset($dataMahasiwa['email']) && empty($validationError['email'])){
                if(getDataMahasiswaByEmail($conn, $dataMahasiwa['email'])){
                    http_response_code(400);
                    $respone['status'] = 400;
                    $respone['message'] = "Email tersebut telah digunakan";
                    $validationError['email'][] = "Email tersebut telah digunakan!"; 
                }
            }

            // var_dump($validationError['id_prodi']);
            // die;

            // kalau error tidak kosong, alias belum tervalidasi anjay
            if(!empty($validationError['nama']) || !empty($validationError['nim']) || !empty($validationError['id_prodi']) || !empty($validationError['email'])) {
                // kembalikan nilai bad request
                http_response_code(400);
                $respone['status'] = 400;
                $respone['message'] = "Data input tidak valid!";
                $respone['errors'] = $validationError;
            
            } else {
                // lakukan satinati jika semua sudah clear dan tervalidasi
                $sanitizedData = [];
                $sanitizedData['nama'] = sanitizeString($dataMahasiwa['nama']);
                $sanitizedData['nim'] = sanitizeString($dataMahasiwa['nim']);
                $sanitizedData['id_prodi'] = sanitizeNumber($dataMahasiwa['id_prodi']);
                $sanitizedData['email'] = sanitizeEmail($dataMahasiwa['email']);
                
                // masukkan data ke model
                $newID = createDataMahasiswa($conn, $sanitizedData);
                

                // cek jika data berhasil disimpan dan mendapatkan ID baru
                if($newID !== false && $newID > 0) {
                    http_response_code(201); //CREATED
                    $respone['status'] = 201;
                    $respone['message'] = "Berhasil menambahkan data";
                    $respone['data'] = $sanitizedData;
                }
            }

        } 

    } else {
        // JIKA PAKAI METHOD SELAIN POST
        http_response_code(405);
        $respone['status'] = 405;
        $respone['message'] = "Method Request TIDAK diijinkan, hanya method POST yang diterima!";
    }

     

   echo json_encode($respone)
?>