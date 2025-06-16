<div class="col-xs-3">
    <div class="side-filter">
        <div class="side-filter-item member-page">
            <h4>Merchant</h4>
            <?php
            $member_header = $this->user_m->get_single('tbl_user','id_user',$this->session->userdata('member')->id_user);
            $status_merchant = $this->commonlib->check_merchant_status($this->session->userdata('member')->id_user,$member_header->id_level, 'approve');
            ?>
            <?php if ($status_merchant) :?>
            <a href="<?= base_url('myproduct')?>">Produk Saya </a>
            <a href="<?= base_url('myarticle')?>">Artikel </a>
            <a href="<?= base_url('merchant')?>">Profile </a>
            <a href="<?= base_url('merchant/orders')?>">Kelola Order </a>
            <!-- <a href="<?= base_url('merchant/food_delivery')?>">Wilayah Pengiriman </a> -->
            <?php
            $unhide = $this->config->item('UNHIDE_B2B_MENU'); 
            if ($unhide) :
            ?>
            <a href="<?= base_url('merchant/settlement')?>">Settlement </a>
            <?php endif; ?>
            <?php else: ?>
            <a href="<?= base_url('myproduct')?>">Produk Saya </a>
            <span style="background: none repeat scroll 0 0; display: block;padding: 7px 10px 7px 40px;">Artikel </span>
            <a href="<?= base_url('merchant')?>">Profile </a>
            <span style="background: none repeat scroll 0 0; display: block;padding: 7px 10px 7px 40px;">Kelola Order </span>
            <!-- <a href="<?= base_url('merchant/food_delivery')?>">Wilayah Pengiriman </a> -->
            <?php endif; ?>
            <a href="<?= base_url('merchant/status')?>">Status </a>
            <a href="<?= base_url('merchant/area_merchant')?>">Area Pengiriman </a>
            <a href="<?= base_url('user/profile')?>">Akun Member </a>
            <hr style="margin:10px;">
            <a href="<?=base_url();?>auth/logout">Logout </a>
        </div>
    </div>
</div>
