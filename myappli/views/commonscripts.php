<div class="modal hidden fade" id="disclaimerModal">
  <div class="modal-body fade" style="text-align: left; padding: 20px">
		<div class="modal-center">
			<img src="http://i.imgur.com/qkKy8.gif"/>
		</div>
	</div>
</div>
<script>
$(function() {
	$('#disclaimerModal').click(function(){
		$('#disclaimerModal').modal('hide');
		return false;
	});
	
	$('#disclaimerModal').on('show', function(){
		$('body').css('overflow', 'hidden');
	});
	$('#disclaimerModal').on('hidden', function () {
		$('#disclaimerModal').children(".modal-body").children(".modal-center").html('<img src="http://i.imgur.com/qkKy8.gif"/>');
		$('body').css('overflow', 'auto');
	});
	
	$('.about_disclaimer').click(function(){
		$.ajax({
			type: "POST",
			url: "../function/show_disclaimer",
			dataType: "html"
		}).done(function( data ) {
			if(data)
				$('#disclaimerModal').children('.modal-body').html(data);
		})
	});
	$('.about_terms').click(function(){
		$.ajax({
			type: "POST",
			url: "../function/show_terms",
			dataType: "html"
		}).done(function( data ) {
			if(data)
				$('#disclaimerModal').children('.modal-body').html(data);
		})
	});
	$('.about_privacy').click(function(){
		$.ajax({
			type: "POST",
			url: "../function/show_privacy",
			dataType: "html"
		}).done(function( data ) {
			if(data)
				$('#disclaimerModal').children('.modal-body').html(data);
		})
	});
});
</script>
<script type="text/javascript">
  var uvOptions = {};
  (function() {
    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/bhZYVMlL7tU5y7PR7AE3iw.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30911529-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>