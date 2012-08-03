<script type="text/javascript">
$(function() {
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
					$.ajax({
						type: "POST",
						url: "../function/find_slug",
						data: {tag: String(ui.item.value)},
						dataType: "html"
					}).done(function( data ) {
						if(data)
							window.location.href = String(data);
					});
					//var terms = split( this.value );
					// remove the current input
					//terms.pop();
					// add the selected item
					//terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					//terms.push( "" );
					//this.value = terms[0];
					return false;
				}
			});
});
</script>