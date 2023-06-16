<?php 
include '../koneksi.php';
$id = $_GET['id'];

mysqli_query($koneksi, "delete from fasilitas_kamar where fk_id='$id'");


header("location:fasilitas_kamar.php");
