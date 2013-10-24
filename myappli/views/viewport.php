<div class="container_12" style="margin-top: 100px; margin-bottom: 40px; padding: 5px 0; overflow: hidden">
	<div class="grid_8 left default_pane alpha">
		<div style="overflow: hidden; margin: 20px 0 0 20px">
			<div class="grid_6 left alpha" id="element_top">
				<div class="author_thumbnail" <?php if($poster) {echo 'style="background-image:url(/images/posters/'.$poster->image.')"';}	?>></div>
				<div class="element_meta">
					<h2><?php if($poster) {
						if($poster->gplus)
							echo '<a rel="author" href="'.$poster->gplus.'" target="_blank">'.$poster->name.'</a>';
						else if($poster->url)
							echo '<a rel="author" href="'.$poster->url.'" target="_blank">'.$poster->name.'</a>';
						else
							echo $poster->name;
						} else echo 'myRight'; ?></h2>
					<p class="orange"><?php if($poster){ if($poster->type === '1') echo 'Guest Contributor'; else echo 'Associate Editor';} else echo 'Admin';?></p>
					<p class="posted"><?php if($element->date_created === '0') echo "Posted September 26, 2012"; else echo date("F j, Y", $element->date_created);?></p>
				</div>
				<h1><?=$element->title?></h1>
				<p class="tags"><?=$element->tags?></p>
				<?php if($element->url): 
					echo '<span style="font-size: 12px; color: #666">Source: </span>'; 
					$urls = explode(",", $element->url);
					$c1 = true;
					foreach($urls as $url):
					if($c1)
						$c1 = false;
					else
						echo ", ";
					$url = trim($url);?><a href="<?=$url?>" target="_blank" style="font-size: 12px; color: #666"><?php echo trim(preg_replace("/^www\./", "", parse_url($url, PHP_URL_HOST)));?></a><?php endforeach; endif; ?>
			</div>
			<div class="grid_2 right omega" id="rating_box">
				<p>RATED</p>
				<div class="rating-number"><?=$element->votes?></div>
				<div class="rating-buttons">
					<a href="#" class="rating-up">Rate Up</a>
					<a href="#" class="rating-down">Rate Down</a>
				</div>
			</div>
		</div>
		
		<div class="element" id="element_body" style="margin: 20px 20px 30px">
			<?=$element->summary?>
		</div>
	</div>
	<div class="grid_4 right default_pane omega" style="text-align: center;">
		<?php if($category->test_id > "0"): ?>
			<div style="margin: 20px auto; width: 260px; font-size: 2em; color: #6BA7BF;"><?=$category->name?></div>
			<div style="margin: 20px auto; width: 200px; font-family: georgia, 'Times New Roman', serif; font-style: italic">Find out your rights now with this interactive guide!</div>
			<a href="/<?=$category->slug?>" style="margin: 0 auto"><div class="blue_button" style="margin: 30px auto">Start Guide</div></a>
		<?php else: ?>
			<div style="margin: 20px auto; width: 260px; font-size: 2em; color: #6BA7BF;"><?=$category->name?></div>
			<div style="margin: 20px auto; width: 230px; font-family: georgia, 'Times New Roman', serif; font-style: italic">Find out the answers to your <?=$category->name?> questions!</div>
			<a href="/<?=$category->slug?>" style="margin: 0 auto"><div class="blue_button" style="margin: 30px auto">Learn More</div></a>
		<?php endif; ?> 
	</div>
</div> <!-- end #container -->
<!-- jquery -->