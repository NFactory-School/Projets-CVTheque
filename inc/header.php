<!DOCTYPE HTML>
<html>
<<<<<<< HEAD
<?php include 'pdo.php' ?>
=======
>>>>>>> ed69d64948c6a9fa86844aae90d07a6037450565
	<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>VAX</title>
        <meta name="description" content="">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<<<<<<< HEAD
	<link href="https://fonts.googleapis.com/css?family=Fondamento" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
=======
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/style_calendrier.css">
	<link rel="stylesheet" href="css/style_about.css">
	<link rel="stylesheet" href="css/style_contact.css">
>>>>>>> ed69d64948c6a9fa86844aae90d07a6037450565
	</head>

	<body>
	<header id="header">
		<header class="header">
			<div class="header-limiter">
				<h1><a href="#">Company<span>logo</span></a></h1>
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
