<?php

include './config/koneksi.php';

$response = array();

// Melakukan pengecekan metode yang di request oleh user, harus method post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengecek apakah parameter yg kita inginkan sudah terisi
    if (isset($_POST["username"]) && isset ($_POST["password"]) && isset ($_POST["namauser"]) 
    && isset ($_POST["alamat"]) && isset ($_POST["jenkel"]) && isset ($_POST["notelp"]) && isset ($_POST["level"])) {
        // Memasukkan data yang sudah dikirim oleh user di dalam parameter ke variable penampung baru
        $username = $_POST["username"];
        $password = md5($_POST["password"]);
        $namauser = $_POST["namauser"];
        $alamat = $_POST["alamat"];
        $jenkel = $_POST["jenkel"];
        $notelp = $_POST["notelp"];
        $level = $_POST["level"];

        // Mengecek data username apakah sudah terpakai?
        // membuat query untuk mencari username yang sama di database
        $sql = "SELECT * FROM tb_user WHERE username = '$username' ";

        // membuat variable cek yang didalamnya berguna untuk menjalankan query di atas
        $check = mysqli_fetch_array(mysqli_query($connection, $sql));
        // Melakukan pengecekan data di dalam variable $check
        if (isset($check)){
            // Membuat response untuk JSON pada saat username sudah terdaftar
            $response["result"] = 0;
            $response["message"] = "ooops!, username sudah terdaftar!";
        }else{
            // Melakukan inputan user ke dalam database menggunakan operasi INSERT
            $sql = "INSERT INTO tb_user(nama_user, alamat, jenkel, no_telp, username, password, level) 
            VALUES('$namauser', '$alamat', '$jenkel', $notelp, '$username', '$password', $level)";

            // Melakukan operasi insert dengan perintah yang sudah kita buat di dalam variable $sql
            // Dan langsung cek apakah eksekusi nya berhasil
            if (mysqli_query($connection, $sql)) {
                // Berhasil masukkan pesan berhasil ke response
                $response["result"] = 1;
                $response["message"] = "Register Berhasil";

            }else{
                // Menampilkan pesan gagal register
                $response["result"] = 0;
                $response["message"] = "Register gagal";
            }
        }

        // Menampilkan response dalam bentuk JSON
        echo json_encode($response);
    }
} 

?>