<?=$this->load->view('publik/ui2/header')?>

    <div class="category-list container">
            
        <div class="row">
            <?php 
            if(!empty($article)) :
            foreach ($article as $row) :
                ?>
            <div class="col-xs-12">
                <div class="product-item">
                    <a href="#">
                        <?php 
                          preg_match('/(<img[^>]+>)/i', $row->content, $image);
                          if ($image) :
                        ?>
                        <figure class="thumbnail">
                            <?php  echo $image[0]; ?>
                        </figure>
                        <?php endif; ?>
                        <div class="desc">
                            <a href="<?= base_url('experttalk/single/'. htmlspecialchars($row->article_slug)) ?>">
                                <h3><?=htmlspecialchars(ucwords($row->title))?></h3>
                            </a>
                        </div>
                    </a>
                    <div class="product-owner">
                        <a href="#">
                            <span class="store-thumb">
                                <?php if (isset($row->image)){ ?>
                                <img src="<?=base_url();?>asset/upload/profil/<?=$row->image;?>">
                                <?php } else { ?>
                                <img src="content/icon-user-small.png">
                                <?php } ?>
                            </span>
                            <?= htmlspecialchars($row->username) ?>
                            <br>
                            <span class="glyphicon glyphicon-time"></span> Posted on <?=date("F j, Y", strtotime($row->date_modified));?>
                        </a>
                    </div>
                    <div style="padding:10px;">
                        <?php $text = htmlspecialchars(strip_tags($row->content));
                        if (strlen($text) > 300)
                            echo $this->auth_m->kata($text, 300);
                          else
                            echo $text;
                        ?>
                    </div>
                    <?php if (strlen($text) > 300) : ?>
                    <div style="padding:5px; float:right">
                            <a href="<?= base_url('experttalk/single/'.$row->article_slug) ?>" class="btn btn-lanjut">Read More</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
             endforeach;
             endif;
             ?>
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
