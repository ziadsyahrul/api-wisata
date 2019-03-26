<?php

header("Content-Type: application/json; charset=UTF-8");
include './config/koneksi.php';

// Membuat nama folder upload
$upload_path = 'uploads/';

$server_ip = gethostbyname(gethostname());

$upload_url = 'http://'.$server_ip.'/wisata/'.$upload_path;

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Pengecekan parameter inputan user
    if (isset($_POST["idmakanan"]) &&
        isset($_POST["idkategori"]) &&
        isset($_POST["namamakanan"]) &&
        isset($_POST["descmakanan"]) &&
        isset($_POST["fotomakanan"]) &&
        isset($_POST["inserttime"]) 
    ) {
        // Memasukkan inputan user ke dalam variable
        $idmakanan = $_POST["idmakanan"];
        $idkategori = $_POST["idkategori"];
        $namamakanan = $_POST["namamakanan"];
        $descmakanan = $_POST["descmakanan"];
        $inserttime = $_POST["inserttime"];
        $fotomakanan = $_POST["fotomakanan"];
        // untuk mengambil image
        $image = $_FILES["image"]['tmp_name'];

        if (isset($image)) {
            // Menghapus image sebelumnya
            unlink("./uploads/" . $fotomakanan);

            // Menghilangkan nama dan mengambil extension file
            $temp = explode(".", $_FILES["image"]["name"]);
            // Menggabungkan nama baru dengan extension
            $newfilename = round(microtime(true)) . '.' . end($temp);

            // Memasukkan file ke dalam folder 
            move_uploaded_file($image, $upload_path . $newfilename);

            // Memasukkan inputan user ke dalam database menggunakan operasi UPDATE
            $query = "UPDATE tb_makanan SET
            id_kategori = '$idkategori',
            nama_makanan = '$namamakanan',
            desc_makanan = '$descmakanan',
            insert_time = '$inserttime',
            foto_makanan = '$newfilename'
            WHERE id_makanan = $idmakanan";
        } else {
            // Mengisi variable $newfilename dengan nama file yang sebelumnya
            $newfilename = $fotomakanan;

            // membuat query tanpa update kolom foto_makanan
            $query = "UPDATE tb_makanan SET
            id_kategori = '$idkategori',
            nama_makanan = '$namamakanan',
            desc_makanan = '$descmakanan',
            insert_time = '$inserttime'
            WHERE id_makanan = $idmakanan";
        }

        // melakukan operasi update dengan perintah yang sudah kita buat di dalam variable $query
        // cek apakah query nya berhasil atau tidak
        if (mysqli_query($connection, $query)) {
            // apabila berhasil maka kita tampilkan response berhasil
            $response["result"] = 1;
            $response["message"] = "Update Berhasil";
            $response['url'] = $upload_url . $newfilename;
            $response['name'] = $namamakanan;
        }else{
            // Menampilkan pesan gagal
            $response["result"] = 0;
            $response["message"] = "Update gagal";
        }

     }else{
         // Menampilkan pesan gagal update
         $response["result"] = 0;
         $response["message"] = "Update gagal, data kurang";
     }

     // Mengubah response menjadi JSON
     echo json_encode($response);
}


?>