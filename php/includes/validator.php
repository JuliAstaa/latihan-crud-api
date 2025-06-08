<?php

    // fungsi sanitasi string
    function sanitizeString($data){
        if($data === null){
            return '';
        }
        $data = trim((string)$data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // fungsi sanitasi email
    function sanitizeEmail($email) {
        if($email === null){
            return '';
        }

        return filter_var(trim((string)$email), FILTER_SANITIZE_EMAIL);
    }

    // fungsi sanitasi number
    function sanitizeNumber($number) {
        if($number === null) {
            return '';
        }

        return filter_var(trim((string)$number), FILTER_SANITIZE_NUMBER_INT);
    }

    // fungsi untuk email yang valdi
    function isValidEmailFormat($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    // fungsi untuk validasi nama
    function isValidName($nama){
        if(!preg_match("/^[A-Za-z' -]*$/", $nama)) {
            return false;
        }
        return true;
    }

    // fungsi validasi data tidak boleh kosong
    function isRequired($value) {
        if(empty($value)) {
            return false;
        }
        return true;
    }

    // validasi apakah data numeric apa tidak
    function isNumeric($value) {
        return ctype_digit((string)$value);
    }

    // validasi untuk memberikan minimal panjang pada sebuah nilai
    function hasMinLength($value, $minLength) {
        return strlen(trim((string)$value)) >= $minLength;
    }

    // validasi untuk memberikan maksimal panjang pada sebuah nilai
    function hasMaxLength($value, $maxLength) {
        return strlen(trim((string)$value)) <= $maxLength;
    }

    // validasi input mahasigma
    function validateInputDataMahasiswa($data) {

        // penampungan sampah error
        $error = [
            'nama' => [],
            'nim' => [],
            'id_prodi' => [],
            'email' => []
        ];

        
        // validasi nama
        $nama = $data['nama'] ?? null;
        if(!isRequired($nama)){
            $error['nama'][] = "Nama tidak boleh kosong";
        } else {
            if(!isValidName($nama)){
                $error['nama'][] = "Nama hanya boleh mengandung huruf, spasi, petik, dan dash saja";
            }

        }

        // validasi NIM
        $nim = $data['nim'] ?? null;
        if(!isRequired($nim)) {
            $error['nim'][] = "NIM tidak boleh kosong";
        } else {
            if(!isNumeric($nim)) {
                $error['nim'][] = "NIM hanya boleh berupa angka";
            } else {
                if(!hasMinLength($nim, 10) || !hasMaxLength($nim, 20)){
                    $error['nim'][] = "Minimal NIM 10 dan maksimal NIM 20";
                }
            }
        }


        //validasi prodi
        $id_prodi = $data['id_prodi'] ?? null;
        if(!isRequired($id_prodi)) {
            $error['prodi'][] = "Prodi tidak boleh kosong";
        } else {
            if(!isNumeric($id_prodi)) {
                $error['prodi'][] = "Prodi tidak valid";
            }
        }

        // validasi email
        $email = $data['email'] ?? null;
        if(!isRequired($email)){
            $error['email'][] = 'Email tidak boleh kosong';
        } else {
            if(!isValidEmailFormat($email)){
                $error['email'][] = 'Format email tidak valid';
            }
        }

        return $error;
        
    }

    //validasi untuk input update mahasiswa 
    function validateInputUpdateDataMahasiswa($data) {
        $error = [
            'nama' => [],
            'id_prodi' => [],
            'email' => [],
            'id_mhs' => []
        ];

        $idMhs = $data['id_mhs'] ?? null;
        if(!isRequired($idMhs)) {
            $error['id_mhs'][] = "ID Tidak valid!";
        }

        //validasi nama
        $nama = $data['nama'] ?? null;
        if(!isRequired($nama)){
            $error['nama'][] = "Nama tidak boleh kosong";
        } else {
            if(!isValidName($nama)){
                $error['nama'][] = "Nama hanya boleh mengandung huruf, spasi, petik, dan dash saja";
            }

        }

        //validasi prodi
        $id_prodi = $data['id_prodi'] ?? null;
        if(!isRequired($id_prodi)) {
            $error['prodi'][] = "Prodi tidak boleh kosong";
        } else {
            if(!isNumeric($id_prodi)) {
                $error['prodi'][] = "Prodi tidak valid";
            }
        }

        // validasi email
        $email = $data['email'] ?? null;
        if(!isRequired($email)){
            $error['email'][] = 'Email tidak boleh kosong';
        } else {
            if(!isValidEmailFormat($email)){
                $error['email'][] = 'Format email tidak valid';
            }
        }

        return $error;

    }

    // validasi input untuk delete mahasiswa 
    function validateIdForDeteleDataMahasiswa($id) {
       $errors = [
        'id_mhs' =>[]
       ];

       
        if(!isRequired($id)) {
            $errors['id_mhs'][] = "ID Tidak valid!";
        } else {
            if(!isNumeric($id)) {
                $errors['id_mhs'][] = "ID tidak valid!";
            }
        }

        return $errors;

    }
?>