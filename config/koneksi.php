<?php

// Menyiapkan variable yang dibutuhkan untuk koneksi ke database
$server = "localhost";
$username = "root";
$password = "";
$database = "wisata";

// mengkoneksikan dan memilih database yang kita inginkan
$connection = mysqli_connect($server, $username, $password, $database)or die("koneksi gagal");

?>