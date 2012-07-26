<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>myRight | <?=$title?></title>
  <link rel="stylesheet" href="../css/common.css" />
  <link rel="stylesheet" href="../css/viewport.css" />
  <link rel="stylesheet" href="../css/grid.css" />
  <link rel="stylesheet" href="../css/isotope.css" />
  <link href='http://fonts.googleapis.com/css?family=Quattrocento:400,700|Quattrocento+Sans:400,700|Lato:700,400,300|Cabin:600' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="topbar">

	<h1 class="logo"><a href="/">myRight</a></h1>
	
	<!-- Search Form -->
	<form method="post" action="" id="top-search">
		<input type="text" id="top-search-input" name="top-search-input" placeholder="What are you looking for?" />
	</form>
	
	<ul id="main_nav">
		<li><a href="#">Home</a></li>
		<li><a href="#">About</a></li>
		<li><a href="#">Contact</a></li>			
	</ul>
	
	<div id="top-right">
		<div id="sns">
			<a class="facebook" href="#">Facebook</a>
			<a class="twitter" href="#">Twitter</a>
			<a class="linkedin" href="#">LinkedIn</a>
		</div>
		
		<a href="#" class="top-login">Login</a>
	</div>
	
	<ul id="category_nav">
	<?php foreach ($categories as $cat_link): ?>
		<li>
			<a href="../<?=$cat_link->slug?>"><?=$cat_link->name?></a>
			
			<!-- drop-down -->
			<ul class="level1">
				<li><h4>Most Talked About</h4></li>
				<li><a href="#">Item 1</a></li>
				<li><a href="#">Item 2</a></li>
				<li><a href="#">Item 3</a></li>
			</ul>
			<!-- end drop down -->
			
		</li>
	<?php endforeach; ?>
	</ul>
</div>