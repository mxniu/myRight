<div class="container_12" id="view_container">
	<div class="left grid_9 container_pane">
		<div class="grid_7 left">
			<div class="element" id="element_top">
				<h1><?=$element->title?></h1>
				<h2><?=$element->tags?></h2>
				<div>Posted xx by xx</div>
			</div>
			<div class="element" id="element_body">
				<?=$element->summary?>
			</div>
			<div class="element" id="review_buttons">
				<div>Did you find this legal summary useful?</div>
				<input type="submit" id="useful_yes" value="Yes"/>
				<input type="submit" id="useful_no" value="No"/>
			</div>
			<a href="../fullview/<?=$element->slug?>" class="element" id="view_source">View Source</a>
			<div class="element" id="comments">
				<?php if(!$comments): ?>
					[NO COMMENTS HERE]
				<?php else: ?>
					<?php foreach ($comments as $comment): ?>
						<div class="comment">
							
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<div class="element" id="post_new">
				<label for="new_comment">Post a Comment</label><br/>
				<textarea name="new_comment" rows="5" cols="40"></textarea><br/>
				<input type="submit" name="submit" value="POST" disabled="disabled"/>
			</div>
		</div>
		<div class="grid_1 right">
			<div class="element" id="rating_box"><?=$element->votes?></div>
		</div>
	</div>
	<div class="right grid_3 container_pane">
		[INSERT TAGS HERE]
	</div>
</div> <!-- end #container -->
<!-- jquery -->
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script type="text/javascript">
$(function() {
});

</script>