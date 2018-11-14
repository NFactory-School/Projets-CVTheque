<!DOCTYPE HTML>
<html>
	<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>VAX</title>
        <meta name="description" content="">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Fondamento" rel="stylesheet">
	<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">

	  <link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<header class="header">
			<div class="header-limiter">
			<a href="index.php"> <img class ="logo-header" src="img/logo_footer.svg" alt=""> </a>
				<?php include 'nav.php' ?>
			</div>
		</header>
		<div class="header-fixed-placeholder"></div>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				var showHeaderAt = 150;
				var win = $(window),
						body = $('body');
				if(win.width() > 600){
					win.on('scroll', function(e){
						if(win.scrollTop() > showHeaderAt) {
							body.addClass('fixed');
						}
						else {
							body.removeClass('fixed');
						}
					});
				}
			});

		</script>
		<div class="clear"></div>
		</header>
