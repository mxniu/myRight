<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=265179353583781";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="container_12" style="text-align: left">
	<div class="grid_7 left">
		<div class="element" id="element_top" style="margin-top: 0">
			<div class="author_thumbnail"></div>
			<div class="element_meta">
				<h2><a href="#">myRight</a></h2>
				<p class="orange">Admin</p>
				<p class="posted">Posted July 31, 2012</p>
			</div>
			<h1><a href="<?=$element->url?>" target="_blank"><?=$element->title?></a></h1>
			<p class="tags"><?=$element->tags?></p>
			<a href="<?=$element->url?>" target="_blank" style="font-size: 12px"><?php echo preg_replace("/^www\./", "", parse_url($element->url, PHP_URL_HOST));?></a>
		</div>
		
		<div class="element" id="element_body">
			<?=$element->summary?>
		</div>
		
		<a href="<?=$element->url?>" id="view_source" target="_blank">View Source</a>
		
		<div class="element" id="review_buttons">
			<p>Did you find this legal summary useful?</p>
			<input type="button" id="useful_yes" value="Yes"/>
			<input type="button" id="useful_no" value="No"/>
			
			<!--<a href="#" class="blue-button clear-button">Related Articles</a>
			
			<div class="tag-cloud">
			</div>-->
		</div>
		
		<!--<div id="element_bottom" class="element">
			<div id="comm_qa">
				<a href="#" class="gray-tab">Comments</a>
				<a href="#" class="gray-tab">Q &amp; A</a>
			</div>-->
			
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
			</div>
		</div><!-- END element_bottom -->
	</div>
	<div class="grid_2 right">
		<div class="element" id="rating_box">
			<p>RATED</p>
			<div class="rating-number"><?=$element->votes?></div>
			<div class="rating-buttons">
				<a href="#" class="rating-up">Rate Up</a>
				<a href="#" class="rating-down">Rate Down</a>
			</div>
		</div>

		<div class="fb-like" data-href="http://myright.me/view/<?=$method?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-font="segoe ui"></div>
		<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://myright.me/view/<?=$method?>" data-via="myrightinc" style="margin-top: 10px">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
	<!--<div class="left grid_3 container_pane">
		[INSERT TAGS HERE]
	</div>-->
</div> <!-- end #container -->
<script type="text/javascript">
$(function() {
	$.ajax({ url: 'http://platform.twitter.com/widgets.js', dataType: 'script', cache:true});
});
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