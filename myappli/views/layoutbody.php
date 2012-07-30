<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=265179353583781";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="maintainer">
	<div class="left" id="tagtainer">
		<?php if(sizeof($tags) > 0): ?>
			<?php foreach ($tags as $tag): ?>
				<a href="<?=$urlstem?><?=$method?>/<?=$tag->slug?>"><div class="tagname left"><?=$tag->tagname?></div></a>
			<?php endforeach; ?>
		<?php else: ?>
			<a href="#">[No Tags Exist Yet]</a>
		<?php endif; ?>
	</div>
	<div id="container" class="clickable clearfix right">

		<div class="loader">
			<img src="../../loading.gif" alt="ajax-loader"/>
		</div>
		
		<?php $counter = 0; ?>
		<?php foreach ($elements as $element): ?>
		
		<?php $counter++; ?>

		<a href="../view/<?php echo $element->slug?>" class="<?php echo strtolower($element->type); ?> isotope-item<?php 
		if(!$offset)
		{
			echo ' hidden';
			if($counter > 2 && $counter < 7)
			{
				echo ' width2';
			}
			else if($counter >= 6)
			{
				echo ' size2';
			}
		}
		else
		{
			echo ' size2';
		}
		?> location-<?php echo preg_replace( '/\s+/', '-', $element->location ); ?>" id="<?=$element->slug?>" data-toggle="modal">
			<?php if(strtolower($element->type) === 'photo') echo '<img src="'.$element->url.'"/>'; ?>
			
			<div class="leader">
				<div class="icon" id="icon_<?php echo strtolower($element->type);?>"></div>
				<div class="rating" style="float: right"><?=$element->votes?></div>
			</div>
			<h3 class="title"><?=$element->title?></h3>
			
			<div class="details">
				<?=$element->summary?>
			</div>
		</a>

		<?php endforeach; ?>
	</div> <!-- end #container -->
</div><!-- end #maintainer -->
<nav id="page_nav">
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
		  },
		  date: function( $elem ) {		
			if ($elem.find('.date').length != 0) {
			  return -1*Date.parse($elem.find('.date').text());
			} else {
			  return Number.NEGATIVE_INFINITY;
			}
		  },
		  alphabetical: function( $elem ) {
			var name = $elem.find('.title'),
				itemText = name.length ? name : $elem;
			return itemText.text();
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

		$('.isotope-item').removeClass('hidden');
		$('.loader').addClass('hidden');
		$container.isotope('insert', $('.isotope-item'));
	  
	function populateModal(slug)
	{
		$('#modalslug').html(slug);
	}
	  
	$('.isotope-item').click(function(e){
		var this_slug = $(this).attr('id');
		$('#myModal').modal('show');
		history.pushState({ slug: this_slug }, null, $('[id=' + this_slug + ']').attr('href'));
		populateModal(this_slug);
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
			$('.isotope-item').click(function(e){
				var this_slug = $(this).attr('id');
				$('#myModal').modal('show');
				history.pushState({ slug: this_slug }, null, $('[id=' + this_slug + ']').attr('href'));
				populateModal(this_slug);
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
		$(".modal-body").html('<img src="loading.gif"/>');
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
});

</script>

<!-- Young 07/25/2012 -->
<script src="http://scripts.embed.ly/jquery.embedly.min.js"></script> 
<script src="/js/jquery.expand.js"></script>
<script src="/js/expand.and.embed.js"></script>
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

</section> <!-- #content -->