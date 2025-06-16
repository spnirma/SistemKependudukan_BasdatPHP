<?=$this->load->view('publik/ui2/header')?>

        <section class="main">

            <header class="content-head container">
                <div class="boxhead">
                   <div class="row">
                       <div class="col-xs-3">
                           Merchant Area
                       </div>
                       <div class="col-xs-9">
                       </div>
                   </div> 
                </div>
            </header>

            <div class="category-list container">
                
                <div class="row">
                    <?php $this->load->view('publik/ui2/merchant/sidebar_merchant_v')?>
                    
                    <div class="col-xs-9">
                        <div class="row">
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Settlement History</span></h3>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Kode Order</th>
                                            <th>Status</th>
                                            <th>Alasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($datas as $key => $value) { ?>
                                        <tr>
                                            <td><?=$value->tanggal;?></td>
                                            <td><a href="<?=base_url();?>order/view/<?=md5($value->id_order);?>"><?= htmlspecialchars($value->kode_order) ;?></a></td>                                    
                                            <td><?= htmlspecialchars($value->status) ;?></td>
                                            <td><?= htmlspecialchars($value->alasan) ;?></td>                                        
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
            <nav class="container">
              <?php
                echo $paginator_new;
                ?>
            </nav>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
