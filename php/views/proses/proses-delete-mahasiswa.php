<?php

    session_start();

    require_once __DIR__ . '/../../includes/validator.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $id = $_POST['id_mhs'] ?? null;
        // var_dump($id);

        $validationError = validateIdForDeteleDataMahasiswa($id);

        // var_dump($validationError['id_mhs']);
        // die;

        if(!empty($validationError['id_mhs'])){
            $_SESSION['errorValidate'] = $validationError;
            header("Location: ../../index.php");
            exit;
        }

        $apiURL = "http://localhost/latihan-crud-api/php/api/delete-data.php?id=". $id;

        // echo $apiURL;
        // die;

        $ch = curl_init($apiURL); 

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        $responJSON = curl_exec($ch);
        $httpResponeCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);

        $responData = json_decode($responJSON, true);

        if($httpResponeCode == 200){
             $_SESSION['flashMessage'] = ['type' => 'success', 'text' => $responseData['message'] ?? 'Data berhasil dihapus.'];
        } else {
             $_SESSION['flashMessage'] = ['type' => 'error', 'text' => $responseData['message'] ?? 'Gagal menghapus data.'];
        }

        header("Location: ../../index.php");
        exit;
    } else {
        $_SESSION['flashMessage'] = ['type' => 'error', 'text' => 'Akses tidak valid'];
        header('Location: ../../index.php');
        exit;
    }

?>