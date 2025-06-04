<?php

    function sanitizeString($data){
        if($data == null){
            return '';
        }
        $data = trim((string)$data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>