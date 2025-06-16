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
                            <h3><span>Edit Order</span></h3>
                            <hr>
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $error?>
                                </div>
                            <?php endif ?>
                                
                            <?php if(!$editable):?>
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    Maaf order ini sudah tidak bisa di edit.
                                </div>
                            <?php endif ?>

                            <div class="col-lg-12">
                     
                              <div class="table-responsive">
                                  <table class="table datatable table-hover table-striped tablesorter">                            
                                      <tbody>
                                          <tr>
                                              <td width="25%">Tgl Order</td>
                                              <td><?php echo strftime("%d-%m-%Y %H:%M:%S",strtotime($order['order']->order_date))?></td>
                                          </tr>
                                          <tr>
                                              <td>Kode Order</td>
                                              <td><?php echo htmlspecialchars($order['order']->kode_order) ?></td>
                                          </tr>                                    
                                          <tr>
                                              <td>Status Pembayaran</td>
                                              <td><?php echo htmlspecialchars(status_payment_label($order['order']->status_payment)) ?></td>
                                          </tr>                                                                        
                                          <tr>
                                              <td>Status Pengiriman</td>
                                              <td><?php echo htmlspecialchars(status_delivery_label($order['order']->status_delivery)) ?></td>
                                          </tr>
                                          <tr>
                                              <td>Biaya Pengiriman Maximum</td>
                                              <td>Rp. <?php echo format_uang($order['order']->original_shipping_fee).'&nbsp;( '. htmlspecialchars($order['order']->shipping_vendor) . ' : '. htmlspecialchars($order['order']->paket_ongkir) .')'; ?></td>
                                          </tr>
                                          <tr>
                                              <td>Pembeli</td>
                                              <td>
                                                  <?php 
                                                      echo htmlspecialchars($order['shipping']->nama) .'<br/>'.
                                                           htmlspecialchars($order['shipping']->alamat) .'<br/>'.
                                                           htmlspecialchars($order['shipping']->destination_kecamatan.','.$order['shipping']->destination_kabupaten.','.$order['shipping']->destination_propinsi) .'<br/>'.
                                                           htmlspecialchars($order['shipping']->telpon) .'<br/>'.
                                                           htmlspecialchars($order['shipping']->email) .'<br/>';
                                                  ?>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>Barang</td>
                                              <td>
                                                  <?php 
                                                      if(!empty($order['items'])){
                                                          $no = 0;
                                                          echo "<table border='0' width='100%'>".
                                                                  "<tr>".
                                                                      "<th width='5%'>No</th>".
                                                                      "<th width='45%'>Nama</th>".
                                                                      "<th width='20%'>Harga (Rp)</th>".
                                                                      "<th width='10%'>Jumlah</th>".
                                                                      "<th width='20%'>Total (Rp)</th>".
                                                                  "</tr>";
                                                          foreach($order['items'] as $row){
                                                              $no++;
                                                              echo "<tr style='vertical-align:top'>".
                                                                      "<td>".$no."</td>".
                                                                      "<td>". htmlspecialchars($row->nama_produk) ."<br /><i>". htmlspecialchars($row->detail_paket) ."</i></td>".
                                                                      "<td>".format_uang($row->harga_merchant)."</td>".
                                                                      "<td>".$row->jml_produk."</td>".
                                                                      "<td>".format_uang($row->harga_merchant * $row->jml_produk)."</td>".
                                                                   "</tr>";   
                                                          }
                                                          echo "</table>";
                                                      }                                                
                                                  ?>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                                  <br/><br/>
                                  
                                  <?php
                                      $readonly = "class='readonly' readonly";
                                  ?>
                                  <form name="f1" method="post" action="<?php echo base_url('merchant/update_order')?>" <?php echo ($editable)?'':"disabled='true'"?>>
                                      <table class="table datatable table-hover table-striped tablesorter">                                    
                                          <tr>
                                              <td>Shipping Vendor</td>
                                              <td>
                                                  <?php
                                                      $sv = set_value('shipping_vendor',$order['order']->shipping_vendor_merchant);
                                                  ?>
                                                  <select name='shipping_vendor' <?php echo ($editable)?'':"disabled='true'"?>>
                                                      <option value=''>-- Pilih Shipping Vendor --</option>
                                                      <option value='JNE' <?php echo ($sv=='JNE')?'selected':''?>>JNE</option>
                                                  </select>
                                                  <?php
                                                      if($sv!=''){
                                                          echo "<input type='hidden' name='shipping_vendor' value='".$sv."'>";
                                                      }
                                                  ?>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>Paket Ongkir</td>
                                              <td>
                                                  <?php 
                                                      $pk = set_value('paket_ongkir_merchant',$order['order']->paket_ongkir_merchant);                                                
                                                  ?>
                                                  <select name='paket_ongkir_merchant' <?php echo ($editable)?'':"disabled='true'"?>>                                                
                                                      <option value=''>-- Pilih Paket Pengiriman --</option>
                                                      <option value='YES' <?php echo ($pk=='YES')?'selected':''?>>YES</option>
                                                      <option value='REG' <?php echo ($pk=='REG')?'selected':''?>>REG</option>
                                                      <option value='OKE' <?php echo ($pk=='OKE')?'selected':''?>>OKE</option>
                                                      <option value='CTCYES' <?php echo ($pk=='CTCYES')?'selected':''?>>CTCYES</option>
                                                  </select>
                                                  <?php
                                                      if($pk!=''){
                                                          echo "<input type='hidden' name='paket_ongkir_merchant' value='".$pk."'>";
                                                      }
                                                  ?>
                                                  
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>Ongkir (Rp)</td>
                                              <td>
                                                  <input type="text" name="ongkir_merchant" id="ongkir_merchant" value="<?php echo set_value('ongkir_merchant',$order['order']->ongkir_merchant)?>" <?php echo ($editable)?'':"disabled='true'"?>>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>No Resi pengiriman</td>
                                              <td>
                                                  <input  type="text" name="noresi" id="noresi" value="<?php echo set_value('noresi',$order['order']->noresi)?>" <?php echo ($editable)?'':"disabled='true'"?>>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td>Tgl Kirim</td>
                                              <td>                                            
                                                  <?php                                                
                                                      switch($order['order']->delivery_date){
                                                          case '':
                                                              $delivery_date = '';
                                                              break;
                                                          case '0000-00-00':
                                                              $delivery_date = '';
                                                              break;
                                                          default:
                                                              $delivery_date = strftime("%d-%m-%Y",strtotime($order['order']->delivery_date));
                                                              break;
                                                      }
                                                  ?>
                                                  <input <?php echo ($editable)?'':"disabled='true'"?> type="text" name="delivery_date" id="delivery_date" value="<?php echo set_value('delivery_date',$delivery_date)?>" class='dtpicker'> (tgl-bulan-tahun)
                                              </td>
                                          </tr>
                                      </table>
                                      <button <?php echo ($editable)?'':"disabled='true'"?> value="1" name="simpan" type="submit" class="btn btn-primary pull-right">Update</button>
                                      <input type="hidden" name="id_order" value="<?php echo $order['order']->id_order?>">
                                      <input type="hidden" name="redirect" value="<?php echo $redirect?>">
                                      <input type="hidden" name="status_delivery" value="<?php echo htmlspecialchars($order['order']->status_delivery) ?>">
                                  </form>
                                  
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
<?=$this->load->view('publik/ui2/footer')?>
