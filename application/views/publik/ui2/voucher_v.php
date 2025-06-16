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
                                <form method="POST" action="<?= base_url(); ?>user/delete_voucher">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Voucher</th>
                                                <th>Nominal</th>
                                                <th>Minimal Transaksi</th>
                                                <th>Expired Date</th>
                                                <th>Status</th>
                                                <th>Redeemed</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($voucher as $o) {
                                                $i++;
                                                ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= htmlspecialchars($o['kode_voucher']); ?></td>
                                                    <td><?= $o['nominal']; ?></td>
                                                    <td><?= $o['min_transaksi']; ?></td>
                                                    <td><?= htmlspecialchars($o['date_expired']); ?></td>
                                                    <td><?= htmlspecialchars(status_voucher_by_date($o['date_start'], $o['date_expired'])); ?></td>
                                                    <td><?= $o['redeemed'] == 1 ? "TRUE" : "FALSE" ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure delete this voucher?')" type="submit" name="delete" value="<?= $o['id_voucher']; ?>">Delete</button>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
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
