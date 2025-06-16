<?=$this->load->view('publik/ui2/header')?>

        <section class="main">

            <header class="content-head container">
                <div class="boxhead">
                   <div class="row">
                       <div class="col-xs-3">
                           Member Area
                       </div>
                       <div class="col-xs-9">
                       </div>
                   </div> 
                </div>
            </header>

            <div class="category-list container">
                
                <div class="row">
                    <?php $this->load->view('publik/ui2/sidebar_member_v')?>
                    
                    <div class="col-xs-9">
                        <div class="row">
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>My Wishlist</span></h3>
                            <hr>
                            <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th></th>
                                        <th>Nama</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($data as $p)
                                    {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td>
                                                <img src="<?=base_url();?>asset/pict.php?src=<?=$p->image;?>&w=150&h=150&z=1">
                                            </td>
                                            <td><?= htmlspecialchars($p->nama_produk) ;?></td>
                                            <td>
                                                <a href="<?=base_url();?>product/detail/<?=$p->id_produk;?>" class="btn btn-danger btn-xs"  >View</a>
                                                <a onclick="return confirm('Are you sure delete this product?')" class="btn btn-danger btn-xs"  href="<?=base_url();?>user/delete_wishlish/<?=md5($p->id_produk);?>/<?=md5($this->session->userdata('member')->id_user);?>">Delete</a>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="totop container">
                <div id="totop" class="ir">
                    To Top
                </div>
            </div>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
