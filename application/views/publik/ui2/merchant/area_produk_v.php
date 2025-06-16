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
                            <h3><span>Area Produk</span></h3>
                            <hr>
                            <?php if($success): ?>
                            <div class="alert alert-success alert-dismissable" id="success_save">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Data berhasil disimpan.
                            </div>
                            <?php endif; ?>

                            <div class="alert alert-success alert-dismissable" id="success_save" style="display:none">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Data berhasil disimpan.
                            </div>
                            <div class="alert alert-danger alert-dismissable" id="gagal_save" style="display:none">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Data tidak terudate.
                            </div>
                            <p>Keterangan :</p>
                            <ol>
                                <li>Default area Pengiriman : produk hanya dapat dikirim ke wilayah/propinsi/kota yang telah ditentukan di Menu Area Pengiriman</li>
                                <li>Ke Semua Area : tidak ada pembatasan area pengiriman</li>
                                <li>Customized : untuk menentukan area pengiriman khusus produk ini saja.</li>
                            </ol>

                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label class="control-label">Opsi Area Produk</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="radio" name="type" value='0' class="radio_area" <?= ($produk->area_produk == 0)?'checked':''; ?> > Default area pengiriman <br>
                                    <input type="radio" name="type" value='2' class="radio_area" <?= ($produk->area_produk == 2)?'checked':''; ?> > Ke semua Area <br>
                                    <input type="radio" name="type" value='1' class="radio_area" <?= ($produk->area_produk == 1)?'checked':''; ?> > Customized <br>
                                </div>
                            </div>
                            <div id="lokasi_area" <?= ($produk->area_produk != 1)?"style='display:none';":""; ?>>
                                <h3>Lokasi</h3>
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
                                                foreach ($area_produk as $p){
                                                $i++;
                                            ?>
                                            <tr id="row<?php echo $p->id_area_produk;?>">
                                                <td><?=$i?></td>
                                                <td><?=htmlspecialchars($p->nama_propinsi)?></td>
                                                <td><?=htmlspecialchars($p->nama_kabupaten)?></td>
                                                <td><a title="hapus" onclick="delete_area_produk(<?=$p->id_area_produk?>)" class="btn btn-danger btn-xs">hapus</a></td>
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

<?php
if(!empty($area_produk)){
    $data_produk = 1;
}else{
    $data_produk = 0;
}
?>
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
    
    $('#propinsi').change(function(e) {
        load_kabupaten('propinsi', 'div_kabupaten', 'kabupaten', 'kecamatan');
    });

    function delete_area_produk(id)
    {
        if(confirm("Apa anda Yakin?")) {
            $.post("<?=base_url()?>myproduct/delete_area_produk",{id:id},function(result){
                $("#row"+id).hide();
            });
        }
    }

    $(".radio_area").bind("click", function(){
        var type = parseInt($(this).val(), 10);
        var cek_area_produk;
        if($(this).is(":checked")) {
            $("#gagal_save").hide();
            $("#success_save").hide();

            $.post("<?=base_url()?>myproduct/cek_area_produk",{id:"<?= $produk->id_produk ?>"},function(result_cek){
               if(type == 1){
                    if(result_cek == 1){
                        $.post("<?=base_url()?>myproduct/update_area_produk",{id:"<?= $produk->id_produk ?>",type:type},function(result){
                            if(result == "true"){
                                $("#success_save").show();
                            } else {
                                $("#gagal_save").show();
                            }
                        });
                    }
                } else {
                    $.post("<?=base_url()?>myproduct/update_area_produk",{id:"<?= $produk->id_produk ?>",type:type},function(result){
                        if(result == "true"){
                            $("#success_save").show();
                        } else {
                            $("#gagal_save").show();
                        }
                    });
                } 
            });
        }
        if(type != 1){
            $("#lokasi_area").hide();
        } else {
            $("#lokasi_area").show();
        }
    });
</script>
<?=$this->load->view('publik/ui2/footer')?>
