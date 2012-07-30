<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>myRight | <?=$element->title?></title>
	<meta property="og:type" content="website"/>   
	<meta property="og:image" content="http://sphotos-b.xx.fbcdn.net/hphotos-ash4/487770_263685067078332_570461548_n.jpg"/>   
	<meta property="og:site_name" content="myRight"/> 
	<meta property="fb:app_id" content="265179353583781"/>
	<link rel="stylesheet" href="../css/common.css" />
	<link rel="stylesheet" href="../css/fullview.css" />
</head>
<body style="overflow: hidden">
<div id="topbar">
	<h2 class="left"><?=$element->title?></h2>
	<div class="right">
		<div class="fb-like" data-href="http://myright.me/fullview/<?=$method?>" data-send="false" data-layout="box_count" data-width="450" data-show-faces="true" data-font="segoe ui"></div>
	</div>
</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=265179353583781";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>