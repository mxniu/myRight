<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=265179353583781";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="container_12" style="text-align: left;">
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
		<a href="../fullview/<?=$element->slug?>" class="element" id="view_source" target="_blank">Learn More</a>
		<!--<div class="element" id="comments">
			<?php //if(!$comments): ?>
				[NO COMMENTS HERE]
			<?php //else: ?>
				<?php //foreach ($comments as $comment): ?>
					<div class="comment">
						
					</div>
				<?php //endforeach; ?>
			<?php //endif; ?>
		</div>-->
		<div class="fb-comments" data-href="http://myright.me/view/<?=$method?>" data-num-posts="10" data-width="470"></div>
		<!--<div class="element" id="post_new">
			<label for="new_comment">Post a Comment</label><br/>
			<textarea name="new_comment" rows="5" cols="40"></textarea><br/>
			<input type="submit" name="submit" value="POST" disabled="disabled"/>
		</div>-->
	</div>
	<div class="grid_1 right">
		<div class="element" id="rating_box"><?=$element->votes?></div>
		<div class="fb-like" data-href="http://myright.me/view/<?=$method?>" data-send="false" data-layout="box_count" data-width="450" data-show-faces="true" data-font="segoe ui"></div>
	</div>
</div><!-- end #container -->
<!-- jquery -->