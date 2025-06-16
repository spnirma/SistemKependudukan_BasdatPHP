<h5>Detail Voucher</h5>
<div class="row">
    <div class="colo-md-3" style="float: left">
        <p style="margin-left: 10px">Pembayaran menggunakan Program Promo Voucher.</p>
        <?php 
        $canvasser_ada_sisa = array("CVSS", "CVSB", "CVSG");
        if (!in_array(substr(trim($codeVoucherMember),0,4), $canvasser_ada_sisa)) {
        ?>
            <p style="margin-left: 10px; color: #E11">Sisa voucher tidak dapat diuangkan/digunakan kembali (hangus)</p>
        <?php }?>
    </div>
</div>
