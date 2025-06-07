<?php

    session_start();
    
    require_once __DIR__. '/../../includes/validator.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dataFormToUpdate = [
            'id_mhs' => $_POST['id_mhs'] ?? null,
            'nama' => $_POST['nama'] ?? null,
            'id_prodi' => $_POST['id_prodi'] ?? null,
            'email' => $_POST['email'] ?? null
        ];

        $validationError = validateInputUpdateDataMahasiswa($dataFormToUpdate);
        

        if(!empty($validationError['id_mhs']) || !empty($validationError['nama']) || !empty($validationError['id_prodi']) || !empty($validationError['email'])) {
            $_SESSION['errorValidate'] = $validationError;
            $_SESSION['data'] = $dataForm;
            header("Location: ../mahasiswa/update-mahasiswa.php?id=". $dataFormToUpdate['id_mhs']);
            exit;
        }

        //ubah ke json 
        $dataJSON = json_encode($dataFormToUpdate);

        //link api ke update-mahasiswa, untuk melakukan update patch
        $apiURL = "http://localhost/latihan-crud-api/php/api/update-data.php";

        $ch = curl_init($apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJSON);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Accept: application/json"
        ]);

        // eksekusi request
        $responeJson = curl_exec($ch);
        $httpRequestCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        // tutup curl
        curl_close($ch);

        // Proses respone dari API
        // error
        if($curlError) {
            $_SESSION['flashMessage'] = ['type'=> 'error', 'text' => 'Gagal menghubungi API'];
            $_SESSION['data'] = $dataFormToUpdate;
            header("Location: ../mahasiswa/update-mahasiswa.php?id=". $dataFormToUpdate['id_mhs']);
            exit;
        }

        // response data dari api
        $responseDataAPI = json_decode($responeJson, true);


        // JIka http request code nya 200, dan responseDataAPI['status'] tidak null dan responDataAPI['status'] = 200, yang dimana berhasil dieksekusi
        if($httpRequestCode === 200 && $responseDataAPI['status'] !== null && $responseDataAPI['status'] === 200) {
            $_SESSION['flashMessage'] = ['type' => 'success', 'text' => 'Berhasil update data'];

            // kosongkan session data
            unset($_SESSION['data']);
            header("Location: ../../index.php");
            exit;
        } else {
            $_SESSION['flashMessage'] = ['type'=> 'error', 'text' => $responseDataAPI['message'] ?? "Terjadi kesalah dalam memproses data melalui API"];
            $_SESSION['errorValidate'] = $responseDataAPI['errors'];

            if(isset($responseDataAPI['error'])) {
                $_SESSION['detailFormError'] = $responseDataAPI['errors'];
            }

            // kembali ke form updata
            $_SESSION['data'] = $dataFormToUpdate;
            header("Location: ../mahasiswa/update-mahasiswa.php?id=". $dataFormToUpdate['id_mhs']);
            exit;
        }


    } else {
        $_SESSION['flashMessage'] = ['type' => 'error', 'text' => 'Akses tidak valid'];
        header("Location: ../mahasiswa/update-mahasiswa.php");
        exit;
    }

?>