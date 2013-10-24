<section id="partition-1" <?php if($bgimage) echo 'style="background: url(/images/'.$bgimage.') 0 0 no-repeat;"'; ?>>
	<div class="tip_top"><ul id="breadcrumbs-two"><li><a href="/">Home</a></li><li><a href="/<?=$category->slug?>/"><?=$category->name?></a></li><?php if(isset($state_name)) echo '<li><a href="#">'.$state_name.'</a></li>';?></ul></div>
	<div id="top_interface">
		<div id="interface_sub">
			<div id="interface_sub_top">
				<div class="shiny_black" id="category_title" style="color: #fff; font-size: 20px;">&#9660; <span style="font-style: italic">Get Informed</span></div>
				<div id="explanation_frame" style="overflow: auto; height: 310px; width: 290px">
					<div id="explanation_box" style="margin: 10px; font-size: 1.1em; color: #555; width: 250px"></div>
				</div>
			</div>
			<div class="shiny_black" id="interface_sub_bot">
				<div class="left" id="character_contact"></div>
				<div class="right" id="contact_caption">Find a Helpful Lawyer Today!</div>
			</div>
		</div>
		<div id="interface_main">
			<div class="shiny_black" id="category_title">
				<h1 id="tag-title" class="left" style="text-transform: capitalize; font-size: 24px; color: #fff; margin: 0; width: 370px"><?=$title?></h1>
				<div class="right" style="width: 250px">
					<div class="meter orange nostripes">
						<span style="width: 0"></span>
					</div>
				</div>
			</div>
			<div id="beta_box">
				<div id="test_interface">
				</div>
				<div class="result_box">
					<div style="font-size: 1.6em; margin: 0 auto; text-align: center; font-weight: 300;"><div>Contact Us for a</div><div>FREE CONSULTATION</div></div>
					<div class="form_line" style="margin-top: 20px"><label>Name</label><input type="text" id="field_name" maxlength=50 class="custominput"/></div>
					<div class="form_line"><label>E-mail</label><input type="email" id="field_email" maxlength=100  class="custominput"/></div>
					<div class="form_line"><label>Phone</label><input type="tel" id="field_phone" maxlength=10 style="width: 6em"  class="custominput"/><div style="display:inline; margin-left: 1em; font-size: 0.8em; font-style: italic; color: #999">just the digits</div></div>
					<div class="warning_message" id="result_warning"></div>
					<div class="orange-button" id="result_submit">Submit</div>
				</div>
			</div>
		</div>
		<div class="hidden" id="contact_dropsource" style="background: #0C546F; height: 0px; width: 300px; z-index: 10; position: absolute; top: 0px; right: 20px; -webkit-transform: skew(-45deg) scaleY(-1);"></div>
		<div class="hidden" id="contact_dropover" style="overflow: hidden; position: absolute; z-index: 10; height: 0px; width: 300px; right: 10px; top: -15px; background: #FFF; border: 2px solid #19B5EF; box-shadow: -3px 3px 8px #BBB">
			<div style="font-size: 1.3em; margin: 0 auto; text-align: center; font-weight: 300; position: relative;">
			<div style="margin-top: 10px;">Contact Us for a</div><div>FREE CONSULTATION</div></div>
			
			<div style="text-align: center; margin-top: 5px">
			<div style="display: inline-block; background: url(/images/results_lawyers.png) no-repeat 0 0; height: 50px; width: 50px;"></div>
			<div style="display: inline-block; background: url(/images/results_lawyers.png) no-repeat 0 -50px; height: 50px; width: 50px;"></div>
			<div style="display: inline-block; background: url(/images/results_lawyers.png) no-repeat 0 -100px; height: 50px; width: 50px;"></div>
			<div style="display: inline-block; background: url(/images/results_lawyers.png) no-repeat 0 -250px; height: 50px; width: 50px;"></div>
			<div style="display: inline-block; background: url(/images/results_lawyers.png) no-repeat 0 -200px; height: 50px; width: 50px;"></div>
			</div>
			
			<div style="margin: 5px 10px 15px; padding: 3px 2px 5px; font-size: 0.9em; text-align: center; border-top: 1px solid #999; border-bottom: 1px solid #999; font-style: italic; color: #999">Submit your contact information for a free, confidential review by an experienced attorney.</div>
			
			<div class="form_line" style="margin-top: 10px; padding-left: 10px;">
			<label>Name</label><input type="text" id="dropover_name" maxlength=50 class="sideinput"/></div>
			<div class="form_line" style="padding-left: 10px;"><label>E-mail</label><input type="email" id="dropover_email" maxlength=100  class="sideinput"/></div>
			<div class="form_line" style="padding-left: 10px;"><label>Phone</label><input type="tel" id="dropover_phone" maxlength=10 style="width: 105px" class="sideinput"/></div>
			<div class="orange-button" id="dropover_submit" style="text-align: center">Submit</div>
			<div class="warning_message" id="dropover_warning"></div>
			<div style="position: absolute; bottom: 3px; right: 3px; background: url(/images/results_lawyer.png); height: 111px; width: 74px"></div>
		</div>
	</div>
</section>
<script>
$(function(){
	$('#contact_caption').hover(function(){
		$('#contact_caption').css("text-decoration", "underline");
		$('#character_contact').css("background-position", "0 -146px");
		$('#contact_caption').css("color", "rgba(252, 181, 33, 1)");
	}, function(){
		$('#character_contact').css("background-position", "0 0");
		$('#contact_caption').css("text-decoration", "none");
		$('#contact_caption').css("color", "rgba(252, 181, 33, 0.85)");
	});
	
	$('#character_contact').hover(function(){
		$('#contact_caption').css("text-decoration", "underline");
		$('#character_contact').css("background-position", "0 -146px");
		$('#contact_caption').css("color", "rgba(252, 181, 33, 1)");
	}, function(){
		$('#character_contact').css("background-position", "0 0");
		$('#contact_caption').css("text-decoration", "none");
		$('#contact_caption').css("color", "rgba(252, 181, 33, 0.85)");
	});
});
</script>