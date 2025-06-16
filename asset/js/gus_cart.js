$(document).ready(function (){
	nama_regex = /^[a-zA-Z ]{0,70}$/;
	email_regex = /^([\w-]+(?:\.[\w-]+)*)\@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$|(\[?(\d{1,3}\.){3}\d{1,3}\]?)$/;  
	
	/**
	START CART
	**/
	$(document).on('click', '.add-to-cart-detail', function(e) {
	    e.preventDefault();
		$('html, body').animate({scrollTop : 0},800);
	    var $productTile = $(this).parents('.product-tile');
	    var productId = $productTile.attr('data-product-id');
	    var url = secure_base_url + index_page + 'cart/add';
	    $.ajax({
	        url: url,
	        type: "POST",
	        data: {id_produk: productId},
	        dataType: "json",
		    success: function(data) {
		            var quantityCount = 0;
	                quantityCount = data.qty;	
		            $('.view-cart-count').html(quantityCount);
		        }
		    });
	});

	$(document).on('click', '.add-to-cart', function(e) {
	    e.preventDefault();
		
		//google event tracking script
		if (typeof ga !== 'undefined') {ga('send', 'event', 'button', 'click', 'add to cart button');}
	    
		var $productTile = $(this).parents('.product-tile');
	    var productId = $productTile.attr('data-product-id');
	    var url = base_url + index_page + 'cart/add';

	    $.ajax({
	        url: url,
	        type: "POST",
	        data: {id_produk: productId},
	        dataType: "json",
	        beforeSend: function() {
	            var $viewCart = $('.view-cart:visible');

                if ($viewCart.size() == 0) {
                    return;
                }
	            
                var offset = $viewCart.offset();

	            //var elem = $productTile.parent().clone();
	            var elem = $('.image-clone').clone();

	            elem.css('position', 'absolute');
	            elem.css('z-index', '9999');
	            //elem.css('left', $productTile.parent().offset().left);
	            elem.css('left', $('.image-clone').offset().left);
	            //elem.css('top', $productTile.parent().offset().top);
	            elem.css('top', $('.image-clone').offset().top);
	            elem.appendTo('body');
	            elem.animate({
	                opacity: 0.3,
	                left: offset.left + ($viewCart.outerWidth() / 2),
	                top: offset.top + ($viewCart.outerHeight() / 2),
	                height: 0,
	                width: 0,
	            }, 1000, function() {
	                elem.remove();
	            });
	        },
	        success: function(data) {
	            var quantityCount = 0;
                quantityCount = data.qty;	
	            $('.view-cart-count').html(quantityCount);
	        }
	    });

	});
	/**
	END CART
	**/

	/**
	START INFINITE SCROLL
	**/
       if(empty_infinite == 0){
	$('.product-thumb-price').each(function() {
		// $(this).append('<a class="add-to-cart label label-warning" href="#"><i class="glyphicon glyphicon-shopping-cart"></i> Beli</a>');
	});

	var infiniteScrollXhr;
	var endOfPage = false;
	var handleScroll = 
	function() {
		var $target = $(this);
		var heightOffset = 10;
		var shouldLoadContent = $target.scrollTop() + heightOffset >= $(document).height() - $target.height();

		if (!shouldLoadContent) {return;}
		if (infiniteScrollXhr && infiniteScrollXhr.readyState != 4) {return;}
		if (endOfPage) {return;}
		$('.infinite-scroll-loader').remove();
		$('.product-thumb-row').parent().append('<div class="row infinite-scroll-loader" style="overflow: hidden; padding-top: 100px; height: 200px; margin: 0 auto; text-align: center"><div class="circles">Loading...</div></div>');

		var itemSize = $('.product-thumb-row').children('.product-thumb-item').size();
		var nextPage = Math.ceil(itemSize / 15) + 1;

		infiniteScrollXhr = $.ajax({
		    url: window.location.href,
		    data: {sc: nextPage},
		    success: function(data) {
		        if (data == '') {
		            endOfPage = true;
		            // TODO tombol refresh
		            $('.infinite-scroll-loader').remove();
		            return;
		        }
		        $('.product-thumb-row').append($('.product-thumb-row', data).html());
		        $('.infinite-scroll-loader').remove();
		        // $('.product-thumb-price').each(function() {
		        //     if ($(this).children('.add-to-cart').size() > 0) {
		        //         return;
		        //     }
		        //     $(this).append('<a class="add-to-cart label label-warning" href="#"><i class="glyphicon glyphicon-shopping-cart"></i> Beli</a>');
		        // });
		    }
		});
	};

	$(window).scroll(handleScroll);
	handleScroll();
    }
    /**
    END INFINITE SCROLL
    **/


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

    /**
	AJAX CHANNEL
    **/
    $(document).on('change', '.parent_channel ', function(){
    	var id=$(this).val();
    	// alert(i);
    	$.ajax({
    			url: base_url + 'ajax/channel_kategori',
    			type: 'POST',
    			data: {id: id},
    			dataType: 'html',
    			success: function (data) {
    				// alert(data);	
    				$('.channel-category').empty();
    				$('.channel-category').append(data);
    			}
    		});
    });

    /**
    END AJAX CHANNEL
    **/


    /**
    START COMMENT
	**/
    // $('#btn-send-comment').on('click', function(e) {
    //     e.preventDefault();

    //     var commentText = $('.input-comment').val();
    //     var productId = $('.product-overview').attr('data-product-id');
        
    //     $.ajax({
    //         url: "/product/product/post-comment",
    //         method: "POST",
    //         data: {"product-id": productId, "comment": commentText},
    //         success: function(response) {
    //             if (response.status && response.status == 1) {
    //                 var newComment = $('<li><section class="comment-item clearfix"><div class="comment-avatar"></div><div class="comment-detail"><h4 class="comment-author"></h4></div></section></li>');

    //                 if (response.comment.user.avatar) {
    //                     newComment.find('.comment-avatar').append('<img style="height: 70px; width: auto" class="img-responsive img-rounded" src="http://distilleryimage.shoop.s3.amazonaws.com/' + response.comment.user.avatar + '" />');
    //                 } else {
    //                     newComment.find('.comment-avatar').append('<img style="height: 70px; width: auto" class="img-responsive img-rounded" src="/img/no-avatar-single.png"" />');
    //                 }

    //                 newComment.find('.comment-author').html(response.comment.user.name);
    //                 newComment.find('.comment-detail').append('<p>' + response.comment.comment + '</p>');
    //                 newComment.find('.comment-detail').append('<p class="small"><time>' + response.comment.time + '</time></p>');
                    
    //                 newComment.hide();
    //                 $('#comment-list').append(newComment);
    //                 newComment.fadeIn('slow');

    //                 $('.box-comments .comment-count').html(parseInt($('.box-comments .comment-count').html()) + 1);
    //                 $('.input-comment').val('');
    //             }
    //         }
    //     });
    // });

	/**
	**/

/************************************************************************************************************
************************************************************************************************************/

	$('input.input_beli').keyup(function(){
		var stok = ($(this).attr('data-stok'));
		var inputan = ($(this).attr('id'));
		if( $('#' + inputan).val() > stok) {
			alert('Maaf stok yang tersedia hanya '+ stok +'. Jadi tidak memenuhi permintaan Anda'); 
			$('#' + inputan).val('');
		}
	});
	
	
	$('#form_pembelian').submit(function(){
		$('html, body').animate({scrollTop : 0},800);
		var asalX = $('#gambarnya').offset().left;
		var asalY = $('#gambarnya').offset().top;
		var tujuanX = $('#shop_cart').offset().left;
		var tujuanY = $('#shop_cart').offset().top - ($("#gambarnya").height()/3);
		var url        =  base_url + index_page + 'p/beli';
		var dataq       = $(this).serialize();
		var newImageWidth   = $("#gambarnya").width() / 4;
		var newImageHeight  = $("#gambarnya").height() / 4;
		
		$('#gambarnya')
			.clone()
			.prependTo("#big_image_container")
			.css({'position':'absolute', 'z-index':'9999'})
			.animate({opacity: 0.05, marginLeft: -tujuanX, marginTop: tujuanY, width: newImageWidth, height: newImageHeight}, 1200, function() {
				$(this).remove();
				$('#ajak_loading').show();
				jQuery.ajax({  
					type: "POST",  
					url: url,
					dataType : 'json',
					data: dataq,
					success: function (resp) {
					  if(resp != "kosong" && resp != "kelebihan" ){
						$('#cart-empty').hide('slow');
						$('#ajak_loading').hide();
						if(resp.options.exist) {$('#list_order tr#'+ resp.id ).remove(); }
						$('#total_cart').remove();
						$('#total_cart').remove();
						$('#list_order').append('<tr id="'+ resp.id +'" class="garis_bawah"><td class="center">'+ resp.options.id_barang +'<br>'+ resp.options.warna +'</td><td class="center"><strong>'+ resp.qty + '</strong></td><td class="right">Rp. '+ resp.price * resp.qty+'</td></tr>');
						$('#list_order').append('<tr id="total_cart" class="right"><td colspan="3">Total = Rp. '+resp.jumlah_belanja +'</td></tr>');
						$('#list_order').append('<tr id="total_cart" class="center"><td colspan="3"><a href="'+ base_url + index_page +'p/keranjang_belanja'+ url_suffix +'"><img src="'+ base_url  + 'asset/publik/images/checkout_btn.png" width="78" height="23" alt="Proses pembayaran"></a></td></tr>');
					  }else if(resp == "kosong") {$('#ajak_loading').hide();
						$('#cart-empty').html('Anda belum menginputkan data sama sekali');
					  }
					  else {$('#ajak_loading').hide();
						$('#cart-empty').html('Stok kami ada yang kurang');
					  }
					}
				});
			});
		return false;
	});

	$('.form_login').submit(function(){
		var hs = false;
		var em = $('#email');
		var ps = $('#password');
		if(em.val()==''){alert('Email tidak boleh kosong'); em.focus(); hs = false;}
		else if(! email_regex.test(em.val())){alert('Email tidak valid'); em.focus(); hs = false;}
		else if(ps.val()==''){alert('Password tidak boleh kosong'); ps.focus(); hs = false;}
		else {hs = true;}
		return hs;
	});
	
	$('.newsletter_form').submit(function(){
		var hs = false;
		var em = $('#email');
		if(em.val()==''){alert('Email tidak boleh kosong'); em.focus(); hs = false;}
		else if(! email_regex.test(em.val())){alert('Email tidak valid'); em.focus(); hs = false;}
		else {hs = true;}
		return hs;
	});
	
	$('.form_register').submit(function(){
		var hs = false;
		var nd = $('#nama_depan');
		var em = $('#email_reg');
		var ps1 = $('#password1');
		var ps2 = $('#password2');
		var kt = $('#kota');
		var tlp = $('#no_telp');
		var al = $('#alamat');
		if(nd.val()==''){alert('Nama Depan tidak boleh kosong'); nd.focus(); hs = false;}
		else if(em.val()==''){alert('Email tidak boleh kosong'); em.focus(); hs = false;}
		else if(! email_regex.test(em.val())){alert('Email tidak valid'); em.focus(); hs = false;}
		else if(ps1.val()==''){alert('Password tidak boleh kosong'); ps1.focus(); hs = false;}
		else if(ps2.val()==''){alert('Password tidak boleh kosong'); ps2.focus(); hs = false;}
		else if(ps2.val()!=ps1.val()){alert('Password tidak sama'); ps2.focus(); hs = false;}
		else if(kt.val()==''){alert('Kota tidak boleh kosong'); kt.focus(); hs = false;}
		else if(tlp.val()==''){alert('Telpon tidak boleh kosong'); tlp.focus(); hs = false;}
		else if(al.val()==''){alert('Alamat tidak boleh kosong'); al.focus(); hs = false;}
		else {hs = true;}
		return hs;
	});
	
	$('.form_kontak').submit(function(){
		var hs = false;
		var nm = $('#nama');
		var em = $('#email');
		var kt = $('#kota');
		var ps = $('#tanya');
		if(nm.val()=='' || nm.val().length < 4){alert('Nama tidak boleh kosong atau kurang dari 4 huruf'); nm.focus(); hs = false;}
		else if(em.val()==''){alert('Email tidak boleh kosong'); em.focus(); hs = false;}
		else if(! email_regex.test(em.val())){alert('Email tidak valid'); em.focus(); hs = false;}
		else if(kt.val()==''){alert('Kota tidak boleh kosong'); kt.focus(); hs = false;}
		else if(ps.val()==''){alert('Pesan tidak boleh kosong'); ps.focus(); hs = false;}
		else {hs = true;}
		return hs;
	});
	
	$('.form_biodata').submit(function(){
		var hs = false;
		var nd = $('#nama_depan');
		var em = $('#email_reg');
		var ps = $('#password');
		var kt = $('#kota');
		var tlp = $('#no_telp');
		var al = $('#alamat');
		if(nd.val()==''){alert('Nama Depan tidak boleh kosong'); nd.focus(); hs = false;}
		else if(em.val()==''){alert('Email tidak boleh kosong'); em.focus(); hs = false;}
		else if(! email_regex.test(em.val())){alert('Email tidak valid'); em.focus(); hs = false;}
		else if(ps.val()==''){alert('Password tidak boleh kosong'); ps.focus(); hs = false;}
		else if(kt.val()==''){alert('Kota tidak boleh kosong'); kt.focus(); hs = false;}
		else if(tlp.val()==''){alert('Telpon tidak boleh kosong'); tlp.focus(); hs = false;}
		else if(al.val()==''){alert('Alamat tidak boleh kosong'); al.focus(); hs = false;}
		else {hs = true;}
		return hs;
	});
	
	$('#CekOrder').submit(function(){
		var hs = false;
		var id = $('#order_cek_id');
		if(id.val()=='' || id.val().length < 10){alert('ID Order tidak boleh kosong atau ID Order tidak valid'); id.focus(); hs = false;}
		else {hs = true;}
		return hs;
	});
});
