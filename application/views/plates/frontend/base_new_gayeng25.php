<!DOCTYPE HTML>
<?php 
$loggedInEvent = $this->getLoggedInEvent();
$namaEvent='';
$dateEvent='';
$homeUrlEvent='#';
$headerHeight=100;
$bodyBgColor='#fff';
$headerBgColor='black';
$headerBgImage='';
$headerForeColor='white';
$headerBtnBgColor='';
$headerBtnForeColor='';
?>
<?php
//if (!empty($loggedInEvent->ev_name)) { $homeUrlEvent=$this->e($loggedInEvent->ev_name); } 
if (!empty($loggedInEvent->ev_name)) { $namaEvent=$this->e($loggedInEvent->ev_name); } 
if (!empty($loggedInEvent->ev_date)) { $dateEvent=$this->e($loggedInEvent->ev_date); } 
if (!empty($loggedInEvent->header_height)) { $headerHeight=$this->e($loggedInEvent->header_height); } 
if (!empty($loggedInEvent->url_event)) { $homeUrlEvent=$this->e($loggedInEvent->url_event); } 
if (!empty($loggedInEvent->body_bg_color)) {$bodyBgColor=$this->e($loggedInEvent->body_bg_color); } 
if (!empty($loggedInEvent->header_bg_color)) {$headerBgColor=$this->e($loggedInEvent->header_bg_color); } 
if (!empty($loggedInEvent->header_bg_image)) {$headerBgImage=$this->e($loggedInEvent->header_bg_image); } 
if (!empty($loggedInEvent->header_fore_color)) {$headerForeColor=$this->e($loggedInEvent->header_fore_color); } 
if (!empty($loggedInEvent->btn_homeurl_bgcolor)) {$headerBtnBgColor=$this->e($loggedInEvent->btn_homeurl_bgcolor); } 
if (!empty($loggedInEvent->btn_homeurl_forecolor)) {$headerBtnForeColor=$this->e($loggedInEvent->btn_homeurl_forecolor); } 
$headerHeight = $headerHeight+0;
$configData= array (
	'is_mobile' =>$is_mobile,
	'homeUrlEvent'	=> $homeUrlEvent,
	'namaEvent'	=> $namaEvent,
	'dateEvent'	=> $dateEvent,
	'headerHeight'	=> $headerHeight,
	'headerBgColor'	=> $headerBgColor,
	'headerBgImage'	=> $headerBgImage,
	'headerForeColor'	=> $headerForeColor,
	'headerBtnBgColor'	=> $headerBtnBgColor,
	'headerBtnForeColor'	=> $headerBtnForeColor,
	'src_area_propinsi' => $this->getConfig('src_area_propinsi'),	
	'src_kategori_produk' => $this->getConfig('src_kategori_produk'),	
);
?>

<html lang="en">
    <head>
        <!--=============== basic  ===============-->
        <meta charset="UTF-8">
		<title>Penduduk</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="robots" content="index, follow"/>
        <meta name="keywords" content=""/>
		<link href="/gIco.jpg" rel="icon">
		
        <!--=============== css  ===============-->	
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>asset_easy/css_town/reset.css?<?= date('YmdHis')?>">
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>asset_easy/css_town/plugins.css?<?= date('YmdHis')?>">
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>asset_easy/css_town/style_gayeng25.css?<?= date('YmdHis')?>">
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>asset_easy/css_town/color.css?<?= date('YmdHis')?>">
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>asset_easy/css_town/dashboard-style.css?<?= date('YmdHis')?>">

		
<!-- asset JS cipika -->		
        <link rel="stylesheet" href="<?= base_url(); ?>asset/ui2.2/css/main.min.css?201703071w448<?= date('YmdHis')?>">
        <script src="<?= base_url() ?>asset/ui2.6/js/jquery-1.11.3.min.js?201703071w448<?= date('YmdHis')?>"></script>
<!-- !asset JS cipika -->		

        <!--=============== scripts  ===============-->
		<script src="<?=base_url()?>asset/admin/js/jquery-ui.min.js?201703071w448<?= date('YmdHis')?>"></script>
<!--
        <script type="text/javascript" src="<?= base_url() ?>asset_easy/js_easy/plugins.js?201703071w448<?= date('YmdHis')?>"></script>
        <script type="text/javascript" src="<?= base_url() ?>asset_easy/js_easy/vismob.js?asas<?= date('YmdHis')?>"></script>
-->
        <!--=============== scripts  ===============-->

        <script type="text/javascript">
            var base_url = '<?= base_url() ?>';
            var secure_base_url = '<?php echo $this->getConfig('secure_base_url');?>';
            var index_page = '';
            var url_suffix = '';
        </script>
<!--
		<link rel="stylesheet" href="/assets1/css/magnific-popup.css">
		<link rel="stylesheet" href="/assets1/css/quick-events.css?eee">
-->	
		<!-- Include language file -->
<!--
		<script src="/languages/lang.js"></script>
-->		
		<!-- Include js files -->
<!--
		<script src="/assets1/js/jquery.magnific-popup.js"></script>
		<script src="/assets1/js/quick-events.js?gggg"></script>		
-->

        <!--=============== scripts  ===============-->
        <script src="<?= base_url() ?>asset_easy/js_town/jquery.min.js?<?= date('YmdHis')?>"></script>
        <script src="<?= base_url() ?>asset_easy/js_town/plugins.js?<?= date('YmdHis')?>"></script>
        <script src="<?= base_url() ?>asset_easy/js_town/scripts.js?<?= date('YmdHis')?>"></script>
<!--        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY_HERE&libraries=places&callback=initAutocomplete"></script>-->
        <script src="<?= base_url() ?>asset_easy/js_town/map-single.js?<?= date('YmdHis')?>"></script>            
        <script src="<?= base_url() ?>asset_easy/js_town/pjs.js?<?= date('YmdHis')?>"></script>

<?php 
//echo ENVIRONMENT;die;
if (ENVIRONMENT === 'testing') { // productions=testing
?>
	<?php if (DOMAINNAME=='gayengexpo.id' || DOMAINNAME=='www.gayengexpo.id') { ?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
	
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-PQ2855HRHB"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-PQ2855HRHB');
		</script>		
		
	<?php } ?>		
<?php } ?>		
        <meta name="google-signin-scope" content="profile email">
        <meta name="google-signin-client_id" content="<?=GOOGLE_CLIENT_ID?>">
        <script src="https://apis.google.com/js/api:client.js"></script>
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		
		
    </head>
    <body style="background-color:#010a45;">
        <!--loader-->
<!--ee
-->
        <div class="loader-wrap">
            <div class="pin">
                <div class="pulse"></div>
            </div>
        </div>
        <!--loader end-->
        <!-- Main  -->
        <div id="main">


			<?php echo $this->insert('frontend/partial_ve/nav_header_new_gayeng25', $configData)?>

			<?php echo $this->section('content', $configData)?>

			<?php echo $this->insert('frontend/partial_ve/nav_footer_new_gayeng25', $configData)?>

			<?php //echo $this->insert('frontend/partial_ve/nav_footer_onlymodal', $configData)?>
		
        </div>
        <!-- Main end -->

<!-- !asset JS cipika -->		
        <script src="<?= base_url(); ?>asset/ui2.2/js/custom.min.js?201703071w448<?= date('YmdHis')?>"></script>		
<!-- !asset JS cipika -->	


        <!-- FACEBOOK LOGIN -->
        

        <!-- GOOGLE API LOGIN -->
        <script>
        var PARAM = {};
        var LOGIN_ACT = false;
        function onFailure(error) {
            console.log(error);
        }
        function renderButton() {
            gapi.signin2.render('g-signin2', {
                'scope': 'profile email',
                'width': 360,
                'height': 60,
                'longtitle': true,
                'theme': 'dark',
                'onsuccess' : onSignIn,
                'onfailure' : onFailure
            });
        }        
        function onSignIn(googleUser) {
            // Useful data for your client-side scripts:
            var profile = googleUser.getBasicProfile();
            console.log("ID: " + profile.getId()); // Don't send this directly to your server!
            console.log('Full Name: ' + profile.getName());
            console.log('Given Name: ' + profile.getGivenName());
            console.log('Family Name: ' + profile.getFamilyName());
            console.log("Image URL: " + profile.getImageUrl());
            console.log("Email: " + profile.getEmail());

            // The ID token you need to pass to your backend:
            var id_token = googleUser.getAuthResponse().id_token;
            console.log("ID Token: " + id_token);

            PARAM = {
                username : profile.getEmail(),
                password : profile.getId(),
                salt : "google",
                email : profile.getEmail(),
                firstname : profile.getGivenName(),
                lastname : profile.getFamilyName(),
                fb_token : id_token,
                fb_name : profile.getId()
            }

            console.log("LOGIN_ACT" , LOGIN_ACT);
            if (LOGIN_ACT) {
                $.post("<?=base_url('auth/sosmed/google')?>", PARAM, function(data){
                    console.log("login status", data);
                    if (data.code == 200) {
                        location.reload();
                    }
                })
            }
        }
        $("#g-signin2").click(function(){
            LOGIN_ACT = true;
        });
        </script>

        <script>
        function set_lang(lang) {
			//alert (lang);
			if (lang=='id' || lang=='en') {
				document.body.style.cursor = 'wait';
				$.post("<?=base_url('ajax/lang')?>/" + lang, {}, function(data){
					console.log("lang", data);
					if (data.status == 200) {
						location.reload();
					}
				})
			} else {
				alert ('Will be available soon.');
				/*
				alert ('English versionis not available yet');
				Swal.fire({
					title : 'Infomation',
					text : 'English versionis not available yet.',
					icon : 'warning'
				})
				*/
			}

        }
        </script>

        <script>
        function toBusinessProfile() {
            Swal.fire({
                title : 'Data Bisnis Kurang',
                text : 'Silahkan lengkapi data bisnis terlebih dahulu dan coba lagi',
                icon : 'warning',
                onClose : function() {
                    var url = window.location.href;
                    var url_encoded = encodeURI(url);
                    window.location = "<?=base_url('user_ve/business_profile?reff=')?>" + url_encoded;
                }
            })
        }
        </script>


        <script>
            /* reff url on login */
            var url = window.location.href;            
            $(".reff_url").val(url);
        
        </script>
<?php if (DOMAINNAME=='gayengexpo.idx' || DOMAINNAME=='www.gayengexpo.idx') { ?>
	<script language="JavaScript">
	  /**
		* Disable right-click of mouse, F12 key, and save key combinations on page
		* By Arthur Gareginyan (arthurgareginyan@gmail.com)
		* For full source code, visit https://mycyberuniverse.com
		*/
		
	  window.onload = function() {
		document.addEventListener("contextmenu", function(e){
		  e.preventDefault();
		}, false);
		document.addEventListener("keydown", function(e) {
		//document.onkeydown = function(e) {
		  // "I" key
		  if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
			disabledEvent(e);
		  }
		  // "J" key
		  if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
			disabledEvent(e);
		  }
		  // "S" key + macOS
		  if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
			disabledEvent(e);
		  }
		  // "U" key
		  if (e.ctrlKey && e.keyCode == 85) {
			disabledEvent(e);
		  }
		  // "F12" key
		  if (event.keyCode == 123) {
			disabledEvent(e);
		  }
		}, false);
		function disabledEvent(e){
		  if (e.stopPropagation){
			e.stopPropagation();
		  } else if (window.event){
			window.event.cancelBubble = true;
		  }
		  e.preventDefault();
		  return false;
		}
	  };

	</script>				
<?php } ?>	
    </body>
</html>		
  
