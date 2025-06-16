<?=$this->load->view('publik/ui2/header')?>
        <section class="main">

            <div class="featured-list container">

               <div class="row">
                    <div class="col-xs-12">
                        <div class="aboutbox-item aboutbox-item-static">
                            <h3><span>Hubungi Kami</span></h3>
                            <hr>

                            <?php if(!isset($_GET['s'])):?>
                
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                        
                            <form name="f1" id="f1" method="post" action="">
                                <div class="table-responsive">
                                <table border='0' width='80%' class='tabel static-table'>
                                    <tr>
                                        <td width='20%'></td>                    
                                        <td>
                                            Untuk menghubungi kami, silakan isi form di bawah ini. Anda juga dapat menghubungi kami melalui email <a href="e-care.store@cipika.co.id">e-care.store@cipika.co.id</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width='20%'>Nama</td>                        
                                        <td><input type="text" name="nama" id="nama" value="<?php echo set_value('nama')?>" size="40"></td>
                                    </tr>
                                    <tr>
                                        <td width='20%'>Email</td>                        
                                        <td><input type="text" name="email" id="email" value="<?php echo set_value('email')?>" size="40"></td>
                                    </tr>
                                    <tr valign='top'>
                                        <td width='20%'>Pesan</td>                        
                                        <td><textarea name="pesan" id="pesan" rows="5" cols="60"><?php echo set_value('pesan')?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><?= $this->lib_recaptcha->recaptcha(); ?></td>
                                    </tr>
                                    <tr valign='top'>
                                        <td width='20%'></td>                        
                                        <td>                                
                                            <input type="submit" value="Kirim" name="submit" class="btn btn-success" type="button" onclick="$('#f1').submit()">
                                        </td>
                                    </tr>
                                </table>
                                </div>
                            </form>
                        <?php else:?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Data berhasil disimpan, terima kasih sudah menghubungi kami.
                            </div>
                        <?php endif;?>
            
                        </div>
                    </div>
                </div>

        </section>
<?=$this->load->view('publik/ui2/footer')?>
