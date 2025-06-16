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
                            <div class="aboutbox-item">
                            <h3><span>Voucher Saya</span></h3>
                            <hr>
                            <br>
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width:40px">No</th>
                                            <th style="width:170px">Tanggal</th>
                                            <th>Keterangan</th>
                                            <th style="text-align:right">Point</th>
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
                                            <td><?=$p->tanggal;?></td>
                                            <td><?=htmlspecialchars($p->keterangan);?></td>
                                            <td style="text-align:right"><?php
                                                if($p->kredit == 0) {
                                                    echo "-" .$this->cart->format_number($p->debet);
                                                } elseif ($p->debet == 0) {
                                                    echo $this->cart->format_number($p->kredit);
                                                }
                                            ?></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <th colspan="3">Saldo Point</td>
                                            <th style="text-align:right"><strong><?= $this->cart->format_number($point->saldo_point); ?></strong></td>
                                        </tr>
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

        </section>
<?=$this->load->view('publik/ui2/footer')?>
