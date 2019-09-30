<?php
$nik = isset($_GET["nik"]) ? $_GET["nik"] : NULL;

if ($nik != null) {
    if ($nik == "3304061303090001") {
        $myfile = fopen("data.json", "r") or die("File tidak bisa dibuka!");
        $data = json_decode(fread($myfile, filesize("data.json")));
        fclose($myfile);

        $data->status = 200;

        echo json_encode($data);
        
    } else {
        echo json_encode(array(
            "status"  => 404,
            "message" => "Data Tidak Ditemukan!"
        ));
    }
} else {
    echo json_encode(array(
        "status"  => 400,
        "message" => "Nik tidak diketahui"
    ));
}
