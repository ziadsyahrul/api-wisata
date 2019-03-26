<?php

include './config/koneksi.php';

// Membuat penampung response
$response = array();

// Kita cek apakah parameter yang dikirimkan ada 
if (isset($_POST["username"]) && isset($_POST["password"])) {
    // Memasukkan inputan user ke dalam variable
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    // Membuat query untuk mengambil detail user
    $sql = "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password'";

    // Mengeksekusi query yang ada di dalam variable $sql
    $check = mysqli_query($connection, $sql);

    // Cek apakah berhasil
    if (!$check) {
        echo 'Tidak bisa menjalankan query: ' . mysqli_error($connection);
        exit;
    }

    // Memasukkan data hasil query ke dalam variable
    // Mengambil baris pertama dari hasil query 
    $row = mysqli_fetch_row($check);

    // Membuat hasil dimasukkan ke dalam array
    $result_data = array(
        'id_user' => $row[0],
        'nama_user' => $row[1],
        'alamat' => $row[2],
        'jenkel' => $row[3],
        'no_telp' => $row[4],
        'username' => $row[5],
        'password' => $row[6],
        'level' => $row[7]
    );

    // Mengecek datanya apakah ada
    if (mysqli_num_rows($check) > 0) {
        // Mengisi pesan berhasil ke response
        $response['result'] = 1;
        $response['message'] = "Berhasil Login!";
        $response['data'] = $result_data;
    }else{
        // apabila kosong maka mengisi pesan gagal ke response
        $response['result'] = 0;
        $response['message'] = "Gagal Login";
    }

    // Mengubah response menjadi JSON
    echo json_encode($response);
}

?>