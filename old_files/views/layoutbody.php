<?php if($ajax === FALSE): ?>
<div class="hidden" id="category-slug"><?=$method?></div>
<div class="hidden" id="location-slug"><?=$locget?></div>
<!-- BEGIN LIST MODE -->
<section id="list-elements">
<?php endif; ?>
<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px;  background: url(../images/bg_square.png); width: 150px; margin-left: 10px;"><?php if(sizeof($elements) > 0) echo "Sources & More"; else echo "No Sources Found"; ?></div>
<?php foreach ($elements as $element): ?>
	<div class="list-element">
		<div class="title-wrapper"><a class="title" href="<?php echo $element->url?>" id="<?=$element->slug?>" target="_blank"><?=$element->title?><div class="list_source"><?php echo preg_replace("/^www\./", "", parse_url($element->url, PHP_URL_HOST));?></div></a></div>
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
		<div class="lowcount">0</div><div class="lowicon icon_comments"></div>
		<div class="lowcount"><?=$element->votes?></div><div class="lowicon icon_rating"></div>
		<div class="icon_share">Share</div>
	</div>
<?php endforeach; ?>
<!-- END LIST MODE -->
<?php if(!$offset): ?>
<nav id="page_nav" style="position: relative; top: -150px">
	<a href="<?php echo $_SERVER["REQUEST_URI"]; if(strpos($_SERVER["REQUEST_URI"], "?") === false) echo "?"; else echo "&";?>page=2"></a>
</nav>
<?php endif; ?>
<?php if($ajax === FALSE): ?>
</section>
<?php if(!$offset): ?>
<!-- jquery -->
<script type="text/javascript">
$(function() {
	/*function populateModal(slug)
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
	}*/
	
	function location_filter(){
		var options = {};
		var val = $('#location_box option:selected').attr('value');
		
		if(val)
		{
			//options['filter'] = '.location-' + val;
			//history.replaceState(null, null, '?location=' + val);
			window.location.href = '?location=' + val;
		}
		else
		{
			//options['filter'] = '';
			//history.replaceState(null, null, window.location.pathname.split("?")[0]);
			window.location.href = window.location.pathname.split("?")[0];
		}
	}
	
	$('#location_box').change(location_filter);
	
	$('#list-elements').infinitescroll({
        navSelector  : '#page_nav',    // selector for the paged navigation 
        nextSelector : '#page_nav a:first',  // selector for the NEXT link (to page 2)
        itemSelector : '.list-element',     // selector for all items you'll retrieve
        loading: {
            finishedMsg: 'No more articles to load.',
            img: 'http://i.imgur.com/qkKy8.gif'
          }
        },
        function( newElements ) {
			$('#list-elements').append(newElements);
			/*$('.list-element').children('.title-wrapper').children('.title').unbind('click');
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
			});*/
        }
    );
	  
	/*$('#myModal').on('shown', function () {
		$.ajax({
		  type: "POST",
		  url: "../viewajax/"+$('#modalslug').html(),
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
	});*/
	
	//Test interface TEST
	$("#test_interface").fadeOut(500, function(){
		$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>").fadeIn(500);
	});	
	$.getScript('../js/testengine.js', function(){
		firstPage(<?=$test_id?>);
	});
	
	$("div[id^='result_option_']").click(function() {
		var id = $(this).attr("id").split("_")[2];
		if($("div[id='result_check_" + id + "']").css("background-position") == "0px 0px")
		{
			$("div[id='result_check_" + id + "']").css("background-position", "0px -23px");
		}
		else
		{
			$("div[id='result_check_" + id + "']").css("background-position", "0px 0px");
		}
	});
	
	$("#result_submit").click(function(){
			$('#result_warning').empty().append('<img src="http://i.imgur.com/qkKy8.gif" />');	
			/*if($("div[id='result_check_answers']").css("background-position") == "0px 0px")
			{
				$('#result_warning').css("color", "#F24122");
				$('#result_warning').empty().append('You must agree to submit your answers');
				return;
			}*/
			if($("div[id='result_check_terms']").css("background-position") == "0px 0px")
			{
				$('#result_warning').css("color", "#F24122");
				$('#result_warning').empty().append('You must agree to the Terms of Use');
				return;
			}
			$.post("../function/submit_results",{ name: $("#field_name").attr("value"), email: $("#field_email").attr("value"), phone: $("#field_phone").attr("value"), test_id: <?=$test_id?>, time: Math.round(new Date().getTime() / 1000)}, function(data){
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

<!-- Young 07/25/2012 -->
<!--<script src="http://scripts.embed.ly/jquery.embedly.min.js"></script>
<script src="/js/jquery.expand.js"></script>
<script src="/js/expand.and.embed.js"></script>-->
<!-- End Young -->

<script src="/js/jquery.infinitescroll.js"></script>

<div class="modal hidden fade" id="myModal">
	<div id="modalslug" class="hidden"></div>
	<div class="modal-body fade">
		<div class="modal-center">
			<img src="http://i.imgur.com/qkKy8.gif"/>
		</div>
	</div>
</div>
<?php endif; ?>
<?php endif; ?>