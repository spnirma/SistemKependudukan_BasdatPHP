<div align="center" style="margin-bottom:1em">
    <img src="<?= base_url(); ?>/asset/ui2.6/img/logos/mobo_outlet_transparent.png" width="170px" >
</div>
<!--
<div style="border: 2px solid black;padding: 10px 10px 10px 10px;margin-bottom: 10px">
    <p>Ketik <strong>TOKEN</strong>(spasi)<strong>PIN</strong> ke <strong>789</strong> atau telepon <strong>*789*5# dari nomor Dompetku.</strong></p><p>Token akan dikirimkan melalui SMS.</p>
</div>
-->
<div class="row">
	<div class="form-group text-only" >
        <span class="col-sm-3" style="margin-top:5px">Nomer MOBO</span>
		<div class="col-sm-9">
			<input readonly value="<?= $mobo_outlet->mbo_number?>" type="text" class="form-control phone-user" id="mobo-number" name="mobo_number"  onkeypress="return checkFieldOnlyNumber(event)">
			<input readonly value="<?= $mobo_outlet->mbo_outlet_id?>" type="hidden" class="form-control phone-user" id="mobo-outlet-id" name="mobo_outlet_id"  onkeypress="return checkFieldOnlyNumber(event)">
			<input readonly value="<?= $mobo_outlet->mbo_operator_id?>" type="hidden" class="form-control phone-user" id="mobo-operator-id" name="mobo_operator_id" >
		</div>
	</div>
</div>
<br>
<!--
<div class="row">
	<div class="form-group text-only" >
        <span class="col-sm-6" style="margin-top:5px">Operator ID</span>
		<div class="col-sm-6">
			<input readonly value="<?= $mobo_outlet->mbo_operator_id?>" type="text" class="form-control phone-user" id="phone-user" name="phone_user" value="" onkeypress="return checkFieldOnlyNumber(event)">
		</div>
	</div>
</div>
-->
<div class="row">
	<div class="form-group text-only" >
        <span class="col-sm-3" style="margin-top:5px">Kode Voucher</span>
		<div class="col-sm-9">
			<input value="" type="text" class="form-control phone-user" id="mobo-voucher" name="mobo_voucher" value="" onkeypress="return checkFieldOnlyNumber(event)" placeholder="Dial *171*4*5*PIN_ANDA# untuk membuat KODE TOKEN ">
		</div>
	</div>
</div>
<br>
    <div class="col-md-12" style="border: 3px solid #f3f1f2;padding: 0.5em;margin-left:0.5em">
        <label><strong>Petunjuk :</strong></label>
        <p>Anda bisa mendapatkan token kode voucher (token) menggunakan handphone dengan nomor MOBO yang terdaftar diatas:</p>
        <ol  style="margin-left:-0.5em">
        <!--
            <li>Dial <strong>*171#</strong></li>
            <li>Pilih menu <strong>4 - Koin Hadiah</strong></li>
            <li>Pilih menu <strong>5 - Menukar Voucher Barang</strong></li>
            <li>Masukkan PIN Mobo anda</li>
        -->    
            <li>Dial ke <strong>*171*4*5*<font style="color:red;">PIN_ANDA</font>#</strong></li>
            <li><font style="color:red;">PIN_ANDA</font> adalah PIN Mobo anda</li>
            <li>Anda akan menerima SMS berisikan kode token voucher</li>
            <li>Masukkan kode token vouchernya di kolom isian <strong>Kode Voucher</strong> diatas</li>
        </ol>
        <p>Mohon gunakan segera kode token voucher sebelum waktu kadaluarsa token tersebut.</p>
    </div>
