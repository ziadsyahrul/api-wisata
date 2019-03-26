<?php

// membuat outputnya selalu berbentuk JSON
header("Content-Type: application/json; charset=UTF-8");
// Memasukkan koneksi untuk menggunakan connection
include './config/koneksi.php';

// Membuat penampung response array
$response = array();

// kita cek method post atau bukan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Pengecekan parameter inputan user
    if (isset($_POST["iduser"]) &&
        isset($_POST["namauser"]) &&
        isset($_POST["alamat"]) &&
        isset($_POST["jenkel"]) &&
        isset($_POST["notelp"])) {
        // Memasukkan inputan user ke dalam variable
        $iduser = $_POST["iduser"];
        $namauser = $_POST["namauser"];
        $alamat = $_POST["alamat"];
        $jenkel = $_POST["jenkel"];
        $notelp = $_POST["notelp"];

        // membuat query untuk mengupdate data ke database
        $query = "UPDATE tb_user SET nama_user = '$namauser', alamat = '$alamat', 
                jenkel = '$jenkel', no_telp = '$notelp' WHERE id_user = '$iduser' ";

        // mengeksekusi query yang sudah dibuat dan langsung mencek apakah berhasil atau tidak
        if (mysqli_query($connection, $query)) {
            // apabila berhasil maka kita tampilkan response berhasil
            $response["result"] = 1;
            $response["message"] = "Update berhasil";
        }else{
            // Menampilkan pesan gagal
            $response["result"] = 0;
            $response["message"] = "Update gagal";
        }

        // Mengubah response menjadi JSON
        echo json_encode($response);
     }
}

?>