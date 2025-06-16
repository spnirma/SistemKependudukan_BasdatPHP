<?=$this->load->view('publik/ui2/header')?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>

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
                            <h3><span>Profilku</span></h3>
                            <hr>
                              <?php if(isset($_GET['p'])): ?>
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Data berhasil disimpan.
                                </div>
                            <?php endif ?>
                            
                            <?php
                                if (isset($error))
                                    {
                                        ?>
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <?=$error;?>
                                        </div>
                            <?php } ?>
                        
                            <form name="f1" method="post" action="<?php echo base_url('merchant')?>">    
                            <div class="alamat_profil">
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Email<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <span><?php echo htmlspecialchars($merchant->email) ?></span>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Nama Merchant<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" name="nama_store" value="<?php echo set_value('nama_store',$merchant->nama_store)?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Bio<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="deskripsi" rows=5><?php echo set_value('deskripsi',$merchant->deskripsi)?></textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Lokasi<span class="icon-required">*</span></label>
                                    </div>
                                    
                                    <div class="col-md-6">                                                   
                                        <?php 
                                        
                                        $kecamatan = (set_value('kecamatan' ,$merchant->merchant_kecamatan));
                                        $kabupaten = (set_value('kabupaten' ,$merchant->merchant_kabupaten));

                                        if($kecamatan){
                                        $lokasi = $this->lib_lokasi->get_lokasi($kecamatan);
                                        }else{
                                        $lokasi = $this->lib_lokasi->get_lokasi_by_kabupaten($kabupaten);   
                                        }
                                        ?>
                                        <select class="form-control" name="propinsi" id="propinsi">
                                            <?php
                                                
                                                if(!empty($propinsi)){
                                                    echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                    foreach($propinsi as $row){
                                                        $selected = ($lokasi->id_propinsi==$row->id_propinsi)?'selected':'';
                                                        echo "<option value='".$row->id_propinsi."' ".$selected.">". htmlspecialchars(ucwords($row->nama_propinsi)) ."</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <br>
                                        <div id="div_kabupaten" class="form-group">                                         
                                            <?php                                            
                                                $kabupaten = $this->lib_lokasi->get_kabupaten($lokasi->id_propinsi);                                    
                                                if(!empty($kabupaten)){
                                                    echo "<select class='form-control' name='kabupaten' id='kabupaten'";
                                                    foreach($kabupaten as $row){
                                                        $selected = ($lokasi->id_kabupaten==$row->id_kabupaten)?'selected':'';
                                                        echo "<option value='".$row->id_kabupaten."' ".$selected.">". htmlspecialchars(ucwords($row->nama_kabupaten)) ."</option>";
                                                    }
                                                    echo "</select>";
                                                }else{
                                                echo "<select class='form-control' disabled >";
                                                    echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                echo "</select>";
                                            }
                                            ?>
                                        </div>
                                        <div id="div_kecamatan" class="form-group">
                                            <?php                                            
                                                $kecamatan = $this->lib_lokasi->get_kecamatan($lokasi->id_kabupaten);
                                                if(!empty($kecamatan)){
                                                    echo "<select class='form-control' name='kecamatan' id='kecamatan'>";
                                                    echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                    foreach($kecamatan as $row){
                                                        if (isset($lokasi->id_kecamatan)) {
                                                            $selected = ($lokasi->id_kecamatan==$row->id_kecamatan)?'selected':'';
                                                        } else {
                                                            $selected = '';
                                                        }
                                                        echo "<option value='".$row->id_kecamatan."' ".$selected.">". htmlspecialchars(ucwords($row->nama_kecamatan)) ."</option>";
                                                    }
                                                    echo "</select>";
                                                }
                                            else{
                                                    echo "<select class='form-control' disabled >";
                                                        echo "<option value='NULL'>-- Pilih Kecamatan --</option>";
                                                    echo "</select>";
                                                }
                                            ?>
                                        </div><br/>
                                    </div>
                                </div>
                                
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Nama Pemilik<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class='form-control' type="text" name="nama_pemilik" value="<?php echo set_value('nama_pemilik',$merchant->nama_pemilik)?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Tanggal Lahir<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input id="tgl_lahir" class='form-control' type="text" name="tgl_lahir_pemilik" value="<?php echo set_value('tgl_lahir_pemilik',strftime("%d-%m-%Y",strtotime($merchant->tgl_lahir_pemilik)))?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Telp<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input onkeypress="return isNumberKey(event)" class='form-control' type="text" name="telpon" value="<?php echo set_value('telpon',$merchant->merchant_telpon)?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">No HP<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input onkeypress="return isNumberKey(event)" class='form-control' type="text" name="merchant_hp" value="<?php echo set_value('merchant_hp',$merchant->merchant_hp)?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Nama Bank<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- <input class='form-control' type="text" name="bank_nama" value="<?php echo set_value('bank_nama',$merchant->merchant_bank_nama)?>"> -->
                                        <select class="form-control" name="bank_nama">
                                            <option value=""> -- Pilih Nama Bank -- </option>
                                            <?php foreach ($bank_list as $value) : ?>
                                                <option value="<?= $value['bank_value'] ?>" <?php echo (set_value('bank_nama',$merchant->merchant_bank_nama) == $value['bank_value'])?'selected':''; ?>><?= $value['bank_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Cabang Bank<span class="icon-required"></span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class='form-control' type="text" name="bank_branch" value="<?php echo set_value('bank_branch',$merchant->bank_branch)?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Kode BI<span class="icon-required"></span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class='form-control' type="text" name="bank_bi_code" value="<?php echo set_value('bank_bi_code',$merchant->bank_bi_code)?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">No Rekening<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input onkeypress="return isNumberKey(event)" class='form-control' type="text" name="bank_norek" value="<?php echo set_value('bank_norek',$merchant->merchant_bank_norek)?>">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Pemegang Rekening<span class="icon-required">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class='form-control' type="text" name="bank_pemilik" value="<?php echo set_value('bank_pemilik',$merchant->merchant_bank_pemilik)?>">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <br><br>
                                <div style="text-align:center;">
                                    <button class="btn btn-primary save-product" type="submit" name="simpan" value=1>Save</button>
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
<script type="text/javascript">

    var disableKabupaten = function() {
        $('#kabupaten, #id_kabupaten').val('').attr('disabled', 'disabled').addClass('disabled');
    };
    
    var disableKecamatan = function() {
        $('#kecamatan, #id_kecamatan').val('').attr('disabled', 'disabled').addClass('disabled');
    };
    
    $('#propinsi').change(function(e) {
        if ($(this).val() == '') {
            disableKabupaten();
            disableKecamatan();
            return;
        }
        
        $('#div_kecamatan > div').remove();
        
        load_kabupaten('propinsi', 'div_kabupaten', 'kabupaten', 'kecamatan');
    });
    
    $(document).on('change', '#kabupaten, #id_kabupaten', function(e) {
        load_kecamatan('kabupaten','div_kecamatan','kecamatan');
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

    function isNumberKey(evt)
    {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if ((charCode > 47 && charCode < 58 ) || charCode == 44 || charCode == 46 || charCode == 8)
                return true;

         return false;
    }

    $("#tgl_lahir").datepicker({
        dateFormat: "dd-mm-yy"
    });
    
</script>
<?=$this->load->view('publik/ui2/footer')?>
