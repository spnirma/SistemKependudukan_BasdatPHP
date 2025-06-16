<?=$this->load->view('publik/ui2/header')?>
<script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
<style type="text/css">
ol.progtrckr {
    margin: 0;
    padding: 0;
    list-style-type none;
}

ol.progtrckr li {
    display: inline-block;
    text-align: center;
    line-height: 3em;
}
ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }

ol.progtrckr li.progtrckr-done {
    color: black;
    border-bottom: 4px solid yellowgreen;
}
ol.progtrckr li.progtrckr-todo {
    color: silver; 
    border-bottom: 4px solid silver;
}
ol.progtrckr li:after {
    content: "\00a0\00a0";
}
ol.progtrckr li:before {
    position: relative;
    bottom: -2.5em;
    float: left;
    left: 50%;
    line-height: 1em;
}
ol.progtrckr li.progtrckr-done:before {
    content: "\2713";
    color: white;
    background-color: yellowgreen;
    height: 1.2em;
    width: 1.2em;
    line-height: 1.2em;
    border: none;
    border-radius: 1.2em;
}
ol.progtrckr li.progtrckr-todo:before {
    content: "\039F";
    color: silver;
    background-color: white;
    font-size: 1.5em;
    bottom: -1.6em;
}

</style>
        <section class="main">

            <div class="featured-list container">

               <div class="row">
                    <div class="col-xs-12">
                        <ol class="progtrckr" data-progtrckr-steps="3">
                            <li class="progtrckr-done">Merchant Profile</li>
                            <li class="progtrckr-todo">Upload Produk</li>
                            <li class="progtrckr-todo">Verifikasi</li>
                        </ol>
                        <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Merchant Profile</span></h3>
                            <hr>
                            <form method="POST" action="<?php echo base_url('merchant/register')?>" class="form-horizontal" id="f1">

                            <div class="checkout_step1">
                                <?php
                                    if(isset($error)){
                                        echo "<div class='error'>".$error."</div>";
                                    }
                                ?>
                                <div class="alamat_profil">
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Email<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <span><?php echo htmlspecialchars($this->session->userdata('member')->email) ?></span>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Nama Merchant<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="nama_store" value="<?php echo set_value('nama_store')?>" placeholder="Nama Store">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Biodata<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea name="deskripsi" class="form-control" placeholder="Toko bunga murah daerah Pasar Senen" rows=5><?php echo set_value('deskripsi')?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Alamat<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea name="alamat" class="form-control" placeholder="Jl. Singosari Blok I No 9" rows=5><?= htmlspecialchars($data->alamat) ;?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Lokasi<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">                                                 
                                            <?php 
                                                $Lokasi         = new \Cipika\Common\Lokasi;
                                                
                                                $idkecamatan    = ($this->input->post('kecamatan')!='')?$this->input->post('kecamatan'):$data->id_kecamatan;
                                                $lokasi         = $Lokasi->getLokasi($idkecamatan);                        
                                                $curr_propinsi  = ($this->input->post('id_propinsi')!='')?$this->input->post('id_propinsi'):$user->id_propinsi;
                                                $curr_kabupaten = ($this->input->post('id_kabupaten')!='')?$this->input->post('id_kabupaten'):$user->id_kabupaten;
                                                $curr_kecamatan = ($this->input->post('kecamatan')!='')?$this->input->post('kecamatan'):$user->id_kecamatan;                        
                                            ?>

                                                    <select class="form-control" name="id_propinsi" id="propinsi">
                                                        <option value=''>-- Pilih Propinsi --</option>
                                                        <?php
                                                        if (!empty($propinsi)){
                                                            foreach ($propinsi as $row)
                                                            {
                                                                $selected = ($curr_propinsi == $row->id_propinsi) ? 'selected' : '';
                                                                echo "<option value='" . $row->id_propinsi . "' " . $selected . ">" . htmlspecialchars(ucwords($row->nama_propinsi)) . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>  
                                                    <div id="div_kabupaten">                                         
                                                        <?php
                                                        $kabupaten  = $Lokasi->getKabupaten($curr_propinsi);
                                                        if (!empty($kabupaten) && $curr_propinsi != ''){
                                                            echo "<select class='form-control' name='id_kabupaten' id='kabupaten'>";
                                                            echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                            foreach ($kabupaten as $row){
                                                                $selected = ($curr_kabupaten == $row->id_kabupaten) ? 'selected' : '';
                                                                echo "<option value='" . $row->id_kabupaten . "' " . $selected . ">" . htmlspecialchars(ucwords($row->nama_kabupaten)) . "</option>";
                                                            }
                                                            echo "</select>";
                                                        }
                                                        else{
                                                                echo "<select class='form-control' disabled >";
                                                                    echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                                echo "</select>";
                                                            }
                                                        ?>
                                                    </div>  
                                                    <div id="div_kecamatan">
                                                        <?php
                                                        $kecamatan  = $Lokasi->getKecamatan($curr_kabupaten);
                                                        if (!empty($kecamatan) && $curr_kabupaten != ''){                                    
                                                            echo "<select class='form-control' name='kecamatan' id='kecamatan'>";
                                                             echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                            foreach ($kecamatan as $row){
                                                                $selected = ($curr_kecamatan == $row->id_kecamatan) ? 'selected' : '';
                                                                echo "<option value='" . $row->id_kecamatan . "' " . $selected . ">" . htmlspecialchars(ucwords($row->nama_kecamatan)) . "</option>";
                                                            }
                                                            echo "</select>";                                   
                                                        }
                                                        else{
                                                                echo "<select class='form-control' disabled >";
                                                                    echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                                echo "</select>";
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                    <h4>Profil Pemilik</h4>
                                    <hr>
                                    
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Nama Pemilik<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="nama_pemilik" value="<?php echo set_value('nama_pemilik')?>" placeholder="Nama Pemilik">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Tanggal Lahir<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="birthdate" id="tgl_lahir" value="<?=strftime("%d-%m-%Y",strtotime(substr($data->birthdate,0,10)));?>" placeholder="29-12-1994">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Telepon<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input onkeypress="return isNumberKey(event)" type="text" class="form-control" name="telpon" value="<?= htmlspecialchars($data->telpon) ;?>" placeholder="0312281672">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Hp<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input onkeypress="return isNumberKey(event)" type="text" class="form-control" name="hp" value="<?= htmlspecialchars($data->hp) ;?>" placeholder="085726891789">
                                        </div>
                                    </div>
                                    
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Gender<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-lg-6">
                                            <?php if($this->input->post('gender')):?>
                                                <input type="radio" value="1" name="gender" <?=($this->input->post('gender')==1)?'checked':'';?>> Pria
                                                <input type="radio" value="2" name="gender" <?=($this->input->post('gender')==2)?'checked':'';?>> Wanita
                                            <?php else:?>
                                                <input type="radio" value="1" name="gender" <?=($data->gender=='man')?'checked':'';?>> Pria
                                                <input type="radio" value="2" name="gender" <?=($data->gender=='woman')?'checked':'';?>> Wanita
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <h4>Rekening Pembayaran</h4>
                                    <hr>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Nama Bank<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- <input type="text" class="form-control" name="bank_nama" value="<?php echo set_value('bank_nama')?>" placeholder="Mandiri"> -->
                                            <select class="form-control" name="bank_nama">
                                            <option value=""> -- Pilih Nama Bank -- </option>
                                            <?php foreach ($bank_list as $value) : ?>
                                                <option value="<?= $value['bank_value'] ?>" <?php echo (set_value('bank_nama') == $value['bank_value'])?'selected':''; ?>><?= $value['bank_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Cabang Bank<span class="icon-required"></span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="bank_branch" value="<?php echo set_value('bank_branch')?>" placeholder="Cabang Jakarta Sudirman">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Kode BI<span class="icon-required"></span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="bank_bi_code" value="<?php echo set_value('bank_bi_code')?>" placeholder="0080062">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">No Rekening<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input onkeypress="return isNumberKey(event)" type="text" class="form-control" name="bank_norek" value="<?php echo set_value('bank_norek')?>" placeholder="1234567890123">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Pemegang Rekening<span class="icon-required">*</span></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="bank_pemilik" value="<?php echo set_value('bank_pemilik')?>" placeholder="Pemegang Rekening">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <label class="control-label"></label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="checkbox" name="syarat_ketentuan"> Saya setuju dengan <a target="_blank" href='<?=base_url();?>page/index/10/Perjanjian-Kerjasama-Merchant'>Syarat & Kententuan</a>.
                                        </div>
                                    </div>
                                    
                                    
                                </div>        
                                <hr />

                                <input type="submit" class="btn btn-lanjut pull-right" name="button_register" value="Lanjutkan">
                                <br />
                                <br>
                            </div>

                        </form>
                        </div>
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
        
        load_kabupaten('propinsi', 'div_kabupaten', 'id_kabupaten', 'kecamatan');
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

    $('#change_pp').click(function(){
            $("#filePhoto").click();
     });
     $("#filePhoto").change(function() {
            readURL(this);
     });
     function readURL(input) {
             if (input.files && input.files[0]) {
                     var reader = new FileReader();
                     reader.onload = function(e) {
                             $('#previewHolder').attr('src', e.target.result);
                     }

                     reader.readAsDataURL(input.files[0]);
             }
     }

     function isNumberKey(evt)
    {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if ((charCode > 47 && charCode < 58 ) || charCode == 44 || charCode == 46 || charCode == 8)
                return true;

         return false;
    }

    $(window).load(function(){
        $("ol.progtrckr").each(function(){
            $(this).attr("data-progtrckr-steps", 
                         $(this).children("li").length);
        });
    })

    $("#tgl_lahir").datepicker({
        dateFormat: "dd-mm-yy"
    });
     
</script>

<?=$this->load->view('publik/ui2/footer')?>
