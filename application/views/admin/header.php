<?php //$user = $this->session->userdata('admin_session');echo '<pre>';print_r($user) ; echo $user->id_level; die; ?>
<!DOCTYPE html>               
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Penduduk - Admin</title>
	<link rel="shortcut icon" href="<?=base_url();?>asset/img/favicon.ico">

	<!-- Bootstrap core CSS -->
	<link href="<?=base_url();?>asset/admin/css/bootstrap.min.css" rel="stylesheet">

	<!-- Add custom CSS here -->
	<link href="<?=base_url();?>asset/admin/css/bootstrap-custom.css" rel="stylesheet">
	<link href="<?=base_url();?>asset/admin/css/sb-admin.css" rel="stylesheet">
	<!-- <link rel="stylesheet" href="<?=base_url();?>asset/admin/font-awesome/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="<?= base_url() ?>asset/ui2.6/font-awesome-4.6.3/css/font-awesome.min.css">
	<!-- Page Specific CSS -->
	<link rel="stylesheet" href="<?=base_url();?>asset/admin/css/morris-0.4.3.min.css">    
	<link rel="stylesheet" href="<?=base_url();?>asset/admin/css/jquery-ui.css">    
	<link rel="stylesheet" href="<?=base_url();?>asset/admin/css/select2.css">
	<link rel="stylesheet" href="<?=base_url();?>asset/admin/css/style-tree.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>asset/ui2.6/css/flat.css?201605010000">
	<script src="<?=base_url();?>asset/admin/js/jquery-1.10.2.js"></script>
  </head>

  <body>

	<div id="wrapper">

	  <!-- Sidebar -->
	  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color:#2257A7;">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <a class="navbar-brand" href="<?=admin_url();?>dashboard">
<!--
		  		<img style="height:30px;" class="hidden-xs hidden-sm img-responsive" id="logo-lg" src="<?= base_url() ?>asset/ui2.6/img/logos/logo-cipika-red-s.png?asas">
-->
				<!-- <img style="max-width:60%;" class="hidden-xs hidden-sm img-responsive" id="logo-lg" src="<?= base_url() ?>asset/ui2.6/img/logos/logo-cipika-red-s.png?asas"> -->
				<!-- <img style="max-width:60%;" class="hidden-md hidden-lg img-responsive pull-left" id="logo-lg" src="<?= base_url() ?>asset/ui2.6/img/logos/logo-cipika-red-s.png"> -->
				<span class="hidden-md hidden-lg">DYC</span>
		  </a>
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		</div>
		<?php 
		$current = $this->uri->segment(2);  // as
		$user = $this->session->userdata('admin_session');
		?>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
		  <ul class="nav navbar-nav side-nav">
		  
<?php if($user->username=='admin1' || $user->username=='admin2') { ?>
			<li class="<?=($current=='penduduk')?'active':''?>"><a href="<?=admin_url();?>penduduk"><i class="fa fa-user"></i> Penduduk</a></li>

<?php } else if($user->username=='admsemarang') { ?>
			<?php if($this->auth->isAllowed($user, 'merchant')) { ?>            
			<li class="<?=($current=='dashboard')?'active':''?>"><a href="<?=admin_url();?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li class="<?=($current=='penduduk')?'active':''?>"><a href="<?=admin_url();?>penduduk"><i class="fa fa-user"></i> Penduduk</a></li>
			
			<li class="dropdown <?= (isset($merchant_open))?$merchant_open:''; ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-pied-piper-alt"></i> UMKM<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<!--
					<li class=""><a href="<?=admin_url()?>merchant/merchant_request"><i class="fa fa-question"></i> Request Verifikasi Merchant</a></li>
					-->
					<li class=""><a href="<?=admin_url()?>user/add_merchant"><i class="fa fa-user-plus"></i> Tambah Baru</a></li>
					<li class=""><a href="<?=admin_url()?>merchant/merchant_verified"><i class="fa fa-user-times"></i> Daftar UMKM</a></li>
				</ul>
			</li>
			<?php } ?>
			<!--
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-pied-piper-alt"></i> PESERTA<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class=""><a href="<?=admin_url();?>peserta/business_matching"><i class="fa fa-first-order"></i> Business Matching</a></li>
						<li class=""><a href="<?=admin_url();?>peserta/coaching_clinic"><i class="fa fa-first-order"></i> Consultation Clinic</a></li>
				</ul>
			</li>
			-->
			<li class="dropdown ">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-first-order"></i> Schedule<b class="caret"></b></a>
				<ul class="dropdown-menu">
<!--
					<li class=""><a href="<?=admin_url()?>acara?jenis=MAINSTAGE"><i class="fa fa-user-plus"></i> Mainstage</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=OPCER"><i class="fa fa-user-plus"></i> Opening Ceremony</a></li>
-->
					<li class=""><a href="<?=admin_url()?>acara?jenis=MAINSTAGE"><i class="fa fa-user-plus"></i> MAINSTAGE</a></li>
<!--
					<li class=""><a href="<?=admin_url()?>acara?jenis=SEMINAR"><i class="fa fa-user-times"></i> SEMINAR</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=TALKSHOW"><i class="fa fa-user-times"></i> TALKSHOW</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=BUSINESS COACHING"><i class="fa fa-user-times"></i> BUSINESS COACHING</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=COACHING CLINIC"><i class="fa fa-user-plus"></i> COACHING CLINIC</a></li>
-->
<!--
					<li class=""><a href="<?=admin_url()?>acara?jenis=VIRTUAL FASHION SHOW"><i class="fa fa-user-times"></i> VIRTUAL FASHION SHOW </a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=DEMO MASAK dan MAKE-UP"><i class="fa fa-user-plus"></i> DEMO MASAK dan MAKE-UP</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=EJAVEC"><i class="fa fa-user-plus"></i> EJAVEC</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=BM BANK"><i class="fa fa-user-plus"></i> BM PERBANKAN</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=BM ZISWAF"><i class="fa fa-user-plus"></i> BM ZISWAF</a></li>
-->
				</ul>
			</li>			

<?php } else { ?>
			<li class="<?=($current=='dashboard')?'active':''?>"><a href="<?=admin_url();?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<?php if($this->auth->isAllowed($user, 'banner')) { ?>
			<li><a href="<?=admin_url()?>banner"><i class="fa fa-flag"></i> Banner</a></li>
			<?php } ?>

			<?php if($this->auth->isAllowed($user, 'article_index')) { ?>
			<li><a href="<?=admin_url()?>article"><i class="fa fa-newspaper-o"></i> Article</a></li>
			<?php } ?>

			<!--
			<li class="<?=($current=='neworder')?'active':''?>"><a href="<?=admin_url();?>acara?jenis=MAINSTAGE"><i class="fa fa-first-order"></i> MAINSTAGE</a></li>
			<li class="<?=($current=='neworder')?'active':''?>"><a href="<?=admin_url();?>acara?jenis=SEMINAR"><i class="fa fa-first-order"></i> SEMINAR</a></li>
			-->
			
			<li class="dropdown ">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-first-order"></i> Schedule<b class="caret"></b></a>
				<ul class="dropdown-menu">
<!--
					<li class=""><a href="<?=admin_url()?>acara?jenis=MAINSTAGE"><i class="fa fa-user-plus"></i> Mainstage</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=OPCER"><i class="fa fa-user-plus"></i> Opening Ceremony</a></li>
-->
					<li class=""><a href="<?=admin_url()?>acara?jenis=MAINSTAGE"><i class="fa fa-user-plus"></i> MAINSTAGE</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=SEMINAR"><i class="fa fa-user-times"></i> SEMINAR</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=TALKSHOW"><i class="fa fa-user-times"></i> TALKSHOW</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=BUSINESS COACHING"><i class="fa fa-user-times"></i> BUSINESS COACHING</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=COACHING CLINIC"><i class="fa fa-user-plus"></i> COACHING CLINIC</a></li>
<!--
					<li class=""><a href="<?=admin_url()?>acara?jenis=VIRTUAL FASHION SHOW"><i class="fa fa-user-times"></i> VIRTUAL FASHION SHOW </a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=DEMO MASAK dan MAKE-UP"><i class="fa fa-user-plus"></i> DEMO MASAK dan MAKE-UP</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=EJAVEC"><i class="fa fa-user-plus"></i> EJAVEC</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=BM BANK"><i class="fa fa-user-plus"></i> BM PERBANKAN</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=BM ZISWAF"><i class="fa fa-user-plus"></i> BM ZISWAF</a></li>
-->
				</ul>
			</li>

			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-pied-piper-alt"></i> Peserta<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class=""><a href="<?=admin_url();?>peserta/business_matching"><i class="fa fa-first-order"></i> Business Matching</a></li>
					<li class=""><a href="<?=admin_url();?>peserta/coaching_clinic"><i class="fa fa-first-order"></i> Coaching Clinic</a></li>
				</ul>
			</li>

			<li class="dropdown ">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-first-order"></i> Materi <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class=""><a href="<?=admin_url()?>acara?jenis=INFOGRAFIS"><i class="fa fa-user-plus"></i> Infografis</a></li>
					<li class=""><a href="<?=admin_url()?>acara?jenis=PHOTO GALLERY"><i class="fa fa-user-plus"></i> Photo Gallery</a></li>
				</ul>
			</li>
			
			<?php if($this->auth->isAllowed($user, 'merchant')) { ?>            
			<li class="dropdown <?= (isset($merchant_open))?$merchant_open:''; ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-pied-piper-alt"></i> Merchant<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<!--
					<li class=""><a href="<?=admin_url()?>merchant/merchant_request"><i class="fa fa-question"></i> Request Verifikasi Merchant</a></li>
					-->
					<li class=""><a href="<?=admin_url()?>merchant/merchant_verified"><i class="fa fa-user-plus"></i> Merchant Verified</a></li>
					<li class=""><a href="<?=admin_url()?>merchant/merchant_unverified"><i class="fa fa-user-times"></i> Merchant Unverified</a></li>
				</ul>
			</li>
			<?php } ?>
			<?php if($this->auth->isAllowed($user, 'member')) { ?>
			<li><a href="<?=admin_url()?>member"><i class="fa fa-rebel"></i> Visitor</a></li>
			<?php } ?>
			<?php if($this->auth->isAllowed($user, 'produk')) { ?>
			<li class="dropdown <?= (isset($produk_open))?$produk_open:''; ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tasks"></i> Produk<b class="caret"></b></a>
				<ul class="dropdown-menu">
<!--
					<li class=""><a href="<?=admin_url()?>produk/request_verifikasi"><i class="fa fa-question"></i> Request Verifikasi Produk</a></li>
					<?php if($this->auth->isAllowed($user, 'produk_request_update')): ?>
					<li class=""><a href="<?=admin_url()?>produk/produk_request_update"><i class="fa fa-retweet"></i> Request Update Produk</a></li>
					<?php endif; ?>
-->
					<li class=""><a href="<?=admin_url()?>produk/produk_verified"><i class="fa fa-check"></i> Produk Verified</a></li>
<!--
					<li class=""><a href="<?=admin_url()?>produk/produk_unverified"><i class="fa fa-times"></i> Produk Unverified</a></li>
					<li class=""><a href="<?=admin_url()?>produk/produk_merchant_unverified"><i class="fa fa-user-times"></i> Produk Merchant Unverified</a></li>
-->
				</ul>
			</li>
			<?php } ?>

			<?php if($this->auth->isAllowed($user, 'kategori_index')) { ?>
			<li><a href="<?=admin_url()?>kategori"><i class="fa fa-sitemap"></i> Kategori</a></li>
			<?php } ?>

			<?php if($this->auth->isAllowed($user, 'login_log_index')) : ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-book"></i> Login Log<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class=""><a href="<?=admin_url()?>login_log/login_history"><i class="fa fa-wrench"></i> Login History</a></li>
					<li class=""><a href="<?=admin_url()?>login_log/login_attempt"><i class="fa fa-wrench"></i> Login Attempt</a></li>
				</ul>
			</li>
			<?php endif; ?>

			<?php if($this->auth->isAllowed($user, 'user')) { ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i> Users<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class=""><a href="<?=admin_url()?>user/admin"><i class="fa fa-pied-piper"></i> Admin</a></li>
				</ul>
			</li>
			<?php } ?>
			<?php //if ($this->auth->isAllowed($user, 'mobo')): ?>
            <?php 
            $is_admin_mobo = in_array($user->id_user, $this->config->item('mobo_admin_user'));
            if ($is_admin_mobo) : ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-road"></i> MOBO <b class="caret"></b></a>
                <ul class="dropdown-menu">            

                    <li class=""><a href="<?=admin_url()?>mobo_produk"><i class="fa fa-television"></i> Produk MoBo</a></li>
                    <li class=""><a href="<?=admin_url()?>mobo_umb_produk"><i class="fa fa-mobile"></i> Produk UMB</a></li>
                    <li class=""><a href="<?=admin_url()?>mobo_umb_order"><i class="fa fa-th"></i> Order UMB</a></li>
                    <li class=""><a href="<?=admin_url()?>mobo_settlement"><i class="fa fa-dollar"></i> Settlement</a></li>
                    <li class=""><a href="<?=admin_url()?>mobo_outlet"><i class="fa fa-list"></i> OUTLET List</a></li>
                </ul>
            </li>
            <?php endif; ?>

			<?php if($this->auth->isAllowed($user, 'settlement')) : ?>            
			<li class="dropdown <?=($current=='settlement')?'open':'';?>">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-money"></i> Settlement<b class="caret"></b></a>
			  <ul class="dropdown-menu">
				   <?php if($this->auth->isAllowed($user, 'settlement_to_request')): ?>
					<li class=""><a href="<?=admin_url();?>settlement/to_request"><i class="fa fa-wrench"></i> Ready to request</a></li>
					<?php endif; ?>
					<?php if($this->auth->isAllowed($user, 'settlement_request')): ?>
					<li class=""><a href="<?=admin_url();?>settlement/request"><i class="fa fa-wrench"></i> Request Settlement</a></li>
					<?php endif; ?>
					<?php if($this->auth->isAllowed($user, 'settlement_progress')): ?>
					<li class=""><a href="<?=admin_url();?>settlement/progress"><i class="fa fa-wrench"></i> Proceed Settlement</a></li>
					<?php endif; ?>
					<?php if($this->auth->isAllowed($user, 'settlement_hold')): ?>
					<li class=""><a href="<?=admin_url();?>settlement/hold"><i class="fa fa-wrench"></i> Hold Settlement</a></li>
					<?php endif; ?>
					<?php if($this->auth->isAllowed($user, 'settlement_reject')): ?>
					<li class=""><a href="<?=admin_url();?>settlement/reject"><i class="fa fa-times"></i> Reject Settlement</a></li>
					<?php endif; ?>
					<?php if($this->auth->isAllowed($user, 'settlement_paid')): ?>
					<li class=""><a href="<?=admin_url();?>settlement/paid"><i class="fa fa-check"></i> Paid Settlement</a></li>
					<?php endif; ?>
			  </ul>
			</li>  
			<?php endif; ?>
			
			<?php if($this->auth->isAllowed($user, 'neworder')) { ?>
			<li class="<?=($current=='neworder')?'active':''?>"><a href="<?=admin_url();?>neworder"><i class="fa fa-first-order"></i> Orders</a></li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'agregator')) { ?>
			<li class="<?=($current=='agregator')?'active':''?>"><a href="<?=admin_url();?>user/agregator"><i class="fa fa-user-secret"></i> Agregator</a></li>
			<?php } ?>

			<?php if($this->auth->isAllowed($user, 'po_indoloka')) { ?>
			<li><a href="<?=admin_url()?>indoloka/po_labels"><i class="fa fa-file-text"></i> PO Agregator</a></li>
			<?php } ?>
			
			
			<?php if($this->auth->isAllowed($user, 'page')) { ?>
			<li><a href="<?=admin_url()?>page"><i class="fa fa-file-powerpoint-o"></i> Page</a></li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'point_rewards')) { ?>
			<li><a href="<?=admin_url()?>point"><i class="fa fa-trophy"></i> Point Rewards</a></li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'freeshipping')
					|| $this->auth->isAllowed($user, 'voucher')
					|| $this->auth->isAllowed($user, 'diskon')
					|| $this->auth->isAllowed($user, 'doorprize_index')) { ?>
			<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tags"></i> Promo<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<?php if($this->auth->isAllowed($user, 'freeshipping')){ ?>
						<li><a href="<?=admin_url()?>freeshipping"><i class="fa fa-plane"></i> Promo Free Shipping</a></li>
						<?php } ?>
						<?php if($this->auth->isAllowed($user, 'voucher')){ ?>
						<li><a href="<?=admin_url()?>voucher"><i class="fa fa-ticket"></i> Promo Voucher</a></li>
						<?php } ?>
						<?php if($this->auth->isAllowed($user, 'diskon')){ ?>
						<li><a href="<?=admin_url()?>diskon"><i class="fa fa-percent"></i> Promo Diskon</a></li>
						<?php } ?>
						<?php if($this->auth->isAllowed($user, 'daily_deals_index')){ ?>
						<li><a href="<?=admin_url()?>daily_deals"><i class="fa fa-calendar-check-o"></i> Daily Deals</a></li>
						<?php } ?>
						<?php if($this->auth->isAllowed($user, 'doorprize_index')) { ?>
						<li><a href="<?=admin_url()?>doorprize"><i class="fa fa-gift"></i> Doorprize</a></li>
						<?php } ?>
						<?php if($this->auth->isAllowed($user, 'giveaway_index')) { ?>
						<li><a href="<?=admin_url()?>giveaway"><i class="fa fa-hand-rock-o"></i> Giveaway</a></li>
						<?php } ?>
						<?php if($this->auth->isAllowed($user, 'giveaway_index')) { ?>
						<li><a href="<?=admin_url()?>email_giveaway"><i class="fa fa-envelope"></i> Email Giveaway</a></li>
                        <?php } ?>
                        <?php if($this->auth->isAllowed($user, 'giveaway_index')) { ?>
						<li><a href="<?=admin_url()?>email_giveaway_voucher"><i class="fa fa-file"></i> Email Giveaway Voucher</a></li>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'contact_form')) { ?>
			<li><a href="<?=admin_url()?>contact_form"><i class="fa fa-file-text"></i> Contact Form</a></li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'newsletter_index')) { ?>
			<li><a href="<?=admin_url()?>newsletter"><i class="fa fa-newspaper-o"></i> Newsletter</a></li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'import')) { ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> Import<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class="<?php echo ($current=='import-sales')?'active':''?>"><a href="<?=admin_url()?>import/sales"><i class="fa fa-wrench"></i> Sales</a></li>
					<li class="<?php echo ($current=='import-merchant')?'active':''?>"><a href="<?=admin_url()?>import/merchant"><i class="fa fa-pied-piper-alt"></i> Merchant</a></li>
					<li class="<?php echo ($current=='import-product')?'active':''?>"><a href="<?=admin_url()?>import/product"><i class="fa fa-wrench"></i> Product</a></li>
					<li class="<?php echo ($current=='import-user-karyawan')?'active':''?>"><a href="<?=admin_url()?>import/karyawan"><i class="fa fa-wrench"></i> User Karyawan</a></li>
				</ul>
			</li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'report')) { ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-files-o"></i> Report<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/transaction_bruto"><i class="fa fa-wrench"></i> Transaction Bruto</a></li>
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/transaction"><i class="fa fa-wrench"></i> Transaction Shipping</a></li>
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/revenue_nett"><i class="fa fa-wrench"></i> Revenue Nett</a></li>
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/price_comparison"><i class="fa fa-wrench"></i> Price Comparison</a></li>
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/merchant_status"><i class="fa fa-wrench"></i> Merchant Status</a></li>
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/merchant_report"><i class="fa fa-wrench"></i> Merchant</a></li>
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/product"><i class="fa fa-wrench"></i> Product</a></li>                    
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/revenue"><i class="fa fa-wrench"></i> Revenue</a></li>
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/payment"><i class="fa fa-wrench"></i> Payment</a></li>
					<li class="<?=($current=='widthdraw')?'active':''?>"><a href="<?=admin_url()?>report/widthdraw"><i class="fa fa-wrench"></i> Widthdraw History</a></li>
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/merchantGrowthByCity"><i class="fa fa-wrench"></i> Merchant Growth By City</a></li>
					<li class="<?=($current=='report-transaction')?'active':''?>"><a href="<?=admin_url()?>report/merchantGrowthBySales"><i class="fa fa-wrench"></i> Merchant Growth By Sales</a></li>
					<li class=""><a href="<?=admin_url()?>daily_reports"><i class="fa fa-wrench"></i> Daily Report</a></li>
					<li class=""><a href="<?=admin_url()?>report/transaction_report"><i class="fa fa-wrench"></i> Transaction Report</a></li>
					<li class=""><a href="<?=admin_url()?>daily_acc_reports"><i class="fa fa-wrench"></i> Daily Accounting Report</a></li>
				</ul>
			</li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'feedback')) { ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-commenting"></i> Feedback<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?=admin_url()?>feedback"><i class="fa fa-blind"></i> No Response</a></li>
					<li><a href="<?=admin_url()?>feedback?grade=good"><i class="fa fa-plus"></i> Positive</a></li>
					<li><a href="<?=admin_url()?>feedback?grade=bad"><i class="fa fa-minus"></i> Negative</a></li>
				</ul>
			</li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'payment')) { ?>
			<li><a href="<?=admin_url()?>payment/all_payment"><i class="fa fa-btc"></i> Payment</a></li>
			<?php } ?>
			<?php if($this->auth->isAllowed($user, 'payment_konfirmasi')) { ?>
			<li><a href="<?=admin_url()?>payment/konfirmasi"><i class="fa fa-file-text"></i> Konfirmasi Pembayaran</a></li>
			<li><a href="<?=admin_url()?>payment/indomaret"><i class="fa fa-file-text"></i> Konfirmasi&nbsp;INDOMARET</a></li>
			<?php } ?>
			<?php if($this->auth->isAllowed($user, 'voucher_reload')) { ?>
			<li><a href="<?=admin_url()?>voucher_reload"><i class="fa fa-ticket"></i> Voucher Reload</a></li>
			<?php } ?>
			<?php if($this->auth->isAllowed($user, 'searching')) { ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i> Search Engine<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="<?=admin_url()?>searching/request"><i class="fa fa-question"></i> Request Keyword</a></li>
					<li><a href="<?=admin_url()?>searching/keyword"><i class="fa fa-terminal"></i> Keywords List</a></li>
				</ul>
			</li>
			<?php } ?>
			<?php if($this->auth->isAllowed($user, 'reference')) { ?>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-anchor"></i> Reference <b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<li class="<?=($current=='level')?'active':''?>"><a href="<?=admin_url();?>level"><i class="fa fa-wrench"></i> Level</a></li>
				<li class="<?=($current=='kategori')?'active':''?>"><a href="<?=admin_url();?>kategori"><i class="fa fa-wrench"></i> Kategori</a></li>
				<li class="<?=($current=='payment')?'active':''?>"><a href="<?=admin_url();?>payment"><i class="fa fa-wrench"></i> Payment</a></li>
				<li class="<?=($current=='ekspedisi')?'active':''?>"><a href="<?=admin_url();?>ekspedisi"><i class="fa fa-wrench"></i> Ekspedisi</a></li>
			  </ul>
			</li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'bidding_index')) { ?>
			<li><a href="<?=admin_url()?>bidding"><i class="fa fa-gavel"></i> Bidding</a></li>
			<?php } ?>
			
			<?php if($this->auth->isAllowed($user, 'inbox_index')) : ?> 
			<li><a href="<?=admin_url();?>inbox/list_messages"><i class="fa fa-inbox"></i> Inbox</a></li>
			<?php endif; ?>
			<?php if($this->auth->isAllowed($user, 'matrix')) : ?>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-credit-card"></i> Matrix Super Plan<b class="caret"></b></a>
			  <ul class="dropdown-menu">
				<?php if($this->auth->isAllowed($user, 'matrix_cs202_plan')) : ?>
				<li><a href="<?=admin_url();?>matrix_plan"><i class="fa fa-wrench"></i> Matrix Plan</a></li>
				<?php endif; ?>
				<?php if($this->auth->isAllowed($user, 'matrix_cs202_area')) : ?>
				<li><a href="<?=admin_url();?>matrix_area"><i class="fa fa-map"></i> Matrix Area</a></li>
				<?php endif; ?>
				<?php if($this->auth->isAllowed($user, 'matrix_cs202_nomor')) : ?>
				<li><a href="<?=admin_url();?>matrix_nomor"><i class="fa fa-wrench"></i> Matrix Nomor</a></li>
				<?php endif; ?>
				<?php if($this->auth->isAllowed($user, 'matrix_cs202_index')) : ?>
				<li><a href="<?=admin_url();?>matrix_cs202"><i class="fa fa-wrench"></i> Matrix CS202</a></li>
				<?php endif; ?>
			  </ul>
			</li>
			<?php endif; ?>
			<?php if($this->auth->isAllowed($user, 'homepage_management')) : ?>
			<li><a href="<?=admin_url()?>homepage_config"><i class="fa fa-home"></i> Homepage Management</a></li>
			<?php endif; ?>
            <?php if($this->auth->isAllowed($user, 'redis_cache')) : ?>
            <li><a href="<?=admin_url()?>redis_cache"><i class="fa fa-refresh"></i> Redis Cache</a></li>
            <?php endif; ?>
			<?php if($this->auth->isAllowed($user, 'ppob_form')) : ?>
			<li><a href="<?=admin_url()?>ppob_form"><i class="fa fa-file-text"></i> PPOB Form</a></li>
			<?php endif; ?>
			<?php if($this->auth->isAllowed($user, 'outlet')) : ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-building"></i> Outlet<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class=""><a href="<?=admin_url()?>outlet/request_verifikasi"><i class="fa fa-question"></i> Request Verifikasi Outlet</a></li>
					<li class=""><a href="<?=admin_url()?>outlet/verified"><i class="fa fa-check"></i> Outlet Verified</a></li>
					<li class=""><a href="<?=admin_url()?>outlet/unverified"><i class="fa fa-times"></i> Outlet Unverivied</a></li>
				</ul>
			</li>
			<?php endif; ?>
			<?php if ($this->auth->isAllowed($user, 'seo')): ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-signal"></i> SEO <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li class=""><a href="<?=admin_url()?>seo/category"><i class="fa fa-tags"></i> Keyword by Category</a></li>
                </ul>
            </li>
            <?php endif; ?>
<!--
			<?php if($this->auth->isAllowed($user, 'user')) { ?>
			<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i> Whitelabel <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li class=""><a href="<?=admin_url()?>whitelabel"><i class="fa fa-tags"></i> Whitelabel Partner</a></li>
                </ul>
			</li>
			<?php } ?>
-->
			<li><a href="#">&nbsp;</a></li>
<?php } ?>			
		  </ul>
		  <ul class="nav navbar-nav navbar-right navbar-user">
			<!--//
			<li class="dropdown alerts-dropdown">
			  <a id="merchant" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Merchant <span id="count-notifikasi-merchant" class="badge"></span> <b class="caret"></b></a>                              
			  <ul id="merchant-notif" class="dropdown-menu">
				<div id="loading" style="display:none;"><br>Loading...<img src="<?=base_url();?>asset/admin/img/loading.gif"></div>                
			  </ul>
			</li>
			<li class="dropdown alerts-dropdown">
			  <a id="order" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Orders <span id="count-notifikasi-order" class="badge"></span> <b class="caret"></b></a>                              
			  <ul id="order-notif" class="dropdown-menu">
				<div id="loading" style="display:none;"><br>Loading...<img src="<?=base_url();?>asset/admin/img/loading.gif"></div>                
			  </ul>
			</li>
			<li class="dropdown alerts-dropdown">
			  <a id="product" href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Products <span id="count-notifikasi-produk" class="badge"></span> <b class="caret"></b></a>                              
			  <ul id="product-notif" class="dropdown-menu">
				<div id="loading" style="display:none;"><br>Loading...<img src="<?=base_url();?>asset/admin/img/loading.gif"></div>                
			  </ul>
			</li>
			-->
			<li class="dropdown user-dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			  	<?php if($user->firstname): ?>
			  		Hi, <?=$user->firstname; ?> <b class="caret"></b>
			  	<?php else: ?>
			  		Hi, <?=$user->email; ?> <b class="caret"></b>
			  	<?php endif; ?>
			  </a>
			  <ul class="dropdown-menu">
<!--
				<li><a href="<?=admin_url();?>user/profile/<?=md5($this->auth_m->get_user()->id_user);?>"><i class="fa fa-user"></i> Profile</a></li>
-->
				<!-- <li><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">7</span></a></li> -->
				<?php if($this->auth->isAllowed($user,'user_setting')): ?>
					<!--
					<li><a href="<?=admin_url();?>user/setting/<?=md5($this->auth_m->get_user()->id_user);?>"><i class="fa fa-gear"></i> Settings</a></li>
					-->
				<?php endif; ?>
				<li class="divider"></li>
				<li><a href="<?=admin_url()?>user/destroy"><i class="fa fa-power-off"></i> Log Out</a></li>
			  </ul>
			</li>
		  </ul>
		</div><!-- /.navbar-collapse -->
	  </nav>
