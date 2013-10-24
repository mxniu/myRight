
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>myRight | <?=$title?></title>
	<meta name="description" content="<?=$description?>" />
	<meta property="og:title" content="myRight | <?=$title?>"/>
	<meta property="og:type" content="website"/>   
	<meta property="og:image" content="http://sphotos-b.xx.fbcdn.net/hphotos-ash4/487770_263685067078332_570461548_n.jpg"/>   
	<meta property="og:site_name" content="myRight"/> 
	<meta property="fb:app_id" content="265179353583781"/>
	<meta property="og:description" content="<?=$description?>"/>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<link rel="icon" href="../favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="../css/common3.css" />
	<link rel="stylesheet" href="../css/grid.css" />
	<link rel="stylesheet" href="../css/bootstrap-modal.css" />
	<link rel="stylesheet" href="../css/home3.css" />
	<link href='http://fonts.googleapis.com/css?family=Lato:700,400,300|Open+Sans:300, 400,600,700|PT+Sans:400|Arvo:400,700|Electrolize:400|Playfair+Display:400' rel='stylesheet' type='text/css'>
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script type='text/javascript' src='../js/bootstrap-dropdown.js'></script>
	<!-- More JS Twitter Bootstrap 07/26/2012-->
	<script src="/js/bootstrap-transition.js"></script>
	<script src="/js/bootstrap-modal.js"></script>
	<script src="/js/testengine3.js"></script>
	<!-- End More JS -->
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=265179353583781";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="topbar">
	<h2 class="logo"><a href="/">myRight</a></h2>
	
	<ul id="main_nav">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">About<b class="caret"></b></a>
			<ul class="dropdown-menu" id="about_drop">
				<li><a data-toggle="modal" href="#disclaimerModal" class="about_disclaimer">Disclaimer</a></li>
				<li><a data-toggle="modal" href="#disclaimerModal" class="about_privacy">Privacy</a></li>
				<li><a data-toggle="modal" href="#disclaimerModal" class="about_terms">Terms of Use</a></li>
				<li><a data-toggle="modal" href="#disclaimerModal" class="about_us">About Us</a></li>
				<li><a href="mailto:info@myright.me">Contact</a></li>	
				<!--<li><a href="http://myright.me/blog" target="_blank">Blog</a></li>-->
			</ul>
		</li>
	</ul>
	<!-- AddThis Button BEGIN -->
	<div style="float: left; width: 400px; margin-top: 20px;" class="addthis_toolbox addthis_default_style ">
	<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
	<a class="addthis_button_tweet" style="width: 87px !important;"></a>
	<a class="addthis_button_linkedin_counter" style="margin-top: 1px;" ></a>
	<a class="addthis_button_google_plusone" g:plusone:size="medium" style="margin-top: 1px;"></a> 
	</div>
	<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-5062be6628da4d93"></script>
	<!-- AddThis Button END -->
	
	<div id="top-right">
		<!--<div id="sns">
			<a class="facebook" href="http://facebook.com/myrightinc" target="_blank">Facebook</a>
			<a class="twitter" href="http://twitter.com/myrightinc" target="_blank">Twitter</a>
			<a class="linkedin" href="http://www.linkedin.com/company/myright" target="_blank">LinkedIn</a>
		</div>-->
		<a href="http://myright.me/lawstudents" class="top-login">For Law Students</a>
	</div>
</div>
<section id="partition-1" style="text-align: center; position: relative">
	<div style="overflow: hidden;">
		<img class="left" src="../images/obama_circle.png" alt="myRight Helps You with Common Legal Issues" title="myRight Helps You with Common Legal Issues"/>
		<div class="right" style="width: 470px; margin: 70px 100px 0 0">
			<div style="color: #FFF; font-size: 1.2em; font-family: 'Arvo', serif;">What type of issue do you want to learn about?</div>
			<div class="orange-button left" id="nav1" style="margin: 25px 0 15px 0; width: 220px; height: 42px; padding: 6px 0 4px 0; font-family: 'Playfair Display', serif; font-size: 1.7em;">Personal</div>
			<div class="orange-button right" id="nav2" style="margin: 25px 0 15px 0; width: 220px; height: 42px; padding: 10px 0 0 0; font-family: 'Arvo', serif; font-size: 1.7em;">Criminal</div>
			<div class="orange-button left" id="nav3" style="margin: 0 0 15px 0; width: 220px; height: 42px; padding: 10px 0 0 0; font-family: 'Electrolize', sans-serif; font-size: 1.7em;">Startup Law</div>
			<div class="orange-button right" id="nav4" style="margin: 0 0 15px 0; width: 220px; height: 42px; padding:10px 0 0 0; font-family: georgia, serif; font-style: italic; font-size: 1.7em;">In The News</div>
		</div>
	</div>
	
	<div class="flare_line"></div>
	<div class="circle_arrow"></div>
	
	<section style="margin-top: 35px; overflow: hidden">
		<div class="category_header" id="anchor1" style="margin-top: 35px; font-family: 'Playfair Display', serif; width: 400px">Personal Legal Issues</div>
		<div style="overflow: hidden">
			<div class="center topic_box" style="margin-left: 0; width: 638px; text-align: center;">
				<a href="car-accident" class="white_variant">Car Accidents</a>
				<a href="wills" class="white_variant">Wills</a>
				<a href="child-custody-california" class="white_variant">Child Custody</a>
				<a href="fmla-eligibility" class="white_variant">FMLA Eligibility</a>
				<a href="security-deposit-california" class="white_variant">Security Deposits</a>
				<a href="workers-compensation" class="white_variant">Workers' Compensation</a>
				<a href="restraining-order" class="white_variant">Restraining Orders</a>
				<a href="tickets" class="white_variant">Parking Tickets</a>
				<a href="asylum" class="white_variant">Immigrant Asylum</a>
				<a href="small-claims" class="white_variant">Small Claims</a>
				<a href="is-my-internship-legal" class="white_variant">Is My Internship Legal?</a>
			</div>
		</div>
		<div class="section_break"></div>
		<div class="category_header" id="anchor2" style="font-family: 'Arvo', serif; width: 370px">Criminal Penalties</div>
		<div style="overflow: hidden">
			<div class="center topic_box" style="margin-left: 0; width: 638px; text-align: center;">
				<a href="dui" class="white_variant">DUI</a>
			</div>
		</div>
		<div class="section_break"></div>
		<div class="category_header" id="anchor3" style="font-family: 'Electrolize', sans-serif;">Legal Guides for Startups</div>
		<div style="overflow: hidden">
			<div class="center topic_box" style="margin-left: 0; width: 638px; text-align: center;">
				<a href="startup" class="white_variant">Startup Law</a>
				<a href="intellectual-property" class="white_variant">Intellectual Property</a>
				<a href="corporation-or-llc" class="white_variant">Corporation or LLC?</a>
				<a href="when-to-incorporate" class="white_variant">When to Incorporate</a>
				<a href="hiring-documents" class="white_variant">Hiring Documents</a>
				<a href="employer-status" class="white_variant">Independent Contractor vs. Employee</a>
				<a href="hiring-interns" class="white_variant">Can I Hire an Intern?</a>
			</div>
		</div>
		<div class="section_break"></div>
		<div class="category_header" id="anchor4" style="font-family: georgia, serif; font-style: italic">Trending Legal Debates</div>
		<div style="overflow: hidden">
			<div class="center topic_box" style="margin-left: 0; width: 638px; text-align: center;">
				<a href="gay-marriage" class="white_variant">Gay Marriage</a>
				<a href="gun-rights" class="white_variant">Gun Rights</a>
				<a href="healthcare-reform" class="white_variant">Healthcare Reform</a>
				<a href="immigration-reform" class="white_variant">Immigration Reform</a>
				<a href="sopa" class="white_variant">SOPA</a>
				<a href="daca" class="white_variant">Deferred Action for Child Arrivals</a>
			</div>
		</div>
	</section>

	<!--<div style="background: rgba(255, 255, 255, 0.9); width: 620px; margin: 30px auto 15px; font-family: 'Arvo', serif; font-weight: 700; font-size: 20px; border-radius: 4px; padding: 10px 0">myRight <div style="display: inline; color: #f39844;">helps you learn</div> about common legal issues.</div>-->

	<section style="background: rgba(255, 255, 255, 0.9); text-align: left; margin: 85px 0 0 0; position: relative; border-radius: 6px 6px 0 0; width: 920px; padding: 30px 20px 80px; box-shadow: 0px 0px 2px 1px #AAA;">
		<div class="logo_med"></div>
		<div style="text-align: left; font-family: 'Open Sans', sans-serif; font-weight: 600; font-size: 20px; margin: 80px auto 0; padding-left: 5px; color: #51c7f4; padding-bottom: 5px">Mission</div>
		<div style="padding: 10px 20px; line-height: 1.6em"><p>At <strong>myRight</strong>, our mission is to help people learn their rights by simplifying the law.</p><p>Everyday, people have their rights compromised or they become the subject of a legal problem and have no idea where to start. We believe that the law can be simple enough for people to understand, and accessible enough that everyone should be able to learn the basics.&nbsp;&nbsp;A single lawyer can only help one person at a time, but <strong>myRight</strong> will be able to help millions.</p></div>
		<div style="text-align: left; font-family: georgia, serif; font-style: italic; font-size: 20px; margin: 20px auto; padding-left: 5px; color: #333; padding-bottom: 5px">Featured In..</div>
		<div id="asseenin"></div>
	</section>
</section>
<section class="footer" style="overflow: hidden">
	<div class="left home_category">
		<h3>Contact</h3>
		<a href="mailto:info@myright.me">E-mail Us</a>
	</div>
	<div class="left home_category">
		<h3>Company</h3>
		<a data-toggle="modal" href="#disclaimerModal" class="about_us">About Us</a>
	</div>
	<div class="left home_category">
		<h3>Legal Stuff</h3>
		<a data-toggle="modal" href="#disclaimerModal" class="about_disclaimer">Disclaimer</a>
		<a data-toggle="modal" href="#disclaimerModal" class="about_privacy">Privacy</a>
		<a data-toggle="modal" href="#disclaimerModal" class="about_terms">Terms of Use</a>
	</div>
	<div class="left home_category">
		<h3>Share</h3>
		<a href="http://facebook.com/myrightinc" target="_blank">Facebook</a>
		<a href="http://twitter.com/myrightinc" target="_blank">Twitter</a>
		<a href="http://www.linkedin.com/company/myright" target="_blank">LinkedIn</a>
	</div>
</section>
<script>
$(function() {
	$("#nav1").click(function(){
		$('html, body').stop().animate({scrollTop: $("#anchor1").offset().top - 95}, 'slow');
	});
	$("#nav2").click(function(){
		$('html, body').stop().animate({scrollTop: $("#anchor2").offset().top - 95}, 'slow');
	});
	$("#nav3").click(function(){
		$('html, body').stop().animate({scrollTop: $("#anchor3").offset().top - 95}, 'slow');
	});
	$("#nav4").click(function(){
		$('html, body').stop().animate({scrollTop: $("#anchor4").offset().top - 95}, 'slow');
	});
});
</script>