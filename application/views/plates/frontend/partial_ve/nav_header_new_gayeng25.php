            <!-- header -->
            <header class="main-header"
style="
display:none;
background-color: #16226c;				
"			
			>
                <!-- logo-->
			<div class="row" style="
				    margin-left: -25px;     margin-right: -25px; min-height: 55px;
 				background-image:url(/asset_easy/images_easy/gayeng2025/bgTop.jpg?aa) ; 
				background-repeat: no-repeat;
			">
				<div class="col-md-8 col-sm-5 col-xs-5" style="padding-right: 0px;padding-left:5px;">
					<a href="/main" class="logo-holder  hidden-xs ">
						<img style="max-height:60px;min-height: 60px;   margin-top: -10px;" src="<?= base_url() ?>asset_easy/images_easy/gayeng2025/logobijateng_small.png?dd" alt="">
					</a>
					<a href="/main" class="logo-holder hidden-xl hidden-lg hidden-md hidden-sm ">
						<img style="max-height:20px;" src="<?= base_url() ?>asset_easy/images_easy/gayeng2022/logobijateng_small_a.png?ddd" alt="">
						<img style="max-height:20px;" src="<?= base_url() ?>asset_easy/images_easy/gayeng2022/logobijateng_small_b.png?ddd" alt="">
					</a>
					<div class="nav-holder main-menu" style="float: right;width:100%;height:0px;display:none !important;">
								<div class="col-md-2 col-sm-6 col-xs-6" style="padding:22px    0 0 0;min-width:200px;">
									<?php 
									$vmenu = 'TENTANG&nbsp;GAYENG';
									if ($this->getSession('bahasa')=='en') $vmenu = 'ABOUT&nbsp;GAYENG';?>							
									<a style="position: ;width: 100% ; border-radius: 20px 20px 0px 0px; right: 0px;margin-bottom: 10px; z-index:9999999; color:#fff;  margin-top: 0px;
	background-color: transparent;
	background-image: linear-gradient(130deg, rgba(255, 85, 56, 0.57) 5%, rgb(51, 106, 234) 80%);								
									" href="/about" target="" class="btn color-bg menuutama"><?= $vmenu?><i class="fal fa-video"></i></a>
								</div>
								<div class="col-md-2 col-sm-6 col-xs-6" style="padding:22px    0 0 0;min-width:210px;">
									<?php 
									$vmenu = 'UMKM&nbsp;&&nbsp;PRODUK';
									if ($this->getSession('bahasa')=='en') $vmenu = 'MSME&nbsp;&&nbsp;PRODUCT';?>							
									<a style="position: ;width: 100% ; border-radius: 20px 20px 0px 0px; right: 0px;margin-bottom: 10px; z-index:9999999; color:#fff;  margin-top: 0px;
	background-color: transparent;
	background-image: linear-gradient(130deg, rgb(51, 106, 234, 1) 25%, rgba(255, 85, 56, 0.57) 90%);								
									" href="/umkmproduct" target="" class="btn color-bg "><?= $vmenu?><i class="fal fa-layer-plus"></i></a>
								</div>
								<div class="col-md-2 col-sm-6 col-xs-6" style="padding:22px    0 0 0;min-width:190px;">
									<?php 
									$vmenu = 'PROGRAM&nbsp;ACARA';
									if ($this->getSession('bahasa')=='en') $vmenu = 'PROGRAMS&nbsp;';?>							
									<a style="position: ;width: 100% ; border-radius: 20px 20px 0px 0px; right: 0px;margin-bottom: 10px; z-index:9999999; color:#fff;  margin-top: 0px;
	background-color: transparent;
	background-image: linear-gradient(130deg, rgba(255, 85, 56, 0.57) 5%, rgb(51, 106, 234) 80%);								
									" href="/schedule" target="" class="btn color-bg "><?= $vmenu?><i class="fal fa-microphone"></i></a>
								</div>
								<div class="col-md-2 col-sm-6 col-xs-6" style="padding:22px    0 0 10px;min-width:220px;display:none;">
									<?php 
									$vmenu = 'PROMO&nbsp;&&nbsp;INFORMASI';
									if ($this->getSession('bahasa')=='en') $vmenu = 'PROMO&nbsp;&&nbsp;INFORMATION';?>							
									<a style="position: ;width: 100% ; border-radius: 20px 20px 0px 0px; right: 0px;margin-bottom: 10px; z-index:9999999; color:#fff;  margin-top: 0px;
	background-color: transparent;
	background-image: linear-gradient(130deg, rgb(51, 106, 234, 1) 25%, rgba(255, 85, 56, 0.57) 90%);								
									" href="/promo" target="" class="btn color-bg "><?= $vmenu?><i class="fal fa-shopping-cart"></i></a>
								</div>
					
					</div>

					<!-- logo end-->
					<!-- header-search_btn-->         
	<!--
	-->
					<!-- header-search_btn end-->
				</div>
				<div class="col-md-4 col-sm-7 col-xs-7" style="padding-right: 0px;padding-left:0px;">
					<!-- header opt --> 
					<!--
					<a href="/main" class=" hidden-sm hidden-xs down-btn color-bg" style="float:right;padding:16px 25px 16px 50px;background:#922b91;    max-width: 100px;"><i style="background:none;color:#fff;" class="fal fa-home"></i>  HOME</a>								
					-->
					
	<!--
					<a href="/main" class="add-list color-bg" style="background-color: #922b91;border-radius: 20px;">HOME<span><i class="fal fa-home"></i></span></a>
					<div class="cart-btn   show-header-modal" data-microtip-position="bottom" role="tooltip" aria-label="Your Wishlist"><i class="fal fa-heart"></i><span class="cart-counter green-bg"></span> </div>
	-->
					<?php if ($this->isPartnerLoggedIn()) : ?>
					<?php elseif ($this->isUserLoggedIn()): ?>
						<?php
							$loggedInUser = $this->getLoggedInUser();
							$user_image = $loggedInUser->image.'';
							$firstname = $loggedInUser->firstname;
							if (empty($user_image)) {
								$user_image = base_url("asset_easy/images_easy/avatar/avatar-bg.jpg");
							} else {
								$user_image = base_url("asset/upload/profil/" . $user_image);
							}
							//$firstname='MOCHAMMADA Gede Ketut Wardika'
						?>
						<div class="header-user-menu" style="margin-left: 40px !important;max-width: 100px;"><!-- min-width: 78px; -->
							<div class="header-user-name" style="text-align: left;">
								<span><img src="<?= $user_image ?>" alt=""></span>
								<?php echo  str_replace(' ','<br>',strtoupper(substr($firstname,0,13)))?>..
							</div>
							<ul>
								<!--
								<li><a href="#/user_ve/profile"> User profile</a></li>
								-->
								<?php 
									$member_header = $this->getLoggedInUser(); 
									if (MERCHANT):               
										$status_merchant = $this->isMerchant($member_header->id_user,$member_header->id_level);
									//echo '='.$status_merchant;die;
									if ($status_merchant) : // level 6 = member 
								?>
									<li class="divider"><hr></li>
									<li><a href="/merchant_ve"> Merchant Profile</a></li>
									<li><a href="/myproduct_ve"> Product&nbsp;Management</a></li>
									<!--
									<li><a href="/merchant_ve/orders"> Incoming Order</a></li>
									<li><a href="/myarticle_ve"> News</a></li>
									<li><a href="/merchant_ve/area_merchant"> Shipping Setup </a></li>
									-->

								<?php 
									endif;
									endif;
								?>
								<!--
								-->
								
								<!--
								<?php if ($this->getSession('bahasa')=='en'){?>
									<li><a href="<?=base_url();?>user_ve/myschedule">My&nbsp;Meeting&nbsp;Schedule</a></li>
								<?php } else {?>
									<li><a href="<?=base_url();?>user_ve/myschedule">Jadwal&nbsp;Meeting&nbsp;Saya</a></li>
								<?php } ?>
								-->
								<li class="divider"><hr></li>
								<li><a href="<?=base_url();?>auth/logout">Log Out</a></li>
							</ul>
						</div>

					<?php else: ?>
								<?php if ($this->getSession('bahasa')=='en'){?>
									<!--
									<div class="hidden-sm hidden-xs show-reg-form modal-open avatar-img login-btn-bawahx" data-srcav="images/avatar/3.jpg"><i class="fal fa-user"></i>REGISTRATION</div>
									<div class="hidden-xl hidden-lg hidden-md show-reg-form modal-open avatar-img login-btn-bawahx" data-srcav="images/avatar/3.jpg"><i class="fal fa-user"></i>REGISTER</div>
									-->
								<?php } else {?>
									<!--
									<div class="hidden-sm hidden-xs show-reg-form modal-open avatar-img login-btn-bawahx" data-srcav="images/avatar/3.jpg"><i class="fal fa-user"></i>REGISTRASI</div>
									<div class="hidden-xl hidden-lg hidden-md show-reg-form modal-open avatar-img login-btn-bawahx" data-srcav="images/avatar/3.jpg"><i class="fal fa-user"></i>REGISTRASI</div>
									-->
								<?php } ?>
									<div onclick="javascript:location.href='/main';" class="hidden-sm hidden-xs show-reg-form  avatar-img " data-srcav="images/avatar/3.jpg" style="font-size:15px;"><i style="font-size:17px;" class="fal fa-home"></i>HOME</div>
								
					<?php endif; ?>
					<!-- header opt end--> 
					<!-- lang-wrap-->
					<?php $lang = $this->getSession('bahasa');
					if ($lang=='') $lang='id';?>
					<div class="lang-wrap" style="width: 53px !important;display:;">
						<div class="show-lang"><span><i class="fal fa-globe-europe"></i><strong style="color:#cf3c4e;font-size:15px;"><?= strtoupper($lang) ?></strong></span><i class="fa fa-caret-down arrlan"></i></div>
						<ul class="lang-tooltip lang-action no-list-style" style="z-index: 1105;">
							<li><a onclick="set_lang('id')" <?=!empty($lang) && $lang == 'id' ? 'class="current-lan"' : '' ?> data-lantext="ID">Bahasa</a></li>
							<?php if (DOMAINNAME=='xfesyarjawa.com' || DOMAINNAME=='www.xfesyarjawa.com') { ?>
								<li><a onclick="set_lang('enx')" <?=!empty($lang) && $lang == 'enx' ? 'class="current-lan"' : '' ?> data-lantext="EN">English</a></li>
							<?php } else { ?>
								<li><a onclick="set_lang('en');" <?=!empty($lang) && $lang == 'en' ? 'class="current-lan"' : '' ?> data-lantext="EN">English</a></li>
							<?php } ?>
						</ul>
					</div>
					<!-- lang-wrap end-->                                 
					<!-- nav-button-wrap--> 
					<div class="nav-button-wrap color-bg hidden-xl hidden-lg hidden-md hidden-sm hidden-xs">
						<div class="nav-button">
							<span></span><span></span><span></span>
						</div>
					</div>
					<div style="float: right;padding-right: 20px;    top: 20px;" class="header-search_btn show-search-button hidden-xl hidden-lg hidden-md"><i style="font-weight:bold; color:#cf3c4e;" class="fal fa-bars"></i><span>Search</span></div>
					<div style="float: right;padding-right: 20px;    top: 20px;" class="header-search_btn hidden-xl hidden-lg hidden-md" onclick="javascript:location.href='/';"><i style="font-weight:bold; color:#cf3c4e;" class="fal fa-home"></i><span></span></div>
					
					<!-- nav-button-wrap end-->
				</div>
			</div>
			<div class="row" style="
			">
                <!--  navigation --> 
                <div class="nav-holder main-menu" style="float: left;margin-right: 0px; display:;">
                    <nav>
                        <ul class="no-list-style">
                                    <li style="display:;">
										<img style="max-height:60px;" src="<?= base_url() ?>asset_easy/images_easy/gayeng2025/logoGayeng1.png?ddd" alt="">
                                    </li>
                                    <li style="display:none;">
										<a href="/" class="" style="display: !important;color:white;"> <span><i style="font-size: 20px;color:white;" class="far fa-home"></i></span></a>                     
                                    </li>
                                    <li style="display:;">
										<?php if ($this->getSession('bahasa')=='en'){?>
											<a href="/about"><img src="/asset_easy/images_easy/gayeng2025/star2.png" style="max-height:10px;">&nbsp;ABOUT GAYENG</a>
										<?php } else {?>
 											<a href="/about"><img src="/asset_easy/images_easy/gayeng2025/star2.png" style="max-height:10px;">&nbsp;TENTANG GAYENG</a>
										<?php } ?>
                                    </li>
                                    <li style="display:;">
										<?php if ($this->getSession('bahasa')=='en'){?>
											<a href="/umkmproduct"><img src="/asset_easy/images_easy/gayeng2025/star2.png" style="max-height:10px;">&nbsp;MSME & PRODUCT </a>
										<?php } else {?>
 											<a href="/umkmproduct"><img src="/asset_easy/images_easy/gayeng2025/star2.png" style="max-height:10px;">&nbsp;UMKM & PRODUK </a>
										<?php } ?>
                                    </li>
                                    <li style="display:;">
										<?php if ($this->getSession('bahasa')=='en'){?>
											<a href="/schedule"><img src="/asset_easy/images_easy/gayeng2025/star2.png" style="max-height:10px;">&nbsp;PROGRAM SCHEDULE </a>
										<?php } else {?>
 											<a href="/schedule"><img src="/asset_easy/images_easy/gayeng2025/star2.png" style="max-height:10px;">&nbsp;PROGRAM ACARA</a>
										<?php } ?>
                                    </li>
                                    <li style="display:none;">
										<?php if ($this->getSession('bahasa')=='en') {?>
											<a href="/promo"><img src="/asset_easy/images_easy/gayeng2025/star2.png" style="max-height:10px;">&nbsp;PROMO & INFORMATION</a>
										<?php } else {?>
											<a href="/promo"><img src="/asset_easy/images_easy/gayeng2025/star2.png" style="max-height:10px;">&nbsp;PROMO & INFORMASI </a>
										<?php } ?>
                                    </li>
									
                                    <li style="display:none;"> <!-- act-link -->
                                        <a href="#" class="">SHARIA FORUM <i class="fas fa-caret-down"></i></a>
                                        <!--second level -->
                                        <ul style="    min-width: 250px;">
										<?php if ($this->getSession('bahasa')=='en') {?>
                                            <li><a href="/timeschedule">PROGRAM SCEHDULE</a></li>
                                            <li><a href="/schedule_ve?ac=MAINSTAGE">MAINSTAGE</a></li>
                                            <li><a href="/schedule_ve?ac=SEMINAR">SEMINAR</a></li>
                                            <li><a href="/schedule_ve?ac=TALKSHOW">TALKSHOW</a></li>
                                            <li><a style="line-height: 15px;" href="/ejavec">EJAVEC - SHARIA BUSINESS MODEL</a></li>
										<?php } else {?>
                                            <li><a href="/timeschedule">JADWAL PROGRAM</a></li>
                                            <li><a href="/schedule_ve?ac=MAINSTAGE">PANGGUNG UTAMA</a></li>
                                            <li><a href="/schedule_ve?ac=SEMINAR">SEMINAR</a></li>
                                            <li><a href="/schedule_ve?ac=TALKSHOW">TALKSHOW</a></li>
                                            <li><a style="line-height: 15px;" href="/ejavec">EJAVEC - SHARIA BUSINESS MODEL</a></li>
										<?php } ?>
                                        </ul>
                                        <!--second level end-->
                                    </li>
                                    <li style="display:none;">
                                        <a href="#">SHARIA FAIR<i class="fas fa-caret-down"></i></a>
                                        <!--second level -->
                                        <ul style="    min-width: 250px;">
                                            <!--
											<li><a href="/about">DAFTAR PEMENANG FESYAR RACE</a></li>
											<li><a href="/program_ve_wide?tipe=MAINSTAGE&cur=114">TABLIGH AKBAR</a></li>
                                            -->
										<?php if ($this->getSession('bahasa')=='en') {?>
                                            <li><a style="line-height: 15px;" href="/schedule_ve?ac=BUSINESS%20COACHING">BUSINESS COACHING</a></li>
											<li><a href="/schedule_ve?ac=COACHING%20CLINIC">COACHING CLINIC 1 ON 1</a></li>
											<li><a  style="line-height: 15px;" href="/layout">EXHIBITOR LIST</a></li>
                                            <li><a href="/virtual_expo">EXPLORE VIRTUAL BOOTH 360&deg;</a></li>
											<li><a href="/umkm/hoi">HALL of INSPIRATION</a></li>
                                            <li><a href="/fesyarrace">FESYar RACE</a></li>
										<?php } else {?>
                                            <li><a href="/daftar_pemenang">DAFTAR PEMENANG LOMBA</a></li>
                                            <li><a style="line-height: 15px;" href="/schedule_ve?ac=BUSINESS%20COACHING">BUSINESS COACHING</a></li>
											<li><a href="/schedule_ve?ac=COACHING%20CLINIC">COACHING CLINIC 1 ON 1</a></li>
											<li><a  style="line-height: 15px;" href="/layout">PESERTA PAMERAN</a></li>
                                            <li><a href="/virtual_expo">EXPLORE VIRTUAL BOOTH 360&deg;</a></li>
											<li><a href="/umkm/hoi">HALL of INSPIRATION</a></li>
                                            <li><a href="/fesyarrace">FESYar RACE</a></li>
										<?php } ?>
                                            <!--
											<li><a href="/virtual_expo">HALL of INSPIRATION</a></li>
                                            <li><a href="/virtual_expo">FESYar RACE</a></li>
											-->
                                        </ul>
                                        <!--second level end-->
                                    </li>
                                    <li style="display:none;">
                                        <a href="#">BUSINESS MATCHING <i class="fas fa-caret-down"></i></a>
                                        <!--second level -->
                                        <ul style="    min-width: 200px;">
                                            <li><a href="/layout?ac=UMKM">VIDEO CALL MEETING</a></li>
                                            <li><a href="/schedule_bm_ve?ac=BM PERBANKAN">PERBANKAN</a></li>
                                            <li><a href="/schedule_bm_ve?ac=BM LEMBAGA ZISWAF">LEMBAGA ZISWAF</a></li>
                                            <li><a href="/schedule_bm_ve?ac=BM FINTECH SYARIAH">FINTECH SYARIAH</a></li>
                                            <li><a href="/schedule_bm_ve?ac=BM E-COMMERCE">E-COMMERCE</a></li>
                                        </ul>
                                        <!--second level end-->
                                    </li>
                                    <li style="display:none;">
										<?php if ($this->getSession('bahasa')=='en') {?>
											<a href="#">DIGITAL LIBRARY<i class="fas fa-caret-down"></i></a>
										<?php } else {?>
											<a href="#">PUSTAKA DIGITAL <i class="fas fa-caret-down"></i></a>
										<?php } ?>
                                        <!--second level -->
                                        <ul style="    min-width: 200px;">
										<?php if ($this->getSession('bahasa')=='en') {?>
                                            <li><a href="/news">NEWS ARTICLE</a></li>
                                            <li><a href="/publikasi">E-CATALOGUE</a></li>
                                            <li><a href="/infografis">INFOGRAFIS</a></li>
										<?php } else {?>
                                            <li><a href="/news">BERITA </a></li>
                                            <li><a href="/publikasi">E-KATALOG</a></li>
                                            <li><a href="/infografis">INFOGRAFIS</a></li>
										<?php } ?>
<!--
                                            <li><a href="/about">E-KATALOG PRODUK</a></li>
                                            <li><a href="/about">GALERI FOTO</a></li>
-->
                                        </ul>
                                        <!--second level end-->
                                    </li>
                                    <li style="display:none;">
										<?php if ($this->getSession('bahasa')=='en') {?>
											<a href="https://bit.ly/pendaftaranQRISfesyarjawa" target="_blank">QRIS REGISTRATION </a>
										<?php } else {?>
											<a href="https://bit.ly/pendaftaranQRISfesyarjawa" target="_blank">PENDAFTARAN QRIS </a>
										<?php } ?>
                                    </li>


                        </ul>
                    </nav>
                </div>
                <!-- navigation  end -->			
			</div>
			
				
                <!-- header-search_container -->                     
                <div class="header-search_container header-search vis-search hidden-md hidden-lg hidden-xl" style="
					background: #185baa;
					background-image: url(/asset_easy/images_easy/gayeng2025/bgMenuMobile.jpg?aa);
					background-repeat: no-repeat;
					background-size: cover;
					background-position: top left;						
					">
                    <div class="container small-container" style="width: 100%;">

                    <div class="row" style="display:;">
						<div  class="col-sm-1 col-xs-1">
						</div>
						<div  class="col-sm-10 col-xs-10">
							<div class="box-widget-content" style="padding: 30px 0 0 0;">
                                <div class="widget-posts fl-wrap">
                                    <ul>
                                        <li class="" style="border-bottom:0px;">
											<?php if ($this->getSession('bahasa')=='en'){?>
												<a href="/about" style="width:100%;" class="widget-posts-img"><img src="/asset_easy/images_easy/gayeng2025/icoTentang_En.png" class="respimg" alt=""></a>
											<?php } else {?>
												<a href="/about" style="width:100%;" class="widget-posts-img"><img src="/asset_easy/images_easy/gayeng2025/icoTentang.png" class="respimg" alt=""></a>
											<?php } ?>
                                            <!--
                                            -->
                                        </li>
                                        <li class="" style="border-bottom:0px;">
											<?php if ($this->getSession('bahasa')=='en'){?>
												<a href="/umkmproduct" style="width:100%;" class="widget-posts-img"><img src="/asset_easy/images_easy/gayeng2025/icoProdukHdr1_En.png?aa" class="respimg" alt=""></a>
											<?php } else {?>
												<a href="/umkmproduct" style="width:100%;" class="widget-posts-img"><img src="/asset_easy/images_easy/gayeng2025/icoProdukHdr1.png" class="respimg" alt=""></a>
											<?php } ?>
                                            <!--
                                            -->
                                        </li>
                                        <li class="" style="border-bottom:0px;">
											<?php if ($this->getSession('bahasa')=='en'){?>
												<a href="/schedule" style="width:100%;" class="widget-posts-img"><img src="/asset_easy/images_easy/gayeng2025/icoAcaraHdr1_En.png" class="respimg" alt=""></a>
											<?php } else {?>
												<a href="/schedule" style="width:100%;" class="widget-posts-img"><img src="/asset_easy/images_easy/gayeng2025/icoAcaraHdr1.png" class="respimg" alt=""></a>
											<?php } ?>
                                            <!--
                                            -->
                                        </li>										
                                        <li class="" style="border-bottom:0px;display:none;">
											<?php if ($this->getSession('bahasa')=='en'){?>
												<a href="/promo" style="width:100%;" class="widget-posts-img"><img src="/asset_easy/images_easy/gayeng2025/icoPromoHdr1_En.png" class="respimg" alt=""></a>
											<?php } else {?>
												<a href="/promo" style="width:100%;" class="widget-posts-img"><img src="/asset_easy/images_easy/gayeng2025/icoPromoHdr1.png" class="respimg" alt=""></a>
											<?php } ?>
                                            <!--
                                            -->
                                        </li>										
                                    </ul>
                                </div>
                            </div>

							
						</div>
						
                    </div>
						
                        <div class="header-search_close color-bg" style="background:#dd712f;"><i class="fal fa-long-arrow-up"></i></div>
                    </div>
                </div>
                <!-- header-search_container  end --> 
                <!-- wishlist-wrap--> 
                <div class="header-modal novis_wishlist">
                    <!-- header-modal-container--> 
                    <div class="header-modal-container scrollbar-inner fl-wrap" data-simplebar>
                        <!--widget-posts-->
                        <div class="widget-posts  fl-wrap">
                            <ul class="no-list-style">
                                <li>
                                    <div class="widget-posts-img"><a href="listing-single.html"><img src="images/gallery/thumbnail/1.png" alt=""></a>  
                                    </div>
                                    <div class="widget-posts-descr">
                                        <h4><a href="listing-single.html">Iconic Cafe</a></h4>
                                        <div class="geodir-category-location fl-wrap"><a href="#"><i class="fas fa-map-marker-alt"></i> 40 Journal Square Plaza, NJ, USA</a></div>
                                        <div class="widget-posts-descr-link"><a href="listing.html" >Restaurants </a>   <a href="listing.html">Cafe</a></div>
                                        <div class="widget-posts-descr-score">4.1</div>
                                        <div class="clear-wishlist"><i class="fal fa-times-circle"></i></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="widget-posts-img"><a href="listing-single.html"><img src="images/gallery/thumbnail/1.png" alt=""></a>
                                    </div>
                                    <div class="widget-posts-descr">
                                        <h4><a href="listing-single.html">MontePlaza Hotel</a></h4>
                                        <div class="geodir-category-location fl-wrap"><a href="#"><i class="fas fa-map-marker-alt"></i> 70 Bright St New York, USA </a></div>
                                        <div class="widget-posts-descr-link"><a href="listing.html" >Hotels </a>  </div>
                                        <div class="widget-posts-descr-score">5.0</div>
                                        <div class="clear-wishlist"><i class="fal fa-times-circle"></i></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="widget-posts-img"><a href="listing-single.html"><img src="images/gallery/thumbnail/1.png" alt=""></a>
                                    </div>
                                    <div class="widget-posts-descr">
                                        <h4><a href="listing-single.html">Rocko Band in Marquee Club</a></h4>
                                        <div class="geodir-category-location fl-wrap"><a href="#"><i class="fas fa-map-marker-alt"></i>75 Prince St, NY, USA</a></div>
                                        <div class="widget-posts-descr-link"><a href="listing.html" >Events</a> </div>
                                        <div class="widget-posts-descr-score">4.2</div>
                                        <div class="clear-wishlist"><i class="fal fa-times-circle"></i></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="widget-posts-img"><a href="listing-single.html"><img src="images/gallery/thumbnail/1.png" alt=""></a>
                                    </div>
                                    <div class="widget-posts-descr">
                                        <h4><a href="listing-single.html">Premium Fitness Gym</a></h4>
                                        <div class="geodir-category-location fl-wrap"><a href="#"><i class="fas fa-map-marker-alt"></i> W 85th St, New York, USA</a></div>
                                        <div class="widget-posts-descr-link"><a href="listing.html" >Fitness</a> <a href="listing.html" >Gym</a> </div>
                                        <div class="widget-posts-descr-score">5.0</div>
                                        <div class="clear-wishlist"><i class="fal fa-times-circle"></i></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- widget-posts end-->
                    </div>
                    <!-- header-modal-container end--> 
                    <div class="header-modal-top fl-wrap">
                        <h4>Your Wishlist : <span><strong></strong> Locations</span></h4>
                        <div class="close-header-modal"><i class="far fa-times"></i></div>
                    </div>
                </div>
                <!--wishlist-wrap end --> 
            </header>
            <!-- header end-->
