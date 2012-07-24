<iframe id="source_view" src="<?php if(preg_match("/\.doc$|\.pdf$/", $element->url)) echo 'http://docs.google.com/gview?url='; ?><?=$element->url?><?php if(preg_match("/\.doc$|\.pdf$/", $element->url)) echo '&embedded=true'; ?>"></iframe>
<div class="loader">
	<img src="../loading.gif" alt="ajax-loader" style="margin-top: 20px"/>
</div>
<!-- jquery -->
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script type="text/javascript">

$(function() {
	$('#source_view').css('height', (window.innerHeight - 60)+"px");
	$('.loader').css('height', (window.innerHeight - 60)+"px");
	$('.loader').fadeOut(1000);
});

</script>