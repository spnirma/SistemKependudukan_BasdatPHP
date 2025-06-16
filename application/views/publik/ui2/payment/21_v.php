<div class="row">
    <div class="colo-md-3">
        <div align="center">
            <img src="<?= base_url(); ?>asset/img/indomaret.png" width="180px" >
        </div>
    </div>
</div>
<div align="center"><h5>Cara melakukan Pembayaran dengan Indomaret <h5></div>
<div class="form-group" style="margin-top: 1em">
    <ol start="1" style="margin-left: -10px">
        <!-- <li>Ketentuan ini merupakan aturan sepenuhnya dari Indomaret dan dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya.</li> -->
        <li>Nilai maksimum per transaksi yang diperbolehkan adalah Rp 5.000.000,-</li>
        <li><strong><u>Kode Pembayaran</u></strong> akan dikirim ke nomor handphone dan email anda.</li>
        <li>Datang ke cabang Indomaret dan sebutkan pembayaran melalui <strong><font color="#ed1c24">CIPIKA</font></strong> dengan menggunakan <strong><u>Kode Pembayaran</u></strong> tersebut.</li>
        <li>Layanan pembayaran ini tergantung kepada jam operasional cabang Indomaret pilihan Anda. Hal tersebut sepenuhnya berada di luar kuasa dan tanggung jawab kami.
        </li>
        <?php if ($whitelabel_partner=="Persib_ticket") { ?>
            <li>Kode dan Waktu Pembayaran berlaku dalam waktu  <b><u>3 jam</u></b> kedepan terhitung sejak diterbitkannya invoice transaksi ini.</li>
        <?php } else {?>
            <li>Kode dan Waktu Pembayaran berlaku dalam waktu  <?php //echo PAYMENT_EXPIRATION_IN?> 48 jam (2 hari) terhitung sejak diterbitkannya invoice transaksi ini.</li>
        <?php } ?>
        <!-- <li>Lalu tekan Tombol "Lanjutkan Pembayaran".</span><br> -->
    </ol>
</div>
