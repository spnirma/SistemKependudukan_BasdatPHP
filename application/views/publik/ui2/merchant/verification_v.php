<?=$this->load->view('publik/ui2/header')?>
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
                            <li class="progtrckr-done">Upload Produk</li>
                            <li class="progtrckr-done">Verifikasi</li>
                        </ol>
                        <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Verifikasi Merchant</span></h3>
                            <hr>
                            <div class="checkout_step1">
                                <?php 
                                if($this->input->get('notif')=="new") {
                                    ?> 
                                <div class='alert alert-success alert-dismissable' align="center">
                                <strong>Registrasi Merchant Berhasil Terkirim!</strong> Tim Cipika Store akan menghubungi anda untuk verifikasi. <br>
                                Untuk memonitor status verifikasi, silahkan cek menu <strong>STATUS</strong> di akun Seller Anda. Terima kasih
                                </div>
                                    <?php
                                } else {
                                    if($merchant->store_status == "pending"):
                                        ?>
                                    <div class='alert alert-warning alert-dismissable' align="center">
                                        Menunggu Proses Verifikasi
                                    </div>
                                        <?php
                                    elseif($merchant->store_status == "review"):
                                        ?>
                                    <div class='alert alert-warning alert-dismissable' align="center">
                                        Dalam proses verifikasi
                                    </div>
                                        <?php
                                    elseif($merchant->store_status == "approve"):
                                        ?>
                                    <div class='alert alert-success alert-dismissable' align="center">
                                        Verified
                                    </div>
                                        <?php
                                    elseif($merchant->store_status == "block"):
                                        ?>
                                    <div class='alert alert-danger alert-dismissable' align="center">
                                        Unverified
                                    </div>
                                        <?php
                                    endif;
                                    }
                                ?>
                            <div class="table-responsive">
                              <table class="table table-hover table-striped tablesorter datatable">
                                  <tr>
                                      <td>Nama Merchant</td>
                                      <td><?php echo htmlspecialchars($merchant->nama_store)?></td>
                                  </tr>
                                  <tr>
                                      <td>Nama Pemilik</td>
                                      <td><?php echo htmlspecialchars($merchant->nama_pemilik)?></td>
                                  </tr>
                                  <tr>
                                      <td>Tgl Lahir</td>
                                      <td><?php echo htmlspecialchars($merchant->tgl_lahir_pemilik)?></td>
                                  </tr>
                                  <tr>
                                      <td>Telepon</td>
                                      <td><?php echo htmlspecialchars($merchant->merchant_telpon)?></td>
                                  </tr>
                                  <tr>
                                      <td>Hp</td>
                                      <td><?php echo htmlspecialchars($merchant->merchant_hp)?></td>
                                  </tr>
                                  <tr>
                                      <td>Email</td>
                                      <td><?php echo htmlspecialchars($merchant->email)?></td>
                                  </tr>
                                  <tr>
                                      <td>Bank</td>
                                      <td><?php echo htmlspecialchars($merchant->merchant_bank_nama).'<br/>'.htmlspecialchars($merchant->merchant_bank_norek).'<br/>'.htmlspecialchars($merchant->merchant_bank_pemilik)?></td>
                                  </tr>
                              </table>
                          </div>
                        </div>
                    </div>
                </div>

        </section>
<script type="text/javascript">
    $(window).load(function(){
        $("ol.progtrckr").each(function(){
            $(this).attr("data-progtrckr-steps", 
                         $(this).children("li").length);
        });
    })
</script>
<?=$this->load->view('publik/ui2/footer')?>
