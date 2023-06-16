<?php include 'header.php'; ?>


<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumb__text">
					<h4>Dashboard Customer</h4>
					<div class="breadcrumb__links">
						<a href="index.php">Home</a>
						<a href="#">Customer</a>
						<span>Pesanan</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
	<div class="container">
		<div class="row">
			
			<div id="aside" class="col-md-3">
				<?php 
				include 'customer_sidebar.php'; 
				?>
			</div>

			<div id="main" class="col-md-9">
				
				<h4><b>INVOICE</b></h4>
				<br>
				<small class="text-muted">Detail pesanan kamar</small>
				<br>
				<br>
				<div class="row">

					<?php 
					$id_invoice = mysqli_escape_string($koneksi, $_GET['id']);
					$id = $_SESSION['customer_id'];
					$invoice = mysqli_query($koneksi,"select * from invoice where invoice_customer='$id' and invoice_id='$id_invoice' order by invoice_id desc");
					while($i = mysqli_fetch_array($invoice)){
						?>


						<div class="col-lg-12">

							<a href="customer_pesanan.php" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> KEMBALI</a>
							<a href="customer_invoice_cetak.php?id=<?php echo $_GET['id'] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> CETAK</a>

							<br/>
							<br/>

							<h4>INVOICE-00<?php echo $i['invoice_id'] ?></h4>


							<br/>
							<table class="table table-bordered">
								<tr>
									<th width="20%">Nama</th>
									<td><?php echo $i['invoice_nama']; ?></td>
								</tr>
								<tr>
									<th>HP</th>
									<td><?php echo $i['invoice_hp']; ?></td>
								</tr>
							</table> 
							<br/>

							<?php 
							$no=1;
							$id_kamar = $i['invoice_kamar'];
							$kamar = mysqli_query($koneksi,"SELECT * FROM kamar,kategori where kategori_id=kamar_kategori and kamar_id='$id_kamar' order by kamar_id desc");
							$k = mysqli_fetch_assoc($kamar);
							?>

							<div class="row">

								<div class="col-lg-2">
									<?php if($k['kamar_foto1'] == ""){ ?>
										<img src="gambar/sistem/kamar.png" style="width: auto;height: auto">
									<?php }else{ ?>
										<img src="gambar/kamar/<?php echo $k['kamar_foto1'] ?>" style="width: auto;height: auto">
									<?php } ?>
								</div>

								<div class="col-lg-10">

									<h5><?php echo $k['kamar_nama']; ?></h5>


									<small class="text-muted">
										<?php echo $k['kategori_nama']; ?>
										|
										Ranjang : <?php echo $k['kamar_ranjang']; ?>
										|
										Ukuran Kamar : <?php echo $k['kamar_ukuran']; ?> m2
										<br>
										Fasilitas : 
										<?php   
										$id_kamar = $k['kamar_id'];
										$fasilitas = mysqli_query($koneksi,"select * from fasilitas_kamar,kamar_fasilitas where fk_id=kf_fasilitas and kf_kamar='$id_kamar' order by fk_nama asc");
										while($f = mysqli_fetch_array($fasilitas)){
											echo $f['fk_nama'].", ";
										}
										?>
										<br>
										Harga : <b><?php echo "Rp. ".number_format($k['kamar_harga']).",-"; ?></b> / mlm

									</small>

								</div>

							</div>

							<br>

							<div class="table-responsive">
								<table class="table table-bordered">
									<tbody>
										<tr>
											<th>Harga Kamar</th>
											<td class="text-center"><?php echo "Rp. ".number_format($i['invoice_harga'])." ,-"; ?></td>
										</tr>
										<tr>
											<th>
												Lama Menginap :
												<br>
												<small class="text-muted"><?php echo date('d/m/Y', strtotime($i['invoice_dari'])); ?> - <?php echo date('d/m/Y', strtotime($i['invoice_sampai'])); ?></small>
											</th>
											<td class="text-center">
												<?php 
												$tgl_dari = strtotime($i['invoice_dari'] );
												$tgl_sampai = strtotime($i['invoice_sampai'] );
												$jumlah_hari =  $tgl_sampai - $tgl_dari;
												$hari = round($jumlah_hari / (60 * 60 * 24));
												?>
												<?php echo $hari ?> Hari
											</td>
										</tr>
										<tr>
											<th>
												Layanan Tambahan :
												<br>
												<?php   
												$harga_layanan = 0;
												$id_invoice = $i['invoice_id'];
												$layanan = mysqli_query($koneksi,"select * from layanan_tambahan, invoice_layanan_tambahan where ilt_layanan=lt_id and ilt_invoice='$id_invoice'");
												while($l = mysqli_fetch_array($layanan)){
													$harga_layanan += $l['lt_harga'];
													?>
													<small class="text-muted">- <?php echo $l['lt_nama'] ?> &nbsp; - &nbsp; (<?php echo "Rp. ".number_format($l['lt_harga'])." ,-" ?>)</small><br>
													<?php
												}
												?>
											</th>
											<td class="text-center"><?php echo "Rp. ".number_format($harga_layanan)." ,-"; ?></td>
										</tr>
										<tr>
											<th>Total Bayar</th>
											<td class="text-center bg-primary text-white font-weight-bold"><?php echo "Rp. ".number_format($i['invoice_total_bayar'])." ,-"; ?></td>
										</tr>
									</tbody>
								</table>
							</div>


							<br>
							<h5>STATUS :</h5> 
							<?php 
							if($i['invoice_status'] == 0){
								echo "<span class='label label-warning'>Menunggu Pembayaran</span>";
							}elseif($i['invoice_status'] == 1){
								echo "<span class='label label-default'>Menunggu Konfirmasi</span>";
							}elseif($i['invoice_status'] == 2){
								echo "<span class='label label-danger'>Ditolak</span>";
							}elseif($i['invoice_status'] == 3){
								echo "<span class='label label-primary'>Dikonfirmasi</span>";
							}elseif($i['invoice_status'] == 4){
								echo "<span class='label label-success'>Selesai</span>";
							}
							?>

						</div>	


						<?php 
					}
					?>
				</div>
				

			</div>
		</div>
	</div>
</section>
<!-- Checkout Section End -->

<?php include 'footer.php'; ?>