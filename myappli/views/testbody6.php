<div class="hidden" id="category-slug"><?=$method?></div>
<section id="partition-2" style="padding-top: 40px;">
	<div id="list-elements"  style="border-radius: 10px 10px 0 0; margin-top: -100px">
		<div style="font-family: Arvo; font-weight: 600; text-align: left; color: #2676a0; font-size: 20px; margin: 20px 20px 0; border-bottom: 2px dotted #2676a0; width: 300px; padding-bottom: 5px;"><?=$category->name?> Basics</div>
		<div class="interface_description" style="margin: 20px 30px 30px; width: 620px; float: left; font-family: georgia, 'Times New Roman', serif; line-height: 1.4em;"><?php if(isset($summary)) echo $summary; else echo $description?></div>
		<div class="right" style="height: 278px; width: 175px; background: url(/images/character_cop.png); margin-right: 70px"></div>
	</div>
</section>
<!-- BEGIN LIST MODE -->
<section id="partition-2">
	<div id="list-elements">
		<div style="text-align: left; color: #666; font-size: 20px; font-weight: bold; margin: 20px 20px; border-bottom: 10px solid rgba(217, 219, 220, 1); width: 289px; padding-bottom: 8px;"><?=$category->name?> Articles</div><?php 
			$num_elements = count($elements);
			for ($count = 0; $count < $num_elements; $count++)
			{
				$element = $elements[$count];
				if($count % 7 === 0)
				{
					if($count >= 21)
						echo '<div class="article_column left" style="width: 289px; margin-left: 15px; border-bottom: 10px solid rgba(217, 219, 220, 1); padding-top: 20px;">';
					else
						echo '<div class="article_column left" style="width: 289px; margin-left: 15px; border-bottom: 10px solid rgba(217, 219, 220, 1); ">';
				}
			?>
		<div class="list-element">
		<a class="title" href="/<?php if($element->category === $relid) echo $relslug; else echo $method;?>/<?php echo $element->slug?>" id="<?=$element->slug?>" data-toggle="modal"><?=$element->title?></a>
		</div>
		<?php
			if($count % 7 === 6 || $count === $num_elements - 1)
				echo '</div>';
		} //End outer for loop?>
	</div>
</section>
<!-- END LIST MODE -->
<section id="partition-2" style="margin-bottom: 40px;">
	<div id="list-elements" style="padding-top: 20px; padding-bottom: 20px; border-radius: 0 0 10px 10px">
		<!--<div style="text-align: left; color: #666; font-size: 18px; margin: 20px 20px; border-bottom: 2px dotted #666; width: 300px; padding-bottom: 8px;"><?=$category->name?> by State</div>
		<div class="left state_column" style="width: 171px; margin-left: 20px;">
			<div><a href="alabama/" id="alabama">Alabama</a></div>
			<div><a href="alaska/" id="alaska">Alaska</a></div>
			<div><a href="arizona/" id="arizona">Arizona</a></div>
			<div><a href="arkansas/" id="arkansas">Arkansas</a></div>
			<div><a href="california/" id="california">California</a></div>
			<div><a href="colorado/" id="colorado">Colorado</a></div>
			<div><a href="connecticut/" id="connecticut">Connecticut</a></div>
			<div><a href="delaware/" id="delaware">Delaware</a></div>
			<div><a href="dc/" id="dc">District of Columbia</a></div>
			<div><a href="florida/" id="florida">Florida</a></div>
			<div><a href="georgia/" id="georgia">Georgia</a></div>
		</div>
		<div class="left state_column" style="width: 171px; margin-left: 15px;">
			<div><a href="hawaii/" id="hawaii">Hawaii</a></div>
			<div><a href="idaho/" id="idaho">Idaho</a></div>
			<div><a href="illinois/" id="illinois">Illinois</a></div>
			<div><a href="indiana/" id="indiana">Indiana</a></div>
			<div><a href="iowa/" id="iowa">Iowa</a></div>
			<div><a href="kansas/" id="kansas">Kansas</a></div>
			<div><a href="kentucky/" id="kentucky">Kentucky</a></div>
			<div><a href="louisiana/" id="louisiana">Louisiana</a></div>
			<div><a href="maine/" id="maine">Maine</a></div>
			<div><a href="maryland/" id="maryland">Maryland</a></div>
		</div>
		<div class="left state_column" style="width: 171px; margin-left: 15px;">
			<div><a href="massachusetts/" id="massachusetts">Massachusetts</a></div>
			<div><a href="michigan/" id="michigan">Michigan</a></div>
			<div><a href="minnesota/" id="minnesota">Minnesota</a></div>
			<div><a href="mississippi/" id="mississippi">Mississippi</a></div>
			<div><a href="missouri/" id="missouri">Missouri</a></div>
			<div><a href="montana/" id="montana">Montana</a></div>
			<div><a href="nebraska/" id="nebraska">Nebraska</a></div>
			<div><a href="nevada/" id="nevada">Nevada</a></div>
			<div><a href="new-hampshire/" id="new-hampshire">New Hampshire</a></div>
			<div><a href="new-jersey/" id="new-jersey">New Jersey</a></div>
		</div>
		<div class="left state_column" style="width: 171px; margin-left: 15px;">
			<div><a href="new-mexico/" id="new-mexico">New Mexico</a></div>
			<div><a href="new-york/" id="new-york">New York</a></div>
			<div><a href="north-carolina/" id="north-carolina">North Carolina</a></div>
			<div><a href="north-dakota/" id="north-dakota">North Dakota</a></div>
			<div><a href="ohio/" id="ohio">Ohio</a></div>
			<div><a href="oklahoma/" id="oklahoma">Oklahoma</a></div>
			<div><a href="oregon/" id="oregon">Oregon</a></div>
			<div><a href="pennsylvania/" id="pennsylvania">Pennsylvania</a></div>
			<div><a href="rhode-island/" id="rhode-island">Rhode Island</a></div>
			<div><a href="south-carolina/" id="south-carolina">South Carolina</a></div>
		</div>
		<div class="left state_column" style="width: 171px; margin-left: 15px;">
			<div><a href="south-dakota/" id="south-dakota">South Dakota</a></div>
			<div><a href="tennessee/" id="tennessee">Tennessee</a></div>
			<div><a href="texas/" id="texas">Texas</a></div>
			<div><a href="utah/" id="utah">Utah</a></div>
			<div><a href="vermont/" id="vermont">Vermont</a></div>
			<div><a href="virginia/" id="virginia">Virginia</a></div>
			<div><a href="washington/" id="washington">Washington</a></div>
			<div><a href="west-virginia/" id="west-virginia">West Virginia</a></div>
			<div><a href="wisconsin/" id="wisconsin">Wisconsin</a></div>
			<div><a href="wyoming/" id="wyoming">Wyoming</a></div>
		</div>-->
	</div>
</section>
<!-- jquery -->
<script type="text/javascript">
$(document).ready(function() {
	//Don't think this tracker works
	window.onbeforeunload = function() {
		$.post("/function/tracker", { type: "EXIT", time: Math.round(new Date().getTime() / 1000), test_id: <?=$test_id?>} );
	};
	
	/*hack to fix the column heights of articles*/
	var max_article_column_height = 0;
	$('.article_column').each(function() {
		if(max_article_column_height === 0)
			max_article_column_height = $(this).outerHeight();
		else if(max_article_column_height < $(this).outerHeight())
			max_article_column_height = $(this).outerHeight();
	}).height(max_article_column_height);

	//Test interface TEST
	$("#test_interface").fadeOut(500, function(){
		$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>").fadeIn(500);
	});

	firstPage(<?=$test_id?>, <?=$debug_mode?>);
	
	//Terminate this soon
	$("#result_submit").click(function(){
		$('#result_warning').empty().append('<img src="http://i.imgur.com/qkKy8.gif" />');	
		$.post("/function/submit_results",{ name: $("#field_name").attr("value"), email: $("#field_email").attr("value"), phone: $("#field_phone").attr("value"), test_id: <?=$test_id?>, time: Math.round(new Date().getTime() / 1000)}, function(data){
			if(String(data) != "")
			{
				$('#result_warning').empty().append(String(data));
				if(String(data) == "Thank you! A legal professional will contact you ASAP.")
				{
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