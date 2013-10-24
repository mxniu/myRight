<section class="content">
<div id="category-title">
	<div class="left backbutton"></div>
	<a class="right" href="#" id="find-a-lawyer">Find a Lawyer</a>
	<h2 class="left" id="tag-title" style="text-transform: capitalize; font-size: 28px; margin: 10px 0; color: #378daf;"><?=$title?></h2>
	<a href="http://www.facebook.com/dialog/feed?&app_id=265179353583781&link=http://myright.me/<?=$method?>&redirect_uri=http://myright.me/<?=$method?>" target="_blank" class="right social-button" id="fb_share" style="margin: 12px 8px 0 0; height: 16px; padding: 7px 7px"><img src="../images/icon_fb.png" style="margin: 0 19px 0 7px" height="14" width="8"/>Share</a>
	<a href="https://twitter.com/share?url=http://myright.me/<?=$method?>&via=myrightinc" target="_blank" class="right social-button" id="twitter_share" style="margin: 12px 8px 0 0; height: 16px; padding: 7px 7px"><img src="../images/icon_twitter.png" style="margin: 0 16px 0 0" height="14" width="17"/>Tweet</a>
	
</div>
<div id="beta_box">
	<div id="test_interface">
	</div>
	<div class="result_box">
		<div style="font-size: 1.6em; margin: 0 auto; text-align: center; font-weight: 300;">Find a Lawyer</div>
		<div class="form_line" style="margin-top: 20px"><label>Name</label><input type="text" id="field_name" maxlength=50 class="custominput"/></div>
		<div class="form_line"><label>E-mail</label><input type="email" id="field_email" maxlength=100  class="custominput"/></div>
		<div class="form_line"><label>Phone</label><input type="tel" id="field_phone" maxlength=10 style="width: 6em"  class="custominput"/><div style="display:inline; margin-left: 1em; font-size: 0.8em; font-style: italic; color: #999">just the digits</div></div>
		<!--<div class="option" id="result_option_answers" style="margin: 0.8em 0 0 4.2em;"><div class="checkbox" id="result_check_answers" style="background-position: 0px -23px"></div>&nbsp;<div class="optiontext">I agree to submit my answers.</div></div>-->
		<div class="option" id="result_option_terms" style="margin: 0.8em 0 0 4.2em;"><div class="checkbox" id="result_check_terms"></div>&nbsp;<div class="optiontext" style="width:250px">I have read and agree to your <a data-toggle="modal" href="#disclaimerModal" class="about_terms">Terms of Use</a>.</div></div>
		<div class="warning_message" id="result_warning"></div>
		<div class="button_orange_thin" id="result_submit" style="margin-top: 25px">Submit</div>
	</div>
</div>
</section>