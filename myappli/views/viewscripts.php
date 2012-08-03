<script type="text/javascript">
$(function() {
	$('#useful_yes').click(function(){
		$('#review_buttons>input').unbind('click');
		$.ajax({
			type: "POST",
			url: "../function/vote",
			data: {action : 'up', id : <?=$element->id?>, votes: <?=$element->votes?>},
			dataType: "html"
		}).done(function( data ) {
			//UPDATE NUMBER
			if(data === "SUCCESS")
				$('.rating-number').html(Number($('.rating-number').html()) + 1);
		});
		return false;
	});
	$('.rating-up').click(function(){
		$('#review_buttons>input').unbind('click');
		$.ajax({
			type: "POST",
			url: "../function/vote",
			data: {action : 'up', id : <?=$element->id?>, votes: <?=$element->votes?>},
			dataType: "html"
		}).done(function( data ) {
			//UPDATE NUMBER
			if(data === "SUCCESS")
				$('.rating-number').html(Number($('.rating-number').html()) + 1);
		});
		return false;
	});
	$('#useful_no').click(function(){
		$('#review_buttons>input').unbind('click');
		$.ajax({
			type: "POST",
			url: "../function/vote",
			data: {action : 'down', id : <?=$element->id?>, votes: <?=$element->votes?>},
			dataType: "html"
		}).done(function( data ) {
			//UPDATE NUMBER
			if(data === "SUCCESS")
				$('.rating-number').html(Number($('.rating-number').html()) - 1);
		});
		return false;
	});
	$('.rating-down').click(function(){
		$('#review_buttons>input').unbind('click');
		$.ajax({
			type: "POST",
			url: "../function/vote",
			data: {action : 'down', id : <?=$element->id?>, votes: <?=$element->votes?>},
			dataType: "html"
		}).done(function( data ) {
			//UPDATE NUMBER
			if(data === "SUCCESS")
				$('.rating-number').html(Number($('.rating-number').html()) - 1);
		});
		return false;
	});
});
</script>