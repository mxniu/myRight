<section id="partition-1" style="background: none;">
	<div id="content">
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
<div class="container_12 default_pane" style="margin-bottom: 40px; padding: 5px 0; overflow: hidden;" id="element_top">
	<div class="author_thumbnail" <?php if($poster) {echo 'style="background-image:url(/images/posters/'.$poster->image.')"';}	?>></div>
	<div class="element_meta">
		<h2><?php if($poster) {
			if($poster->gplus)
				echo '<a rel="author" href="'.$poster->gplus.'" target="_blank">'.$poster->name.'</a>';
			else if($poster->url)
				echo '<a rel="author" href="'.$poster->url.'" target="_blank">'.$poster->name.'</a>';
			else
				echo $poster->name;
			} else echo 'myRight'; ?></h2>
		<p class="orange"><?php if($poster){ if($poster->type === '1') echo 'Guest Contributor'; else echo 'Associate Editor';} else echo 'Admin';?></p>
		<p class="posted"><?php if($element->date_created === '0') echo "Posted September 26, 2012"; else echo date("F j, Y", $element->date_created);?></p>
		
	</div>
	<h1 style="margin-left: 20px"><?=$element->title?></h1>
	<p class="tags" style="margin-left: 20px"><?=$element->tags?></p>
	<?php if($element->url): 
		echo '<span style="font-size: 12px; color: #666; margin-left: 20px;">Source: </span>'; 
		$urls = explode(",", $element->url);
		$c1 = true;
		foreach($urls as $url):
		if($c1)
			$c1 = false;
		else
			echo ", ";
		$url = trim($url);?><a href="<?=$url?>" target="_blank" style="font-size: 12px; color: #666"><?php echo trim(preg_replace("/^www\./", "", parse_url($url, PHP_URL_HOST)));?></a><?php endforeach; endif; ?>
	<div class="element" id="element_body" style="margin: 20px 20px 30px">
		<?=$element->summary?>
	</div>
</div> <!-- end #container -->
<!-- jquery -->
<script type="text/javascript">
$(function() {
	//Test interface TEST
	$("#test_interface").fadeOut(500, function(){
		$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>").fadeIn(500);
	});	
	
	firstPage(<?=$category->test_id?>, false);
	
	$("#result_submit").click(function(){
			$('#result_warning').empty().append('<img src="http://i.imgur.com/qkKy8.gif" />');	
			$.post("/function/submit_results",{ name: $("#field_name").attr("value"), email: $("#field_email").attr("value"), phone: $("#field_phone").attr("value"), test_id: <?=$category->test_id?>, time: Math.round(new Date().getTime() / 1000)}, function(data){
				if(String(data) != "")
				{
					$('#result_warning').empty().append(String(data));
					if(String(data) == "Thank you! A legal professional will contact you ASAP.")
					{
						_kmq.push(['record', 'Conversion']);
						$('#result_warning').css("color", "#27C22F");
						$("#field_name").attr("value", "");
						$("#field_email").attr("value", "");
						$("#field_phone").attr("value", "");
						$("div[id='result_check_terms']").css("background-position", "0px 0px")
					}
					else
					{
						$('#result_warning').css("color", "#F24122");
					}
				}
				});
		});
});

</script>