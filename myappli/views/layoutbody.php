<div id="maintainer">
	<div class="left" id="tagtainer">
	<?php if(!$offset): ?>
		<?php if(sizeof($tags) > 0): ?>
			<?php foreach ($tags as $tag): ?>
				<a href="<?=$urlstem?><?=$method?>/<?=$tag->slug?>"><div class="tagname left"><?=$tag->tagname?></div></a>
			<?php endforeach; ?>
		<?php else: ?>
			<a href="#">[No Tags Exist Yet]</a>
		<?php endif; ?>
	<?php endif; ?>
	</div>
	<?php if(!$offset): ?>
		<div class="loader">
			<img src="http://i.imgur.com/qkKy8.gif" alt="ajax-loader"/>
		</div>
		<?php endif; ?>
	<div id="container" class="clearfix right">

		<?php $counter = 0; ?>
		<?php foreach ($elements as $element): ?>
		
		<?php $counter++; $show_detail = TRUE;?>

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
		?> <!--location---><?php //echo preg_replace( '/\s+/', '-', $element->location );?> <?php
			if(!$offset)
			{
				echo "color".(int)(($counter/4) + 1);
			}
			else
			{
				$color_num = (int)(((($offset * 13) + $counter)/4) + 1);
				if($color_num > 8)
					$color_num = 8;
				echo "color".$color_num;
			}
		?>" id="<?=$element->slug?>" data-toggle="modal">
			<?php if(strtolower($element->type) === 'photo') echo '<img src="'.$element->url.'"/>'; ?>
			
			<div class="leader">
				<div class="icon" id="icon_<?php echo strtolower($element->type);?>"></div>
				<div class="rating" style="float: right"><?=$element->votes?></div>
			</div>
			<h3 class="title"><?=$element->title?></h3>
			
			<div class="details <?php if($show_detail) echo "visible"; ?>">
				<?=$element->summary?>
			</div>
			
			<?php if($show_detail && $element->type !== 'photo'): ?>
				<div class="gradient-mask"></div>
			<?php endif; ?>
		</a>
		<?php endforeach; ?>
	</div> <!-- end #container -->
</div><!-- end #maintainer -->
<?php if(!$offset): ?>
<nav id="page_nav" style="position: relative; top: -100px">
	<a href="<?php echo $_SERVER["REQUEST_URI"]; if(strpos($_SERVER["REQUEST_URI"], "?") === false) echo "?"; else echo "&";?>page=2"></a>
</nav>
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
		sortBy: 'rating'
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
	
	$('#tagtainer').animate({opacity: 1.0}, 200);
	
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
        itemSelector : '.isotope-item',     // selector for all items you'll retrieve
        loading: {
            finishedMsg: 'No more articles to load.',
            img: 'http://i.imgur.com/qkKy8.gif'
          }
        },
        // call Isotope as a callback
        function( newElements ) {
			$container.isotope( 'appended', $( newElements ) ); 
			$('.isotope-item').unbind('click');
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
        }
    );
	  
	$('#myModal').on('shown', function () {
		$.ajax({
		  type: "POST",
		  url: "../viewajax/"+$('#modalslug').html(),
		  dataType: "html"
		}).done(function( data ) {
			$(".modal-body").html(data);
			FB.XFBML.parse();
		});
	});
	
	$('#myModal').on('hidden', function () {
		$(".modal-body").html('<img src="http://i.imgur.com/qkKy8.gif"/>');
	});
	
	var availableTags = [<?php
		if ($alltags) {
			$first_time = 1;
			foreach ($alltags as $tag) {
				if($first_time == 1)
				{
					$first_time = 0;
				}
				else
				{
					echo ",";
				}
				echo "'".$tag->tagname."'";
			}
		}
		?>];
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#top-search-input" )
			// don't navigate away from the field on tab when selecting an item
			.bind( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).data( "autocomplete" ).menu.active) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					var results = $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) );
					response(results.slice(0, 10));
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					//terms.push( "" );
					this.value = terms[0];
					return false;
				}
			});
			
		$(window).scroll(function(){
			if ($(window).scrollTop() >= 70) {
				//$('.back_button').css("opacity", "1.0");
				$('#tagtainer').css({
					position: 'fixed',
					top: '120px',
					//left: '50%',
					//marginLeft: '-495px',
					//background: '#FFF'
				});
			}
			else 
			{
				//$('.back_button').css("opacity", "0.4");
				$('#tagtainer').css({
					position: 'static'
				});
			}
		});
		
		setTimeout(function(){
			$('.isotope-item').removeClass('hidden');
			$('.loader').addClass('hidden');
			$container.isotope('insert', $('.isotope-item'));
		},500);
});

</script>

<!-- Young 07/25/2012 -->
<!--<script src="http://scripts.embed.ly/jquery.embedly.min.js"></script>
<script src="/js/jquery.expand.js"></script>
<script src="/js/expand.and.embed.js"></script>-->
<!-- End Young -->

<!-- More JS Twitter Bootstrap 07/26/2012-->
<script src="/js/bootstrap-transition.js"></script>
<script src="/js/bootstrap-modal.js"></script>
<!-- End More JS -->

<script src="/js/jquery.infinitescroll.min.js"></script>

<div class="modal hidden fade" id="myModal">
	<div id="modalslug" class="hidden"></div>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">x</button>
  </div>
  <div class="modal-body">
	<img src="loading.gif"/>
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal">Close</a>
  </div>
</div>
<div id="fb-root"></div>
<?php endif; ?>