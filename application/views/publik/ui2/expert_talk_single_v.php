<?=$this->load->view('publik/ui2/header')?>

        <section class="main">

            <div class="featured-list container">

               <div class="row">
                    <div class="col-xs-12">
                        <div class="aboutbox-item">
                            <h3 class="featured-title"><span><?= htmlspecialchars(ucwords($data->title)) ;?></span></h3>
                            <p>
                            <span class="store-thumb">
                                <?php if (isset($data->image)){ ?>
                                <img src="<?=base_url();?>asset/upload/profil/<?=$data->image;?>">
                                <?php } else { ?>
                                <img src="content/icon-user-small.png">
                                <?php } ?>
                            </span>
                            <?= htmlspecialchars($data->username) ?>
                            <br>
                            <span class="glyphicon glyphicon-time"></span> Posted on <?=date("F j, Y", strtotime($data->date_modified));?>
                            </p>
                            <?=$data->content;?>
                        </div>
                    </div>
                </div>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
