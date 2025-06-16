<?php $this->layout('frontend/base_new_gayeng25', array('is_mobile'=>$is_mobile)) ?>
<?php //$this->layout('frontend/base_new_fj21', array('is_mobile'=>$is_mobile)) ?>
<?php
//$uriChannel = 'store/id/'.$data->id_user.'';
?>
<style>
.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}
</style>


<?php $vTop=90;$vRight=350;
if ($is_mobile==0) {
	$vTop=500;
	$vRight=0;
}
?>
            <!-- wrapper-->
            <div id="wrapper">
                <!-- content-->
                <div class="content" style="
									background: #16226c;
									background-image: url(/asset_easy/images_easy/gayeng2025/bg1.jpg?cc);
									background-repeat: repeat-y;
									background-size: cover;
									background-position: top <?= $vTop?>px right -<?= $vRight?>px;									
									height: 100%;
									width:100%;
									overflow: hidden;
				">
				
                    				

					<section id="acara" class="no-top-padding"
					style="
					display:;
					
					padding: 0px 0 40px 0;
					"
					>
                        <div class="container">
                            <!--
							<div class="breadcrumbs inline-breadcrumbs fl-wrap">
                                <a href="#">Home</a><a href="#">Listings</a><a href="#">New York</a><span>Listing Single</span> 
                            </div>
                            <div class="clearfix"></div>
                            -->
							<div class="row" style="margin-left:-20px;margin-right:-20px;display:;">
								<?php $vTgl='05 May 2025';?>
                                <!-- list-single-main-wrapper-col -->
								
                                <div class="col-md-12" style="
									padding:10px 0 10px 0;
									background-image: url(/asset_easy/images_easy/gayeng2024/bgSepar2.png?aa);
									background-repeat: no-repeat;
									background-size: cover;
									background-position: center;
									height: 100%;
									width:100%;
									overflow: hidden;
									">
									<h1 style="color:white;">Data Penduduk</h1>
								</div>
                                <div class="col-md-12 hidden-sm hidden-xs" style="display:;">
									<!--
									<img src="/asset_easy/images_easy/gayeng2022/6big.jpg?cc" class="hidden-sm hidden-xs">
									<img src="/asset_easy/images_easy/gayeng2022/6small.jpg?cc" class="hidden-xl hidden-lg hidden-lg">
									-->
									<br><br>
									<!--
									<br><br><h4 style="font-weight:normal;color:#fff;">Nantikan rangkaian acara Gayeng EXPO pada tanggal 11 - 15 April 2023.</h4><br><br><br>
									-->
								</div>								
                                <div class="col-md-2 hidden-sm hidden-xs">
									<!--<img src="/asset_easy/images_easy/gayeng2022/perisaiputih1x.jpg?aa" style="margin-top:90px;display:none;">-->
								</div>								
                                <div class="col-md-9 col-sm-12 col-xs-12" style="">
                                    <!-- list-single-main-wrapper -->
                                    <div class="list-single-main-wrapper fl-wrap">
                                        <!-- description --> 
                                        <div class="list-single-main-item fl-wrap block_box" id="description" style="border:0px;">
                                            <div class="list-single-main-item-title" style="border-bottom:0px;display:none;">
												<h3 style="line-height: 10px; ">
												<?php if ($this->getSession('bahasa')=='en'){?>
												<?php } else {?>
												<?php } ?>
												</h3>
                                                <!--
												-->
                                            </div>
											<br>
											
											<div class="list-single-header-itemx  fl-wrapx" style="">
												<div class="row" style="
														background: ;
														background-image: url(/asset_easy/images_easy/gayeng2023/bgAcaraDayx.png?dd);
														background-repeat: no-repeat;
														background-size: cover;
														background-position:-10px 10px;
														height: 100%;
														width:100%;
														overflow: hidden;
														font-size:20px;
														color:yellow;
													">
														<div class="col-md-4 col-sm-12 col-xs-12" style="padding-left:0px;padding-right:4px;">
															Nama
														</div>											
														<div class="col-md-3 col-sm-12 col-xs-12" style="padding-top:4px;">
															Usia
														</div>											
														<div class="col-md-3 col-sm-12 col-xs-12" style="padding-top:4px;">
															Jenis Kelamin
														</div>											
														<div class="col-md-12" style="padding:2px;background:;">
														</div>											
														<div class="col-md-12 hidden-sm hidden-xs" style="padding:0px;background:#ffcd03;height:1px;">
														</div>											
												</div>												
												<?php $num=0;
												foreach($penduduk as $v) {  
												//echo human_date($v->tgl);die; 
													$num+=1;
												?>
											
													<div class="row" style="
														background: ;
														background-image: url(/asset_easy/images_easy/gayeng2023/bgAcaraDayx.png?dd);
														background-repeat: no-repeat;
														background-size: cover;
														background-position:-10px 10px;
														height: 100%;
														width:100%;
														overflow: hidden;
														font-size:16px;
														color:white;
													">
														<div class="col-md-4 col-sm-12 col-xs-12" style="padding-left:0px;padding-right:4px;">
															<?= $v->nama?>
														</div>											
														<div class="col-md-3 col-sm-12 col-xs-12" style="padding-top:4px;">
															<?= $v->usia?>
														</div>											
														<div class="col-md-3 col-sm-12 col-xs-12" style="padding-top:4px;">
															<?= $v->jenis_kelamin?>
														</div>											
														<div class="col-md-12" style="padding:2px;background:;">
														</div>											
														<div class="col-md-12 hidden-sm hidden-xs" style="padding:0px;background:#ffcd03;height:1px;">
														</div>											
													</div>	
												<?php } ?>		
												
																						
												
												<?php 
												if ($num==0) {
												?>						
													<div class="col-md-12">
															<h3 style="color: white;float:left;"><br><br>Penduduk belum tersedia<br><br></h3>
													</div>
												<?php } ?>
											</div>	

											
<!--
										</div>
                                        <div class="list-single-main-item fl-wrap block_box" id="description">
-->
											
											
                                        </div>
									
									</div>
								
                                    <!-- list-single-main-wrapper -->
                                    
								</div>
                                <div class="col-md-1  hidden-sm hidden-xs">
									<!--
									<img src="/asset_easy/images_easy/gayeng2022/perisaiputih1x.jpg?aa" style="margin-top:200px;display:none;">
									-->
								</div>	
                                <div class="col-md-12" style="display:;">
								</div>									
								
							</div>
										
                        </div>
<?php //= $store[0]->id_store?>
                    </section>
					
					
					
                    <!-- kalei--> 
								


					<section class="no-top-padding"
					style="
					display:none;
					padding: 30px 0 0px 0px;
					"
					>
                        <div class="container">
                            <!--
							<div class="breadcrumbs inline-breadcrumbs fl-wrap">
                                <a href="#">Home</a><a href="#">Listings</a><a href="#">New York</a><span>Listing Single</span> 
                            </div>
                            <div class="clearfix"></div>
                            -->
							<div class="row" style="margin-left:-20px;margin-right:-20px;">
								<?php $vTgl='24 Apr 2022';?>
                                <!-- list-single-main-wrapper-col -->
                                <div class="col-md-12" style="
									padding:10px 0 10px 0;
									background-image: url(/asset_easy/images_easy/gayeng2024/bgSepar1.png?aa);
									background-repeat: no-repeat;
									background-size: cover;
									background-position: center;
									height: 100%;
									width:100%;
									overflow: hidden;
									">
									<?php if ($this->getSession('bahasa')=='en'){?>
										<img src="/asset_easy/images_easy/gayeng2024/icoProdukHdr1_En.png?cc" style="width:80%;max-width:400px;">
									<?php } else {?>
										<img src="/asset_easy/images_easy/gayeng2024/icoProdukHdr1.png?cc" style="width:80%;max-width:400px;">
									<?php } ?>								
								</div>
                                <div class="col-md-2  hidden-sm hidden-xs">
									<img src="/asset_easy/images_easy/gayeng2022/perisai.png?aa" style="margin-top:90px;display:none;">
								</div>								
                                <div class="col-md-9">

									<div class="listing-item-grid_container fl-wrap">
										<?php 
										$vUmkm='UMKM';
										if ($this->getSession('bahasa')=='en') $vUmkm='MSME';?>
										<div class="row">
											<!--  listing-item-grid  -->
											<div class="col-md-4 col-sm-6 ">
												<div class="listing-item-grid" style="padding:220px 30px;border-radius:0px;">
													<a href="/area?cat=Singapura">
													<div class="bg"  data-bg="/asset_easy/images_easy/gayeng2023/btnSin.png?cc"></div>
													<div class="d-gr-sec"></div>
													<div style="display:none;" class="listing-counter color2-bg"><span>28 </span> <?= $vUmkm?></div>
													<div class="listing-item-grid_title" style="display:none;">
														<h3><a href="/area?cat=Singapura">SINGAPURA</a></h3>
														<p>UMKM GAYENG</p>
													</div>
													</a>
												</div>
											</div>
											<!--  listing-item-grid end  -->
											<div class="col-sm-4">
											</div>
											<!--  listing-item-grid  -->
											<div class="col-md-4 col-sm-6 ">
												<div class="listing-item-grid" style="padding:220px 30px;border-radius:0px;">
													<a href="/area?cat=Belgia">
													<div class="bg"  data-bg="/asset_easy/images_easy/gayeng2023/btnBel.png?cc"></div>
													<div class="d-gr-sec"></div>
													<div style="display:none;" class="listing-counter color2-bg"><span>10 </span> <?= $vUmkm?></div>
													<div class="listing-item-grid_title" style="display:none;">
														<h3><a href="/area?cat=Belgia">BELGIA</a></h3>
														<p>UMKM GAYENG</p>
													</div>
													</a>
												</div>
											</div>
											<!--  listing-item-grid end  -->    
											
											<!--  listing-item-grid  -->
											<div class="col-md-4 col-sm-6 ">
												<div class="listing-item-grid" style="padding:200px 30px;border-radius:0px;">
													<a href="/area?cat=Semarang">
													<div class="bg"  data-bg="/asset_easy/images_easy/gayeng2023/btnSemarang.jpg?cc"></div>
													<div class="d-gr-sec"></div>
													<div style="display:none;" class="listing-counter color2-bg"><span>27 </span> <?= $vUmkm?></div>
													<div class="listing-item-grid_title" style="display:none;">
														<p>Eks Karesidenan</p>
														<h3><a href="/area?cat=Semarang">SEMARANG</a></h3>
													</div>
													</a>												
												</div>
											</div>
											<!--  listing-item-grid end  -->
											<!--  listing-item-grid  -->
											<div class="col-md-4 col-sm-6 ">
												<div class="listing-item-grid" style="padding:200px 30px;border-radius:0px;">
													<a href="/area?cat=Pati">
													<div class="bg"  data-bg="/asset_easy/images_easy/gayeng2023/btnPati.jpg?cc"></div>
													<div class="d-gr-sec"></div>
													<div style="display:none;" class="listing-counter color2-bg"><span>29 </span> <?= $vUmkm?></div>
													<div class="listing-item-grid_title" style="display:none;">
														<p>Eks Karesidenan</p>
														<h3><a href="/area?cat=Pati">PATI</a></h3>
													</div>
													</a>												
												</div>
											</div>
											<!--  listing-item-grid end  -->
											<!--  listing-item-grid  -->
											<div class="col-md-4 col-sm-6 ">
												<div class="listing-item-grid" style="padding:200px 30px;border-radius:0px;">
													<a href="/area?cat=Kedu">
													<div class="bg"  data-bg="/asset_easy/images_easy/gayeng2023/btnKedu.jpg?cc"></div>
													<div class="d-gr-sec"></div>
													<div style="display:none;" class="listing-counter color2-bg"><span>12 </span> <?= $vUmkm?></div>
													<div class="listing-item-grid_title" style="display:none;">
														<p>Eks Karesidenan</p>
														<h3><a href="/area?cat=Kedu">KEDU</a></h3>
													</div>
													</a>												
												</div>
											</div>
											<!--  listing-item-grid end  -->   

											<!--  listing-item-grid  -->
											<div class="col-md-4 col-sm-6 ">
												<div class="listing-item-grid" style="padding:200px 30px;border-radius:0px;">
													<a href="/area?cat=Surakarta">
													<div class="bg"  data-bg="/asset_easy/images_easy/gayeng2023/btnSurakarta.jpg?cc"></div>
													<div class="d-gr-sec"></div>
													<div style="display:none;" class="listing-counter color2-bg"><span>25 </span> <?= $vUmkm?></div>
													<div class="listing-item-grid_title" style="display:none;">
														<p>Eks Karesidenan</p>
														<h3><a href="/area?cat=Surakarta">SURAKARTA</a></h3>
													</div>
													</a>												
												</div>
											</div>
											<!--  listing-item-grid end  -->
											<!--  listing-item-grid  -->
											<div class="col-md-4 col-sm-6 ">
												<div class="listing-item-grid" style="padding:200px 30px;border-radius:0px;">
													<a href="/area?cat=Pekalongan">
													<div class="bg"  data-bg="/asset_easy/images_easy/gayeng2023/btnPekalongan.jpg?cc"></div>
													<div class="d-gr-sec"></div>
													<div style="display:none;" class="listing-counter color2-bg"><span>29 </span> <?= $vUmkm?></div>
													<div class="listing-item-grid_title" style="display:none;">
														<p>Eks Karesidenan</p>
														<h3><a href="/area?cat=Pekalongan">PEKALONGAN</a></h3>
													</div>
													</a>												
												</div>
											</div>
											<!--  listing-item-grid end  -->
											<!--  listing-item-grid  -->
											<div class="col-md-4 col-sm-6 ">
												<div class="listing-item-grid" style="padding:200px 30px;border-radius:0px;">
													<a href="/area?cat=Banyumas">
													<div class="bg"  data-bg="/asset_easy/images_easy/gayeng2023/btnBanyumas.jpg?cc"></div>
													<div class="d-gr-sec"></div>
													<div style="display:none;" class="listing-counter color2-bg"><span>30 </span> <?= $vUmkm?></div>
													<div class="listing-item-grid_title" style="display:none;">
														<p>Eks Karesidenan</p>
														<h3><a href="/area?cat=Banyumas">BANYUMAS</a></h3>
													</div>
													</a>												
												</div>
											</div>
											<!--  listing-item-grid end  -->  											
										</div>
									</div>
									<!--
									<a href="listing.html" class="btn dec_btn   color2-bg">View All Cities<i class="fal fa-arrow-alt-right"></i></a>								
									-->
								</div>
                                <div class="col-md-1  hidden-sm hidden-xs">
									<img src="/asset_easy/images_easy/gayeng2022/perisai.png?aa" style="margin-top:30px;display:none;">
								</div>
								
							</div>
										
                        </div>
<?php //= $store[0]->id_store?>
                    </section>

					<section class="no-top-padding"
					style="
					display:none;
					padding: 0px 0 0px 0px;
					"
					>
                        <div class="container">
                            <!--
							<div class="breadcrumbs inline-breadcrumbs fl-wrap">
                                <a href="#">Home</a><a href="#">Listings</a><a href="#">New York</a><span>Listing Single</span> 
                            </div>
                            <div class="clearfix"></div>
                            -->
							<div class="row" style="margin-left:-20px;margin-right:-20px;">
								<?php $vTgl='24 Apr 2022';?>
                                <!-- list-single-main-wrapper-col -->
                                <div class="col-md-12" style="
									padding-top:0px;
									background-repeat: no-repeat;
									background-size: cover;
									background-position:center;
									height: 100%;
									width:100%;
									overflow: hidden;
									margin : 0px 0 0px 0;
									">
									<?php if ($this->getSession('bahasa')=='en'){?>
										<img src="/asset_easy/images_easy/gayeng2024/icoKategoriHdr1_En.png?cc" style="width:80%;max-width:400px;">
									<?php } else {?>
										<img src="/asset_easy/images_easy/gayeng2024/icoKategoriHdr1.png?cc" style="width:80%;max-width:400px;">
									<?php } ?>								
								</div>
                                <div class="col-md-2  hidden-sm hidden-xs">
									<img src="/asset_easy/images_easy/gayeng2022/perisai.png?aa" style="margin-top:90px;display:none;">
								</div>								
                                <div class="col-md-9">

										<?php 
										$vLinkAgro='ada';
										$vLinkCraft='ada';
										$vLinkFashion='ada';
										$vLinkMakanan='ada';
										?>
										<!-- listing-item-container -->
										<div class="listing-item-container init-grid-items fl-wrap nocolumn-lic three-columns-grid">
											<div class="col-md-3 col-sm-3 col-xs-6">
												<!-- 1  -->
												<?php $nama_kategori='AGRO KOMODITI';?>
												<div class="listing-item" style="width: 100%;display:;">
													<article class="geodir-category-listing fl-wrap" style="background:none;">
														<div class="geodir-category-img" style="">
															<?php if ($vLinkAgro=='ada') {?>
																<a href="/umkm/?area=All&cat=<?= $nama_kategori?>" class="geodir-category-img-wrap fl-wrap" style="border-radius: 0px;">
																	<img   src="/asset_easy/images_easy/gayeng2023/thumb_<?= strtolower(str_replace(" ","_",$nama_kategori))?>.png?bb" >
																</a>
															<?php } else {?>
																<a class="geodir-category-img-wrap fl-wrap" style="border-radius: 0px;opacity:0.5;">
																	<img   src="/asset_easy/images_easy/gayeng2023/thumb_<?= strtolower(str_replace(" ","_",$nama_kategori))?>.png?bb" >
																</a>
															<?php } ?>
																<!--
																<div class="geodir_status_date color-bg "><i class="fal fa-clock"></i>BOOTH</div>
																-->
														</div>
													</article>
												</div>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<!-- 2  -->
												<?php $nama_kategori='CRAFT FURNITURE HOME DECO';?>
												<div class="listing-item" style="width: 100%;display:;">
													<article class="geodir-category-listing fl-wrap" style="background:none;">
														<div class="geodir-category-img" style="">
															<?php if ($vLinkCraft=='ada') {?>
																<a href="/umkm/?area=All&cat=<?= $nama_kategori?>" class="geodir-category-img-wrap fl-wrap" style="border-radius: 0px;">
																	<img   src="/asset_easy/images_easy/gayeng2023/thumb_<?= strtolower(str_replace(" ","_",$nama_kategori))?>.png?ddd" >
																</a>
															<?php } else {?>
																<a class="geodir-category-img-wrap fl-wrap" style="border-radius: 0px;opacity:0.5;">
																	<img   src="/asset_easy/images_easy/gayeng2023/thumb_<?= strtolower(str_replace(" ","_",$nama_kategori))?>.png?ddd" >
																</a>
															<?php } ?>
																<!--
																<div class="geodir_status_date color-bg "><i class="fal fa-clock"></i>BOOTH</div>
																-->
														</div>
													</article>
												</div>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<!-- 3  -->
												<?php $nama_kategori='FASHION AND ACCESSORIES';?>
												<div class="listing-item" style="width: 100%;display:;">
													<article class="geodir-category-listing fl-wrap" style="background:none;">
														<div class="geodir-category-img" style="">
															<?php if ($vLinkFashion=='ada') {?>
																<a href="/umkm/?area=All&cat=<?= $nama_kategori?>" class="geodir-category-img-wrap fl-wrap" style="border-radius: 0px;">
																	<img   src="/asset_easy/images_easy/gayeng2023/thumb_<?= strtolower(str_replace(" ","_",$nama_kategori))?>.png?ddd" >
																</a>
															<?php } else {?>
																<a class="geodir-category-img-wrap fl-wrap" style="border-radius: 0px;opacity:0.5;">
																	<img   src="/asset_easy/images_easy/gayeng2023/thumb_<?= strtolower(str_replace(" ","_",$nama_kategori))?>.png?ddd" >
																</a>
															<?php } ?>
																<!--
																<div class="geodir_status_date color-bg "><i class="fal fa-clock"></i>BOOTH</div>
																-->
														</div>
													</article>
												</div>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<!-- 4  -->
												<?php $nama_kategori='MAKANAN MINUMAN';?>
												<div class="listing-item" style="width: 100%;display:;">
													<article class="geodir-category-listing fl-wrap" style="background:none;">
														<div class="geodir-category-img" style="">
															<?php if ($vLinkMakanan=='ada') {?>
																<a href="/umkm/?area=All&cat=<?= $nama_kategori?>" class="geodir-category-img-wrap fl-wrap" style="border-radius: 0px;">
																	<img   src="/asset_easy/images_easy/gayeng2023/thumb_<?= strtolower(str_replace(" ","_",$nama_kategori))?>.png?ddd" >
																</a>
															<?php } else {?>
																<a class="geodir-category-img-wrap fl-wrap" style="border-radius: 0px;opacity:0.5;">
																	<img   src="/asset_easy/images_easy/gayeng2023/thumb_<?= strtolower(str_replace(" ","_",$nama_kategori))?>.png?ddd" >
																</a>
															<?php } ?>
																<!--
																<div class="geodir_status_date color-bg "><i class="fal fa-clock"></i>BOOTH</div>
																-->
														</div>
													</article>
												</div>
											</div>											
												

										</div>
										<!-- listing-item-container end -->
									<!--
									<a href="listing.html" class="btn dec_btn   color2-bg">View All Cities<i class="fal fa-arrow-alt-right"></i></a>								
									-->
								</div>
                                <div class="col-md-1  hidden-sm hidden-xs">
									<img src="/asset_easy/images_easy/gayeng2022/perisai.png?aa" style="margin-top:30px;display:none;">
								</div>
								
							</div>
										
                        </div>
<?php //= $store[0]->id_store?>
                    </section>					
					
					
                    

                    <section class=" no-top-padding" style="
					padding:0px;
					">
                        <div class="container">
							<div class="row">
									<!--
									<img src="/asset_easy/images_easy/gayeng2025/awan2.png?aa" style="float:right;margin-top:0px;max-width:300px;width:100%;right: -100px; position: relative;">
									-->
									
							</div>
						</div>
                    </section>
							
                    <div class="limit-box fl-wrap"></div>
                </div>
                
				<!--content end-->
            </div>
            <!-- wrapper end-->




<script>
(function() {

    $(".beli").click(function(){
                //var aidi_produk    =    $("#id_produk").val();                
                // alert (aidi_produk+' '+base_url);
                var aidi_produk = $(this).attr('data-id');
//                var rowval = $(this).val();
//                alert (aidi_produk+' '+rowval);
//return false;
				isChecked = 'off'; 
                $.post(base_url+"cart/add", {
                    id_produk: aidi_produk, 
                    qty : 1, //$("#qty").val(), 
                    id_produk_adira: 0, //$("#id_produk_adira").val(),
                    adira_insurance: isChecked
                }, function(result){
                    obj = jQuery.parseJSON(result);
                    if (obj.status == 0) {
						alert('Barang telah berhasil dimasukkan ke dalam keranjang belanja anda'); //return false;
                        //$("#add-cart-modal").modal('show');
                    } else if (obj.status == 1) {
						alert('err1'); return false;
                        $("#add-cart-modal-error-1").modal('show');
                    } else if (obj.status == 2) {
						alert('err2'); return false;
                        $("#add-cart-modal-error-2").modal('show');
                    } else if (obj.status == 3) {
						alert('err3'); return false;
                        $("#add-cart-modal-error-3").modal('show');
                    } else if (obj.status == 4) {
						alert('err4'); return false;
                        $("#add-cart-modal-error-4").modal('show');
                    }
					//alert (parseInt(obj.qty));
					$(".cart_counter").removeAttr("style");
					if (parseInt(obj.qty)==0) {
						$(".cart_counter").css({"background":"rgba(0,0,0,0.11)", "color":"white"});
					} else {
						$(".cart_counter").css({"background":"red", "color":"white"});
					}
                    $(".cart_counter").html(obj.qty);
                    //TotalCart();
                });
				
    });

})();
</script>

			