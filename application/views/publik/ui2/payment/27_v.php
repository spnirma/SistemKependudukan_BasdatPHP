<?php
/*
 * Document    : 27_v.php
 * Create on   : Feb 22, 2017, 7:44:52 PM
 * Author      : Decky Iskandar
 * Description : 
 */
?>
<!--<div class="row" style="margin-top: 1em;">
    <div class="col-md-6 col-xs-12">
        <div class="col-md-12" align="center" style="margin-bottom:1.5em">
            <input type="radio" name="bank_code" value="BMRI" style="left: 30px;" />
            <img src="<?= base_url(); ?>asset/img/mandiri-transfer.png" align="center" width="120px" height="45px" alt="Payment Kredivo Cipika">
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="col-md-12" align="center" style="margin-bottom:1.5em">
            <input type="radio" name="bank_code" value="BBBA" style="left: 30px;" />
            <img src="<?= base_url(); ?>asset/img/permata-transfer.png" align="center" width="120px" height="45px" alt="Payment Kredivo Cipika">
        </div>
    </div>
    <div class="col-xs-12" style="margin-top: 15px;">
        <label><strong>Perhatian :</strong></label>
        <ul>
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
            <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
            <li>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</li>
            <li>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</li>
        </ul>
    </div>
</div>-->

    <!--<div id="collapse666" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading666">-->
        <!--<div class="panel-body layout-payment666">-->
        <?php if ($whitelabel_partner=="Persib" || $whitelabel_partner=="Persib_ticket" || $whitelabel_partner=="Renewal") {?>
            <div class="row" style="margin-top: 1em;">
                <div class="col-md-6 col-xs-12">
                    <div class="col-md-12" align="center" style="margin-bottom:1.5em">
                        <input id="nicepay_payment_permata_bank" type="radio" name="bank_code" style="left: 30px;" value="BBBA" />
                        <img src="<?= base_url(); ?>asset/img/logo-permata-bank.png" align="center" width="120" height="45" alt="Payment NICEPAY Permata">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="col-md-12" align="center" style="margin-bottom:1.5em">
                    &nbsp;
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row" style="margin-top: 1em;">
                <div class="col-md-6 col-xs-12">
<!--                    <div class="col-md-12" align="center" style="margin-bottom:1.5em">
                        <input id="nicepay_payment_bca" type="radio" name="bank_code" style="left: 30px;" value="bca" checked="checked" />
                        <img src="<?= base_url(); ?>asset/img/logo-bank-bca.png" align="center" width="120" height="45" alt="Payment NICEPAY BCA">
                    </div>-->
                    <div class="col-md-12" align="center" style="margin-bottom:1.5em">
                        <input id="nicepay_payment_permata_bank" type="radio" name="bank_code" style="left: 30px;" value="BBBA" />
                        <img src="<?= base_url(); ?>asset/img/logo-permata-bank.png" align="center" width="120" height="45" alt="Payment NICEPAY Permata">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="col-md-12" align="center" style="margin-bottom:1.5em">
                        <input id="nicepay_payment_mandiri" type="radio" name="bank_code" style="left: 30px;" value="BMRI" />
                        <img src="<?= base_url(); ?>asset/img/mandiri-transfer.png" align="center" width="120" height="45" alt="Payment NICEPAY Mandiri">
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 1em;">
                <div class="col-md-6 col-xs-12">
                    <div class="col-md-12" align="center" style="margin-bottom:1.5em">
                        <input id="nicepay_payment_bni" type="radio" name="bank_code" style="left: 30px;" value="BNIN" />
                        <img src="<?= base_url(); ?>asset/img/logo-bni.png" align="center" width="120" height="45" alt="Payment NICEPAY BNI">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="col-md-12" align="center" style="margin-bottom:1.5em">
                        <input id="nicepay_payment_keb_hana_bank" type="radio" name="bank_code" style="left: 30px;" value="HNBN" />
                        <img src="<?= base_url(); ?>asset/img/logo-keb-hana-bank.png" align="center" width="120" height="45" alt="Payment NICEPAY KEB Hana Bank">
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 1em;">
                <div class="col-md-6 col-xs-12">
                    <div class="col-md-12" align="center" style="margin-bottom:1.5em">
                        <input id="nicepay_payment_maybank" type="radio" name="bank_code" style="left: 30px;" value="IBBK" />
                        <img src="<?= base_url(); ?>asset/img/logo-maybank.png" align="center" width="120" height="45" alt="Payment NICEPAY Maybank">
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    &nbsp;
                </div>
            </div>
        <?php } ?>
<!--            <div class="row" style="margin-top: 1em;">
                <div class="col-md-6 col-xs-12">
                    <div class="col-md-12" align="center" style="margin-bottom:1.5em">
                        <input id="nicepay_payment_atm_bersama_prima" type="radio" name="bank_code" style="left: 30px;" value="atm_bersama_prima" />
                        <img src="<?= base_url(); ?>asset/img/logo-atm-bersama-prima.png" align="center" width="120" height="45" alt="Payment NICEPAY ATM Bersama - Prima">
                    </div>
                </div>
            </div>-->
            <div class="row">
<!--                <div id="nicepay_payment_detail_bca" class="col-xs-12 nicepay-payment-detail">
                    <label><strong>Pembayaran ke BCA dapat dilakukan melalui:</strong></label>
                    <ul>
                        <li><a style="color: #333;" target="_blank" href="<?= base_url() ?>">ATM</a></li>
                        <li>Internet Banking</li>
                        <li>Mobile Banking</li>
                    </ul>
                    <a target="_blank" style="color:#333; text-decoration:underline;" href="<?= base_url() ?>cart/petunjuk_pembayaran_nicepay/bca">Lihat petunjuk selengkapnya</a>
                </div>-->
                <div id="nicepay_payment_detail_BMRI" class="col-xs-12 nicepay-payment-detail" style="display:none;">
                    <label><strong>Pembayaran ke Mandiri dapat dilakukan melalui:</strong></label>
                    <ul>
                        <li>ATM</li>
                        <li>Internet Banking</li>
                        <li>Mobile Banking</li>
                    </ul>
                    <a target="_blank" style="color:#333; text-decoration:underline;" href="<?= base_url() ?>cart/petunjuk_pembayaran_nicepay/mandiri">Lihat petunjuk selengkapnya</a>
                </div>
                <div id="nicepay_payment_detail_BNIN" class="col-xs-12 nicepay-payment-detail" style="display:none;">
                    <label><strong>Pembayaran ke BNI dapat dilakukan melalui:</strong></label>
                    <ul>
                        <li>ATM</li>
                        <li>Internet Banking</li>
                        <li>SMS Banking</li>
                        <li>Mobile Banking</li>
                    </ul>
                    <a target="_blank" style="color:#333; text-decoration:underline;" href="<?= base_url() ?>cart/petunjuk_pembayaran_nicepay/bni">Lihat petunjuk selengkapnya</a>
                </div>
                <div id="nicepay_payment_detail_BBBA" class="col-xs-12 nicepay-payment-detail" style="display:none;">
                    <label><strong>Pembayaran ke Permata Bank dapat dilakukan melalui:</strong></label>
                    <ul>
                        <li>ATM</li>
                        <li>Internet Banking</li>
                        <li>Mobile Banking</li>
                    </ul>
                    <a target="_blank" style="color:#333; text-decoration:underline;" href="<?= base_url() ?>cart/petunjuk_pembayaran_nicepay/permata_bank">Lihat petunjuk selengkapnya</a>
                </div>
                <div id="nicepay_payment_detail_IBBK" class="col-xs-12 nicepay-payment-detail" style="display:none;">
                    <label><strong>Pembayaran ke Maybank (BII) dapat dilakukan melalui:</strong></label>
                    <ul>
                        <li>ATM</li>
                        <li>Internet Banking</li>
                        <li>SMS Banking</li>
                        <li>Cabang</li>
                    </ul>
                    <a target="_blank" style="color:#333; text-decoration:underline;" href="<?= base_url() ?>cart/petunjuk_pembayaran_nicepay/maybank">Lihat petunjuk selengkapnya</a>
                </div>
                <div id="nicepay_payment_detail_HNBN" class="col-xs-12 nicepay-payment-detail" style="display:none;">
                    <label><strong>Pembayaran ke KEB Hana Bank dapat dilakukan melalui:</strong></label>
                    <ul>
                        <li>ATM</li>
                        <li>Internet Banking</li>
                    </ul>
                    <a target="_blank" style="color:#333; text-decoration:underline;" href="<?= base_url() ?>cart/petunjuk_pembayaran_nicepay/keb_hana_bank">Lihat petunjuk selengkapnya</a>
                </div>
<!--                <div id="nicepay_payment_detail_atm_bersama_prima" class="col-xs-12 nicepay-payment-detail" style="display:none;">
                    <label><strong>Pembayaran ke bank lain (Bersama/Prima) dapat dilakukan melalui:</strong></label>
                    <ul>
                        <li>ATM</li>
                        <li>Internet Banking</li>
                        <li>SMS Banking</li>
                        <li>Mobile Banking</li>
                    </ul>
                    <a target="_blank" style="color:#333; text-decoration:underline;" href="<?= base_url() ?>cart/petunjuk_pembayaran_nicepay/atm_bersama_prima">Lihat petunjuk selengkapnya</a>
                </div>-->
            </div>
        <!--</div>-->
    <!--</div>-->