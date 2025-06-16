<?=$this->load->view('publik/ui2/header')?>

        <section class="main">

            <div class="featured-list container">

               <div class="row">
                    <div class="col-xs-12">
                        <div class="aboutbox-item aboutbox-item-static">
                            <h3><span><?= htmlspecialchars(ucwords($data->title)) ;?></span></h3>
                            <hr>
                            <?=$data->content;?>
                        </div>
                    </div>
                </div>

        </section>
        
<?=$this->load->view('publik/ui2/footer')?>
