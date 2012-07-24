<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Supa myRight</title>
  <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <link rel="stylesheet" href="css/isotope.css" />
  <link href='http://fonts.googleapis.com/css?family=Quattrocento:400,700|Quattrocento+Sans:400,700|Lato:700,400,300|Cabin:600' rel='stylesheet' type='text/css'>
  <!-- scripts at bottom of page -->
</head>
<body>
<div class="glassify" id="topbar"></div>
<section id="content">
<section id="options" class="clearfix">
	<div class="option-logo">
		<h1>myRight</h1>
	</div>
	<div class="option-combo">
	  <ul id="sort" class="option-set clearfix" data-option-key="sortBy">
      	<li><a href="#rating" data-option-value="rating" class="selected" style="border-left: 1px solid black">rating</a></li>
	    <li><a href="#date" data-option-value="date">date</a></li>
	    <li><a href="#alphabetical" data-option-value="alphabetical">a-z</a></li>
	  </ul>
	</div>
	<div class="option-combo">
	  <ul id="filter" class="option-set clearfix" data-option-key="filter">
	    <li><a href="#show-all" data-option-value="*" class="selected" style="border-left: 1px solid black">all</a></li>
	    <li><a href="#news" data-option-value=".news, .photo">news</a></li>
	    <li><a href="#resources" data-option-value=".info, .primary, .secondary">resources</a></li>
	  </ul>
	</div>
</section>


<div id="container" class="clickable clearfix">

	<div class="loader" data-number="3">
		<img src="images/ajax-loader.gif" alt="ajax-loader" width="16" height="16" /> Loading...
	</div>
	
</div> <!-- end #container -->
<!-- jquery -->
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script src="js/jquery.fittext.js"></script>
<script src="https://www.google.com/jsapi"></script>
<script src="js/jquery.isotope.min.js"></script>
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
	 
	
  $.post("gettag.php",{ sendValue: 1 },
			function(data){
				var $newItems = "";
				var whatever = 0;
				for(x in data)
				{
					if(data[x]['parent'])
					{
						$newItems += '<div class="tag feed-item isotope-item';
						var headline = String(data[x]['tagname']);
						$newItems += '"><h3 class="title">' + headline + '</h3>';
						$newItems += '</div>';
					}
					else
					{
						var this_type = String(data[x]['type']).toLowerCase()
						$newItems += '<div class="' + this_type + ' feed-item isotope-item';
						if(whatever==0)
							{}
						else if(whatever==1)
							$newItems += ' width2';
						else if(whatever<3)
							$newItems += ' height2';
						else
							$newItems += ' size2';
						whatever++;
							
						var headline = String(data[x]['title']);
						if(!headline)
						{
							headline = String(data[x]['url']).replace(/^.*[\\\/]/, '');
						}
						$newItems += '"><div class="leader"><div class="icon" id="icon_' + this_type + '"></div><div class="rating" style="float: right">' + String(data[x]['votes']) + '</div></div>';
						if(this_type == 'photo')
						{
							$newItems += '<div class="glassify"><img src="' + String(data[x]['url']) + '" /></div>';
						}
						else
						{
							$newItems += '<h3 class="title"><a href="/bah/' + headline + '">' + headline + '</a></h3>';
						}
						$newItems += '</div>';
					}
				}

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
					$('.loader').addClass('hidden');
					
					$container.isotope('insert', $(String($newItems)) );

            }, "json");
});

</script>
</section> <!-- #content -->
</body>
</html>