<!DOCTYPE html>
<html lang="es">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $site->descr ?>">
    <meta name="author" content="<?= $site->auth ?>">

    <title><?= $site->title ?></title>
    
    <link rel="icon" href="images/web-icon.png" type="image/x-icon" >
	<link rel="shortcut icon" href="images/web-icon.png" type="image/x-icon" >

    <!-- Site Stylesheet -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
    <link href="css/bootstrap.css" rel="stylesheet">
	  
    <!-- Custom Fonts -->
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!--Cookie Alert https://github.com/Wruczek/Bootstrap-Cookie-Alert-->
    <link rel="stylesheet" href="css/cookiealert.css">
	  
	<!-- Scrollbar Custom CSS 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">-->
	  
	  <!--Charts js-->
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
	  
	<?php if(c::get('use.firebase',false)) : ?>
	<!--Firebase-->
	<script src="https://www.gstatic.com/firebasejs/5.4.0/firebase.js"></script>
	<script>
	  // Initialize Firebase
	  var config = {
		apiKey: "<?= c::get('fb.apiKey') ?>",
		authDomain: "<?= c::get('fb.authDomain') ?>",
		databaseURL: "<?= c::get('fb.databaseURL') ?>",
		projectId: "<?= c::get('fb.projectId') ?>",
		storageBucket: "<?= c::get('fb.storageBucket') ?>",
		messagingSenderId: "<?= c::get('fb.messagingSenderId') ?>"
	  };
	  firebase.initializeApp(config);
	</script>
	<?php endif ?>
	  
	<?php if(c::get('captcha.site') != '' && c::get('captcha.secret') != '') : ?>
	
	<!--Google CAPTCHA -->
	<script src="https://www.google.com/recaptcha/api.js"></script>

	<?php endif ?>  
</head>