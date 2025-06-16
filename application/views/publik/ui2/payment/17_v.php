<h4>Detail Kartu Kredit Mandiri</h4>
<div class="row">
    <div class="colo-md-3" style="float: left">
        <p style="margin-left: 10px">Pembayaran menggunakan Kartu Kredit Mandiri akan dilakukan pada halaman Veritrans.</p>
        <?php if (isset($getPaymentCicilanProduct[17])) : ?>
        <div style="margin-bottom: 50px">
            <span class="col-md-2" style="margin-top:0.5em;margin-left: -5px">Cicilan :</span>
            <div class="col-md-5" style="margin-left:-10px">
                <select id="id_product_cicilan17" name="id_product_cicilan17" class="form-control">
                <?php foreach ($getPaymentCicilanProduct[17] as $v) { ?>
                    <option value="<?= $v->id_produk_cicilan;?>">Cicilan <?= $v->bunga_cicilan;?>% <?= $v->periode_cicilan;?> bulan</option>
                <?php } ?>
                </select>
            </div>
        </div>
        <?php else: ?>
        <div style="margin-bottom: 50px">
            <span class="col-md-2" style="margin-top:0.5em;margin-left: -5px">Cicilan :</span>
            <div class="col-md-5" style="margin-left:-10px">
                <select id="id_product_cicilan17" name="id_product_cicilan17" class="form-control">
                <?php foreach (unserialize(MANDIRI_KREDIT_CARD_CICILAN) as $k => $v) { ?>
                    <option value="<?= $k ?>">Cicilan 0% <?= $k ?> bulan</option>
                <?php } ?>
                </select>
            </div>
        </div>
        <?php endif; ?>
        <p style="margin-left: 10px">Mandiri Kartu Kredit bisa melakukan pembayaran menggunakan : </p>
        <img src="<?= base_url(); ?>asset/img/Mastercard_small.png" align="center" width="120px" height="60px" style="margin-left: 25px;">
        <a href="http://visa.co.id/ap/id/personal/security/onlineshopping.shtml"><img src="<?= base_url(); ?>asset/img/VbV 2-colors.jpg" align="center" width="120px" height="60px" style="margin-left: 10px"></a>
        <img src="<?= base_url(); ?>asset/img/MC SecureCode 3.gif" align="center" width="130px" height="60px" style="margin-left: 10px">
        <img src="<?= base_url(); ?>asset/img/logo_180x58 - Copy.gif" align="center" width="120px" height="45px" style="margin-left: 10px">
    </div>
</div>
<div class="col-md-12" style="border: 3px solid #f3f1f2;padding: 0.5em;margin-left:0.2em;margin-top:1em">
    <label><strong>Perhatian :</strong></label>
    <p>Jika dalam transaksi ini Anda telah menggunakan Voucher Cipika dan tidak menyelesaikan transaksi dengan baik, karena salah satu atau beberapa sebab berikut :</p>
    <ol type=number style="margin-left:-0.5em">
        <li>Kesalahan input CVV</li>
        <li>Kesalahan input Data Kartu Kredit</li>
        <li>Masa Tenggat Transaksi Habis</li>
        <li>Kesalahan input kode Otorisasi</li>
        <li>Menutup Browser saat transaksi berlangsung di halaman mitra pembayaran</li>
    </ol>
    <p>Secara otomatis kode voucher Anda dinyatakan hangus/tidak dapat digunakan kembali/redeemed. Oleh karenanya, pastikan Anda mengisi dengan benar sebelum waktu tenggat transaksi habis.</p>
</div>

