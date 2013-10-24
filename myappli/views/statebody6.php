<div class="hidden" id="category-slug"><?=$method?></div>
<section id="partition-2" style="padding-top: 40px; margin-bottom: 40px">
	<div id="list-elements" style="border-radius: 10px; margin-top: -100px; padding-bottom: 20px;">
		<div style="font-family: Arvo; font-weight: 600; text-align: left; color: #2676a0; font-size: 20px; margin: 20px 20px 0; border-bottom: 2px dotted #2676a0; width: 450px; padding-bottom: 5px;"><?=$category->name?> Basics in <?=$state_name?></div>
		<div class="interface_description" style="margin: 20px 30px 30px; width: 620px; float: left; font-family: georgia, 'Times New Roman', serif; line-height: 1.4em;"><?php if(isset($summary)) echo $summary; else echo $description?></div>
		<div class="right" style="height: 278px; width: 175px; background: url(/images/character_cop.png); margin-right: 70px"></div>
	</div>
</section>
<!-- jquery -->
<script type="text/javascript">
$(function() {
	window.onbeforeunload = function() {
		$.post("/function/tracker", { type: "EXIT", time: Math.round(new Date().getTime() / 1000), test_id: <?=$test_id?>} );
	};
	
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
</script>