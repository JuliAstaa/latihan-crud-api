<?php

    function getAllDataProdi($conn) {
        $query = "SELECT * FROM prodi";
        $result = mysqli_query($conn, $query);

        $dataProdi = [];

        if($result && mysqli_num_rows($result) > 0) {
            while($rows = mysqli_fetch_assoc($result)){
                $dataProdi[] = $rows;
            }
        }

        return $dataProdi;
    }

?>