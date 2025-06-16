    </div><!-- /#wrapper  ddfdff-->

    <!-- JavaScript -->
    <script src="<?=base_url();?>asset/admin/js/bootstrap.js"></script>
    <script src="<?=base_url();?>asset/admin/js/jquery-ui.min.js"></script>
    <script src="<?=base_url();?>asset/admin/js/jquery.dataTables.js"></script>

    <!-- Page Specific Plugins -->
    <!--<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
    <!--
    <script src="<?=base_url();?>asset/admin/js/morris.js"></script>
    <script src="<?=base_url();?>asset/admin/js/morris/chart-data-morris.js"></script>
    <script src="<?=base_url();?>asset/admin/js/tablesorter/jquery.tablesorter.js"></script>
    <script src="<?=base_url();?>asset/admin/js/tablesorter/tables.js"></script>

    <script src="<?=base_url();?>asset/admin/ckeditor/ckeditor.js"></script>
    <script src="<?=base_url();?>asset/admin/ckeditor/adapters/jquery.js"></script>
    -->
    <script type="text/javascript">
var base_url = '<?=base_url();?>';
var secure_base_url = '<?php echo $this->config->item('secure_base_url');?>';
var admin_url = '<?=admin_url();?>';
</script>
<script src="<?=base_url();?>asset/admin/js/notifikasi.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/admin/js/select2.js"></script>
<script type="text/javascript">
$(".select2").select2({
    placeholder: "Select a State"
});
</script>
<script type="text/javascript">
//cek number field
  function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if ((charCode > 47 && charCode < 58 ) || charCode == 44 || charCode == 46 || charCode == 8)
        return true;

     return false;
     // alert(charCode);
  }
</script>
<script type="text/javascript">
// cek all
$('.check_all').click(function () {    
  $('input:checkbox').prop('checked', this.checked);    
});
</script>
<script type="text/javascript">
    /**
  AJAX CATEGORY
    **/
    $(document).on('change', '.parent_category, .sub_category', function(){
      var id=$(this).val();
      var i=$(this).data().sub;
      var j=i+1;
      // alert(i);
      $.ajax({
          url: base_url + 'ajax/category',
          type: 'POST',
          data: {id: id, i: i, j: j},
          dataType: 'html',
          success: function (data) {
            // alert(data); 
            $('.sub-category-'+j).empty();
            $('.sub-category-'+j).append(data);
            $('.sub-category-'+j).append('<div class="sub-category-' + (j+1) +'"></div>');
          }
        });
    });

    /**
    END AJAX CATEGORY
    **/
</script>

  <script>
  function fillKota(id) {
    $.getJSON(base_url + "cart/kota?id=" + id,
      "", function (json) {
          $("#select-kota").html("");
          $.each(json, function (index, value) {
              $("#select-kota").append("<option value='" + value.id_kota + "'>" + value.nama_kota + "</option>");
          })
      })
  }

  (function( $ ) { 

    fillKota(1);

    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "" )
          .insertAfter( this.element );

        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },

      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";

        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "form-control" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });

        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },

          autocompletechange: "_removeIfInvalid"
        });
      },
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },

      _removeIfInvalid: function( event, ui ) {
        if ( ui.item ) {
          return;
        }
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
        if ( valid ) {
          return;
        }
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },

      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );

  $(function() {
    $( "#id_kota" ).combobox();
  });
  </script>
  
<script type="text/javascript">
$('.btn-danger').click(function(){
  return confirm('Are you sure delete this item?');
});
</script>
<script>
   function readURL(input) {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function(e) {
               $('#previewHolder').attr('src', e.target.result);
           }

           reader.readAsDataURL(input.files[0]);
       }
   }
   $('#change_pp').click(function(){
      $("#filePhoto").click();
   });
   $("#filePhoto").change(function() {
      readURL(this);
   });
</script>
    <script type="text/javascript">
        $(function() {
            $('.dtpicker').datepicker({changeYear:true, changeMonth:true, showMonthAfterYear:true,dateFormat: 'dd-mm-yy'});
            $(".uitabs").tabs();
            
            oTable = $('.datatable').dataTable({
                "bJQueryUI": false,
                "sPaginationType": "full_numbers"
                });

                $("#change").click(function(){
                    $("#foto").click();
                  });

                $(".pilih").click(function(){
                    $(this).prev().attr('checked',true);
                    $('.pilih').removeClass('selected');
                    $(this).addClass('selected');
                });
        });
    </script>

    <!--
    untuk kalkulasi harga jual otomatis
    -->
    <script type="text/javascript">
//    $('#harga_produk').blur(function(){
//      var val=parseInt($(this).val());
//      $('#harga_jual').val(Math.ceil(((val+(10/100*val))/1000)) * 1000);
//    });
    
    $('#harga_produk').keyup(function(){
      var val1=parseInt($('#harga_produk').val()) || 0;
      var ins=parseInt($('#harga_produk').val()*0.1) || 0;
      var presentase = Math.ceil((ins/val1)*10000)/100;
      $('#insentif_fee').val(ins);
      $('#presentase_insentif').val(presentase);
    });
    $('#harga_produk, #transaction_fee, #shipping_fee').keyup(function(){
    var val1=parseInt($('#harga_produk').val()) || 0;
    var val2=parseInt($('#transaction_fee').val()) || 0;
    var val3=parseInt($('#shipping_fee').val()) || 0;
    var presentase_insentif=parseFloat($('#presentase_insentif').val()) || 0;
    var val4=parseInt($('#insentif_fee').val()) || 0;
    var val5=Math.ceil((val1+val2+val3+val4)/1000) * 1000;
    var val6=Math.ceil((val1+val2+val3+val4)/1000) * 1000 - (val1+val2+val3+val4);
//      $('#harga_jual').val(Math.ceil((val1+val2+val3+val4)/1000) * 1000);
    var insentif_fee = (val1*(presentase_insentif/100))
    var presentase = Math.ceil((val4/val1)*10000)/100;
    $('#harga_jual').val(val5);
    $('#selisih_pembulatan').val(val6);
    $('#insentif_fee').val(insentif_fee);
    $('#presentase_insentif').val(presentase);
    });
    $('#insentif_fee').keyup(function(){
    var val1=parseInt($('#harga_produk').val()) || 0;
    var val2=parseInt($('#transaction_fee').val()) || 0;
    var val3=parseInt($('#shipping_fee').val()) || 0;
    var presentase_insentif=parseFloat($('#presentase_insentif').val()) || 0;
    var val4=parseInt($('#insentif_fee').val()) || 0;
    var val5=Math.ceil((val1+val2+val3+val4)/1000) * 1000;
    var val6=Math.ceil((val1+val2+val3+val4)/1000) * 1000 - (val1+val2+val3+val4);
    var presentase = Math.ceil((val4/val1)*10000)/100;
    $('#harga_jual').val(val5);
    $('#selisih_pembulatan').val(val6);
    $('#presentase_insentif').val(presentase);
    });
    $('#presentase_insentif').keyup(function(){
    var val1=parseInt($('#harga_produk').val()) || 0;
    var val2=parseInt($('#transaction_fee').val()) || 0;
    var val3=parseInt($('#shipping_fee').val()) || 0;
    var presentase_insentif=parseFloat($('#presentase_insentif').val()) || 0;
    var val4 = Math.ceil(val1*(presentase_insentif/100))
    var val5=Math.ceil((val1+val2+val3+val4)/1000) * 1000;
    var val6=Math.ceil((val1+val2+val3+val4)/1000) * 1000 - (val1+val2+val3+val4);
    $('#harga_jual').val(val5);
    $('#selisih_pembulatan').val(val6);
    $('#insentif_fee').val(val4);
    });
    $( document ).ready(function() {
        var val1=parseInt($('#harga_produk').val()) || 0;
        var val4=parseInt($('#insentif_fee').val()) || 0;
        var presentase = Math.ceil((val4/val1)*10000)/100;
        
        if (presentase < 1) {
          $("#presentase_insentif").val("10");
        } else {
          $('#presentase_insentif').val(presentase);
        }
        $("#presentase_insentif").keyup();
    });
    </script>
    <script type="text/javascript">
      $( "#delivery_date" ).datepicker({
        dateFormat: 'dd-mm-yy'
      });
    </script>
    <!--
    untuk ajax kota di ongkir
    -->
    <script type="text/javascript">
    var ajaxku;
    function ajaxkota(id){
        ajaxku = buatajax();
        var url= admin_url + "ongkir/ajax_kota";
        url=url+"?q="+id;
        url=url+"&sid="+Math.random();
        ajaxku.onreadystatechange=stateChanged;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    function ajaxkec(id){
        ajaxku = buatajax();
        var url= admin_url + "ongkir/ajax_kota";
        url=url+"?kec="+id;
        url=url+"&sid="+Math.random();
        ajaxku.onreadystatechange=stateChangedKec;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    function ajaxkel(id){
        ajaxku = buatajax();
        var url= admin_url + "ongkir/ajax_kota";
        url=url+"?kel="+id;
        url=url+"&sid="+Math.random();
        ajaxku.onreadystatechange=stateChangedKel;
        ajaxku.open("GET",url,true);
        ajaxku.send(null);
    }

    function buatajax(){
        if (window.XMLHttpRequest){
        return new XMLHttpRequest();
        }
        if (window.ActiveXObject){
        return new ActiveXObject("Microsoft.XMLHTTP");
        }
        return null;
    }
    function stateChanged(){
        var data;
        if (ajaxku.readyState==4){
        data=ajaxku.responseText;
        if(data.length>=0){
        document.getElementById("kota").innerHTML = data
        }else{
        document.getElementById("kota").value = "<option selected>Pilih Kota/Kab</option>";
        }
        }
    }

    function stateChangedKec(){
        var data;
        if (ajaxku.readyState==4){
        data=ajaxku.responseText;
        if(data.length>=0){
        document.getElementById("kec").innerHTML = data
        }else{
        document.getElementById("kec").value = "<option selected>Pilih Kecamatan</option>";
        }
        }
    }

    function stateChangedKel(){
        var data;
        if (ajaxku.readyState==4){
        data=ajaxku.responseText;
        if(data.length>=0){
        document.getElementById("kel").innerHTML = data
        }else{
        document.getElementById("kel").value = "<option selected>Pilih Kelurahan/Desa</option>";
        }
        }
    }
    </script>
    
<script type="text/javascript">
$('.edit_cat').click(function () {
  $('.select_cat').toggle();
  $('#category-parent').toggle();
});
$('.edit_channel').click(function () {
    $('.select_channel').toggle();
    $('#category-channel').toggle();
});
</script>
<script type="text/javascript">
$('.merchant_toggle').click(function(){
  $('.merchant_box').slideToggle();
  if($(this).html()=='Hide Merchant') $(this).html('Show Merchant');
    else $(this).html('Hide Merchant');
});
</script>

<script type="text/javascript">
  // $( "#tgl_lahir" ).datepicker({dateFormat: 'yy-mm-dd'});
  $( "#tgl_lahir" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange:'-90:+5',
    dateFormat: 'dd-mm-yy'
  });
  $( "#delivery_date" ).datepicker({
    dateFormat: 'dd-mm-yy'
  });
  $( ".tanggal" ).datepicker({
    dateFormat: 'dd-mm-yy'
  });
  
  $( "#date_start" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange:'-90:+5',
    dateFormat: 'dd-mm-yy'
  });
  $( "#date_end" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange:'-90:+5',
    dateFormat: 'dd-mm-yy'
  });
  $( "#date_akhir" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange:'-90:+0',
    dateFormat: 'dd-mm-yy'
  });
  $( "#date_paid_start" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange:'-90:+5',
    dateFormat: 'dd-mm-yy'
  });
  $( "#date_paid_end" ).datepicker({
    changeMonth: true,
    changeYear: true,
    yearRange:'-90:+5',
    dateFormat: 'dd-mm-yy'
  });
</script>
<script type="text/javascript">
$( ".city_auto" ).autocomplete({
  source: <?=$this->auth_m->getCity();?>
});
</script>
<script type="text/javascript">
// var settlement_status = Number($('.settlement_progress').val());
function show_keterangan() {
  if ($('.settlement_progress').val() == 4 || $('.settlement_progress').val() == 5) {
    $('.keterangan_settlement').show();
  }
  else {
    $('.keterangan_settlement').hide();
  }
}
</script>
<script type="text/javascript">
  // $( "#parent_produk" ).autocomplete({
  //   source: function(request, response) {
  //     $.ajax({
  //         url: admin_url + 'produk/getProductName',
  //         type: 'post',
  //         data: {
  //           name: request.term
  //         },
  //         dataType: 'json',
  //         success: function (data) {
  //           response($.map(data, function(v,i){
  //             return {
  //               label: v.nama_produk,
  //                   value: v.id_produk
  //             };
  //           }));
  //         }
  //       });
  //   }
  // });
  
  
    /* Set kolom alasan ditolak show/hide berdasar status produk */
    function toggle_alasan_ditolak(id)
    {
        $status = $('#publish'+id).val();        
        if($status==2){
            $('#alasan'+id).show();
        }else{
            $('#alasan'+id).hide();
        }
    }
</script>

<!-- START INDOLOKA -->
<script type="text/javascript">
  $('#merchant_indoloka').change(function(e) {
    if ($(this).val() != '') {
        $('#indoloka_type').show();
        $('#indoloka_lokasi').show();
        $('#indoloka_telpon_pic').show();
        $('#indoloka_pic').show();
        $('#indoloka_ket').show();
    } else {
        $('#indoloka_type').hide();
        $('#indoloka_lokasi').hide();
        $('#indoloka_telpon_pic').hide();
        $('#indoloka_pic').hide();
        $('#indoloka_ket').hide();
    }
    // $('#indoloka_type').toggle();
    // $('#indoloka_lokasi').toggle();
    // $('#indoloka_telpon_pic').toggle();
    // $('#indoloka_pic').toggle();
  });
  // if ($('#merchant_indoloka').prop('checked')) {
    // $('#indoloka_type').show();
    // $('#indoloka_lokasi').show();
    // $('#indoloka_telpon_pic').show();
    // $('#indoloka_pic').show();
  // }
</script>
<!-- END INDOLOKA -->

 <!-- START AUTOCOMPLETE -->
 <script>
     $("#autocomplete_merchant").autocomplete({
    source: "<?=admin_url()?>merchant/autocomplete",
    minLength: 1,//search after two characters
    select: function(event,ui){
        //do something
        $('#merchant_auto_id').val(ui.item.id);
        }
    });
 </script>
 <!-- END AUTOCOMPLETE -->

<!-- START AUTOCOMPLETE -->
 <script>
     $("#autocomplete_member").autocomplete({
    source: "<?=admin_url()?>member/autocomplete",
    minLength: 1,//search after two characters
    select: function(event,ui){
        //do something
        $('#member_auto_id').val(ui.item.id);
        }
    });
 </script>
 <!-- END AUTOCOMPLETE -->

 <!-- START AUTOCOMPLETE -->
 <script>
     $("#autocomplete_produk").autocomplete({
    source: "<?=admin_url()?>diskon/autocomplete",
    minLength: 1,//search after two characters
    select: function(event,ui){
        //do something
        $('#produk_auto_id').val(ui.item.id);
        }
    });
 </script>
 <!-- END AUTOCOMPLETE -->
 
  <!-- START AUTOCOMPLETE -->
 <script>
     $("#produk_rekomendasi_search").autocomplete({
    source: "<?=admin_url()?>homepage_config/autocomplete",
    minLength: 1,//search after two characters
    select: function(event,ui){
        //do something
        $('#produk_auto_id').val(ui.item.id);
        }
    });
 </script>
 <!-- END AUTOCOMPLETE -->

 <script>
     $("#produk_feature_search").autocomplete({
    source: "<?=admin_url()?>homepage_config/autocomplete_store",
    minLength: 1,//search after two characters
    select: function(event,ui){
        //do something
        $('#produk_auto_id_feature').val(ui.item.id);
        }
    });
 </script>

 <script>
    $("#produk_branded_search").autocomplete({
        source: "<?=admin_url()?>homepage_config/autocomplete_store",
        minLength: 1,//search after two characters
        select: function(event,ui){
            //do something
            $('#produk_branded_id_auto').val(ui.item.id);
        }
    });
 </script>
 <!-- END AUTOCOMPLETE -->
<script type="text/javascript">
$('#id_level').change(function(e){
  if ($(this).val() == 3) {
    $('.akun_bank').show();
  } else {
    $('.akun_bank').hide();
  }
});

</script>
 <!-- START AUTOCOMPLETE -->
 <script>
     $("#complete_member").autocomplete({
    source: "<?=admin_url()?>inbox/autocomplete",
    minLength: 1,//search after two characters
    select: function(event,ui){
        //do something
        $('#auto_inbox_to').val(ui.item.id);
        }
    });
 </script>
 <!-- END AUTOCOMPLETE -->
<script>
    $('#form_nominal_voucher_reload').hide();
    $('#form_provider_voucher_reload').hide();
    $('#form_code_voucher_reload').hide();
    $('#voucher_reload').change(function(){
        if (this.checked) {
            $('#form_nominal_voucher_reload').fadeIn('fast');
            $('#form_provider_voucher_reload').fadeIn('fast');
            $('#form_code_voucher_reload').fadeIn('fast');
        }
        else {
            $('#form_nominal_voucher_reload').fadeOut('fast');
            $('#form_provider_voucher_reload').fadeOut('fast');
            $('#form_code_voucher_reload').fadeOut('fast');
        }                   
    });
    $('#voucher_reload_check').change(function(){
        if (this.checked) {
            $("#nominal_voucher_reload").removeAttr('disabled');
            $("#provider_voucher_reload").removeAttr('disabled');
            $("#code_voucher_reload").removeAttr('disabled');
        }
        else {
            $('#nominal_voucher_reload').prop('disabled', true);
            $('#provider_voucher_reload').prop('disabled', true);
            $('#code_voucher_reload').prop('disabled', true);
        }                   
    });
    $('#voucher_reload_check_modal').change(function(){
        if (this.checked) {
            $("#nominal_voucher_reload_modal").removeAttr('disabled');
            $("#provider_voucher_reload_modal").removeAttr('disabled');
            $("#code_voucher_reload_modal").removeAttr('disabled');
        }
        else {
            $('#nominal_voucher_reload_modal').prop('disabled', true);
            $('#provider_voucher_reload_modal').prop('disabled', true);
            $('#code_voucher_reload_modal').prop('disabled', true);
        }                   
    });
    $('#voucher_reload_variant_check').change(function(){
        if (this.checked) {
            $("#nominal_voucher_reload_variant").removeAttr('disabled');
            $("#provider_voucher_reload_variant").removeAttr('disabled');
            $("#code_voucher_reload_variant").removeAttr('disabled');
        }
        else {
            $('#nominal_voucher_reload_variant').prop('disabled', true);
            $('#provider_voucher_reload_variant').prop('disabled', true);
            $('#code_voucher_reload_variant').prop('disabled', true);
        }                   
    });
    $('#voucher_reload_edit_variant_check').change(function(){
        if (this.checked) {
            $("#nominal_voucher_reload_edit_variant").removeAttr('disabled');
            $("#provider_voucher_reload_edit_variant").removeAttr('disabled');
            $("#code_voucher_reload_edit_variant").removeAttr('disabled');
        }
        else {
            $('#nominal_voucher_reload_edit_variant').prop('disabled', true);
            $('#provider_voucher_reload_edit_variant').prop('disabled', true);
            $('#code_voucher_reload_edit_variant').prop('disabled', true);
        }                   
    });
</script>
<!-- START AUTOCOMPLETE -->
<script>
$("#provider_voucher_reload").autocomplete({
    source: "<?=admin_url()?>produk/autocomplete_provider_voucher_reload",
    minLength: 1,//search after two characters
    select: function(event,ui){
        $('#provider_voucher_reload').val(ui.item.id);
    }
});
$("#provider_voucher_reload_modal").autocomplete({
    source: "<?=admin_url()?>produk/autocomplete_provider_voucher_reload",
    minLength: 1,//search after two characters
    select: function(event,ui){
        $('#provider_voucher_reload_modal').val(ui.item.id);
    }
});
$("#provider_voucher_reload_variant").autocomplete({
    source: "<?=admin_url()?>produk/autocomplete_provider_voucher_reload",
    minLength: 1,//search after two characters
    select: function(event,ui){
        $('#provider_voucher_reload_variant').val(ui.item.id);
    }
});
$("#provider_voucher_reload_edit_variant").autocomplete({
    source: "<?=admin_url()?>produk/autocomplete_provider_voucher_reload",
    minLength: 1,//search after two characters
    select: function(event,ui){
        $('#provider_voucher_reload_edit_variant').val(ui.item.id);
    }
});

</script>
<script>
    $(".berat-alert").blur(function(){
        var berat = $(".berat-alert").val();
        if (parseInt(berat) >= 10) {
            alert("Berat barang melebihi 10kg apakah anda yakin?");
        }
    });
</script>
<!-- END AUTOCOMPLETE -->

  </body>
</html>
