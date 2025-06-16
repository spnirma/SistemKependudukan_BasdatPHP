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
                            <h3><span>Status</span></h3>
                            <hr>
                            <?php if ($success != '') { ?>
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$success;?>
                            </div>
                            <?php } ?>

                            <form method="post" action="" >
                              <div class="table-responsive">
                              <table class="table table-striped table-hover">
                                  <thead>
                                      <tr>
                                          <th>Status</th>
                                          <th>Tanggal</th>
                                          <th>Keterangan</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php 
                      //display latest 5
                                      $logs = $this->auth_m->get_data_where('tbl_store_status_log', 'id_store', $data->id_store, 'date_added', 'desc', 5);
                                      foreach ($logs as $log) {
                                      ?>
                                      <tr>
                                        <td><?= htmlspecialchars($log->status) ;?></td>
                                        <td><?=$log->date_added?></td>
                                        <td><?= htmlspecialchars($log->keterangan) ;?></td>
                                        <!--<td><?=($log->id_admin != null)?$this->auth_m->getUserNameById($log->id_admin):'';?></td>-->
                                      </tr>
                                      <?php } ?>
                                  </tbody>
                              </table>
                          </div>
                          </form>
                          <?php
                            $member_header = $this->user_m->get_single('tbl_user','id_user',$this->session->userdata('member')->id_user);
                            $status_merchant = $this->commonlib->check_merchant_status($this->session->userdata('member')->id_user,$member_header->id_level, 'block');
                            if($status_merchant){
                            ?>
                            <form action="" method="POST">
                                <input type="submit" value="Request Verifikasi" name="request" class="btn btn-success btn-sm pull-right">
                            </form>
                            <?php
                            }
                            ?>

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
