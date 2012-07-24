<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>myRight - Learn the Law & Attorney Search</title>
<meta name="description" content="myRight is an exciting new internet company that plans to revolutionize the law by giving the public an unprecedented educational tool for learning about their legal rights and finding local attorneys. If you are an attorney looking for leads and new clients, register early to receive complementary premium services when we launch.">
<meta property="og:title" content="myRight - When Something's Wrong, Know Your Right" /><meta property="og:type" content="company" /><meta property="og:site_name" content="myRight" /><meta property="og:url" content="http://checkmyright.com/index.php" /><meta property="og:image" content="https://launchrock-assets.s3.amazonaws.com/facebook-files/l6COeIZgrBwar1V.png" /><meta property="og:description" content="myRight is an exciting new internet company that plans to revolutionize the law by giving the public an unprecedented educational tool for learning about their legal rights. Follow their progress and support access to justice for all!" />
<link rel="icon" href="/images/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"> 
<link href="css/index2.css" rel="stylesheet" type="text/css"/>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:600,400,300' rel='stylesheet' type='text/css'>
<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>
<script type="text/javascript" src="http://launchrock-ignition.s3.amazonaws.com/ignition.1.1.js"></script>
<script>
	$(document).ready(function () {
		 //Scrollable
		 $(".scrollable").scrollable({circular: true}).navigator().autoscroll(4000);
		$("div[rel]").overlay();
		
		$(".contact_button").click(function(){
			$.post("contact_submit.php",{ email: $("#contact_email").attr("value"), subject: $("#contact_subject").attr("value"), message: $("#contact_message").attr("value")}, function(data){$("#contact_link").data("overlay").close();}, "json");
			
		});
	});
</script>
</head>
<body>
	<div class="container">
    	<div class="container_left">
    		<div class="logo"></div>
            <div class="login">
                <form name="loginform" action="login.php" method="post">
                	<div>Username</div>
                    <input type="text" name="log" id="log" class="custominput" autocomplete="off"/>
                    <div>Password</div>
                    <input type="password" name="pwd" id="pwd" class="custominput" />
                	<input type="submit" value="" class="enter_button" style="border:none">
                </form>
    		</div>
        </div>
        <div class="container_right">
            <div class="scrollbox">
              <div class="scrollable">
                  <div class="items">
                    <div class="item" id="slide1">
                    </div>
                    <div class="item" id="slide2">
                    </div>
                    <div class="item" id="slide3">
                    </div>
                    <div class="item" id="slide4">
                    </div>
                  </div>
              </div>
            </div>
            <div class="navi">
              <a style="border-radius: 0 0 0 5px;" class="active">Why myRight?</a>
              <a>How It Works</a>
              <a>Find a Lawyer</a>
              <a style="border-radius: 0 0 5px 0;">Get Results</a>
            </div>
            <div class="sm_links">
            	<div class="sm_caption">Stay up to date with our newest updates. Follow us, like us, message us, tweet @ us, we'd love to hear from you.</div>
                <div class="sm_buttons">
                	<div class="fb_button"></div>
                    <div class="tumblr_button"></div>
                </div>
            </div>
    	</div>
    </div>
    <div class="tagline">When something's wrong, know your right.</div>
    <div class="container2">
    	<div class="container2_left">
        	<div class="smallimage"></div>
            <div class="smallcaption">Are you a lawyer or law firm interested in receiving targeted local leads?</div>
        	<div class="notify_button" rel="#notify_box_lawyer"></div>
        </div>
        <div class="container2_right">
        	<div class="smallimage" id="alt"></div>
            <div class="smallcaption">Want to be notified of any future updates?</div>
        	<div class="notify_button" rel="#notify_box_user"></div>
        </div>
    </div>
   <div class="footer">
        <div class="rights">Copyright 2012 myRight</div>
        <ul class="lowmenu">
        	<a href="https://twitter.com/myrightinc" class="twitter-follow-button" data-show-count="false" data-size="large"><img src="" /></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
             <!--<li><div id="contact_link" rel="#contact_box">Contact Us</div></li>-->
        </ul>
        
    </div>
    <div class="overlay" id="notify_box_lawyer">
    	<div class="notify_box_logo"></div>
    	<div class="notify_box_header">Join Our Attorney Mailing List!</div>
        <div class="notify_box_text"><p>If you are an attorney who would like to advertise with us upon launch, we will let you know when lawyer features go live.</p><p>We will also be offering exclusive deals for our early subscribers, so stay tuned!</p></div>
        <div class="notify_form">
          <!--<form action="notify_submit.php" method="post">
          	<div>
                <div class="form_line"><label>Your Name:</label><input type="text" name="name" id="log" size="50" class="custominput" style="float: left"/></div>
                <div class="form_line"><label><font color="red">*</font>Your E-mail:</label><input type="text" name="email" id="log" size="50" class="custominput" style="float: left"/></div>
                <div class="form_line"><label>Your Phone:</label><input type="text" name="phone" id="log" size="50" class="custominput" style="float: left"/></div>
            </div>
            <div><input type="submit" name="submit" value="" class="notify_button" style="border: none; margin-top: 15px;"/></div>
          </form>-->
          <div rel="INTBFXDB" class="lrdiscoverwidget" data-logo="off" data-background="off" data-share-url="checkmyright.com/index.php"></div>
        </div>
    </div>
    <div class="overlay" id="notify_box_user">
    	<div class="notify_box_logo"></div>
    	<div class="notify_box_header">Join Our Mailing List!</div>
        <div class="notify_box_text">If you subscribe to our mailing list, we will keep you updated on our progress as we get ready to launch.</div>
        <div class="notify_form">
          <!--<form action="notify_submit.php" method="post">
            <div class="form_line"><label>Your E-mail:</label><input type="text" name="email" id="log" size="50" class="custominput"/></div>
            <div><input type="submit" name="submit" value="" class="notify_button" style="border: none; margin-top: 15px;"/></div>
          </form>-->
          <div rel="INTBFXDB" class="lrdiscoverwidget" data-logo="off" data-background="off" data-share-url="checkmyright.com/index.php"></div>
        </div>
    </div>
    <div class="overlay" id="contact_box">
    	<div class="notify_box_logo"></div>
    	<div class="notify_box_header">Drop Us a Line!</div>
        <div class="notify_form" style="margin-top: 15px">
          <form>
            <div class="form_line"><label>Your E-mail:</label><input type="text" name="email" id="contact_email" size="100" class="custominput" style="float: left"/></div>
            <div class="form_line"><label>Subject:</label><input type="text" name="subject" id="contact_subject" size="100" class="custominput" style="float: left"/></div>
            <div class="form_line"><label>Message:</label><input type="text" name="message" id="contact_message" size="1000" class="custominput" style="float: left"/></div>
            <div class="contact_button"></div>
          </form>
        </div>
    </div>
</body>
</html>