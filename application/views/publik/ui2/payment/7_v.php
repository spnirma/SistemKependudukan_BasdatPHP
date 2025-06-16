<div class="row" style="margin-top: 1em;">
    <div class="col-md-3" align="center" style="margin-bottom:1.5em">
        <img src="<?= base_url(); ?>asset/img/Mastercard_small.png" width="105px" height="55px" style="margin-top:2.5em">
        <img src="<?= base_url(); ?>asset/img/logo_180x58 - Copy.gif" align="center" width="120px" height="45px" style="margin-top:3em">
    </div>
    <div class="col-md-8" style="">
        <span class="col-md-4 col-sm-8" style="margin-left:-1.5em">Bank Penerbit : </span>
        <div class="col-md-8" style="margin-left:-2em;margin-top:-1em;margin-bottom:1em">
            <select id="kartu_kredit_bin" class="form-control" name="kartu_kredit_bin">
                <?php if(isset($getListKartuKreditBin[7]) && count($getListKartuKreditBin[7]) > 0) : ?>
                    <?php foreach ($getListKartuKreditBin[7] as $v) : ?>
                        <option value="<?= $v ?>">Bank <?= $v ?></option>
                    <?php endforeach;?>
                <?php else :?>
                    <option value="">-- Bank Lain --</option>
                    <option value="bni">Bank BNI</option>
                    <option value="mandiri">Bank Mandiri</option>
                <?php endif;?>
            </select>
        </div>
    </div>
    <div class="col-md-8" style="border: 3px solid #f3f1f2;padding: 0.5em;margin-left:0.5em">
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
</div>
