<section id="partition-1" <?php if($bgimage) echo 'style="background: url(/images/'.$bgimage.') 0 0 no-repeat;"'; ?>>
	<div id="content">
		<div id="category-title">
			<div class="left backbutton"></div>
			<div class="right orange-button" id="find-a-lawyer">Find a Lawyer</div>
			<h1 class="left" id="tag-title" style="text-transform: capitalize; font-size: 28px; margin: 10px 0; color: #378daf;"><?=$title?></h1>
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
</section>