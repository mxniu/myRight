<?php if(!$offset): ?>
<div id="maintainer">
	<div class="left" id="tagtainer">
		<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px; background: url(../images/bg_square.png)">Related Tags</div>
		<?php if(sizeof($tags) > 0): ?>
			<?php foreach ($tags as $tag): ?>
				<a href="<?=$urlstem?><?=$method?>/<?=$tag->slug?><?php if($locget) echo "?location=".$locget; ?>"><div class="tagname left"><?=$tag->tagname?></div></a>
			<?php endforeach; ?>
		<?php else: ?>
			<a href="#">[No Tags Exist Yet]</a>
		<?php endif; ?>
	</div>
		<div class="loader">
			<img src="http://i.imgur.com/qkKy8.gif" alt="ajax-loader"/>
		</div>
	<div id="container" class="clearfix right">

		<?php for ($counter = 1; $counter < 8; $counter++): ?>
		
		<?php if(!isset($elements[$counter-1])) break; $element = $elements[$counter-1]; $show_detail = TRUE;?>

		<a href="../view/<?php echo $element->slug?>" class="<?php echo strtolower($element->type); ?> isotope-item<?php 
		if(!$offset)
		{
			echo ' hidden';
			if($counter > 1 && $counter <= 3)
			{
				echo ' height2';
			}
			else if($counter === 5 || $counter === 8 || $counter === 13)
			{
				echo ' width2';
			}
			else if(($counter > 5 && $counter <= 7) || ($counter > 8 && $counter <= 12) || ($counter > 13))
			{
				echo ' size2';
				$show_detail = FALSE;
			}
		}
		else
		{
			echo ' size2';
			$show_detail = FALSE;
		}
		?>" id="<?=$element->slug?>" data-toggle="modal">
			<?php if(strtolower($element->type) === 'photo') echo '<img src="'.$element->url.'"/>'; ?>
		
			<h3 class="title"><?=$element->title?></h3>
			
			<div class="details <?php if($show_detail) echo "visible"; ?>">
				<?=$element->summary?>
			</div>
			
			<div class="comments_box"></div>
			
			<div class="isotope-hover">
				<div class="view-this">View this</div>
				<div class="type-string"><?php
				if($element->type === "primary")
				{
					echo "Law";
				}
				else if($element->type === "secondary")
				{
					echo "Legal Info";
				}
				else if($element->type === "news")
				{
					echo "News Article";
				}
				else if($element->type === "document")
				{
					echo "Document";
				}
				?></div>
			</div>
			
			<div class="lowliner">
				<div class="lowcount"><?=$element->views?></div><div class="lowicon icon_views"></div>
				<div class="lowcount">0</div><div class="lowicon icon_comments"></div>
				<div class="lowcount"><?=$element->votes?></div><div class="lowicon icon_rating"></div>
			</div>
		</a>
		<?php endfor; ?>
	</div> <!-- end #container -->
</div><!-- end #maintainer -->
<?php endif; ?>
<!-- BEGIN LIST MODE -->
<section id="list-elements">
<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px;  background: url(../images/bg_square.png); width: 150px; margin-left: 10px;"><?php if(sizeof($elements) > 7) echo "More Articles"; else echo "No More Articles"; ?></div>
<?php if(!$offset): /*List the remainder if not n-page*/ ?>

<?php for ($i = 7; $i < 20; $i++):
	if(!isset($elements[$i])) break; $element = $elements[$i];
	$element = $elements[$i]; ?>
	<div class="list-element" <?php if($i === 7) echo 'style="border-top: none;"'; ?>>
		<div class="title-wrapper"><a class="title" href="../view/<?php echo $element->slug?>" id="<?=$element->slug?>" data-toggle="modal"><?=$element->title?><div class="list_source"><?php echo preg_replace("/^www\./", "", parse_url($element->url, PHP_URL_HOST));?></div></a></div>
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
<?php endfor; ?>

<?php else: /*Else list all that shit*/ ?>

<?php foreach ($elements as $element): ?>
	<div class="list-element">
		<div class="title-wrapper"><a class="title" href="../view/<?php echo $element->slug?>" id="<?=$element->slug?>" data-toggle="modal"><?=$element->title?><div class="list_source"><?php echo preg_replace("/^www\./", "", parse_url($element->url, PHP_URL_HOST));?></div></a></div>
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

<?php endif; ?>
<!-- END LIST MODE -->
<nav id="page_nav" style="position: relative; top: -150px">
	<a href="<?php echo $_SERVER["REQUEST_URI"]; if(strpos($_SERVER["REQUEST_URI"], "?") === false) echo "?"; else echo "&";?>page=2"></a>
</nav>
</section>
<?php if(!$offset): ?>
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
		
		$container.isotope(options);
	}
	
	$('#location_box').change(location_filter);
	
	$container.infinitescroll({
        navSelector  : '#page_nav',    // selector for the paged navigation 
        nextSelector : '#page_nav a:first',  // selector for the NEXT link (to page 2)
        itemSelector : '.list-element',     // selector for all items you'll retrieve
        loading: {
            finishedMsg: 'No more articles to load.',
            img: 'http://i.imgur.com/qkKy8.gif'
          }
        },
        // call Isotope as a callback
        function( newElements ) {
			//$container.isotope( 'appended', $( newElements ) ); 
			$('#list-elements').append(newElements);
			$('.list-element').children('.title-wrapper').children('.title').unbind('click');
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
        }
    );
	  
	$('#myModal').on('shown', function () {
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
	});
		
	$('.isotope-item').removeClass('hidden');
	$('.loader').addClass('hidden');
	$container.isotope('insert', $('.isotope-item'));
	
	//Test interface TEST
	<?php if(isset($test_id)): ?>
		$('#start_guide').click(function(){
			$.getScript('../js/testengine.js', function(){
				firstPage(<?=$test_id?>);
			});
		});
	<?php endif; ?>
		
		
	$('.isotope-item').hover(function(){
		$(this).children('.isotope-hover').stop(true).animate({opacity: 1.0}, 200);
	},function(){
		$(this).children('.isotope-hover').stop(true).animate({opacity: 0.0}, 200);
	});
	
	/*$('.list-element').hover(function(){
		$(this).children('.icon_share').stop(true).animate({opacity: 1.0}, 200);
	},function(){
		$(this).children('.icon_share').stop(true).animate({opacity: 0.0}, 200);
	});*/
});

</script>

<!-- Young 07/25/2012 -->
<!--<script src="http://scripts.embed.ly/jquery.embedly.min.js"></script>
<script src="/js/jquery.expand.js"></script>
<script src="/js/expand.and.embed.js"></script>-->
<!-- End Young -->

<script src="/js/jquery.infinitescroll.min.js"></script>


<div class="modal hidden fade" id="myModal">
	<div id="modalslug" class="hidden"></div>
	<div class="modal-body fade">
		<div class="modal-center">
			<img src="http://i.imgur.com/qkKy8.gif"/>
		</div>
	</div>
</div>
<?php endif; ?>