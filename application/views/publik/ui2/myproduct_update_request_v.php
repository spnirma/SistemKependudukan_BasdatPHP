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
                            <a style="margin-top:40px;margin-right:20px;" href="<?=base_url();?>myproduct/upload" class="btn btn-lanjut pull-right">Unggah Produk Baru</a>
                            <a style="margin-top:40px; margin-right:10px;" href="<?=base_url();?>myproduct/" class="btn btn-lanjut pull-right">Produk Saya</a>
                            <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Update Request</span></h3>
                            <hr>
                            <div class="table-responsive garis_tab" style="margin-top:10px">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th></th>
                                        <th width="100px">Nama</th>
                                        <th width="100px">Kategori</th>
                                        <th>Stok</th>
                                        <th>Status</th>
                                        <th>Dilihat</th>
                                        <th>Suka</th>
                                        <th>Detail</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="myproduct_list">
                                    <?php
                                    $i = $offset;
                                    foreach ($produk as $p)
                                    {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td>
                                                <img src="<?=base_url();?>asset/pict.php?src=<?=$p->image;?>&w=100&h=100&z=1">
                                            </td>
                                            <td><?= htmlspecialchars($p->nama_produk) ;?></td>
                                            <td><?= htmlspecialchars($this->produk_m->get_kategori($p->id_produk)) ;?></td>
                                            <td><?=$p->stok_produk;?></td>
                                            <td><?php 
                                                if($p->publish==0) echo 'Moderasi';
                                                else if($p->publish==1) echo 'Verified';
                                                else if($p->publish==2) echo 'Un Verified';
                                            ?></td>
                                            <td><?=$p->viewed;?></td>
                                            <td><?=$p->loved?></td>
                                            <td>
                                                <a href="#" data-toggle="modal" data-target="#Req<?= $p->id_produk_request ?>" type="button" class="btn btn-warning btn-xs"> Lihat Detail</a>
                                                <div class="modal fade" id="Req<?= $p->id_produk_request ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="padding:20px">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel"><?= htmlspecialchars($p->nama_produk) ?></h4>
                                                      </div>
                                                      <div class="modal-body form-horizontal">
                                                          <div class="form-group">
                                                              <label for="" style="font-weight: bold;" class="col-lg-6">Product Name</label>
                                                              <div class="col-lg-4" <?php if(!empty($update_request[$p->id_produk]['nama_produk'])) echo "style='color:#f33'" ?>>
                                                                <?= htmlspecialchars((!empty($update_request[$p->id_produk]['nama_produk']))?$update_request[$p->id_produk]['nama_produk']:$p->nama_produk);?>
                                                              </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <label for="" style="font-weight: bold;" class="col-lg-6">Description</label>
                                                              <div class="col-lg-4" <?php if(!empty($update_request[$p->id_produk]['deskripsi'])) echo "style='color:#f33'" ?>>
                                                                <?= htmlspecialchars((!empty($update_request[$p->id_produk]['deskripsi']))?$update_request[$p->id_produk]['deskripsi']:$p->deskripsi);?>
                                                              </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <label for="" style="font-weight: bold;" class="col-lg-6">Weight</label>
                                                              <div class="col-lg-4" <?php if(!empty($update_request[$p->id_produk]['berat'])) echo "style='color:#f33'" ?> style="padding:0 15px;">
                                                                <?= htmlspecialchars((!empty($update_request[$p->id_produk]['berat']))?$update_request[$p->id_produk]['berat']:$p->berat);?> Kg
                                                              </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <label for="" style="font-weight: bold;" class="col-lg-6">Dimension</label>
                                                              <div class="col-lg-6">
                                                                  <div class="col-lg-3 pull-left" <?php if(!empty($update_request[$p->id_produk]['panjang'])) echo "style='color:#f33'" ?>>
                                                                    <?= htmlspecialchars((!empty($update_request[$p->id_produk]['panjang']))?$update_request[$p->id_produk]['panjang']:$p->panjang);?> cm
                                                                  </div>
                                                                  <div class="col-lg-3 pull-left" <?php if(!empty($update_request[$p->id_produk]['lebar'])) echo "style='color:#f33'" ?>>
                                                                    <?= htmlspecialchars((!empty($update_request[$p->id_produk]['lebar']))?$update_request[$p->id_produk]['lebar']:$p->lebar);?> cm
                                                                  </div>
                                                                  <div class="col-lg-3 pull-left" <?php if(!empty($update_request[$p->id_produk]['tinggi'])) echo "style='color:#f33'" ?>>
                                                                    <?= htmlspecialchars((!empty($update_request[$p->id_produk]['tinggi']))?$update_request[$p->id_produk]['tinggi']:$p->tinggi);?> cm
                                                                  </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <label for="" style="font-weight: bold;" class="col-lg-6">Stock</label>
                                                              <div class="col-lg-4" <?php if(!empty($update_request[$p->id_produk]['stok_produk'])) echo "style='color:#f33'" ?>>
                                                                <?= htmlspecialchars((!empty($update_request[$p->id_produk]['stok_produk']))?$update_request[$p->id_produk]['stok_produk']:$p->stok_produk);?>
                                                              </div>
                                                            </div>
                                                            <div class="form-group">
                                                              <label for="" style="font-weight: bold;" class="col-lg-6">Harga Produk</label>
                                                              <div class="col-lg-4" <?php if(!empty($update_request[$p->id_produk]['harga_produk'])) echo "style='color:#f33'" ?>>
                                                                    Rp <?= htmlspecialchars((!empty($update_request[$p->id_produk]['harga_produk']))?$update_request[$p->id_produk]['harga_produk']:$p->harga_produk);?>
                                                              </div>
                                                            </div>
                                                            <?php
                                                              // if(!empty($update_request[$p->id_produk]['nama_produk){
                                                              //   $kategori_update = explode(',',$update_request[$p->id_produk]['kategori);
                                                              //   $kategori_db = $kategorip[$p->id_produk];
                                                              //   $kategori_db_value = array('0');
                                                              //   foreach ($kategori_db as $value) {
                                                              //     $kategori_db_value[] = $value->id_kategori;
                                                              //   }
                                                              //   $diff_kategori = array_diff($kategori_update,$kategori_db_value);
                                                              // }
                                                              if(!empty($update_request[$p->id_produk]['kategori'])){
                                                                $kategori = explode(',',$update_request[$p->id_produk]['kategori']);
                                                              } else {
                                                                $kategori = $kategorip[$p->id_produk];
                                                              }
                                                              // var_dump($kategori);
                                                            ?>
                                                            <div class="form-group">
                                                              <label for="" style="font-weight: bold;" class="col-lg-6">Kategori</label>
                                                              <div class="col-lg-4" <?php if(!empty($update_request[$p->id_produk]['kategori'])) echo "style='color:#f33'" ?>>
                                                                    <?php
                                                                      echo htmlspecialchars(strtolower(ucwords(!empty($update_request[$p->id_produk]['channel']))?$update_request[$p->id_produk]['channel']:$p->channel))." >> ";
                                                                      $i=0;foreach ($kategori as $kat) { $i++;
                                                                        if (!empty($update_request[$p->id_produk]['kategori'])){
                                                                          if($i==1) {echo htmlspecialchars($kategoriname[$kat]->nama_kategori) ;} else{
                                                                            echo ' >> '. htmlspecialchars($kategoriname[$kat]->nama_kategori) ;
                                                                          }
                                                                        } else {
                                                                          if($i==1) {echo htmlspecialchars($kat->nama_kategori) ;} else{
                                                                            echo ' >> '. htmlspecialchars($kat->nama_kategori) ;
                                                                          }
                                                                        }
                                                                      }
                                                                    ?>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <div class="modal-footer">
                                                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                          </div> 
                                                      </div>
                                                   </div>
                                                </div>
                                              </td>
                                            <td>
                                                <a title="edit" class="btn btn-warning btn-xs" href="<?=base_url();?>myproduct/edit/<?=md5($p->id_produk);?>/<?=md5($this->session->userdata('member')->id_user);?>">Edit</a>
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
<script type="text/javascript">
$(document).ready(function (){
    /**
  AJAX CHANNEL
    **/
    $(document).on('change', '.parent_channel ', function(){
      var id=$(this).val();
      // alert(i);
      $.ajax({
          url: base_url + 'ajax/channel_kategori',
          type: 'POST',
          data: {id: id},
          dataType: 'html',
          success: function (data) {
            // alert(data); 
            $('.channel-category').empty();
            $('.channel-category').append(data);
          }
        });
    });

    /**
    END AJAX CHANNEL
    **/

    /**
  AJAX CATEGORY
    **/
    $(document).on('change', '.parent_category, .sub_category', function(){
      var id=$(this).val();
      var i=$(this).data().sub;
      var j=i+1;
      // alert(i);
      $.ajax({
          url: base_url + 'ajax/category',
          type: 'POST',
          data: {id: id, i: i, j: j},
          dataType: 'html',
          success: function (data) {
            // alert(data); 
            $('.sub-category-'+j).empty();
            $('.sub-category-'+j).append(data);
            $('.sub-category-'+j).append('<div class="sub-category-' + (j+1) +'"></div>');
          }
        });
    });

    /**
    END AJAX CATEGORY
    **/

});
    $('.edit_channel').click(function () {
      $('.select_channel').toggle();
      $('#category-channel').toggle();
    });
</script>
<?=$this->load->view('publik/ui2/footer')?>
