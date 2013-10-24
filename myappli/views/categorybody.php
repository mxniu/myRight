<div class="hidden" id="category-slug"><?=$method?></div>
<div class="hidden" id="location-slug"><?=$locget?></div>
<!-- BEGIN LIST MODE -->
<section id="partition-2" style="padding-top: 20px;">
<div id="list-elements" style="border-radius: 10px">
<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px;  background: #f0f3f4; width: 150px; margin-left: 10px;"><?php if(sizeof($elements) > 0) echo "Sources & More"; else echo "No Sources Found"; ?></div>
<?php foreach ($elements as $element): ?>
	<div class="list-element">
		<div class="title-wrapper"><a class="title" href="/<?=$method?>/<?php echo $element->slug?>" id="<?=$element->slug?>" data-toggle="modal"><?=$element->title?><div class="list_source">&nbsp;</div></a></div>
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
<!-- END LIST MODE -->
</div>
</section>
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