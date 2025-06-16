
            <!--footer -->
            <footer class="main-footer fl-wrap" style="
			display:none;
									background: #0a95bf;
									background-image: url(/asset_easy/images_easy/gayeng2025/bgFooter1.jpg?aa);
									background-repeat: no-repeat;
									background-size: cover;
									background-position:center;
			">
                <!-- footer-header-->
				<!--
				<img src="/asset_easy/images_easy/gayeng2025/awan2.png?aa" style="float:left;margin-top:0px;max-width:600px;width:100%;">
				-->
				
				<div style="background-color: ;display:none; padding: 0px 0 0px;" class="footer-header fl-wrap grad ient-dark">
                        <div class="container" style="max-width: 1500px;">
							<div class="row">
								<!--
								-->
								<div class="col-md-1" style="">
								</div>
								<div class="col-md-3"
								style="
								"
								>
									
								</div>
								<div class="col-md-8"
								style=" padding-left:0px;
								"
								>
								</div>
								<div class="col-md-12" style="
										background-repeat:repeat-x;
										background-image:url(/asset_easy/images_easy/gayeng2022/bg_store_footerx.jpg?bb) ;
								">
									<br><br><br><br><br>
								</div>								
							</div>
						</div>
				</div>
				<div style="background-color: #085360;display:none;" class="footer-header fl-wrap grad ient-dark">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5">
                                <div  class="subscribe-header">
								<?php if ($this->getSession('bahasa')=='en'){?>
                                    <h3>Get more <span>LATEST</span> information </h3>
                                    <p>ENter your email to receive our newsletters.</p>
								<?php } else {?>
                                    <h3>Dapatkan informasi  <span>TERKINI</span></h3>
                                    <p>Masukkan alamat email anda untuk mendapatkan kiriman informasi melalui email.</p>
								<?php } ?>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="subscribe-widget">
                                    <div class="subcribe-form">
                                        <form id="subscribe">
                                            <input class="enteremail fl-wrap" name="email" id="de-subscribe-email" placeholder="Your email  ..." spellcheck="false" type="text">
                                            <button type="submit" id="subscribe-button" class="subscribe-button"><i class="fal fa-envelope"></i></button>
                                            <label for="subscribe-email" class="subscribe-message"></label>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer-header end-->
                <!--footer-inner-->
				<div class="footer-inner   fl-wrap" style="background-color: ; padding-bottom:20px;">
                    <div class="container">
                        <div class="row">
                            <!-- footer-widget-->
                            <div class="col-md-3">
                                <div class="footer-widget fl-wrap">
                                    <div class="footer-logo"><a><img style="width: 80% !important; height: auto !important; " src="/asset_easy/images_easy/gayeng2025/logoGayeng3.png" alt=""></a></div>
									<div class="container hidden-sm hidden-xs" style="width:90%;">
										<div class="copyright" style="border-top: 0px solid #e5e5e5;">© UMKM Gayeng 2025.  All rights reserved.</div>
									</div>
									
                                    <div class="footer-contacts-widget fl-wrap">
                                        <p> </p>
                                        <ul style="display:none;" class="footer-contacts fl-wrap no-list-style">
                                            <li><span><i class="fal fa-envelope"></i> Mail :</span><a href="#" target="_blank">yourmail@domain.com</a></li>
                                            <li> <span><i class="fal fa-map-marker"></i> Adress :</span><a href="#" target="_blank">USA 27TH Brooklyn NY</a></li>
                                            <li><span><i class="fal fa-phone"></i> Phone :</span><a href="#">+7(111)123456789</a></li>
                                        </ul>

                                    </div>
                                </div>
							
                            </div>
                            <!-- footer-widget end-->
                            <!-- footer-widget-->
                            <div class="col-md-2 col-sm-6 col-xs-6" style="padding-right:5px;">
                                <div class="footer-widget fl-wrap" style="text-align: left;">
									<div class="subscribe-header" style="    width: 100%;">
										<?php if ($this->getSession('bahasa')=='en'){?>
											<h3>MSME <span>& Product</span></h3>
										<?php } else {?>
											<h3>UMKM <span>& Produk</span></h3>
										<?php } ?>	
									</div>
                                    <div class="footer-widget-posts fl-wrap">
										<?php 
										$vday='Agro Komoditi';
										if ($this->getSession('bahasa')=='en') $vday='Agro Commodity';
										?>										
                                        <a href="/umkm/?area=All&cat=AGRO%20KOMODITI" style="width: 100%;" class="footer-link"><img src="/asset_easy/images_easy/gayeng2025/star1.png" style="max-width:12px;">&nbsp;<?= $vday?></a>
										<br><br>
										<?php 
										$vday='Makanan & Minuman';
										if ($this->getSession('bahasa')=='en') $vday='Food & Beverages';
										?>										
                                        <a href="/umkm/?area=All&cat=MAKANAN%20MINUMAN" style="width: 100%;" class="footer-link"><img src="/asset_easy/images_easy/gayeng2025/star1.png" style="max-width:12px;">&nbsp;<?= $vday?> </a>
										<br><br>
                                    </div>
                                </div>
                            </div>
                            <!-- footer-widget end-->
                            <!-- footer-widget  -->
                            <div class="col-md-2 col-sm-6 col-xs-6" style="padding-right:5px;">
                                <div class="footer-widget fl-wrap" style="text-align: left;">
									<div class="subscribe-header" style="    width: 100%;">
										<h3>&nbsp;</h3>
									</div>
                                    <div class="footer-widget-posts fl-wrap">
										<?php 
										$vday='Fesyen & Aksesori';
										if ($this->getSession('bahasa')=='en') $vday='Fashion & Accessories';
										?>										
                                        <a href="/umkm/?area=All&cat=FASHION%20AND%20ACCESSORIES" style="width: 100%;" class="footer-link"><img src="/asset_easy/images_easy/gayeng2025/star1.png" style="max-width:12px;">&nbsp;<?= $vday?></a>
										<br><br>
										<?php 
										$vday='Kerajinan & Furnitur';
										if ($this->getSession('bahasa')=='en') $vday='Craft, Furniture & Deco';
										?>										
                                        <a href="/umkm/?area=All&cat=CRAFT%20FURNITURE%20HOME%20DECO" style="width: 100%;" class="footer-link"><img src="/asset_easy/images_easy/gayeng2025/star1.png" style="max-width:12px;">&nbsp;<?= $vday?> </a>
										<br><br>
                                    </div>
                                </div>
                            </div>
                            <!-- footer-widget end-->
                            <!-- footer-widget  -->
                            <div class="col-md-1 col-sm-6 col-xs-6" style="padding-right:5px;">
                                <div class="footer-widget fl-wrap" style="text-align: left;">
									<div class="subscribe-header" style="    width: 100%;">
										<?php if ($this->getSession('bahasa')=='en'){?>
											<h3>Program&nbsp;<span>Schedule</span></h3>
										<?php } else {?>
											<h3>Jadwal&nbsp;<span>Acara</span></h3>
										<?php } ?>	
									</div>
                                    <div class="footer-widget-posts fl-wrap">
										<?php 
										$vday='Hari ke-';
										if ($this->getSession('bahasa')=='en') $vday='Day ';
										?>										
										<a href="/schedule#day1" style="width: 100%;" class="footer-link"><img src="/asset_easy/images_easy/gayeng2025/star1.png" style="max-width:12px;">&nbsp;<?= $vday?>1 </a>
										<br><br>
                                        <a href="/schedule#day2" style="width: 100%;" class="footer-link"><img src="/asset_easy/images_easy/gayeng2025/star1.png" style="max-width:12px;">&nbsp;<?= $vday?>2 </a>
										<br><br>
									                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-sm-6 col-xs-6" style="padding-right:5px;">
                                <div class="footer-widget fl-wrap" style="text-align: left;">
									<div class="subscribe-header" style="    width: 100%;">
											<h3>&nbsp;<span></span></h3>
									</div>
                                    <div class="footer-widget-posts fl-wrap">
										<?php 
										$vday='Hari ke-';
										if ($this->getSession('bahasa')=='en') $vday='Day ';
										?>										
                                        <a href="/schedule#day3" style="width: 100%;" class="footer-link"><img src="/asset_easy/images_easy/gayeng2025/star1.png" style="max-width:12px;">&nbsp;<?= $vday?>3 </a>
										<br><br>
                                        <a href="/schedule#day4" style="width: 100%;" class="footer-link"><img src="/asset_easy/images_easy/gayeng2025/star1.png" style="max-width:12px;">&nbsp;<?= $vday?>4 </a>
										<br><br>
									                                    </div>
                                </div>
                            </div>		
                            <div class="col-md-1 col-sm-6 col-xs-6">
                                <div class="footer-widget fl-wrap" style="text-align: left;">
									<div class="subscribe-header" style="    width: 100%;">
											<h3>&nbsp;<span></span></h3>
									</div>
                                    <div class="footer-widget-posts fl-wrap">
										<?php 
										$vday='Hari ke-';
										if ($this->getSession('bahasa')=='en') $vday='Day ';
										?>										
                                        <a href="/schedule#day5" style="width: 100%;" class="footer-link"><img src="/asset_easy/images_easy/gayeng2025/star1.png" style="max-width:12px;">&nbsp;<?= $vday?>5 </a>
										<br><br>
									                                    </div>
                                </div>
                            </div>								
                            <div class="col-md-1  col-sm-12 col-xs-12">
                                <div class="footer-widget fl-wrap">
									<div class="subscribe-header" style="    width: 100%;">
										<?php if ($this->getSession('bahasa')=='en'){?>
											<h3>Media&nbsp;<span>Channel</span></h3>
										<?php } else {?>
											<h3>Kanal&nbsp;<span>Media</span></h3>
										<?php } ?>	
									</div>
									<div class="footer-social">
										<ul class="no-list-style">
											<!--
											<li><a href="#" target="_blank"><i style="font-size: 20px;" class="fab fa-facebook-f"></i></a></li>
											<li><a href="#" target="_blank"><i style="font-size: 20px;" class="fab fa-twitter"></i></a></li>
											-->
											<li><a href="https://www.instagram.com/umkmgayeng.id/?hl=en" target="_blank"><i style="font-size: 20px;" class="fab fa-instagram"></i></a></li>
											<li><a href="https://www.youtube.com/@bankindonesiajateng" target="_blank"><i style="font-size: 20px;" class="fab fa-youtube"></i></a></li>
											<!--
											<li><a href="#" target="_blank"><i class="fab fa-vk"></i></a></li>
											<li><a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
											-->
										</ul>
									</div>
								</div>
								<div class="sub-footer  fl-wrap ">
                                    <div class="total-visitor-col" style="text-align:left;display:none;">
                                        <small style="color:#fff">Click View : </small>
                                        <h4 style="color:#FDCB0A">90.461</h4>
                                    </div>
									<div class="container hidden-xl hidden-lg hidden-md" style="width:100%;">
										<div class="copyright"> © UMKM Gayeng 2025.  All rights reserved.</div>
									</div>
								</div>
								
                            </div>
                            <!-- footer-widget end-->
                        </div>
                    </div>
                    <!-- footer bg-->
                    <div class="footer-bg" data-ran="4"><span class="footer-bg-pin"></span><span class="footer-bg-pin"></span><span class="footer-bg-pin"></span><span class="footer-bg-pin footer-bg-pin-vis"></span></div>
                    <div class="footer-wave">
                        <svg viewBox="0 0 100 25">
                            <path fill="#fff" d="M0 30 V12 Q30 17 55 12 T100 11 V30z"></path>
                        </svg>
                    </div>
                    <!-- footer bg  end-->
                </div>				
				
                <div class="footer-inner   fl-wrap" style="display:none;background-color: #02a4d5;">
				
                    <div class="container">
                        <div class="row">
                            <!-- footer-widget-->
                            <div class="col-md-3">
                                <div class="footer-widget fl-wrap">
                                    <div class="footer-logo"><a><img style="width: 80% !important; height: auto !important; " src="/asset_easy/images_easy/gayeng2023/logoGayeng1.png" alt=""></a></div>
                                    <div class="footer-contacts-widget fl-wrap">
                                        <p> </p>
                                        <ul  style="display:none;"  class="footer-contacts fl-wrap no-list-style">
                                            <li><span><i class="fal fa-envelope"></i> Mail :</span><a href="#" target="_blank">yourmail@domain.com</a></li>
                                            <li> <span><i class="fal fa-map-marker"></i> Adress :</span><a href="#" target="_blank">USA 27TH Brooklyn NY</a></li>
                                            <li><span><i class="fal fa-phone"></i> Phone :</span><a href="#">+7(111)123456789</a></li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                            <!-- footer-widget end-->
                            <!-- footer-widget-->
                            <div class="col-md-2 col-sm-6 col-xs-6" style="padding:30px  0 0 0;">
								<a style="position: ;width: 100% ; border-radius: 20px 20px 0px 0px; right: 0px;margin-bottom: 10px; z-index:9999999; color:#054681;  margin-top: 0px;" href="/about" target="" class="btn color-bg ">TENTANG&nbsp;KAMI<i class="fal fa-video hidden-xs"></i></a>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-6" style="padding:30px  0 0 0;">
								<a style="position: ;width: 100% ; border-radius: 20px 20px 0px 0px; right: 0px;margin-bottom: 10px; z-index:9999999; color:#054681;  margin-top: 0px;" href="/umkmproduct" target="" class="btn color-bg ">UMKM&nbsp;&&nbsp;PRODUK<i class="fal fa-layer-plus  hidden-xs"></i></a>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-6" style="padding:30px  0 0 0;">
								<a style="position: ;width: 100% ; border-radius: 20px 20px 0px 0px; right: 0px;margin-bottom: 10px; z-index:9999999; color:#054681;  margin-top: 0px;" href="/schedule" target="" class="btn color-bg ">AGENDA&nbsp;ACARA<i class="fal fa-microphone  hidden-xs"></i></a>
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-6" style="padding:30px  0 0 0;">
								<a style="position: ;width: 100% ; border-radius: 20px 20px 0px 0px; right: 0px;margin-bottom: 10px; z-index:9999999; color:#054681;  margin-top: 0px;" href="/promo" target="" class="btn color-bg ">PROMO&nbsp;BELANJA<i class="fal fa-shopping-cart  hidden-xs"></i></a>
                            </div>
                            <!-- footer-widget end-->
                            <!-- footer-widget  -->

                            <!-- footer-widget end-->
                            <!-- footer-widget  -->
                            <div class="col-md-2 col-sm-4 col-xs-4">
                                <div class="footer-widget fl-wrap" style="text-align: left;display:none;">
									<div  class="subscribe-header" style="    width: 100%;">
									<a href="/schedule">
									<?php if ($this->getSession('bahasa')=='en'){?>
										<h3>EVENT <span>SCHEDULE</span></h3>
									<?php } else {?>
										<h3>AGENDA <span>KEGIATAN</span></h3>
									<?php } ?>
									</a>
									</div>
                                    <div class="footer-widget-posts fl-wrap" style="display:none;">
									<?php if ($this->getSession('bahasa')=='en'){?>
                                        <a href="/about" style="width: 100%;" class="footer-link">About Us <i class="fal fa-long-arrow-right"></i></a>
										<br><br>
                                        <a href="/news" style="width: 100%;" class="footer-link">News <i class="fal fa-long-arrow-right"></i></a>
										<br><br>
                                        <a href="/stakeholders" style="width: 100%;" class="footer-link">Stakeholders <i class="fal fa-long-arrow-right"></i></a>
									<?php } else {?>
                                        <a href="/about" style="width: 100%;" class="footer-link">Tentang Kami <i class="fal fa-long-arrow-right"></i></a>
										<br><br>
                                        <a href="/news" style="width: 100%;" class="footer-link">Berita <i class="fal fa-long-arrow-right"></i></a>
										<br><br>
                                        <a href="/stakeholders" style="width: 100%;" class="footer-link">Mitra Pendukung <i class="fal fa-long-arrow-right"></i></a>
									<?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3  col-sm-12 col-xs-12">
								<div class="sub-footer  fl-wrap">
									<div class="container" style="width:100%;">
										<div class="copyright"> &#169; Gayeng Expo 2023.  All rights reserved.</div>
									</div>
								</div>
								
                            </div>
                            <!-- footer-widget end-->
                        </div>
                    </div>
                    <!-- footer bg-->
                    <div class="footer-bg" data-ran="4"></div>
                    <div class="footer-wave">
                        <svg viewbox="0 0 100 25">
                            <path fill="#fff" d="M0 30 V12 Q30 17 55 12 T100 11 V30z" />
                        </svg>
                    </div>
                    <!-- footer bg  end-->
                </div>
                <!--footer-inner end -->
                <!--sub-footer-->
                <div class="sub-footer  fl-wrap" style="display:none;">
                    <div class="container">
                        <div class="copyright"> &#169; Townhub 2019 .  All rights reserved.</div>
                        <div class="lang-wrap">
                            <div class="show-lang"><span><i class="fal fa-globe-europe"></i><strong>En</strong></span><i class="fa fa-caret-down arrlan"></i></div>
                            <?php $lang = $this->getSession('bahasa')?>
                            <ul class="lang-tooltip lang-action no-list-style">
                                <li><a onclick="set_lang('id')" <?=!empty($lang) && $lang == 'id' ? 'class="current-lan"' : '' ?> data-lantext="Id">Indonesia</a></li>
                                <li><a onclick="set_lang('en')" <?=!empty($lang) && $lang == 'id' ? 'class="current-lan"' : '' ?> data-lantext="En">English</a></li>
                            </ul>
                        </div>
                        <div class="subfooter-nav">
                            <ul class="no-list-style">
                                <li><a href="#">Terms of use</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Blog</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--sub-footer end -->
            </footer>
            <!--footer end -->  
            <!--map-modal -->
            <div class="map-modal-wrap">
                <div class="map-modal-wrap-overlay"></div>
                <div class="map-modal-item">
                    <div class="map-modal-container fl-wrap">
                        <div class="map-modal fl-wrap">
                            <div id="singleMap" data-latitude="40.7" data-longitude="-73.1"></div>
                        </div>
                        <h3><span>Location for : </span><a href="#">Listing Title</a></h3>
                        <div class="map-modal-close"><i class="fal fa-times"></i></div>
                    </div>
                </div>
            </div>
            <!--map-modal end -->                
            <!--register form -->
            <div class="main-register-wrap modal" style="padding: 20px;">
                <div class="reg-overlay"></div>
                <div class="main-register-holder tabs-act">
                    <div class="main-register fl-wrap  modal_main">
                        <div class="main-register_title" style="
							background-image: url(/asset_easy/images_easy/gayeng2024/bgSepar1.png?aa);
							background-repeat: no-repeat;
							background-size: auto;
							background-position: top left;						
						">
							<?php if ($this->getSession('bahasa')=='en'){?>
							Visitor <span><strong>REGISTRATION</strong><strong></strong></span>
							<?php } else {?>
							REGISTRASI <span><strong>Pengunjung</strong><strong></strong></span>
							<?php } ?>						
						</div>
                        <div class="close-reg"><i class="fal fa-times"></i></div>
                        <ul style="display:none;" class="tabs-menu fl-wrap no-list-style">
                            <li class="current"><a href="#tab-1"><i class="fal fa-sign-in-alt"></i> Pendaftaran</a></li>
<!--
                            <li><a href="#tab-2"><i class="fal fa-user-plus"></i> Register</a></li>
-->
                        </ul>
                        <!--tabs -->                       
                        <div class="tabs-container">
                            <div class="tab">
                                <!--tab -->
                                <div id="tab-1" class="tab-content first-tab">
                                    <div class="custom-form">

<!-- a -->								<form id="form-login" name="registerform" class="form" method="post" action="<?php echo $this->getConfig('secure_base_url'); ?>auth/login"> 
											<input name="reff" type="hidden" class="reff_url">
											<div class="login_error" style="color:red;padding-bottom: 10px;"></div>

											<label >Fullname <span>*</span> </label>
											<input name="password" type="text"   onClick="this.select()" value="" placeholder="Fullname">
											<label style="padding-top: 12px;">Email Address <span>*</span> </label>
											<input name="email" type="text"   onClick="this.select()" value="" placeholder="Email">
											<input type="hidden" name="csrf_token" value="<?php echo time() ?>" />
                                            <!--
											<button type="submit"  class="log-submit-btn"><span>Log In</span></button>
											-->
											<div class="col-md-12 col-sm-12 col-xs-12 hidden-xl hidden-lg hidden-md " style="margin-top:20px;padding-bottom:10px;" >
											</div>
											<div class="col-md-1 col-sm-1 col-xs-1" style="padding-bottom:0px;" >
												<input type="checkbox" id="logincheck" name="aggrement" value="Y" style="float:left;">
											</div>
											<div class="col-md-11 col-sm-10 col-xs-10" style="padding-bottom:0px;" >
											<?php if ($this->getSession('bahasa')=='en'){?>
												<label style="float:left;color:red;" for="logincheck" > Yes, I agree to the collection and use of information in accordance with this privacy policy.</label>
											<?php } else {?>
												<label style="float:left;color:red;" for="logincheck" > Ya, saya setuju dengan syarat dan ketentuan yang diberlakukan oleh GayengExpo.id.</label>
											<?php } ?>
											</div>
											<input style="width: 100%; border-radius: 20px;
												background-color: transparent;
												background-image: linear-gradient(130deg, rgba(196, 23, 141, 1.57) 15%, rgb(51, 106, 234) 80%);
												" type="submit" class="btn float-btn color2-bg log-submit-btn signin-submit" value="LOGIN" />											
<!-- b  -->

                                            <div class="clearfix"></div>
                                            <!--
                                            <button type="submit"  class="btn float-btn color2-bg"> Log In <i class="fas fa-caret-right"></i></button>
											<div class="filter-tags">
												<input id="check-a2" type="checkbox" name="check">
												<label for="check-a2">I agree to the <a href="#">Privacy Policy</a></label>
											</div>
											<div class="filter-tags">
                                                <input id="check-a3" type="checkbox" name="check">
                                                <label for="check-a3">Remember me</label>
                                            </div>
											-->
                                        </form>
                                        <!--
										<div class="lost_password">
                                            <a href="#">Lost Your Password?</a>
                                        </div>
                                        <a class="google-log btn btn-danger btn-block" style="width: 100%; background-color:#db4a39; display:block; text-align:center" href="https://social21.fesyarjawa.com/redirect/google?callback=<?=base64_encode(base_url() . "socialcallback")?>&reff_url=<?=actuallink()?>"><i class="fab fa-google"></i>Login with Google</a>
										-->
                                    </div>
                                </div>
                                <!--tab end -->
                                <!--tab -->
                                <div class="tab">
                                    <div id="tab-2" class="tab-content">
                                        <div class="custom-form">
                                            <form method="post"   name="registerform" class="main-register-form" id="main-register-form2">
                                                <label >Full Name <span>*</span> </label>
                                                <input name="name" type="text"   onClick="this.select()" value="">
                                                <label>Email Address <span>*</span></label>
                                                <input name="email" type="text"  onClick="this.select()" value="">
                                                <label >Password <span>*</span></label>
                                                <input name="password" type="password"   onClick="this.select()" value="" >
                                                <div class="filter-tags ft-list">
                                                    <input id="check-a2" type="checkbox" name="check">
                                                    <label for="check-a2">I agree to the <a href="#">Privacy Policy</a></label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="filter-tags ft-list">
                                                    <input id="check-a" type="checkbox" name="check">
                                                    <label for="check-a">I agree to the <a href="#">Terms and Conditions</a></label>
                                                </div>
                                                <div class="clearfix"></div>
                                                <button type="submit"     class="btn float-btn color2-bg"> Register  <i class="fas fa-caret-right"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--tab end -->
                            </div>
                            <!--tabs end -->
							<!--
                            <div class="log-separator fl-wrap"><span>or</span></div>
                            <div class="soc-log fl-wrap">
                                <p>Gunakan akun google untuk masuk dengan cepat.</p>
                                <a href="#" class="facebook-log"> Google</a>
                            </div>
                            <div class="wave-bg">
                                <div class='wave -one'></div>
                                <div class='wave -two'></div>
                            </div>
							-->
                        </div>
                    </div>
                </div>
            </div>
            <!--register form end -->
            <a class="to-top" style="border-radius: 20px;"><i class="fas fa-caret-up" style="color:#fff;"></i></a>     
