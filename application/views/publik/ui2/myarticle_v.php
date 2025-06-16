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
                            <a style="margin-top:40px;margin-right:20px;" href="<?=base_url();?>myarticle/add" class="btn btn-lanjut pull-right">Input Artikel</a>
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Artikel</span></h3>
                            <hr>
                            <?php if($this->input->get('delete')=='success'){ ?>
                            <div class="alert alert-success alert-dismissable">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                              Success
                            </div>
                            <?php } ?>
                            
                            <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Artikel</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    foreach ($datas as $p)
                                    {
                                        $i++; ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td><?= htmlspecialchars($p->title) ;?></td>
                                            <!--<td><?= htmlspecialchars(strip_tags(substr($p->content, 0, 50)));?>...</td>-->
                                            <td><?=$p->date_added?></td>
                                            <?php
                                                if(1 == $p->publish)
                                                    $status = "Publish";
                                                else if(2 == $p->publish)
                                                    $status = "Unpublish";
                                                else if(3 == $p->publish)
                                                    $status = "Draft";
                                                else
                                                    $status = "Verification Request";
                                            ?>
                                            <td><?=$status;?></td>
                                            <td>
                                                <a class="btn btn-warning btn-xs" href="<?=base_url();?>myarticle/edit/<?=md5($p->id_article);?>/<?=md5($this->session->userdata('member')->id_user);?>">Edit</a>
                                                <a onclick="return confirm('Are you sure delete this article?')" class="btn btn-danger btn-xs"  href="<?=base_url();?>myarticle/delete/<?=md5($p->id_article);?>/<?=md5($this->session->userdata('member')->id_user);?>">Delete</a>
                                                </ul>
                                            </td>
                                    <?php } ?>
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
            <nav class="container">
              <?php
                echo $paginator_new;
                ?>
            </nav>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
