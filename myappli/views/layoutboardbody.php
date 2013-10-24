<section id="partition-2">
	<div id="list-elements">
		<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px;  background: #f0f3f4; width: 150px; margin-left: 10px;">Summary</div>
		<div style="margin: 20px 20px 30px; width: 620px; float: left; font-family: georgia, 'Times New Roman', serif; line-height: 1.4em;"><?php if(isset($summary)) echo $summary; else echo $description?></div>
		<!--<div class="left">
			<a href="http://lztrk.com/?a=4418&c=647&p=r&s1=" id="lzad"><img src="http://c363102.r2.cf1.rackcdn.com/647_300x250a.jpg" width="300" height="250" border="0" /></a>
			<div style="color: #AAA; text-align: right">Sponsored Ad</div>
		</div>-->
	</div>
</section>
<!-- BEGIN LIST MODE -->
<section id="list-elements" style="box-shadow: none;">
<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px;  background: url(/images/bg_square.png); width: 150px; margin-left: 10px;"><?php if(sizeof($elements) > 7) echo "More Articles"; else echo "No More Articles"; ?></div>

<?php for ($i = 7; $i < sizeof($elements); $i++): if(!isset($elements[$i])) break; $element = $elements[$i];
	$element = $elements[$i]; ?>
	<div class="list-element" <?php if($i === 7) echo 'style="border-top: none;"'; ?>>
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
<?php endfor; ?>

<!-- END LIST MODE -->
</section>
<!-- jquery -->
<script src="/js/jquery.isotope.min.js"></script>
<script type="text/javascript">

var $container = $('#container');

$(function() {
	$container.isotope({
		masonry: {
		  columnWidth: 190
		},
		getSortData: {
		  rating: function( $elem ) {
			var name = $elem.find('.rating');
			return -1*Number(name.text());
		  }
		},
		sortBy: 'original-order'
	  });

	  var $optionSets = $('#options .option-set'),
		  $optionLinks = $optionSets.find('a');

	  $optionLinks.click(function(){
		var $this = $(this);
		// don't proceed if already selected
		if ( $this.hasClass('selected') ) {
		  return false;
		}
		//toggle "selected classes"
		var $optionSet = $this.parents('.option-set');
		$optionSet.find('.selected').removeClass('selected');
		$this.addClass('selected');

		// make option object dynamically, i.e. { filter: '.my-filter-class' }
			var options = {},
				key = $optionSet.attr('data-option-key'),
				value = $this.attr('data-option-value');
			// parse 'false' as false boolean
			value = value === 'false' ? false : value;
			options[ key ] = value;
			if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
			  // changes in layout modes need extra logic
			  changeLayoutMode( $this, options )
			} else {
			  // otherwise, apply new options
			  $container.isotope( options );
			}
			
			return false;
	  });
	  
	function populateModal(slug)
	{
		$('#modalslug').html(slug);
	}
	  
	$('.isotope-item').click(function(e){
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
		
		$container.isotope(options);
	}
	
	$('#location_box').change(location_filter);
	  
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
		
	$('.isotope-item').removeClass('hidden');
	$('.loader').addClass('hidden');
	$container.isotope('insert', $('.isotope-item'));
	
	//Test interface TEST
	<?php if(isset($test_id)): ?>
		$('#start_guide').click(function(){
			$.getScript('/js/testengine.js', function(){
				firstPage(<?=$test_id?>);
			});
		});
	<?php endif; ?>
		
		
	$('.isotope-item').hover(function(){
		$(this).children('.isotope-hover').stop(true).animate({opacity: 1.0}, 200);
	},function(){
		$(this).children('.isotope-hover').stop(true).animate({opacity: 0.0}, 200);
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