<div class="col-xs-3">
    <div class="side-filter">
        <div class="side-filter-item member-page">
            <h4>Member</h4>
            <a href="<?=base_url();?>order">Order </a>
            <a href="<?=base_url();?>user/wishlist">Wishlist </a>
            <a href="<?=base_url();?>user/profile">Profile </a>
            <a href="<?=base_url();?>user/account">Account </a>
            <?php
            if (SHOW_PAYMENT_BANK_BCA_TRANSFER || SHOW_PAYMENT_BANK_MANDIRI_TRANSFER) :
            ?>
            <a href="<?=base_url();?>order/konfirmasi">Confirm Payment </a>
        	<?php endif; ?>
        	<?php 
			$member_header = $this->user_m->get_single('tbl_user','id_user',$this->session->userdata('member')->id_user);
            if(MERCHANT) :               
            $status_merchant = $this->commonlib->check_merchant($this->session->userdata('member')->id_user,$member_header->id_level);
            if($status_merchant) : // level 6 = member 
            ?>
            <a href="<?=base_url();?>merchant">Merchant </a>
	        <?php 
        	endif;
	        endif;
	        ?>
            <hr style="margin:10px;">
            <a href="<?=base_url();?>auth/logout">Logout </a>
        </div>
    </div>
	<div class="side-filter">
		<div class="side-filter-item">
            <h4>Reward</h4>
            <label>Saat ini Anda memiliki : </label>
            <?php
            $countVoucher = $this->user_m->count_all_data_where('tbl_voucher', 'id_user', $this->session->userdata('member')->id_user);
            $countPoint = $this->user_m->count_point($this->session->userdata('member')->id_user);
            ?>
            <table>
                <tr>
                    <td style="width: 10%"><?=(int)$countVoucher;?></td>
                    <td style="width: 50%"><a href="<?=base_url();?>user/voucher" style="text-decoration: none">Voucher Belanja</a></td>
                </tr>
                <tr>
                    <td style="width: 10%"><?=(int)$countPoint->saldo_point;?></td>
                    <td style="width: 50%"><a href="<?=base_url();?>user/point" style="text-decoration: none">Point Rewards</a></td>
                </tr>
            </table>
        </div>
	</div>
</div>
