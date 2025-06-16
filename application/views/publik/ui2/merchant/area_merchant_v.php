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
                            <h3><span>Area Pengiriman</span></h3>
                            <hr>
                            <p>
                              Menu AREA PENGIRIMAN dapat Anda gunakan untuk menentukan area pengiriman produk yang dapat anda layani.
                            </p>
                              <div class="alert alert-success alert-dismissable" id="success_save" style="display:none">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  Data berhasil disimpan.
                              </div>
                              <div class="alert alert-danger alert-dismissable" id="gagal_save" style="display:none">
                                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                  Data gagal disimpan.
                              </div>
                              <div class="content">
                              <h3>Lokasi</h3>
                              <div class="row form-group">
                                  <div class="col-md-3">
                                      <label class="control-label">Terapkan Ke Semua Produk</label>
                                  </div>
                                  <div class="col-md-6">
                                      <input type="checkbox" id="check_area" value="<?= $merchant->id_user ?>" <?= ($merchant->area_merchant == 1)?'checked':''; ?>>
                                  </div>
                              </div>
                              <form name="f1" method="post" action="">    
                                  <div class="alamat_profil">
                                      <div class="form-group">
                                          <div class="col-md-3">
                                          </div>
                                          <div class="col-md-6">
                                              <select class="form-control" name="propinsi" id="propinsi">
                                                  <?php
                                                      
                                                      if(!empty($propinsi)){
                                                          echo "<option value=''>-- Pilih Propinsi --</option>";
                                                          foreach($propinsi as $row){
                                                              echo "<option value='".$row->id_propinsi."'>". htmlspecialchars(ucwords($row->nama_propinsi)) ."</option>";
                                                          }
                                                      }
                                                  ?>
                                              </select>
                                              <br><br>
                                              <div id="div_kabupaten" class="form-group">
                                                  <select class='form-control' disabled>
                                                      <option value=''>-- Pilih Kabupaten --</option>
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                      
                                      <div class="clearfix"></div>
                                      <div style="text-align:center;">
                                          <button class="btn btn-primary save-product" type="submit" name="simpan" value=1>Save</button>
                                      </div>
                                  </div>
                              </form>
                              <hr>
                                  <p>Keterangan : </p>
                                  <ol>
                                      <li>Jika checkbox "Terapkan ke Semua Produk" Anda centang, maka Area Pengiriman akan berlaku ke semua produk Anda. Namun tidak berlaku untuk produk dengan area pengiriman Customized. </li>
                                      <li>Jika Area Pengiriman berlaku untuk seluruh Kabupaten dalam satu propinsi, maka kosongkan pilihan KABUPATEN</li>
                                      <li>Kosongkan Area Pengiriman jika produk dapat dikirim ke semua kota/propinsi di Indonesia</li>
                                  </ol>
                              <div class="table-responsive">
                                  <table class="table table-striped table-hover">
                                      <thead>
                                          <tr>
                                              <th>No</th>
                                              <th>Propinsi</th>
                                              <th>Kabupaten</th>
                                              <th>Opsi</th>
                                          </tr>
                                      </thead>
                                      <tbody class="myproduct_list">
                                          <?php
                                              $i = 0;
                                              foreach ($area_merchant as $p){
                                              $i++;
                                          ?>
                                          <tr id="row<?php echo $p->id_area_merchant;?>">
                                              <td><?=$i?></td>
                                              <td><?=htmlspecialchars($p->nama_propinsi)?></td>
                                              <td><?=htmlspecialchars($p->nama_kabupaten)?></td>
                                              <td><a title="hapus" onclick="delete_area_merchant(<?=$p->id_area_merchant?>)" class="btn btn-danger btn-xs">Delete</a></td>
                                          </tr>
                                          <?php } ?>
                                      </tbody>
                                  </table>
                              </div>

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

<script>

    $('#propinsi').change(function(e) {
        load_kabupaten('propinsi', 'div_kabupaten', 'kabupaten', 'kecamatan');
    });

    function load_kabupaten(idpropinsi,container_kabupaten,nama_input_kabupaten)
    {
        var propinsi             = $('#'+idpropinsi).val();        
        $('#'+container_kabupaten).html("Loading...");
        $.ajax({
                type    : "POST",
                url     : "<?php echo base_url('lokasi/dropdown_kabupaten')?>",
                data    : "id_propinsi="+propinsi+"&nama_input_kabupaten="+nama_input_kabupaten,
                success : function(result){
                    $('#'+container_kabupaten).html(result);
                }
            });
    }
    
    function load_kecamatan(idkabupaten,container_kecamatan,nama_input_kecamatan)
    {
        var kabupaten = $('#'+idkabupaten).val();        
        $('#'+container_kecamatan).html("Loading...");
        $.ajax({
                type    : "POST",
                url     : "<?php echo base_url('lokasi/dropdown_kecamatan')?>",
                data    : "id_kabupaten="+kabupaten+"&nama_input_kecamatan="+nama_input_kecamatan,
                success : function(result){
                    $('#'+container_kecamatan).html(result);
                }
            });
    }

    function delete_area_merchant(id)
    {
        if(confirm("Apa anda Yakin?")) {
            $.post("<?=base_url()?>merchant/delete_area_merchant",{id:id},function(result){
                $("#row"+id).hide();
            });
        }
    }

    $("#check_area").bind("click", function(){
        var id = parseInt($(this).val(), 10);
        $("#gagal_save").hide();
        $("#success_save").hide();
        if($(this).is(":checked")) {
            $.post("<?=base_url()?>merchant/update_area_merchant",{id:id,cek:"1"},function(result){
                if(result == "true"){
                    $("#success_save").show();
                } else {
                    $("#gagal_save").show();
                }
            });
        } else {
            $.post("<?=base_url()?>merchant/update_area_merchant",{id:id,cek:"0"},function(result){
                if(result == "true"){
                    $("#success_save").show();
                } else {
                    $("#gagal_save").show();
                }
            });
        }
    });
</script>
<?=$this->load->view('publik/ui2/footer')?>
