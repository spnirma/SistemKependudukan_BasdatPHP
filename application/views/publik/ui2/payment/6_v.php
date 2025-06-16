<div class="row">
    <div class="colo-md-3">
        <div align="center">
            <a href="<?= base_url(); ?>mandiri-clickpay/" target="_blank"><img src="<?= base_url(); ?>asset/img/branding-clickpay.png" width="180px" height="90px"></a>
        </div>
    </div>
</div>
<div align="center"><h5>Cara melakukan Pembayaran dengan Mandiri ClickPay<h5></div>
<div class="form-group" style="margin-top: 1em">
    <ol start="1" style="margin-left: -10px">
        <li>Masukkan 16 digit nomor kartu Debit anda :
            <input type="text" name="card_number_user" onkeyup="show_digit_cart_number()" id="card_number_user" placeholder="Masukkan 16 Digit Nomor Kartu Debit" style="padding: 4px 5px 4px 4px; width: 250px" onkeypress="return checkFieldOnlyNumber(event)"><br>
        </li>
        <li>Nyalakan Token Mandiri Anda dengan menekan tombol Merah pada Token Fisik anda.</li>
        <li>Masukkan password Token Mandiri.</li>
        <li>Tekan "3" ketika muncul pesan "APPLI"</li>
        <li>Masukkan "<strong><label id="card_number_user_digit"></label></strong>" pada input 1 yang tertera pada layar Anda dan tekan Tombol Merah selama 3 detik</li>
        <li>Masukkan "<strong><?= $grandTotalAllMandiri; ?></strong>" pada input 2 yang tertera pada layar Anda dan tekan Tombol Merah selama 3 detik</li>
        <li>Masukkan "<strong><?= htmlspecialchars($unixIdMandiri); ?></strong>" pada input 3 yang tertera pada layar Anda dan tekan Tombol Merah selama 3 detik</li>
        <li>Masukkan angka yang tertera di layar Token Mandiri Anda :
            <input type="text" name="token_number_user" id="token_number_user" placeholder="Respon Token Fisik Anda" style="padding: 4px 5px 4px 4px; width:150px" onkeypress="return checkFieldOnlyNumber(event)"></li>
            <input type="hidden" name="unix_id_user" id="unix_id_user" value="<?= htmlspecialchars($unixIdMandiri); ?>"></li>
        <li>Lalu tekan Tombol "Lanjutkan".</span><br>
    </ol>
</div>
<div class="row">
    <div align="center">
        <a href="<?= base_url(); ?>mandiri-clickpay/" target="_blank"><img src="<?= base_url(); ?>asset/img/mandiriclickpay.gif" width="880px"></a>
    </div>
</div>