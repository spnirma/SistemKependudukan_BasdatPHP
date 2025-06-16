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
                            <h3><span>Akun Saya</span></h3>
                            <hr>
                            <?php
                            if ($success != '')
                            {
                                ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?= $success; ?>
                                </div>
                            <?php } ?>

                            <?php
                            if ($error != '')
                            {
                                ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?= $error; ?>
                                </div>
                            <?php } ?>
                        
                            
                                <form class="form-horizontal" name="user_pass" method="post" action="<?= base_url(); ?>user/account">
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Email</label>
                                        <div class="col-lg-4">
                                            <input value="<?= htmlspecialchars($data->email); ?>" name="email" type="email" class="form-control" id="nama_produk" readonly placeholder="">                                            
                                        </div>
                                        <?php if(isset($array_error['email'])){ ?>
                                        <div class="col-lg-2">
                                            <span class="error glyphicon glyphicon-remove"></span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Password lama</label>
                                        <div class="col-lg-4">
                                            <input name="old_password" type="password" class="form-control" id="old_password" autocomplete="off" placeholder="">
                                        </div>
                                        <?php if(isset($array_error['old_password'])){ ?>
                                        <div class="col-lg-2">
                                            <span class="error glyphicon glyphicon-remove"></span>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Password baru</label>
                                        <div class="col-lg-4">
                                            <input name="password" type="password" onblur="cek_pass()" class="form-control" id="password" autocomplete="off" placeholder="">
                                            <small style="color:red;">*password minimal 6 karakter</small>
                                        </div>
                                        <?php if(isset($array_error['password'])){ ?>
                                        <div class="col-lg-2">
                                            <span class="error glyphicon glyphicon-remove"></span>
                                        </div>
                                        <?php } ?>
                                        <div id="error" style="margin-top: 10px; color: red;font-size: 13px;"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-lg-2 control-label">Konfirmasi password baru</label>
                                        <div class="col-lg-4">
                                            <input name="passconf" type="password"  onblur="cek_pass_confirm()" class="form-control" id="passconf" autocomplete="off" placeholder="" >
                                        </div>
                                        <?php if(isset($array_error['passconf'])){ ?>
                                        <div class="col-lg-2">
                                            <span class="error glyphicon glyphicon-remove"></span>
                                        </div>
                                        <?php } ?>
                                      <!-- <a href="<?= base_url() ?>user/password" data-toggle="modal" data-href="#change-password-form">Ganti kata sandi</a> -->
                                    </div>
                                    <div class="clearfix"></div>
                                    <br><br>
                                    <div style="text-align:center;">
                                        <button class="btn btn-primary save-product" type="submit" name="simpan" value=1>Simpan</button>
                                    </div>                      
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

        </section>
<?=$this->load->view('publik/ui2/footer')?>
