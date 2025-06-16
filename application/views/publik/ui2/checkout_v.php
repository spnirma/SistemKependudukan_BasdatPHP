<?= $this->load->view('publik/ui2/header') ?>

<section class="main">
    <div class="trolibox container-ex">
        <?php
        if (isset($error)) {
            ?>
            <div style="color:red" align="center" class="alert alert-danger alert-dismissable ajax-error-response"><?= $error; ?></div>
            <?php
        }
        ?>
        <?php
        if (isset($errorArray)) {
            ?>
            <div style="color:red" align="center" class="alert alert-danger alert-dismissable ajax-error-response">
                <?php
                foreach ($errorArray as $v) {
                    ?>
                    <?= $v['output']; ?>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-xs-6">        
                <?php
                foreach ($cart as $key => $value) {
                    ?>
                    <div class="troli-item-wrap">
                        <div class="troli-item konfirmasi">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jml</th>
                                        <th>Diskon</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($value as $row) {
                                        ?>
                                        <tr>
                                            <td>
                                                <img class="thumb" src="<?= base_url(); ?>asset/pict.php?src=<?= $row['image']; ?>&w=50&h=50&z=1">
                                                <span class="product-name"><?= htmlspecialchars($row['name']); ?><br>
                                                    <small>Merchant : <?= htmlspecialchars(ucwords($merchantNameStore[$key])); ?></small><br>
                                                    <small>Lokasi : <?= htmlspecialchars(ucwords($merchantLokasiStore[$key])); ?></small></span>
                                            </td>
                                            <td><strong><?= $row['qty']; ?></strong></td>
                                            <td><strong><?= $row['discount']; ?>%</strong></td>
                                            <td><strong class="total-harga">Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?></strong></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row" style="margin-bottom:20px">
                            <div class="col-md-2">
                                <div align="center" style="margin-left: 20px;marin-top:100px">
                                    <?php
                                    if (!$merchantVoucherReload[$key]) {
                                        ?>
                                        <a href="#" data-toggle="modal" data-target="#myModal<?= $key ?>" style="text-decoration:none;color:black">
                                            <img src="<?=base_url();?>asset/ui2/img/icon-map-maker.png" height="70" width="40" style="margin-top:10px;margin-bottom:5px"/>
                                            Edit
                                        </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="#" data-toggle="modal" data-target="#myModalGantiNomorTujuan<?= $key ?>" style="text-decoration:none;color:black">
                                            <img src="<?=base_url();?>asset/ui2/img/icon-mobile-phone-hi.png" style="width: auto; height:50px!important; margin-top:5px;margin-bottom:5px; max-width: auto;"/><br />
                                            Edit
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="modal fade" id="myModal<?= $key; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div style="margin-left:1em;padding:10px"><h4 id="myModalLabel">Alamat Pengiriman</h4></div>
                                            </div>
                                            <div class="formGantiAlamatAjaxError" style="color:red;text-align:center" align=center></div>
                                            <form class="form-horizontal formGantiAlamatAjax" role="form" method="POST" action="<?= base_url() . 'ajax/change_address_shipping_member'; ?>" name="formGantiAlamatAjax" id="formGantiAlamatAjax">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <?php
                                                        if ($merchantProductSoftware[$key]) {
                                                            ?>
                                                            <label class="control-label col-sm-3" for="email">Company Name / PIC Name<span class="icon-required">*</span></label>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <label class="control-label col-sm-3" for="email">Nama Lengkap<span class="icon-required">*</span></label>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="col-sm-9">
                                                            <input value="<?= set_value('nama', ucwords($userShippingAddress[$key]['nama'])); ?>" name="nama" type="text" class="form-control name" id="name" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="email">Alamat<span class="icon-required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <textarea name="alamat" type="text" class="form-control address" id="address" rows="4"><?= set_value('alamat', $userShippingAddress[$key]['alamat']) ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="email">Propinsi<span class="icon-required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control propinsi<?= $key; ?>" name="id_propinsi" id="propinsi" onchange="ajax_load_kabupaten('propinsi<?= $key; ?>', 'kabupaten<?= $key; ?>', 'id_kabupaten', <?= $key; ?>);">
                                                                <option value=''>-- Pilih Propinsi --</option>
                                                                <?php
                                                                if (!empty($propinsi)) {
                                                                    foreach ($propinsi as $row) {
                                                                        $submitted_prop = $this->input->post('id_propinsi');
                                                                        if ($submitted_prop) {
                                                                            $selected = ($submitted_prop == $row->id_propinsi) ? 'selected' : '';
                                                                        } else if ($userShippingAddress[$key]['id_provinsi']) {
                                                                            $selected = ($userShippingAddress[$key]['id_provinsi'] == $row->id_propinsi) ? 'selected' : '';
                                                                        }
                                                                        echo "<option value='" . $row->id_propinsi . "' " . $selected . ">" . htmlspecialchars(ucwords($row->nama_propinsi)) . "</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="email">Kota<span class="icon-required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <div id="div_kabupaten">
                                                                <?php
                                                                if ($submitted_prop) {
                                                                    $submitted_kab = $this->input->post('id_kabupaten');
                                                                    $kabupaten = $this->lib_lokasi->get_kabupaten($submitted_prop);
                                                                    if (!empty($kabupaten)) {
                                                                        echo "<select class='form-control kabupaten" . $key . "' name='id_kabupaten' id='kabupaten' onchange='ajax_load_kecamatan(\"kabupaten" . $key . "\",\"kecamatan" . $key . "\",\"id_kecamatan\"," . $key . ")'>";
                                                                        echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                                        foreach ($kabupaten as $row) {
                                                                            $selected = ($submitted_kab == $row->id_kabupaten) ? 'selected' : '';
                                                                            echo "<option value='" . $row->id_kabupaten . "' " . $selected . ">" . htmlspecialchars(ucwords($row->nama_kabupaten)) . "</option>";
                                                                        }
                                                                        echo "</select>";
                                                                    } else {
                                                                        echo "<select class='form-control' disabled >";
                                                                        echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                                        echo "</select>";
                                                                    }
                                                                } else {
                                                                    if (!empty($userShippingListKabupaten[$key])) {
                                                                        echo "<select class='form-control kabupaten" . $key . "' name='id_kabupaten' id='kabupaten' onchange='ajax_load_kecamatan(\"kabupaten" . $key . "\",\"kecamatan" . $key . "\",\"id_kecamatan\", " . $key . ")'>";
                                                                        echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                                        foreach ($userShippingListKabupaten[$key] as $row) {
                                                                            $selected = ($userShippingAddress[$key]['id_kota'] == $row->id_kabupaten) ? 'selected' : '';
                                                                            echo "<option value='" . $row->id_kabupaten . "' " . $selected . ">" . htmlspecialchars(ucwords(strtolower($row->nama_kabupaten))) . "</option>";
                                                                        }
                                                                        echo "</select>";
                                                                    } else {
                                                                        echo "<select class='form-control kabupaten" . $key . "' name='id_kabupaten' id='kabupaten' onchange='ajax_load_kecamatan(\"kabupaten" . $key . "\",\"kecamatan" . $key . "\",\"id_kecamatan\", " . $key . ")' disabled>";
                                                                        echo "<option value=''>-- Pilih Kabupaten --</option>";
                                                                        echo "</select>";
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="email">Kecamatan</label>
                                                        <div class="col-sm-9">
                                                            <div id="div_kecamatan">
                                                                <?php
                                                                if (!empty($submitted_kab)) {
                                                                    $submitted_kec = $this->input->post('id_kecamatan');
                                                                    $kecamatan = $this->lib_lokasi->get_kecamatan($submitted_kab);
                                                                    if (!empty($kecamatan)) {
                                                                        echo "<select class='form-control kecamatan" . $key . "' name='id_kecamatan' id='kecamatan'>";
                                                                        echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                                        foreach ($kecamatan as $row) {
                                                                            $selected = ($submitted_kec == $row->id_kecamatan) ? 'selected' : '';
                                                                            echo "<option value='" . $row->id_kecamatan . "' " . $selected . ">" . htmlspecialchars(ucwords($row->nama_kecamatan)) . "</option>";
                                                                        }
                                                                        echo "</select>";
                                                                    } else {
                                                                        echo "<select class='form-control' disabled >";
                                                                        echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                                        echo "</select>";
                                                                    }
                                                                } else if (!empty($submitted_prop)) {
                                                                    echo "<select class='form-control' disabled >";
                                                                    echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                                    echo "</select>";
                                                                } else {
                                                                    if (!empty($userShippingListKecamatan[$key])) {
                                                                        echo "<select class='form-control kecamatan" . $key . "' name='id_kecamatan' id='kecamatan'>";
                                                                        echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                                        foreach ($userShippingListKecamatan[$key] as $row) {
                                                                            $selected = ($userShippingAddress[$key]['id_kecamatan'] == $row->id_kecamatan) ? 'selected' : '';
                                                                            echo "<option value='" . $row->id_kecamatan . "' " . $selected . ">" . htmlspecialchars(ucwords($row->nama_kecamatan)) . "</option>";
                                                                        }
                                                                        echo "</select>";
                                                                    } else {
                                                                        echo "<select class='form-control kecamatan" . $key . "' name='id_kecamatan' id='kecamatan' disabled>";
                                                                        echo "<option value=''>-- Pilih Kecamatan --</option>";
                                                                        echo "</select>";
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div> 

                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="email">No Handphone<span class="icon-required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input value="<?= set_value('telpon', $userShippingAddress[$key]['telpon']) ?>" name="telpon" type="text" class="form-control phone" id="phone" placeholder="" onkeypress="return checkFieldOnlyNumber(event)">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="email">Email<span class="icon-required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input value="<?= set_value('email', $userShippingAddress[$key]['email']) ?>" name="email" type="text" class="form-control email" id="email" placeholder="" <?= $merchantProductSoftware[$key] ? "" : "readonly";?>>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-md-8">
                                                        <input value="<?= $key; ?>" name="id_merchant" type="hidden" id="id_merchant">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <input type="submit" name="gantiAlamatPengiriman" class="btn btn-primary" id="gantiAlamatPengiriman" value="Save" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="myModalGantiNomorTujuan<?= $key; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <div style="margin-left:1em;padding:10px"><h4 id="myModalLabel">Nomor Tujuan</h4></div>
                                            </div>
                                            <div class="formGantiNomorTujuanAjaxError" style="color:red;text-align:center" align=center></div>
                                            <form class="form-horizontal formGantiNomorTujuanAjax" role="form" method="POST" action="<?= base_url() . 'ajax/change_nomor_tujuan_member'; ?>" name="formGantiNomorTujuanAjax" id="formGantiNomorTujuanAjax">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="control-label col-sm-3" for="email">No Handphone<span class="icon-required">*</span></label>
                                                        <div class="col-sm-9">
                                                            <input value="<?= set_value('telpon', $userNomorTujuan[$key]['telpon']) ?>" name="telpon" type="text" class="form-control phone" id="phone" placeholder="" onkeypress="return checkFieldOnlyNumber(event)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-md-8">
                                                        <input value="<?= $key; ?>" name="id_merchant" type="hidden" id="id_merchant">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <input type="submit" name="gantiNomorTujuan" class="btn btn-primary" id="gantiNomorTujuan" value="Save" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php
                                if (!$merchantVoucherReload[$key] && !$merchantProductSoftware[$key]) {
                                    ?>
                                    <p class="alamat-detail">
                                        Nama Lengkap : <?= htmlspecialchars(ucwords($userShippingAddress[$key]['nama'])); ?><br>
                                        Alamat Pengiriman: <?= htmlspecialchars(ucwords($userShippingAddress[$key]['alamat'])); ?><br>
                                        Kecamatan: <?= ($userShippingAddress[$key]['kecamatan']) ? htmlspecialchars(ucwords($userShippingAddress[$key]['kecamatan'])) : '-'; ?><br>
                                        Kota: <?= htmlspecialchars(ucwords($userShippingAddress[$key]['kabupaten'])); ?><br>
                                        Provinsi: <?= htmlspecialchars(ucwords($userShippingAddress[$key]['propinsi'])); ?><br>
                                        No. Handphone: <?= htmlspecialchars($userShippingAddress[$key]['telpon']); ?><br>
                                        Email: <?= htmlspecialchars($userShippingAddress[$key]['email']); ?>
                                    </p>
                                    <?php
                                } elseif ($merchantProductSoftware[$key]) {
                                    ?>
                                    <p class="alamat-detail">
                                        Company Name / PIC Name : <?= htmlspecialchars(ucwords($userShippingAddress[$key]['nama'])); ?><br>
                                        Alamat Pengiriman: <?= htmlspecialchars(ucwords($userShippingAddress[$key]['alamat'])); ?><br>
                                        Kecamatan: <?= ($userShippingAddress[$key]['kecamatan']) ? htmlspecialchars(ucwords($userShippingAddress[$key]['kecamatan'])) : '-'; ?><br>
                                        Kota: <?= htmlspecialchars(ucwords($userShippingAddress[$key]['kabupaten'])); ?><br>
                                        Provinsi: <?= htmlspecialchars(ucwords($userShippingAddress[$key]['propinsi'])); ?><br>
                                        No. Handphone: <?= htmlspecialchars($userShippingAddress[$key]['telpon']); ?><br>
                                        Email: <?= htmlspecialchars($userShippingAddress[$key]['email']); ?>
                                    </p>
                                    <?php
                                } else {
                                    ?>
                                    <div class="col-md-6 alamat-detail">
                                        <div style="font-size:1.2em; margin-top:10px;">Nomor Tujuan :</div>
                                        <div style="font-size:1.7em; font-weight: bold;"><?= htmlspecialchars(ucwords($userNomorTujuan[$key]['telpon'])); ?></div><br />
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?php if (!$merchantVoucherReload[$key]): ?>
                                <label>Ongkir : </label>
                                <?php if ($showDropdownOngkir[$key]) { ?>
                                    <select name="ongkir_sementara<?= $key ?>" class="ongkir_sementara<?= $key ?> detail-merchant-shipping-ongkir-select" onchange="update_ongkir(<?= $key ?>)">
                                        <?php
                                        $indexOngkir = 1;
                                        foreach ($userShippingAmount[$key] as $k => $v) {
                                            ?>
                                            <option value="<?= $indexOngkir++; ?>" <?= $checkIndexOngkir[$key] == $v['ongkir_asli'] ? "selected" : "" ?>><?= $v['string']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                <?php } ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top: 2em">
                        <?php
                        if (isset($errorCheckOngkir[$key])) {
                            ?>
                            <div style ='color:red;margin-top:15px'><?= $errorCheckOngkir[$key]; ?></div>
                            <?php
                        }
                        if (isset($informationCheckOngkir[$key])) {
                            ?>
                            <div style ='color:red;margin-top:15px'><?= $informationCheckOngkir[$key]; ?></div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="voucher form-horizontal">
                    <div class="form-group" id="form-input-kode-voucher">
                        <label for="" class="col-xs-5 col-xs-offset-1 control-label">Kode Voucher:</label>
                        <div class="col-sm-5">
                            <div class="control-check">
                                <input type="text" class="form-control" id="kode_voucher" name="kode_voucher" value="<?= !empty($codeVoucherMember) ? $codeVoucherMember : ""; ?>" <?= !empty($codeVoucherMember) ? "disabled='disabled'" : ""; ?>>
                                <button class="control-button ir" id="confirm-code-voucher">Confirm</button>
                                <button class="control-button reset ir" id="reset-code-voucher">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-only">
                        <span class="col-sm-5 col-xs-offset-1" style="text-align: right">Nilai Voucher</span>
                        <div class="col-sm-3">Rp</div>
                        <div class="col-md-2" align="right" id="kode-voucher-nominal"><?= $grandTotalVoucher; ?></div>
                    </div>
                <?php
                if ($this->config->item('ACTIVE_FITUR_POINT_REWARDS') == true) {
                ?>
                    <div class="form-group text-only">
                        <span class="col-sm-5 col-xs-offset-1" style="text-align: right">Nilai Poin Anda Sekarang</span>
                        <span class="col-sm-5"><?=$pointUser;?> poin (<span style="color: #ed1b24">1 poin = Rp <?=number_format($this->config->item('POINT_REWARDS_RUPIAH'),0, ",", ".");?></span>)</span>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-xs-5 col-xs-offset-1 control-label">Masukkan nilai poin yang Anda redeem:</label>
                        <div class="col-sm-5">
                            <div class="control-check">
                                <input type="text" class="form-control" id="poin_input_user" name="poin_input_user" value="<?= !empty($codeVoucherMember) ? $codeVoucherMember : ""; ?>" <?= !empty($codeVoucherMember) ? "disabled='disabled'" : ""; ?>>
                                <button class="control-button ir" id="confirm-point-user">Confirm</button>
                                <button class="control-button reset ir" id="reset-point-user">Reset</button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                    <div class="form-group text-only">
                        <div class="col-sm-5 col-xs-offset-1" style="text-align: right">Total Produk</div>
                        <div class="col-sm-3">Rp</div>
                        <div class="col-md-2" align="right"><?= $grandTotalProduk; ?></div>
                    </div>
                    <div class="form-group text-only">
                        <span class="col-sm-5 col-xs-offset-1" style="text-align: right">Biaya Pengiriman</span>
                        <div class="col-sm-3">Rp</div>
                        <div class="col-md-2" align="right"><?= $grandTotalOngkir; ?></div>
                    </div>
                    <div class="form-group text-only">
                        <span class="col-sm-5 col-xs-offset-1" style="text-align: right">Total Pembayaran</span>
                        <div class="col-sm-3 final-price">Rp</div>
                        <div class="col-md-2 final-price" align="right"><?= $grandTotalAll; ?></div>
                    </div>
                </div>

            </div> 

            <form method="POST" action="<?= base_url() ?>checkout" class="formPostPayment">
                <div class="col-xs-6">
                    <div class="panel-group payment-method-accordion" id="accordion" role="tablist">
                        <?php
                        $index = 1;
                        if (!empty($listPayment)) {
                            foreach ($listPayment as $k => $v) {
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading<?= $k; ?>">
                                        <input class="pilih_payment<?= $v->id; ?>" type="radio" id="pilih_payment<?=$v->id;?>" name="pilih_payment" value="<?= $v->id; ?>" <?= $v->id == 11 ? 'checked="checked"' : ""; ?>/>
                                        <label for="pilih_payment<?=$v->id;?>" class="radio inline" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $v->id; ?>" >
                                            <?= $v->payment; ?>
                                        </label>
                                    </div>
                                    <div id="collapse<?= $v->id; ?>" class="panel-collapse collapse <?= $v->id == 11 ? 'in' : ''; ?>" role="tabpanel" aria-labelledby="heading<?= $v->id; ?>">
                                        <div class="panel-body layout-payment<?= $v->id; ?>">
                                            <?php 
                                            if (!file_exists('application/views/publik/ui2/payment/'.$v->id.'_v.php')) {
                                                echo $v->payment;
                                            } else {
                                                include('application/views/publik/ui2/payment/'.$v->id.'_v.php');
                                            }
                                            ?> 
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading" align="center">
                                    <label class="radio inline">
                                        Metode Pembayaran tidak Tersedia
                                    </label>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="troli-action"> 
                        <input type="hidden" id="input_id_payment" name="input_id_payment"/>
                        <button onclick="if (typeof ga !== 'undefined') {ga('send', 'event', 'button', 'click', 'pay button');}" value="checkout" type="submit" class="btn btn-lanjut" name="submit" id="lanjutkan" <?= $buttonConfirmPayment; ?>>Lanjutkan Pembayaran</button>
                    </div>
                </div> 
            </form>
        </div>

    </div>
</section>
<script>
function load_kabupaten(idpropinsi, container_kabupaten, nama_input_kabupaten, key)
{
    var propinsi = $('.' + idpropinsi).val();
    $('.' + container_kabupaten).html("Loading...");
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('lokasi/ajax_dropdown_kabupaten/')?>/"+key,
        data: "id_propinsi=" + propinsi + "&nama_input_kabupaten=" + nama_input_kabupaten,
        success: function (result) {
            $('.' + container_kabupaten).html(result);
        }
    });
}

function load_kecamatan(idkabupaten, container_kecamatan, nama_input_kecamatan, key)
{
    var kabupaten = $('.' + idkabupaten).val();
    $('.' + container_kecamatan).html("Loading...");
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('lokasi/ajax_dropdown_kecamatan')?>/"+key,
        data: "id_kabupaten=" + kabupaten + "&nama_input_kecamatan=" + nama_input_kecamatan,
        success: function (result) {
            $('.' + container_kecamatan).html(result);
        }
    });
}
</script>

<?= $this->load->view('publik/ui2/footer') ?>
