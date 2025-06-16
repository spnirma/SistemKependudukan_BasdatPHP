
function valCmb(kondisi,nilai,nama) {

	var nilai_old = $('#'+nama+'_val').val();

	//alert (kondisi+' '+nilai+' '+nama+' ');
	nilai = ''+nilai+',';
	if (kondisi) {
		nilai_new = nilai_old + '' + nilai + ''; //nilai_new + nilai;
	} else {
		nilai_new = nilai_old.replace(nilai, '');
	}
	if (nilai_new=='0,') {nilai_new='';}
	$('#'+nama+'_val').val(nilai_new);
}

function valFile(nilai,id) {
//alert (id+'-'+nilai);
	aidiGR = id.replace("file_", "");
	$('#'+aidiGR+'').val(nilai);
}

function validateForm2()
{
// textbox : done	
// radio : done	
// combo : done	
// textarea : done	
// checkbox : done	
// date : done	

	var blnvalidate = true;
	var elementsInputs;
	var aidi = 0;

	$('#pBar').css('display','');
	$('#warningWarning').css({'display' : 'none'});
	$('#warningWarningDesc').css({'display' : 'none'});

	
	$('#frmregiz input').each(function() { 
		nama = this.name; //grp1_element
		aidi = this.id; //grp1_element
		aidiGR = nama.replace("_element", "");
		aidiGR = aidiGR.replace("_req", "");
		$("#"+aidiGR).removeClass("has-error");
//		$("#"+aidiGR+'_notif').html('');
		$("#"+aidiGR+'_notif').html('<span id="'+aidiGR+'_notif" ></span>');
		//alert (this.type + ' : ' + nama + ' - '+ aidiGR + ' - ' + aidi+' - '+this.value);
//		return false;
		if (this.type=="radio") {
			//radio
//		alert (this.type + ' : ' + nama + ' - '+ aidiGR + ' - ' + aidi+' - '+this.value);
			if ((this.className.indexOf("required")) >=0) {
				if ($('input[name='+nama+']:checked').length > 0) {
					//alert ('isi kok');
				} else {
					$("#"+aidiGR).addClass("has-error");
					$("#"+aidiGR+'_notif').html('<span style="margin-top: 0px; margin-bottom: 0px; color:red; " class="help-block">This filed is required ..</span>');
					blnvalidate = false; 
				}
			}
		} else if (this.type=="checkbox") {
			// checkbox
			if ((this.className.indexOf("required")) >=0) {
				if ($('input[name='+nama+']:checked').length > 0) {
				
				} else {
					$("#"+aidiGR).addClass("has-error");
					$("#"+aidiGR+'_notif').html('<span style="margin-top: 0px; margin-bottom: 0px; color:red; " class="help-block">This filed is required ..</span>');
					blnvalidate = false; 
				}
			}
		} else if (this.type=="date") {
			// date
			if ((this.className.indexOf("required")) >=0) {
				if (this.value=="") { 
					$("#"+aidiGR).addClass("has-error");
					$("#"+aidiGR+'_notif').html('<span style="margin-top: 0px; margin-bottom: 0px; color:red; " class="help-block">This filed is required ..</span>');
					blnvalidate = false; 
				}
			}
		} else {
			// textbox
			if ((this.className.indexOf("required")) >=0) {
				if (this.value=="") { 
				//alert (aidiGR);
					$("#"+aidiGR).addClass("has-error");
					$("#"+aidiGR+'_notif').html('<span style="margin-top: 0px; margin-bottom: 0px; color:red; " class="help-block">This filed is required ..</span>');
					blnvalidate = false; 
				}
			}
		}
	});

	$('#frmregiz select').each(function() { 
		nama = this.name; //grp1_element
		aidi = this.id; //grp1_element
		aidiGR = nama.replace("_element", "");
		aidiGR = aidiGR.replace("_req", "");
		$("#"+aidiGR).removeClass("has-error");
		$("#"+aidiGR+'_notif').html('<span id="'+aidiGR+'_notif" ></span>');
		//alert (this.type + ' : ' + nama + ' - '+ aidiGR + ' - ' + aidi+' - '+this.value);
		if ((this.className.indexOf("required")) >=0) {
			if (this.value=="") { 
//			alert (aidiGR);
				$("#"+aidiGR).addClass("has-error");
				$("#"+aidiGR+'_notif').html('<span style="margin-top: 0px; margin-bottom: 0px; color:red; " class="help-block">This filed is required..</span>');
				blnvalidate = false; 
			}
		}
	});

	$('#frmregiz textarea').each(function() { 
		nama = this.name; //grp1_element
		aidi = this.id; //grp1_element
		aidiGR = nama.replace("_element", "");
		aidiGR = aidiGR.replace("_req", "");
		$("#"+aidiGR).removeClass("has-error");
		$("#"+aidiGR+'_notif').html('<span id="'+aidiGR+'_notif" ></span>');
//		alert (this.type + ' : ' + nama + ' - '+ aidiGR + ' - ' + aidi+' - '+this.value);
		if ((this.className.indexOf("required")) >=0) {
			if (this.value=="") { 
//			alert (aidiGR);
				$("#"+aidiGR).addClass("has-error");
				$("#"+aidiGR+'_notif').html('<span style="margin-top: 0px; margin-bottom: 0px; color:red; " class="help-block">This filed is required ..</span>');
				blnvalidate = false; 
			}
		}
	});
	
	if (!blnvalidate) {
				$('#pBar').css('display','none');
		
				$('#warningWarningDesc').css({'display' : ''});
				$('#warningWarningDesc').html(' Please complete your registration data.');
				
				$('#warningWarning').css({'display' : ''});
				$('#warningWarning').show();
	}
	
	return blnvalidate;
}

$(document).ready(function() {
	/*
	$('.uno').on('click', function(){
		alert ('aaa');
$('html, body').animate({ scrollTop: $('#div_id').offset().top }, 'slow');});
  
  */
//	alert ('b');
	$(":submit").click(function () { 
//	return true;
//		return false;
		var oke=1;
		if (this.id=='btnSubmit') { 
//			alert(validateForm2());
//return false;
			if (validateForm2()==false) {
				//$('#pBar').css('display','none');

/*            $('html,body').animate({
                scrollTop: $('.target1').offset().top
            }, 1000);

				$('#warningWarningDesc').css({'display' : ''});
				$('#warningWarningDesc').html(' Please complete your registration data as shown with red highlight.');
				
				$('#warningWarning').css({'display' : ''});
				$('#warningWarning').show();
*/
				//            return false;


/*
				
				$('body,html').animate({
					scrollTop: 0,
				}, 1000);
				$('#warningWarningDesc').css({'display' : ''});
				$('#warningWarningDesc').html(' Please complete your registration data as shown with red highlight.');
				$('#warningWarning').css({'display' : ''});
				$('#warningWarning').show();
*/
				oke=0;
			} 
		}
		if (oke==1) {
			var e = confirm('Are you sure want to send registration ?');
//			$('#validate2 :input[id="action"]').val(this.id);
//			var e = true;
			if(e){
				$('#pBar').css('display','');
				$('#btnSubmit').css({'display' : 'none'});
				$('#btnReset').css({'display' : 'none'});

//				$('#btn_wait').css({'display' : ''});
//				$('#btn_send').css({'display' : 'none'});
//				alert ('Validation is done. ');
				return true; //return true;
				//$('#frmregiz').submit();
			}else{
				return false;
			}
		}
		return false;
	});
});
