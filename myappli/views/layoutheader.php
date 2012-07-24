<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>myRight | <?=$category?></title>
  <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <link rel="stylesheet" href="css/common.css" />
  <link rel="stylesheet" href="css/isotope.css" />
  <link href='http://fonts.googleapis.com/css?family=Quattrocento:400,700|Quattrocento+Sans:400,700|Lato:700,400,300|Cabin:600' rel='stylesheet' type='text/css'>
  <!-- scripts at bottom of page -->
</head>
<body>
<div id="topbar">
	<ul id="category_nav">
	<?php foreach ($categories as $cat_link): ?>
		<li><a href="<?=$cat_link->slug?>"><?=$cat_link->name?></a></li>
	<?php endforeach; ?>
	</ul>
</div>