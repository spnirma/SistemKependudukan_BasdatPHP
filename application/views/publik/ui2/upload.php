<script src="<?=base_url();?>asset/admin/js/upload.min.js"></script>
<script type="text/javascript">
$(document).ready(
function(){
	var 
	ajaxUploadPhoto="<?=base_url();?>ajax/upload",
	ajaxRemovePhoto="<?=base_url();?>ajax/delete",
	pluploadSWF="<?=base_url();?>asset/admin/js/Moxie.swf",
	maxPhotoSize="5mb",maxPhotoCount=4,currentCount=$(".img-upload").length,edited=[];	

	var j=this;
	var q=new Array();
	var f=maxPhotoCount;
	var g=function(){
		return $("#photo-container .img-upload").length
	};
	var t=g();
	var l=function(y){
		var x=Math.min(y.length,f);
		var z=maxPhotoCount-g();
		x=Math.min(x,z);
		for(var w=0;w<x;w++){
			var A=$('<div class="img-upload"><div class="upload-progress"></div></div>');
			$("#add-photo"+(g()+1)).hide();
		if($("#photo-container .img-upload:last").length){
			$("#photo-container .img-upload:last").after(A)
		}
		else{
			$("#photo-container").prepend(A)
		}

		}

	};
	var u=function(){
		f++;
		if(f>maxPhotoCount){
			f=maxPhotoCount
		}

	};
	var p=function(){
		f--;
		if(f<0){
			f=0
		}

	};
	var d=function(){
		$("#photo-container .img-upload").has(".upload-progress").first().remove()
	};
	var h=function(y,A){
		var x='<img src="'+y+'" />',z='<input type="hidden" class="photo_img_input" name="photo_img['+t+']" value="'+y+'" />',w='<div class="img-upload col-lg-2">'+x+'<div class="del-image"></div>'+z+"</div>";
		if(A!=undefined){
			A()
		}
		if($("#photo-container .img-upload:not(:has(.upload-progress)):last").length){
			$("#photo-container .img-upload:not(:has(.upload-progress)):last").after(w)
		}
		else{
			$("#photo-container").prepend(w)
		}

	};
	var s=function(w){
		$(".add-foto").map(function(x,y){
		$(y).hide().attr("disabled","disabled")
		}
		)
	};
	var m=function(w){
		if($("#add-photo"+w).is(":disabled")){
		$("#add-photo"+w).removeAttr("disabled")
		}
		$("#add-photo"+w).show()
	};
	var c=function(y){
		var x=y.find("img").attr("src"),w=y.find("img").attr("rel");
		if(confirm("Hapus Image Ini?")){
			if(typeof(w)!="undefined"){
				$("#uploadFoto").append('<input type="hidden" id="delete_img'+w+'" name="delete_img[]" value="'+w+'" />')
			}
			else{
				$.ajax({
				type:"POST",url:ajaxRemovePhoto,data:{
				src:x
			}

			}
			)
			}
			$(y).remove();
			u();
			t--;
			if(f>0){
				m(t+1)
			}
			n();
			v();
			if(t>1){
				$(".drag-note").show()
			}
			else{
				$(".drag-note").hide()
			}

		}

	};
	n=function(){
		r();
		$("#photo-container .img-upload:first").append('<div class="futama"><div class="clr"></div></div>')
	};
	var r=function(){
		$("#photo-container").find(".futama").remove()
	};
	var v=function(){
		$("#photo-container .img-upload").each(function(w,x){
			$(x).find("input.photo_img_id").attr("name","photo_img["+(w)+"][id]");
			$(x).find("input.photo_img_input").attr("name","photo_img["+(w)+"]")
		}
		)
	};
	var b=function(w){
		var y=false;
		for(o in q){
			var x=q[o];
		if(x.state==plupload.UPLOADING){
			y=true
		}

	}
	if(y){
		window.setTimeout(function(){
		b(w)
		}
		,300)
	}
	else{
		w.start()
		}

	};
	var a=function(w){
		var x=w.files.slice(0);
		for(o in x){
			w.removeFile(x[o])
		}

	}
	;
	for(var o=1;o<=maxPhotoCount;
	o++){
			var k=new plupload.Uploader({
					runtimes:"html5, html4",browse_button:"add-photo"+o,max_file_size:maxPhotoSize,url:ajaxUploadPhoto,flash_swf_url:pluploadSWF,filters:[{
					title:"Image files",extensions:"jpg,jpeg,pjpeg,gif,png"
				}
			],unique_names:true,max_file_count:maxPhotoCount,multipart_params:{
				uid:"temp"
			}

			}
			);
			k.bind("FilesAdded",function(w,x){
				l(x);
			window.setTimeout(function(){
				b(w)
			}
			,100)
			}
			);
			k.bind("BeforeUpload",function(w,x){
				if($("#frm_pasang input#userid").val()){
				w.settings.multipart_params.uid=$("#frm_pasang input#userid").val()
			}

			}
			);
			k.bind("FileUploaded",function(w,y,x){
				if(x.status!=undefined&&parseInt(x.status)!=200||x.response==undefined){
				alert("Terjadi kesalahan dalam mengupload foto");
				return
			}
			data=jQuery.parseJSON(x.response);
			if(!data.status){
				alert(data.msg);
				d();
			return
			}
			if(f>0){
				h(data.res.src,d)
			}
			p();
			t++;
			if(f<=0){
				s();
				w.stop()
			}
			n();
			if(t>1){
				$(".drag-note").show()
			}
			else{
				$(".drag-note").hide()
			}

			}
			);
			k.bind("Error",function(w,x,y){
				if(x.code!=undefined){
				if(x.code==plupload.INIT_ERROR){
				d()
			}
			else{
				if(x.code==plupload.FILE_EXTENSION_ERROR){
				d();
				alert("Jenis file tidak didukung. Hanya berkas gambar yang diperbolehkan.")
			}
			else{
				if(x.code==plupload.FILE_SIZE_ERROR){
				d();
				alert("File yang diperbolehkan max 5MB")
			}
			else{
				d();
				alert("Terjadi kesalahan dalam mengupload foto")
			}

			}

			}

			}
			else{
				d();
				alert("Terjadi kesalahan dalam mengupload foto")
			}
			$("#add-photo"+(t+1)).show()
			}
			);
			k.bind("Init",function(w,x){
				window.setInterval(function(){
				w.refresh()
			}
			,550)
			}
			);
			k.init();
			q.push(k)
		}
		if(t>0){
			for(var o=1;
			o<=t;
		o++){
			p();
			$("#add-photo"+o).hide()
		}
		if(f<=0){
			s()
			}
			n()
		}
		if(t>1){
			$(".drag-note").show()
		}
		else{
			$(".drag-note").hide()
		}
		$("#photo-container").on("click",".del-image",function(w){
			w.preventDefault();
			c($(this).parent(".img-upload"))
		}
		);
		$("#photo-container").sortable({
			cursor:"move",items:"> .img-upload:not(:has(.upload-progress))",tolerance:"pointer",update:function(){
			n();
			v()
		}
		,start:function(w,x){
			r()
			}
			,stop:function(){
				n()
			}

		}
		)
	}
	);
</script>
