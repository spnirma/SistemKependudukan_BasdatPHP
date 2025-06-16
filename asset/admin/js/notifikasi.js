var x = 1;

function cek(){
    $.ajax({
        url: base_url + "ajax/cek_order",
        cache: false,
        success: function(msg){
            if(msg>0){
                $("#count-notifikasi-order").html(msg);
            }else{
                $("#count-notifikasi-order").css('display', 'none');
            }
        }
    });

    $.ajax({
        url: base_url + "ajax/cek_produk",
        cache: false,
        success: function(msg){
            if(msg>0){
                $("#count-notifikasi-produk").html(msg);
            }else{
                $("#count-notifikasi-produk").css('display', 'none');
            }
        }
    });
	
	$.ajax({
        url: base_url + "ajax/cek_merchant",
        cache: false,
        success: function(msg){
            if(msg>0){
                $("#count-notifikasi-merchant").html(msg);
            }else{
                $("#count-notifikasi-merchant").css('display', 'none');
            }
        }
    });
    //var waktu = setTimeout("cek()",3000);
}

$(document).ready(function(){
    //cek();
    $("#order").click(function(){
        $("#loading").show();
        // if(x==1){
        //     $("#pesan").css("background-color","#efefef");
        //     x = 0;
        // }else{
        //     $("#pesan").css("background-color","#4B59a9");
        //     x = 1;
        // }
        // $("#info").toggle();
        //ajax untuk menampilkan pesan yang belum terbaca
        $.ajax({
            url: base_url + "ajax/view_order",
            cache: false,
            success: function(msg){
                $("#loading").hide();
                $("#order-notif").html(msg);
            }
        });

    });

    // $("#content").click(function(){
    //     $("#info").hide();
    //     $("#pesan").css("background-color","#4B59a9");
    //     x = 1;
    // });

    $("#product").click(function(){
        $("#loading").show();
        // if(x==1){
        //     $("#pesan").css("background-color","#efefef");
        //     x = 0;
        // }else{
        //     $("#pesan").css("background-color","#4B59a9");
        //     x = 1;
        // }
        // $("#info").toggle();
        //ajax untuk menampilkan pesan yang belum terbaca
        $.ajax({
            url: base_url + "ajax/view_produk",
            cache: false,
            success: function(msg){
                $("#loading").hide();
                $("#product-notif").html(msg);
            }
        });

    });
	
	$("#merchant").click(function(){
        $("#loading").show();
        // if(x==1){
        //     $("#pesan").css("background-color","#efefef");
        //     x = 0;
        // }else{
        //     $("#pesan").css("background-color","#4B59a9");
        //     x = 1;
        // }
        // $("#info").toggle();
        //ajax untuk menampilkan pesan yang belum terbaca
        $.ajax({
            url: base_url + "ajax/view_merchant",
            cache: false,
            success: function(msg){
                $("#loading").hide();
                $("#merchant-notif").html(msg);
            }
        });

    });

});


