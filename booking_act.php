<?php 
include 'koneksi.php';

session_start();
date_default_timezone_set('Asia/Jakarta');

// $id_customer = $_SESSION['customer_id'];

$kamar = mysqli_real_escape_string($koneksi, $_POST['kamar']);
$dari = mysqli_real_escape_string($koneksi, $_POST['dari']);
$sampai = mysqli_real_escape_string($koneksi, $_POST['sampai']);
$dewasa = mysqli_real_escape_string($koneksi, $_POST['dewasa']);
$anak = mysqli_real_escape_string($koneksi, $_POST['anak']);

$kk = mysqli_query($koneksi,"select * from kamar where kamar_id='$kamar'");
$k = mysqli_fetch_assoc($kk);
$jumlah_kamar = $k['kamar_jumlah'];
// echo $jumlah_kamar;

// echo $dari;

$dari = date('Y-m-d', strtotime($dari));
$sampai = date('Y-m-d', strtotime($sampai));
// echo $dari;
$cek = mysqli_query($koneksi,"select * from invoice where invoice_kamar='$kamar' and (invoice_dari >= '$dari' and invoice_dari <= '$sampai' or invoice_sampai > '$dari' and invoice_sampai <= '$sampai') and (invoice_status='0' or invoice_status='1' or invoice_status='3')");
                    
// $cek = mysqli_query($koneksi,"select * from invoice where (date(invoice_dari) >= '$dari' and date(invoice_dari) <= '$sampai') or ((date(invoice_sampai) >= '$dari' and date(invoice_sampai) <= '$sampai')) and invoice_kamar='$kamar'");

$c = mysqli_num_rows($cek);
echo $c;
if($c >= $jumlah_kamar){
	echo "tidak tersedia";

	$_SESSION['booking_kamar_status'] = "tidak-tersedia";
	$_SESSION['booking_kamar'] = $kamar;
	$_SESSION['booking_dari'] = $dari;
	$_SESSION['booking_sampai'] = $sampai;
	$_SESSION['booking_dewasa'] = $dewasa;
	$_SESSION['booking_anak'] = $anak;

	header("location:booking.php?id=$kamar&alert=tidak-tersedia");
}else{
	echo "tersedia";

	$_SESSION['booking_kamar_status'] = "tersedia";
	$_SESSION['booking_kamar'] = $kamar;
	$_SESSION['booking_dari'] = $dari;
	$_SESSION['booking_sampai'] = $sampai;
	$_SESSION['booking_dewasa'] = $dewasa;
	$_SESSION['booking_anak'] = $anak;

	
	header("location:booking.php?id=$kamar&alert=tersedia");
}

