<div align="center" style="margin-bottom:1em">
    <img src="<?= base_url(); ?>asset/img/logo-dompetku-2016.png" width="170px" height="60px">
</div>
<div style="border: 2px solid black;padding: 10px 10px 10px 10px;margin-bottom: 10px">
    <p>Ketik <strong>TOKEN</strong>(spasi)<strong>PIN</strong> ke <strong>789</strong> atau telepon <strong>*789*5# dari nomor Dompetku.</strong></p><p>Token akan dikirimkan melalui SMS.</p>
</div>
<div class="row">
	<div class="form-group text-only" >
        <?php if ($whitelabel_partner=="Persib_ticket") { ?>
            <span class="col-sm-6" style="margin-top:5px">Nomer Dompetku / No Anggota</span>
        <?php } else {?>
            <span class="col-sm-6" style="margin-top:5px">Nomer Indosat Dompetku</span>
        <?php } ?>
		<div class="col-sm-6">
			<input type="text" class="form-control phone-user" id="phone-user" name="phone_user" value="" onkeypress="return checkFieldOnlyNumber(event)">
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group text-only" >
		<span class="col-sm-6" style="margin-top:15px">Token Anda</span>
		<div class="col-sm-6" style="margin-top:10px">
			<input type="text" class="form-control token-user" id="token-user" name="token_user" value="" onkeypress="return checkFieldOnlyNumber(event)">
		</div>
	</div>
</div>
