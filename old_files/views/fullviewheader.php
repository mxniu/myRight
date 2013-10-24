<?php
header( "HTTP/1.1 301 Moved Permanently" ); 
header( "Location: http://myright.me" ); 
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>myRight | <?=$element->title?></title>
	<meta property="og:type" content="website"/>   
	<meta property="og:image" content="http://sphotos-b.xx.fbcdn.net/hphotos-ash4/487770_263685067078332_570461548_n.jpg"/>   
	<meta property="og:site_name" content="myRight"/> 
	<meta property="fb:app_id" content="265179353583781"/>
	<meta property="og:description" content="<?=$element->summary?>"/>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<link rel="icon" href="../favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="../css/common.css" />
	<link rel="stylesheet" href="../css/fullview.css" />
	<link rel="stylesheet" href="../css/jquery-ui-1.8.21.custom.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script type='text/javascript' src='../js/jquery-ui-1.8.21.custom.min.js'></script>
</head>
<body style="overflow: hidden">
<div id="topbar">

	<h1 class="logo"><a href="/">myRight</a></h1>
	
	<!-- Search Form -->
	<!--<form method="post" action="" id="top-search">
		<input type="text" id="top-search-input" name="top-search-input" placeholder="What are you looking for?" />
	</form>-->
	
	<!--<ul id="main_nav">
		<li><a href="#">Home</a></li>
		<li><a href="#">About</a></li>
		<li><a href="#">Contact</a></li>			
	</ul>-->
	
	<div id="top-right">
		<a href="http://signup.myright.me" class="top-login" target="_blank">Get Invited</a>
		<div id="sns">
			<a class="facebook" href="http://facebook.com/myrightinc" target="_blank">Facebook</a>
			<a class="twitter" href="https://twitter.com/myrightinc" target="_blank">Twitter</a>
		</div>
	</div>
</div>