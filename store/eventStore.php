<?php
    include "../php/initial.php";
    include "../php/mysql_db.php";

    $db = new mysql_db();
    $db->mysql_connect();

    $data = $db->getFieldValue("tbl_kalender_akademik", array("id", "warna AS cid", "kegiatan AS title", "tgl_dari AS `start`", "tgl_sampai AS `end`", "TRUE AS `ad`"), array(), array(), 0, 0, "tgl_dari");
    $db->mysql_close();
    
    $result = array(
        "totalCount" => count($data),
        "topics"    => $data
    );

    die(json_encode($result));