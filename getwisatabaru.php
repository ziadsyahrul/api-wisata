<?php

header("Content-Type: application/json; charset=UTF-8");
include './config/koneksi.php';

$upload_path = 'uploads/';

$server_ip = gethostbyname(gethostname());

$upload_url = 'http://'.$server_ip.'/wisata/'.$upload_path;

$query = "SELECT tm.id_wisata, tm.id_user, tm.id_kategori, tm.nama_wisata, tm.desc_wisata, tm.foto_wisata, tm.insert_time, tm.view,
tu.nama_user, 
tk.nama_kategori FROM tb_user tu,tb_wisata tm, tb_kategori tk WHERE 
tu.id_user = tm.id_user  &&
tk.id_kategori = tm.id_kategori
ORDER BY tm.id_wisata DESC";

$result = mysqli_query($connection, $query) or die ("Error in selecting " . mysqli_error($connection));

$temparray = array();

$response = array();

$cek = mysqli_num_rows($result);

if ($cek > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($row['url_wisata'] = $upload_url . $row['foto_wisata']);
        $temparray[] = $row;
    }

    $response['result'] = 1;
    $response['message'] = "Data berhasil di ambil";

    $response['data'] = $temparray;
}else {
    $response['result'] = 0;
    $response['message'] = "Data kosong";
}

echo json_encode($response);

mysqli_close($connection);

?>