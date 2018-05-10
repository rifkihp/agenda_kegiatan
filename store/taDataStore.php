<?php
    include "../php/initial.php";
    include "../php/mysql_db.php";

    $db = new mysql_db();
    $db->mysql_connect();
    
    $data = $db->getFieldValue("tahunakademik", array("id", "CONCAT(tahun, ' ', semester) AS keterangan", "aktif"));
    $db->mysql_close();
    
    $result = array(
        "totalCount" => count($data),
        "topics"    => $data
    );

    die(json_encode($result));