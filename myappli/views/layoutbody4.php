<div class="hidden" id="category-slug"><?=$method?></div>
<div class="hidden" id="location-slug"><?=$locget?></div>
<section id="partition-2">
	<div id="list-elements"  style="margin-top: 20px; border-radius: 10px 10px 0 0">
		<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px;  background: #f0f3f4; width: 150px; margin-left: 10px;">Summary</div>
		<div class="interface_description" style="margin: 20px 20px 30px; width: 620px; float: left; font-family: georgia, 'Times New Roman', serif; line-height: 1.4em;"><?php if(isset($summary)) echo $summary; else echo $description?></div>
		<!--<div class="left">
			<a href="http://lztrk.com/?a=4418&c=647&p=r&s1=" id="lzad"><img src="http://c363102.r2.cf1.rackcdn.com/647_300x250a.jpg" width="300" height="250" border="0" /></a>
			<div style="color: #AAA; text-align: right">Sponsored Ad</div>
		</div>-->
	</div>
</section>
<!-- BEGIN LIST MODE -->
<section id="partition-2">
<div id="list-elements">
<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px;  background: #f0f3f4; width: 150px; margin-left: 10px;"><?php if(sizeof($elements) > 0) echo "Sources & More"; else echo "No Sources Found"; ?></div>
<?php foreach ($elements as $element): ?>
	<div class="list-element">
		<div class="title-wrapper"><a class="title" href="/<?php if($element->category === $relid) echo $relslug; else echo $method;?>/<?php echo $element->slug?>" id="<?=$element->slug?>" data-toggle="modal"><?=$element->title?><div class="list_source">&nbsp;</div></a></div>
		<div class="list_type"><?php
			if($element->type === "primary"):
				echo "The Law";
			elseif($element->type === "secondary"):
				echo "Legal Info";
			elseif($element->type === "news"):
				echo "News Article";
			elseif($element->type === "document"):
				echo "Document";
			endif;
		?></div>
		<div class="lowcount"><?=$element->views?></div><div class="lowicon icon_views"></div>
		<!--<div class="lowcount">0</div><div class="lowicon icon_comments"></div>-->
		<div class="lowcount"><?=$element->votes?></div><div class="lowicon icon_rating"></div>
		<div class="icon_share">Share</div>
	</div>
<?php endforeach; ?>
</div>
</section>
<!-- END LIST MODE -->
<!-- jquery -->
<script type="text/javascript">
$(function() {
	window.onbeforeunload = function() {
		$.post("/function/tracker", { type: "EXIT", time: Math.round(new Date().getTime() / 1000), test_id: NUM} );
	};
	
	function location_filter(){
		var options = {};
		var val = $('#location_box option:selected').attr('value');
		
		if(val)
		{
			window.location.href = '?location=' + val;
		}
		else
		{
			window.location.href = window.location.pathname.split("?")[0];
		}
	}
	
	$('#location_box').change(location_filter);
	
	//Test interface TEST
	$("#test_interface").fadeOut(500, function(){
		$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>").fadeIn(500);
	});	
	
	firstPage(<?=$test_id?>, <?=$debug_mode?>);
	
	$("#result_submit").click(function(){
			$('#result_warning').empty().append('<img src="http://i.imgur.com/qkKy8.gif" />');	
			$.post("/function/submit_results",{ name: $("#field_name").attr("value"), email: $("#field_email").attr("value"), phone: $("#field_phone").attr("value"), test_id: <?=$test_id?>, time: Math.round(new Date().getTime() / 1000)}, function(data){
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
	
	function populateModal(slug)
	{
		$('#modalslug').html(slug);
	}
	
	$('.list-element').children('.title-wrapper').children('.title').click(function(e){
		var this_slug = $(this).attr('id');
		$('#myModal').modal('show');
		history.pushState({ slug: this_slug }, null, $('[id=' + this_slug + ']').attr('href'));
		populateModal(this_slug);
		if(e.preventDefault){  
			e.preventDefault();  
		}else{  
			e.returnValue = false;  
			e.cancelBubble=true; 
		}
		return false;
	});
	
	window.onpopstate = function (event) {
		if(event.state)
		{
			populateModal(event.state.slug);
			$('#myModal').modal('show');
		}
		else
		{
			$('#myModal').modal('hide');
		}
	}
	
	$('#myModal').on('shown', function () {
		$.ajax({
		  type: "POST",
		  url: "/viewajax/"+$('#modalslug').html(),
		  dataType: "html"
		}).done(function( data ) {
			$('#myModal').children(".modal-body").children(".modal-center").html(data);
		});
		
	});
	
	$('#myModal').on('show', function(){
		$('body').css('overflow', 'hidden');
	});
	
	$('#myModal').on('hidden', function () {
		$('#myModal').children(".modal-body").children(".modal-center").html('<img src="http://i.imgur.com/qkKy8.gif"/>');
		$('body').css('overflow', 'auto');
	});
});

</script>

<div class="modal hidden fade" id="myModal">
	<div id="modalslug" class="hidden"></div>
	<div class="modal-body fade">
		<div class="modal-center">
			<img src="http://i.imgur.com/qkKy8.gif"/>
		</div>
	</div>
</div>