<?php 
include 'koneksi.php';

session_start();
date_default_timezone_set('Asia/Jakarta');

$tanggal = date('Y-m-d');
$id_customer = $_SESSION['customer_id'];


$layanan_tambahan = $_POST['layanan_tambahan'];
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$hp = mysqli_real_escape_string($koneksi, $_POST['hp']);
$kamar = $_SESSION['booking_kamar'];
$dari = mysqli_real_escape_string($koneksi, $_POST['dari']);
$sampai = mysqli_real_escape_string($koneksi, $_POST['sampai']);
$total_bayar = mysqli_real_escape_string($koneksi, $_POST['harga']);
$harga_per_malam = mysqli_real_escape_string($koneksi, $_POST['harga_per_malam']);

mysqli_query($koneksi,"insert into invoice values(NULL,'$tanggal','$id_customer','$nama','$hp','$kamar','$dari','$sampai','$harga_per_malam','$total_bayar','0','')")or die(mysqli_error($koneksi));

$last_id = mysqli_insert_id($koneksi);

for($a = 0; $a < count($layanan_tambahan); $a++){
	$f = $layanan_tambahan[$a];
	mysqli_query($koneksi,"insert into invoice_layanan_tambahan values('$last_id','$f')");
}


unset($_SESSION['booking_kamar_status']);
unset($_SESSION['booking_kamar']);
unset($_SESSION['booking_dari']);
unset($_SESSION['booking_sampai']);
unset($_SESSION['booking_dewasa']);
unset($_SESSION['booking_anak']);

header("location:customer_pesanan.php?alert=sukses");