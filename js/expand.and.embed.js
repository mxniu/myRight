$(function(){
	$('#link-publish').toggler({
		method: "slideFadeToggle",
		speed: "slow"
	});
});

$(document).ready(function(){
	$.embedly.defaults['key'] = '4383b83484f042a5b93b771da83e776e';
	$('#link-publish').click(function(){
		var url = $('#link-input').val();
		$.embedly(url, {}, function(oembed, dict){
			$('#link-title').val(oembed.title);
			$('#link-summary').html(oembed.description);
		});
		if($(this).children('a').hasClass('open')) { $(this).children('a').html('Hide'); }
		else { $(this).children('a').html('Publish'); }
	});
});