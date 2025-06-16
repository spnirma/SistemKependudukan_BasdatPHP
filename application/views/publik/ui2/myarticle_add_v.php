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
                    <?php $this->load->view('publik/ui2/merchant/sidebar_merchant_v')?>
                    
                    <div class="col-xs-9">
                        <div class="row">
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Input Artikel</span></h3>
                            <hr>
                            <?php if($success=='success'){ ?>
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              Success
                            </div>
                            <?php } ?>

                            <?php if($error!=''){ ?>
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$error;?>
                            </div>
                            <?php } ?>
                            
                            
                            <form class="form-horizontal" method="post" action="<?=base_url();?>myarticle/add">
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Title</label>
                                <div class="col-lg-9">
                                    <input name="title" type="text" class="form-control" id="nama_produk" placeholder="" value="<?php echo (!empty($title) && $success!='success') ? htmlspecialchars($title) : ''  ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Content</label>
                                <div class="col-lg-4">
                                    <textarea name="content" class="form-control" id="deskripsi" placeholder="" rows=5><?php echo (!empty($content) && $success!='success') ? htmlspecialchars($content) : ''  ?></textarea>
                                </div>
                              </div>
                                <div class="form-group">
                                <label for="" class="col-lg-2 control-label">Status</label>
                                <div class="col-lg-4">
                                    <select class="form-control" name="status">
                                        <option value="3">Draft</option>
                                        <option value="0">Request Verification</option>
                                    </select>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                              <br><br>
                              <div style="text-align:center;">
                                <button class="btn btn-primary save-product" type="submit" name="simpan" value=1>Simpan</button>
                              </div>                      
                              
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
<script type="text/javascript">
  var cktext='editor1';
</script> 
<?=$this->load->view('publik/tinymce')?>
