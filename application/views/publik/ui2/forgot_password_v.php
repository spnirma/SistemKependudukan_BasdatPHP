<?=$this->load->view('publik/ui2/header')?>

        <section class="main">

            <div class="featured-list container">

               <div class="row">
                    <div class="col-xs-12">
                        <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Lupa Password</span></h3>
                            <hr>
                            <?php if($error!=''){ ?>
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$error;?>
                            </div>
                            <?php } ?>

                            <?php if($success!=''){ ?>
                            <div class="alert alert-success alert-dismissable">
                              <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
                              <?=$success;?>
                            </div>
                            <?php } else { ?>

                          <form method="post" action="<?php echo base_url('auth/reset_password')?>" class="form-horizontal" role="form">
                            <div class="form-group">
                              <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                              <div class="col-sm-6">
                                <input name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email">
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-10">
                                <button name="submit" value="1" type="submit" class="btn btn-primary btn-lg">Kirim</button>
                              </div>
                            </div>
                          </form>

                          <?php } ?>
            
                        </div>
                    </div>
                </div>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
