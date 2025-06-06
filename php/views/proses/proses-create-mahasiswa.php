<?php

    session_start();

    require_once __DIR__ .'/../../includes/validator.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {


        $dataForm = [
            "nim" => $_POST['nim'] ?? null,
            "nama" => $_POST['nama'] ?? null,
            "id_prodi" => $_POST['id_prodi'] ?? null,
            "email" => $_POST['email'] ?? null
        ];


        $validationError = validateInputDataMahasiswa($dataForm);

        
        if(!empty($validationError['nama']) || !empty($validationError['nim']) || !empty($validationError['id_prodi']) || !empty($validationError['email'])) {
            $_SESSION['errorValidate'] = $validationError;
            $_SESSION['data'] = $dataForm;
            header("Location: ../mahasiswa/create-mahasiswa.php");
            exit;
        }

        // ubah arrray asosiatif jadi json
        $dataJSON = json_encode($dataForm);


        // link URL API untuk create-data
        $apiURL = "http://localhost/latihan-crud-api/php/api/create-data.php";

        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // mengembalikan respon sebagai string
        curl_setopt($ch, CURLOPT_POST, true); // method POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJSON); // field data json sebagai body
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: aplication/json',
            'Content-Length: '. strlen($dataJSON)
        ]);

        //ekseksusi request
        $responeJson = curl_exec($ch);
        $httpRequestCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);


        // Proses respon dari API
        if($curlError) {
            $_SESSION["flashMessage"] = ['type' => 'text', 'error' => 'Gagal menghubungi API'];
            $_SESSION['data'] = $dataForm;
            header("Location: ../mahasiswa/create-mahasiswa.php");
            exit;
        }

        //respone data dari API
        $responseData = json_decode($responeJson, true);

        // var_dump($responseData['errors']);
        // die;
        
        // jika http request code nya 201 dan responseData['status'] bukan null dan response['status'] == 201 whichis berhasil membuat data baru
        if($httpRequestCode === 201 && isset($responseData['status']) && $responseData['status'] == 201) {
            $_SESSION['flashMessage'] = ['type' => 'success', 'text' => 'Berhasil menambahkan data'];

            // kosongkan data, karena udah sukses
            unset($_SESSION['data']);
            header("Location: ../../index.php");
            exit;
        } else {
            // Ada error dari API, misal validasi gagal

            $_SESSION['flashMessage'] = ['type' => 'error', 'text' => $responseData['message'] ?? 'Terjadi kesalahan dalam mempreoses data melalui API'];
            $_SESSION['errorValidate'] = $responseData['errors'];

            //jika  API mengirimkan detail error, simpan
            if(isset($responseData['error'])) {
                $_SESSION['detailFormError'] = $responseData['errors'];
            }

            // kembalikan data form ke form input
            $_SESSION['data'] = $dataForm;
            header("Location: ../mahasiswa/create-mahasiswa.php");
            exit;
        }
        

    } else {
        // ketika bukan request mthod POST dan tombol submit belum dipencet
        $_SESSION['flashMessage'] = ['type' => 'error', 'text' => 'Akses tidak valid'];
        header("Location: ../mahasiswa/create-mahasiswa.php");
        exit;
    }



?>