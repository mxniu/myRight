<section class="content">
<div id="beta_box">
	<div id="test_interface">
	<?php if(!isset($test_id)): ?>
		<div class="left" style="width: 390px; padding: 0 20px 0 30px; text-align: left;">
			<h2 style="margin-top: 30px; line-height: 20px">Think something is missing?</h2>
			<p>We are giving a select group exclusive first access to curate the best legal information available online</p>
		</div> 
		<div class="left" style="width: 150px; padding-top: 30px; text-align: left">
			<a href="http://signup.myright.me" class="button_orange_thin" target="_blank" style="color: #FFF; margin: 0">Get Invited</a>
		</div>
	<?php else: ?>
		<div class="left" style="width: 390px; padding: 0 20px 0 30px; text-align: left;">
			<h2 style="margin-top: 25px; line-height: 20px">Not sure where to start?</h2>
			<?=$top_desc?>
		</div> 
		<div class="left" style="width: 150px; padding-top: 25px; text-align: left">
			<a href="#" id="start_guide" class="button_orange_thin" style="color: #FFF; margin: 0">Start Guide</a>
		</div>
	<?php endif; ?>
	</div>
</div>
<!--<section class="link-submit-form">
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
</section>-->
<section class="clearfix">
	<h2 class="left" style="text-transform: capitalize; font-size: 28px; line-height: 30px; color: #378daf;"><?=$title?></h2>
	<div class="right" style="margin-top: 28px">
		<?php 
			if(isset($locations))
			{
				echo "Location: ";
				$options = array("" => "-----");
				foreach($locations as $location)
				{
					$options[preg_replace( '/\s+/', '-', $location->location )] = $location->location;
				}
				echo form_dropdown('location', $options, $locget, 'id="location_box"');
			}
		?>
	</div>
</section>
</section>