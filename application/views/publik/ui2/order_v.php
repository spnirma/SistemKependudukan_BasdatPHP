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
                            <h3><span>My Order</span></h3>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kode Order</th>
                                            <th>Kode Invoice</th>
                                            <th>Total</th>
                                            <th>Pembayaran</th>
                                            <th>Pengiriman</th>
                                            <th>Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($order as $o)
                                        {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$o->date_added;?></td>
                                                <td><a href="<?=base_url();?>order/view/<?=md5($o->id_order);?>"><?= htmlspecialchars($o->kode_order) ;?></a></td>
                                                <td><?=$invoices[$o->kode_order] ;?></td>
                                                <td><?=$o->total;?></td>
                                                <td><?=status_payment_label($o->status_payment)?></td>
                                                <td><?=status_delivery_label($o->status_delivery);?></td>
                                                <td><a target="_blank" href="<?=base_url('order/print_invoice').'/'.md5($invoices[$o->kode_order]);?>/view">Download Invoice</a></td>
                                            </tr>
                                            <?php } ?>
                                        
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
            <nav class="container">
              <?php
                echo $paginator_new;
                ?>
            </nav>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
