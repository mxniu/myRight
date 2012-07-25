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
	<ul id="category_nav">
	<?php foreach ($categories as $cat_link): ?>
		<li><a href="../<?=$cat_link->slug?>"><?=$cat_link->name?></a></li>
	<?php endforeach; ?>
	</ul>
</div>

<section class="link-submit-form">
	<h2 class="counting">19,203,209 articles and counting.</h2>
	<form action="#" method="post">
		<input id="link-input" name="link-input" type="search" placeholder="Add Link" />
		<span id="link-publish">Publish</span>
		
		<div class="collapse">
			
			<div class="form-input">
				<label for="link-type">Type</label>
				<input type="radio" name="link-type" value="resource" />Resource
				<input type="radio" name="link-type" value="news" />News
				<input type="radio" name="link-type" value="infographic" />Infographic				
			</div>
			
			<div class="form-input">
				<label for="link-title">Title</label>
				<input type="text" id="link-title" name="link-title" />
			</div>
			
			<div class="form-input">
				<label for="link-summary">Summary</label>
				<textarea id="link-summary" name="link-summary"></textarea>
			</div>
			
			<div class="form-input">
				<label for="link-tags">Tags</label>
				<input type="text" id="link-tags" name="link-tags" />
			</div>
			
			<div class="form-input">
				<label for="link-location">Location</label>
				<input type="text" id="link-location" name="link-location" />
			</div>
			
			<input type="submit" id="submit" name="submit" value="Submit" />
		</div>
		
		
	</form>
</section>