<?php 
include '../koneksi.php';
$icon  = $_POST['icon'];
$nama  = $_POST['nama'];

mysqli_query($koneksi, "insert into fasilitas_hotel values (NULL,'$icon','$nama')");
header("location:fasilitas_hotel.php");