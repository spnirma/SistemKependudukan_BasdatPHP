<?=$this->load->view('publik/ui2/header')?>

        <section class="main">

            <div class="featured-list container">

               <div class="row">
                    <div class="col-xs-12">
                        <div class="aboutbox-item">
                            <h3 class="featured-title"><span>Facebook Authentification</span></h3>
                        
                            <?php if($error!=''){ ?>
                            <div class="alert alert-danger alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              <?=$error;?>
                            </div>
                            <?php } ?>
            
                        </div>
                    </div>
                </div>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
