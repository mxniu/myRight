<section id="partition-1">
<!--<section class="link-submit-form">
	<form action="#" method="post">
		<input id="link-input" name="link-input" type="search" placeholder="Add Link" />
		<span id="link-publish">Publish</span>
		<div class="collapse">
			<div class="form-input">
				<label for="link-type">Type</label>
				<input type="radio" name="link-type" value="resource" />Resource
				<input type="radio" name="link-type" value="news" />News
				<input type="radio" name="link-type" value="infographic" />Infographic				
			</div>
			
			<div class="form-input">
				<label for="link-title">Title</label>
				<input type="text" id="link-title" name="link-title" />
			</div>
			
			<div class="form-input">
				<label for="link-summary">Summary</label>
				<textarea id="link-summary" name="link-summary"></textarea>
			</div>
			
			<div class="form-input">
				<label for="link-tags">Tags</label>
				<input type="text" id="link-tags" name="link-tags" />
			</div>
			
			<div class="form-input">
				<label for="link-location">Location</label>
				<input type="text" id="link-location" name="link-location" />
			</div>
			
			<input type="submit" id="submit" name="submit" value="Submit" />
		</div>
	</form>
</section>-->
<div id="content">
	<div id="category-title">
		<h1 class="left" id="tag-title" style="text-transform: capitalize; font-size: 28px; margin: 10px 0; color: #378daf;"><?=$title?></h1>
		<div class="right" style="margin-top: 16px">
			<?php 
				if(isset($locations))
				{
					echo "Location: ";
					$options = array("" => "-----");
					foreach($locations as $location)
					{
						$options[preg_replace( '/\s+/', '-', $location->location )] = $location->location;
					}
					echo form_dropdown('location', $options, $locget, 'id="location_box"');
				}
			?>
		</div>
	</div>
	<?php if(!$offset): ?>
	<div id="maintainer" style="border-top: none">
		<div class="left" id="tagtainer">
			<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px; background: url(../images/bg_square.png)">Related Tags</div>
			<?php if(sizeof($tags) > 0): ?>
				<?php foreach ($tags as $tag): ?>
					<a href="<?=$urlstem?><?=$method?>/<?=$tag->slug?><?php if($locget) echo "?location=".$locget; ?>"><div class="tagname left"><?=$tag->tagname?></div></a>
				<?php endforeach; ?>
			<?php else: ?>
				<a href="#">[No Tags Exist Yet]</a>
			<?php endif; ?>
		</div>
			<div class="loader">
				<img src="http://i.imgur.com/qkKy8.gif" alt="ajax-loader"/>
			</div>
		<div id="container" class="clearfix right">

			<?php for ($counter = 1; $counter < 8; $counter++): ?>
			
			<?php if(!isset($elements[$counter-1])) break; $element = $elements[$counter-1]; $show_detail = TRUE;?>

			<a href="../<?=$method?>/<?php echo $element->slug?>" class="<?php echo strtolower($element->type); ?> isotope-item<?php 
			if(!$offset)
			{
				echo ' hidden';
				if($counter > 1 && $counter <= 3)
				{
					echo ' height2';
				}
				else if($counter === 5 || $counter === 8 || $counter === 13)
				{
					echo ' width2';
				}
				else if(($counter > 5 && $counter <= 7) || ($counter > 8 && $counter <= 12) || ($counter > 13))
				{
					echo ' size2';
					$show_detail = FALSE;
				}
			}
			else
			{
				echo ' size2';
				$show_detail = FALSE;
			}
			?>" id="<?=$element->slug?>" data-toggle="modal">
				<?php if(strtolower($element->type) === 'photo') echo '<img src="'.$element->url.'"/>'; ?>
			
				<h3 class="title"><?=$element->title?></h3>
				
				<div class="details <?php if($show_detail) echo "visible"; ?>">
					<?=$element->summary?>
				</div>
				
				<div class="comments_box"></div>
				
				<div class="isotope-hover">
					<div class="view-this">View this</div>
					<div class="type-string"><?php
					if($element->type === "primary")
					{
						echo "Law";
					}
					else if($element->type === "secondary")
					{
						echo "Legal Info";
					}
					else if($element->type === "news")
					{
						echo "News Article";
					}
					else if($element->type === "document")
					{
						echo "Document";
					}
					?></div>
				</div>
				
				<div class="lowliner">
					<div class="lowcount"><?=$element->views?></div><div class="lowicon icon_views"></div>
					<div class="lowcount">0</div><div class="lowicon icon_comments"></div>
					<div class="lowcount"><?=$element->votes?></div><div class="lowicon icon_rating"></div>
				</div>
			</a>
			<?php endfor; ?>
		</div> <!-- end #container -->
	</div><!-- end #maintainer -->
	<?php endif; ?>
</div>
</section>