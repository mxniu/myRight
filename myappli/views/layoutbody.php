<div id="container" class="clickable clearfix">

	<div class="loader">
		<img src="loading.gif" alt="ajax-loader"/>
	</div>
	
	<?php $counter = 0; ?>
	<?php foreach ($elements as $element): ?>
	
	<?php $counter++; ?>
	
	<a href="view/<?=$element->slug?>" class="<?php echo strtolower($element->type); ?> isotope-item hidden<?php 
	if($counter > 3 && $counter < 10)
	{
		echo ' width2';
	}
	else if($counter >= 10)
	{
		echo ' size2';
	}
	?>" id="<?=$element->slug?>">
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
<!-- jquery -->
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script src="/js/jquery.isotope.min.js"></script>
<!-- feed reader -->
<script type="text/javascript">

$.Isotope.prototype._getCenteredMasonryColumns = function() {
    this.width = this.element.width();
    
    var parentWidth = this.element.parent().width();
    
                  // i.e. options.masonry && options.masonry.columnWidth
    var colW = this.options.masonry && this.options.masonry.columnWidth ||
                  // or use the size of the first item
                  this.$filteredAtoms.outerWidth(true) ||
                  // if there's no items, use size of container
                  parentWidth;
    
    var cols = Math.floor( parentWidth / colW );
    cols = Math.max( cols, 1 );

    // i.e. this.masonry.cols = ....
    this.masonry.cols = cols;
    // i.e. this.masonry.columnWidth = ...
    this.masonry.columnWidth = colW;
  };
  
  $.Isotope.prototype._masonryReset = function() {
    // layout-specific props
    this.masonry = {};
    // FIXME shouldn't have to call this again
    this._getCenteredMasonryColumns();
    var i = this.masonry.cols;
    this.masonry.colYs = [];
    while (i--) {
      this.masonry.colYs.push( 0 );
    }
  };

  $.Isotope.prototype._masonryResizeChanged = function() {
    var prevColCount = this.masonry.cols;
    // get updated colCount
    this._getCenteredMasonryColumns();
    return ( this.masonry.cols !== prevColCount );
  };
  
  $.Isotope.prototype._masonryGetContainerSize = function() {
    var unusedCols = 0,
        i = this.masonry.cols;
    // count unused columns
    while ( --i ) {
      if ( this.masonry.colYs[i] !== 0 ) {
        break;
      }
      unusedCols++;
    }
    
    return {
          height : Math.max.apply( Math, this.masonry.colYs ),
          // fit container to columns that have been used;
          width : (this.masonry.cols - unusedCols) * this.masonry.columnWidth
        };
  };

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
		$container.isotope('insert', $('.isotope-item') );
		/*var current = 0;
		var max_div = ($container.children('.isotope-item').size()-1);
		for(current=0;current<=max_div;current++)
		{
			setTimeout(function () { 
				$container.isotope('insert', $('.isotope-item').eq(current) );
			}, 1000);
		}*/
		
		$('.isotope-item').hover(function(){
			$('[id=' + $(this).attr('id') + ']').children('.details').stop(true).animate({opacity: 1.0}, 150);
		}, function(){
			$('[id=' + $(this).attr('id') + ']').children('.details').stop(true).animate({opacity: 0.0}, 150);
		});
		
      /*$container.delegate( '.isotope-item', 'click', function(){
		$('.supersize').toggleClass('supersize');
        $(this).toggleClass('supersize');
        $container.isotope('reLayout');
		$('.details').hide();
		$('[id=' + $(this).attr('id') + ']').children('.details').show();
      });*/
});

</script>

<!-- Young 07/25/2012 -->
<script src="http://scripts.embed.ly/jquery.embedly.min.js"></script> 
<script src="/js/jquery.expand.js"></script>
<script src="/js/expand.and.embed.js"></script>
<!-- End Young -->

</section> <!-- #content -->