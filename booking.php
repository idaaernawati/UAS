<?php include 'header.php'; ?>

<?php 
if(isset($_SESSION['booking_kamar_status'])){
    if($_SESSION['booking_kamar'] != $_GET['id']){
        unset($_SESSION['booking_kamar_status']);
        unset($_SESSION['booking_kamar']);
        unset($_SESSION['booking_dari']);
        unset($_SESSION['booking_sampai']);
        unset($_SESSION['booking_dewasa']);
        unset($_SESSION['booking_anak']);
    }
}
?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Check Out</h4>
                    <div class="breadcrumb__links">
                        <a href="index.php">Home</a>
                        <a href="#">Booking</a>
                        <span>Check Out</span>
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
        <div class="checkout__form">

            <?php 
            if(isset($_SESSION['booking_kamar_status'])){
                if($_SESSION['booking_kamar_status'] == "tersedia"){
                    echo "<div class='alert alert-success text-center'><b>Kamar tersedia.</b> silahkan klik \"CHECKOUT\" untuk melanjutkan booking</div>";
                }elseif($_SESSION['booking_kamar_status'] == "tidak-tersedia"){
                    echo "<div class='alert alert-danger text-center'><b>Kamar tidak tersedia.</b> Silahkan cari tanggal atau kamar lain.</div>";
                }
            }
            ?>

            <!-- <form action="#"> -->
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-6">

                        <h6 class="checkout__title">Detail Booking</h6>

                        <?php 
                        $no=1;
                        $id_kamar = mysqli_escape_string($koneksi,$_GET['id']);
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
                        <hr>


                        <form action="booking_act.php" method="post">
                            <input type="hidden" name="kamar" value="<?php echo $id_kamar ?>">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="checkout__input">
                                        <p>Tgl. Check-In<span>*</span></p>
                                        <input type="text" name="dari" class="datepicker" required="required" value="<?php if(isset($_SESSION['booking_dari'])){ echo date('d-m-Y', strtotime($_SESSION['booking_dari'])); } ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="checkout__input">
                                        <p>Tgl. Check-Out<span>*</span></p>
                                        <input type="text" name="sampai" class="datepicker" required="required" value="<?php if(isset($_SESSION['booking_sampai'])){ echo date('d-m-Y', strtotime($_SESSION['booking_sampai'])); } ?>">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="checkout__input">
                                        <p>Dewasa<span>*</span></p>
                                        <select name="dewasa" required="required">
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "1"){ echo "selected='selected'"; } } ?> value="1">1</option>
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "2"){ echo "selected='selected'"; } } ?> value="2">2</option>
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "3"){ echo "selected='selected'"; } } ?> value="3">3</option>
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "4"){ echo "selected='selected'"; } } ?> value="4">4</option>
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "5"){ echo "selected='selected'"; } } ?> value="5">5</option>
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "6"){ echo "selected='selected'"; } } ?> value="6">6</option>
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "7"){ echo "selected='selected'"; } } ?> value="7">7</option>
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "8"){ echo "selected='selected'"; } } ?> value="8">8</option>
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "9"){ echo "selected='selected'"; } } ?> value="9">9</option>
                                            <option <?php if(isset($_SESSION['booking_dewasa'])){ if($_SESSION['booking_dewasa'] == "10"){ echo "selected='selected'"; } } ?> value="10">10</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="checkout__input">
                                        <p>Anak-anak<span>*</span></p>
                                        <select name="anak" required="required">
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "0"){ echo "selected='selected'"; } } ?> value="0">0</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "1"){ echo "selected='selected'"; } } ?> value="1">1</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "2"){ echo "selected='selected'"; } } ?> value="2">2</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "3"){ echo "selected='selected'"; } } ?> value="3">3</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "4"){ echo "selected='selected'"; } } ?> value="4">4</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "5"){ echo "selected='selected'"; } } ?> value="5">5</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "6"){ echo "selected='selected'"; } } ?> value="6">6</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "7"){ echo "selected='selected'"; } } ?> value="7">7</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "8"){ echo "selected='selected'"; } } ?> value="8">8</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "9"){ echo "selected='selected'"; } } ?> value="9">9</option>
                                            <option <?php if(isset($_SESSION['booking_anak'])){ if($_SESSION['booking_anak'] == "10"){ echo "selected='selected'"; } } ?> value="10">10</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <center><button class="site-btn">CEK KETERSEDIAA KAMAR</button></center>
                        </form>

                        <br>
                        <br>

                        <center>
                            <?php 
                            if(isset($_SESSION['booking_kamar_status'])){
                                if($_SESSION['booking_kamar_status'] == "tersedia"){
                                    ?>
                                    <a href="checkout.php" class="site-btn bg-success">CHECK OUT &nbsp; <i class="fa fa-arrow-right"></i></a>
                                    <?php
                                }

                            }
                            ?>
                        </center>


                    </div>
                    
                </div>
                <!-- </form> -->
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->


    <?php include 'footer.php'; ?>