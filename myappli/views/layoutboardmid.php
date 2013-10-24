<section id="partition-1" style="padding-bottom: 0; box-shadow: none;">
<div id="content" style="padding: 5px 0 0; width: 960px;  box-shadow: none;">
	<div id="category-title" style="padding-left: 19px; padding-right: 19px;">
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
	<div id="maintainer" style="border-top: none">
		<div class="loader">
			<img src="http://i.imgur.com/qkKy8.gif" alt="ajax-loader"/>
		</div>
		<div id="container" class="clearfix">

			<?php for ($counter = 1; $counter < 8; $counter++): ?>
			
			<?php if(!isset($elements[$counter-1])) break; $element = $elements[$counter-1]; $show_detail = TRUE;?>

			<a href="/<?php if($element->category === $relid) echo $relslug; else echo $method;?>/<?php echo $element->slug?>" class="<?php echo strtolower($element->type); ?> isotope-item<?php 
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
					<!--<div class="lowcount">0</div><div class="lowicon icon_comments"></div>-->
					<div class="lowcount"><?=$element->votes?></div><div class="lowicon icon_rating"></div>
				</div>
			</a>
			<?php endfor; ?>
		</div> <!-- end #container -->
	</div><!-- end #maintainer -->
</div>
</section>