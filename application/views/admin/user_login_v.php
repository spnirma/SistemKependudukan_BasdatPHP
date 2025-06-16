<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Login</title>
<meta name="description" content="slick Login">
<meta name="author" content="Webdesigntuts+">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>asset/admin/login/style.css?asas" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="http://www.modernizr.com/downloads/modernizr-latest.js"></script>
<script type="text/javascript" src="<?= base_url() ?>asset/admin/login/placeholder.js"></script>
</head>
<body>
<form id="slick-login" style="text-align:center" action="<?=admin_url();?>user/dologin" method="POST">
<!--<img src="<?= base_url() ?>login/images/1_login_03.png" width="150" /><br /><br />-->
<?php
    if(!empty ($error)){
?>
<span style="color:white;"><?= $error ?></span>
<?php
    }
?>
<label for="username">username</label><input style="border-radius: 0;" type="text" name="username" class="placeholder" placeholder="username or email">
<label for="password">password</label><input style="border-radius: 0;" type="password" name="password" class="placeholder" autocomplete="off" placeholder="password">
<input style="border-radius: 0;" type="submit" value="Log In">
</form>
</body>
</html>
