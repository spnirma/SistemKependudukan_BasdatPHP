<?= $this->load->view('publik/ui2/header') ?>
<section class="main">
    <div class="featured-list container">
        <div class="row">
            <div class="col-xs-12">
                <div class="aboutbox-item aboutbox-item-static">
                    <form method="POST" action="<?= base_url() ?>cart/alamat" class="form-horizontal">
                        <input class="alamat_check hidden" type="checkbox" name="alamat" value="sama" checked>
                        <div class="checkout_step1">
                            <h4>Detail Pengiriman</h4>
                            <hr />
                            <div class="row alamat_lain">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nama Depan<span class="icon-required">*</span></label>
                                    <div class="col-sm-6">
                                        <input <?= (isset($user->firstname)) ? 'value="' . htmlspecialchars($user->firstname) . '"' : ''; ?> name="firstname" type="text" class="form-control name" id="name" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nama Belakang<span class="icon-required">*</span></label>
                                    <div class="col-sm-6">
                                        <input <?= (isset($user->lastname)) ? 'value="' . htmlspecialchars($user->lastname) . '"' : ''; ?> name="lastname" type="text" class="form-control name" id="name" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email<span class="icon-required">*</span></label>
                                    <div class="col-sm-6">
                                        <input <?= (isset($user->email)) ? 'value="' . htmlspecialchars($user->email) . '"' : ''; ?> name="email" type="text" class="form-control email" id="email" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Alamat<span class="icon-required">*</span></label>
                                    <div class="col-sm-6">
                                        <textarea name="alamat" type="text" class="form-control address" id="address" rows="4"><?= (isset($user->alamat)) ? htmlspecialchars($user->alamat) : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user" class="col-lg-2 control-label">Provinsi<span class="icon-required">*</span></label>
                                    <div class="col-md-6">                                                   
                                        <?php
                                        $kecamatan = (set_value('kecamatan', $user->id_kecamatan));
                                        $kabupaten = (set_value('id_kabupaten', $user->id_kabupaten));

                                        if ($kecamatan) {
                                            $lokasi = $this->lib_lokasi->get_lokasi($kecamatan);
                                        } else {
                                            $lokasi = $this->lib_lokasi->get_lokasi_by_kabupaten($kabupaten);
                                        }
                                        ?>

                                        <select class="form-control" name="id_propinsi" id="propinsi">
                                            <option value=''>-- Pilih Propinsi --</option>
                                            <?php
                                            if (!empty($propinsi)) {
                                                foreach ($propinsi as $row) {
                                                    $selected = ($lokasi->id_propinsi == $row->id_propinsi) ? 'selected' : '';
                                                    echo "<option value='" . $row->id_propinsi . "' " . $selected . ">" . htmlspecialchars(ucwords($row->nama_propinsi)) . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user" class="col-lg-2 control-label">Kabupaten<span class="icon-required">*</span></label>
                                    <div class="col-md-6">  
                                        <div id="div_kabupaten">                                         
                                            <?php
                                            if (!empty($lokasi)) {
                                                $kabupaten = $this->lib_lokasi->get_kabupaten($lokasi->id_propinsi);
                                                if (!empty($kabupaten)) {
                                                    echo "<select class='form-control' name='id_kabupaten' id='kabupaten'";
                                                    echo "<option value=''>-- 1 Pilih Kabupaten --</option>";
                                                    foreach ($kabupaten as $row) {
                                                        $selected = ($lokasi->id_kabupaten == $row->id_kabupaten) ? 'selected' : '';
                                                        echo "<option value='" . $row->id_kabupaten . "' " . $selected . ">" . htmlspecialchars(ucwords(strtolower($row->nama_kabupaten))) . "</option>";
                                                    }
                                                    echo "</select>";
                                                } else {
                                                    echo "<select class='form-control' disabled >";
                                                    echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                    echo "</select>";
                                                }
                                            } else {
                                                echo "<select class='form-control' disabled >";
                                                echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                echo "</select>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user" class="col-lg-2 control-label">Kecamatan</label>
                                    <div class="col-md-6">  
                                        <div id="div_kecamatan">
                                            <?php
                                            if (!empty($lokasi)) {
                                                $kecamatan = $this->lib_lokasi->get_kecamatan($lokasi->id_kabupaten);
                                                if (!empty($kecamatan)) {
                                                    echo "<select class='form-control' name='kecamatan' id='kecamatan'>";
                                                    echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                    foreach ($kecamatan as $row) {
                                                        $selected = ($lokasi->id_kecamatan == $row->id_kecamatan) ? 'selected' : '';
                                                        echo "<option value='" . $row->id_kecamatan . "' " . $selected . ">" . htmlspecialchars(ucwords($row->nama_kecamatan)) . "</option>";
                                                    }
                                                    echo "</select>";
                                                } else {
                                                    echo "<select class='form-control' disabled >";
                                                    echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                    echo "</select>";
                                                }
                                            } else {
                                                echo "<select class='form-control' disabled >";
                                                echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                echo "</select>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Telepon<span class="icon-required">*</span></label>
                                    <div class="col-sm-6">
                                        <input onkeypress="return isNumberKey(event)" <?= (isset($user->telpon)) ? 'value="' . htmlspecialchars($user->telpon) . '"' : ''; ?> name="telpon" type="text" class="form-control phone" id="phone" placeholder="0319211111">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Hp<span class="icon-required">*</span></label>
                                    <div class="col-sm-6">
                                        <input onkeypress="return isNumberKey(event)" <?= (isset($user->hp)) ? 'value="' . htmlspecialchars($user->hp) . '"' : ''; ?> name="hp" type="text" class="form-control phone" id="phone" placeholder="085711234560">
                                    </div>
                                </div>
                            </div>   
                            <br>
                            <a href="<?= base_url(); ?>cart" class="btn btn-danger">Kembali</a>
                            <button value="1" type="submit" class="btn btn-warning pull-right link" name="simpan">Lanjutkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var disableKabupaten = function () {
        $('#kabupaten, #id_kabupaten').val('').attr('disabled', 'disabled').addClass('disabled');
    };

    var disableKecamatan = function () {
        $('#kecamatan, #id_kecamatan').val('').attr('disabled', 'disabled').addClass('disabled');
    };

    $('#propinsi').change(function (e) {
        if ($(this).val() == '') {
            disableKabupaten();
            disableKecamatan();
            return;
        }

        $('#div_kecamatan > div').remove();

        ajax_load_kabupaten_alamat('propinsi', 'div_kabupaten', 'id_kabupaten', 'kecamatan');
    });

    $(document).on('change', '#kabupaten, #id_kabupaten', function (e) {
        ajax_load_kecamatan_alamat('kabupaten', 'div_kecamatan', 'kecamatan');
    });
    function ajax_load_kabupaten_alamat(idpropinsi, container_kabupaten, nama_input_kabupaten)
    {
        var propinsi = $('#' + idpropinsi).val();
        $('#' + container_kabupaten).html("Loading...");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('lokasi/dropdown_kabupaten_alamat') ?>",
            data: "id_propinsi=" + propinsi + "&nama_input_kabupaten=" + nama_input_kabupaten,
            success: function (result) {
                $('#' + container_kabupaten).html(result);
            }
        });
    }

    function ajax_load_kecamatan_alamat(idkabupaten, container_kecamatan, nama_input_kecamatan)
    {
        var kabupaten = $('#' + idkabupaten).val();
        $('#' + container_kecamatan).html("Loading...");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('lokasi/dropdown_kecamatan_alamat') ?>",
            data: "id_kabupaten=" + kabupaten + "&nama_input_kecamatan=" + nama_input_kecamatan,
            success: function (result) {
                $('#' + container_kecamatan).html(result);
            }
        });
    }
</script>
<?= $this->load->view('publik/ui2/footer') ?>
