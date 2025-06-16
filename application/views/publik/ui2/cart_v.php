<?php $this->load->view('publik/ui2/header')?>
<section class="main">

<div class="trolibox container">
    
    <?php if($this->cart->total_items()!=0){ ?>
          <h3>Anda telah berbelanja <strong class="total-item"><?=$this->cart->total_items();?></strong> produk dari <strong><?=count($cart)?></strong> merchant</h3>
        <?php } else { ?>
          <h4>Anda belum memiliki produk di Keranjang Belanja.</h4>
            <p>Silahkan pilih dan masukan produk yang akan Anda beli terlebih dahulu.</p>
        <?php } ?>
        <?php if($this->input->get('error')=='minimal_order'){ ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Minimal Pembelian Rp. <?= $this->config->item('minimal_order') ?>
          </div>
        <?php } ?>
        <?php if(!empty($suggest)){ ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php 
            foreach($suggest as $message) {
                echo $message.'<br>';
            }
            ?>
          </div>
        <?php } ?>
    <?php $grand_total = 0;$i=0;foreach ($cart as $key => $value) { ?>
    <div class="troli-item">
        <?php $merchant = $this->cart_m->get_merchant($key); ?>
        <div><small>Merchant: <a href="<?=base_url()?>store/id/<?=$merchant->id_user?>"><?= htmlspecialchars(ucwords($merchant->nama_store)) ?></a></small></div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk &amp; Detail</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $berat=0;
                $totalharga=0;
                foreach ($value as $row) { 
                ?>
                <?php 
                if(!empty($row['stock_available'])){
                    $max_item = $row['stock_available'];                    
                } elseif(!empty($row['stok'])) {
                    $max_item = $row['stok'];
                }
                
                if ($merchant->merchant_voucher_reload == "Y") {
                    $max_item = 1;
                }
                if (in_array($key, $this->config->item('merchant_product_software'))) {
                    $max_item = 1;
                }
                
                if(isset($row['id_produk'])){
                    $id_produk = $row['id_produk'];
                } else {
                    $id_produk = $row['id'];
                }
                ?>
                <tr>
                    <td style="width:250px;">
                        <a href="<?=base_url()?>product/detail/<?=$row['id_produk']?>/<?=htmlspecialchars($row['name']);?>">
                        <img src="<?=base_url();?>asset/pict.php?src=<?=$row['image'];?>&w=82&h=82&z=1">
                        <span class="product-name" style="width: 500px;">
                            <b><?=htmlspecialchars($row['name']);?></b>
                            <br>
                            <?=htmlspecialchars($this->cart_m->getDetailPaketByIdProduk($row['id_produk']))?>
                        </span>
                        </a>
                    </td>
                    <td style="width:50px;">
                        <select class="cart-item-quantity" data-id="<?=$row['rowid'];?>" data-idmerchant="<?=$merchant->id_user?>">
                            <?php for($j=1;$j<=$max_item && $j<=100;$j++) { ?>
                                    <option value="<?=$j;?>" <?=($j==$row['qty'])?'selected':'';?>><?=$j;?></option>
                            <?php
                            } ?>
                        </select>
                    </td>
                    <td style="width:100px;">
                        <span class="force-right"><a class="hapus" href="#" data-row-id="<?=$row['rowid']?>" title="Hapus"><i class="fa fa-trash-o fa-lg" style="font-size:20px;"></i></a></span>
                        <?php if(!empty($row['discount'])){ ?>
                        <?php $totalharga += ($row['price']*$row['qty']) ?>
                        <span class="troli-price-now<?=$row['rowid']?>">Rp <?=$this->cart->format_number(($row['price']*$row['qty']));?></span><br>
                        <span class="troli-price"><span><del class="troli-price-del<?=$row['rowid']?>">Rp <?=$this->cart->format_number($row['harga']*$row['qty']);?></del></span><br>
                        <span class="troli-diskon"><strong class="icon-diskon"></strong> Diskon <?=$row['discount'];?>%</span>
                        <?php } else { ?>
                            <?php $totalharga += ($row['harga']*$row['qty']) ?>
                        <span class="troli-price-now<?=$row['rowid']?>">Rp <?=$this->cart->format_number($row['harga']*$row['qty']);?></span><br>    
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="2" align="right">Total Harga : </td>
                    <td><span class="total-harga" id="total-harga-marchant-<?=$merchant->id_user?>">Rp <?=$this->cart->format_number($totalharga)?></span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php } ?>
    
    <?php if(!empty($cart)){ ?>

    <div class="troli-action"> 
        <a class="btn kembali-belanja" href="<?=base_url()?>" style="float:left;">&lt; Kembali Belanja</a>
        <?php if(!$this->session->userdata('member')){ ?>
        <button class="btn btn-lanjut" data-toggle="modal" data-target="#register-login-form">Lanjut Pembayaran</button>    
        <?php } else { ?>
        <form action="<?=base_url()?>cart" method="POST">
        <button class="btn btn-lanjut" type="submit" name="btn-goto-billing" value="1">Lanjut Pembayaran</button>
        </form>
        <?php } ?>
    </div>
    
    <?php } else { ?>
    
    <div class="other-action"> 
        <a class="btn kembali-belanja" href="<?=base_url()?>">&lt; Kembali Belanja</a>
    </div>
    
    <br><br><br><br><br><br><br><br><br><br>
        
    <?php } ?>

</div>

</section>
<?php $this->load->view('publik/ui2/footer')?>
<script src="<?=base_url()?>asset/ui2/js/numeral.min.js"></script>
<script>
$(document).on('click', '.hapus', function(e) {
    e.preventDefault();
    var rowid = $(this).attr('data-row-id');
    $.post("<?=base_url()?>cart/delete_ui2", {rowid:rowid}, function(result){
        window.location = result;
    });
});
    
/*
* START UPDATE CART
*/
    function TotalHarga(idMerchant)
    {
        $.post('<?=base_url()?>cart/totalharga' , {idMerchant: idMerchant},
        function(resp) {
            var Total = numeral(resp).format('0,0');
            $("#total-harga-marchant-"+idMerchant).html('Rp '+Total.replace(',', '.'));
        });
    }
    
    function rupiahToInteger(rupiah)
    {
      rupiah = rupiah.replace('.', '');
      rupiah = rupiah.replace('Rp ', '');
      rupiah = parseInt(rupiah);
      return rupiah;
    }

  $('.cart-item-quantity').change(function(){
    var quantity = $(this).val();
    var id = $(this).data().id;
    var idmerchant = $(this).data().idmerchant;
    var domRow = $(this);
    var url = secure_base_url + index_page + 'cart/update';
    var hargaSebelum = $('.troli-price-now'+id).html();

    $.post(url , {rowid: id, qty: quantity},
      function(resp) {
          var trParent = $(domRow).parent().parent();
          var price = trParent.data().price;
          var total = Number(price * quantity).toLocaleString();
          trParent.find('.price-total').text(total);
      /** hitung total semua di cart **/
          var grandTotal = 0;
                var TotalWeight = 0;
          tbody=$(domRow).parent().parent().parent();
          tbody.find('.row-item').each(function(index) {
              quantityItem = $(this).find('.cart-item-quantity').val();
              priceItem = $(this).data().price;
                    weightItem = $(this).data().berat;
              grandTotal = grandTotal + (quantityItem * priceItem);
                    TotalWeight = TotalWeight + (quantityItem * weightItem);
          });
          tbody.find('.grand-total').text(Number(grandTotal).toLocaleString());
          $('.shopping-item').html(resp.qty);
          $('.total-item').html(resp.qty);
          
          var priceNow = numeral(resp.qty_item*resp.price).format('0,0');
          var priceDel = numeral(resp.qty_item*resp.harga).format('0,0');
          $('.troli-price-now'+id).html('Rp '+priceNow.replace(',', '.'));
          $('.troli-price-del'+id).html('Rp '+priceDel.replace(',', '.'));

          if(resp.redirect == 'yes') {
              window.location= '<?=base_url()?>cart';
          }
          
          TotalHarga(idmerchant);
    }, 'json');
    
  });
  /**
  END UPDATE CART
  **/
</script>
