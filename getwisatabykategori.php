<?php

header("Content-Type: application/json; charset=UTF-8");
include './config/koneksi.php';

// Membuat nama folder upload
$upload_path = 'uploads/';

// Mengambil IP server
$server_ip = gethostbyname(gethostname());

// Membuat url upload
$upload_url = 'http://'.$server_ip.'/wisata/'.$upload_path;

// Membuat variable untuk inputan user dari parameter GET
$idkategori = $_GET['idkategori'];

// Membuat variable untuk querinya
$query = "SELECT tm.id_wisata, tm.id_user, tm.id_kategori, tm.nama_wisata, tm.desc_wisata, tm.foto_wisata, tm.insert_time, tm.view,
tu.nama_user, 
tk.nama_kategori FROM tb_user tu,tb_wisata tm, tb_kategori tk WHERE 
tu.id_user = tm.id_user  &&
tk.id_kategori = tm.id_kategori &&
tm.id_kategori = '$idkategori'
ORDER BY tm.view DESC";

// Membuat variable result/hasil dari eksekusi query
$result = mysqli_query($connection, $query) or die ("Error in selecting " . mysqli_error
    ($connection));

// Membuat variable array untuk data yang diambil
$temparray = array();
// Membuat  variable untuk response terakhir
$response = array();

// Membuat variable untuk mengecek isi data setelah di query
$check = mysqli_num_rows($result);

// Melakukan kondisi untuk mengecek apakah query tadi ada isinya
if ($check > 0){
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($row['url_wisata'] = $upload_url . $row['foto_wisata']);
        $temparray[] = $row;
    }    

    // Membuat tambahan item untuk menampilka pesan sukses
    $response['result'] = 1;
    $response['message'] = "Data berhasil di ambil";

    // Memasukkan data tadi ke dalam variable response
    $response['data'] = $temparray;
}else {
    // Menampilkan response data kosong
    $response['result'] = 0;
    $response['message'] = "Data kosong";
}

echo json_encode($response);

// Close connection
mysqli_close($connection)

?>