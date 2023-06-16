<?php include 'header.php'; ?>

<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Kamar
      <small>Data Kamar</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Kamar</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-12">
        <div class="box">

          <div class="box-header">
            <h3 class="box-title">Kamar</h3>
            <a href="kamar_tambah.php" class="btn btn-default btn-sm pull-right"><i class="fa fa-plus"></i> &nbsp Tambah Kamar Baru</a>              
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="table-datatable">
                <thead>
                  <tr>
                    <th width="1%">NO</th>
                    <th>NAMA KAMAR</th>
                    <th width="10%">JENIS RANJANG</th>
                    <th>UKURAN</th>
                    <th>KATEGORI</th>
                    <th width="10%">HARGA</th>
                    <th>JUMLAH</th>
                    <th width="1%">FOTO</th>
                    <th width="10%">OPSI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $no=1;
                  $data = mysqli_query($koneksi,"SELECT * FROM kamar,kategori where kategori_id=kamar_kategori order by kamar_id desc");
                  while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td>
                        <?php echo $d['kamar_nama']; ?>
                        <br>
                        <small class="text-muted">
                          <?php   
                          $id_kamar = $d['kamar_id'];
                          $fasilitas = mysqli_query($koneksi,"select * from fasilitas_kamar,kamar_fasilitas where fk_id=kf_fasilitas and kf_kamar='$id_kamar' order by fk_nama asc");
                          while($f = mysqli_fetch_array($fasilitas)){
                            echo $f['fk_nama'].", ";
                          }
                          ?>
                        </small>
                      </td>
                      <td class="text-center"><?php echo $d['kamar_ranjang']; ?></td>
                      <td><?php echo $d['kamar_ukuran']; ?> m2</td>
                      <td><?php echo $d['kategori_nama']; ?></td>
                      <td><?php echo "Rp. ".number_format($d['kamar_harga']).",-"; ?></td>
                      <td class="text-center">
                        <?php echo number_format($d['kamar_jumlah']); ?>
                      </td>
                      <td>
                        <center>
                          <?php if($d['kamar_foto1'] == ""){ ?>
                            <img src="../gambar/sistem/kamar.png" style="width: 70px;height: auto">
                          <?php }else{ ?>
                            <img src="../gambar/kamar/<?php echo $d['kamar_foto1'] ?>" style="width: 70px;height: auto">
                          <?php } ?>
                        </center>
                      </td>
                      <td>                        
                        <a class="btn btn-warning btn-sm" href="kamar_edit.php?id=<?php echo $d['kamar_id'] ?>"><i class="fa fa-cog"></i></a>
                        <a class="btn btn-danger btn-sm" onclick=" return confirm('Yakin?')" href="kamar_hapus.php?id=<?php echo $d['kamar_id'] ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php 
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
<center>
  <h2><b>GRAFIK JUMLAH PENGUNJUNG DI SETIAP KAMAR HOTEL</b></h2>
<?php
include('koneksi.php');
$pengunjung = mysqli_query($koneksi,"select * from kamar_pengunjung");
while($row = mysqli_fetch_array($pengunjung)){
$nama_kamar[] = $row['nama_kamar'];
$query = mysqli_query($koneksi,"select sum(jumlah_pengunjung) as jumlah_pengunjung from 
kamar_pengunjung where nama_kamar='".$row['nama_kamar']."'");
$row = $query->fetch_array();
$jumlah[] = $row['jumlah_pengunjung'];
}
?>

<!doctype html>
<html>
<head>
<title>Pie Chart</title>
<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
<div id="canvas-holder" style="width:40%">
<canvas id="chart-area"></canvas>
</div>
<script>
var config = {
type: 'pie',
data: {
datasets: [{
data:<?php echo json_encode($jumlah); 
?>,
backgroundColor: [
                        'rgba(210, 180, 140, 1)',
                        'rgba(238, 130, 238, 1)',
                        'rgba(205, 92, 92, 1)',
                        'rgba(255, 20, 147, 1)',
                        'rgba(100, 149, 237, 1)',
                        'rgba(255, 215, 0, 1)',
                        'rgba(152, 251, 152, 1)',
                        'rgba(64, 224, 208, 1)'
                     ],
                     borderColor: [
                        'rgba(210, 180, 140, 1)',
                        'rgba(238, 130, 238, 1)',
                        'rgba(205, 92, 92, 1)',
                        'rgba(255, 20, 147, 1)',
                        'rgba(100, 149, 237, 1)',
                        'rgba(255, 215, 0, 1)',
                        'rgba(152, 251, 152, 1)',
                        'rgba(64, 224, 208, 1)'
],
label: 'Presentase Data Kamar'
}],
labels: <?php echo json_encode($nama_kamar); ?>},
options: {
responsive: true
}
};
window.onload = function() {
var ctx = document.getElementById('chart-area').getContext('2d');
window.myPie = new Chart(ctx, config);
};
document.getElementById('randomizeData').addEventListener('click', 
function() {
config.data.datasets.forEach(function(dataset) {
dataset.data = dataset.data.map(function() {
return randomScalingFactor();
});
});
window.myPie.update();
});
var colorNames = Object.keys(window.chartColors);
document.getElementById('addDataset').addEventListener('click', 
function() {
var newDataset = {
backgroundColor: [],
data: [],
label: 'New dataset ' + 
config.data.datasets.length,
};
for (var index = 0; index < config.data.labels.length; 
++index) {
newDataset.data.push(randomScalingFactor());
var colorName = colorNames[index % 
colorNames.length];
var newColor = window.chartColors[colorName];
newDataset.backgroundColor.push(newColor);
}
config.data.datasets.push(newDataset);
window.myPie.update();
});
document.getElementById('removeDataset').addEventListener('click', 
function() {
config.data.datasets.splice(0, 1);
window.myPie.update();
});
</script>
</body>
</html>
</center>
        </div>
      </section>
    </div>
  </section>

</div>
<?php include 'footer.php'; ?>