<section id="partition-1" <?php if($bgimage) echo 'style="background: url(/images/'.$bgimage.') 0 0 no-repeat;"'; ?>>
	<div class="tip_top"><div id="breadcrumbs"><a href="/">Home</a> > <?=$category->name?></div></div>
	<div id="top_interface" style="height: auto">
		<div style="margin: 0 auto; width: 700px; height: 160px; padding-top: 40px; border-radius: 10px; background: rgba(255, 255, 255, 0.9); ">
			<h1 style="text-transform: capitalize; font-size: 3em; color: #FCB521; margin: 0 auto; text-align: center; padding: 0; font-family: 'Arvo', serif; "><?=$title?></h1>
			<h2 style="font-size: 2em; color: #333; text-align: center; margin: 10px auto; font-family: Lato; font-weight: 300;">Interactive Guide Coming Soon!</h2>
		</div> 
	</div>
</section>
<div class="hidden" id="category-slug"><?=$method?></div>
<section id="partition-2" style="padding-top: 40px">
	<div id="list-elements"  style="border-radius: 10px 10px 0 0; margin-top: -100px">
		<div style="font-family: Arvo; font-weight: 600; text-align: left; color: #2676a0; font-size: 20px; margin: 20px 20px 0; border-bottom: 2px dotted #2676a0; width: 300px; padding-bottom: 5px;"><?=$category->name?> Basics</div>
		<div class="interface_description" style="margin: 20px 30px 30px; width: 620px; float: left; font-family: georgia, 'Times New Roman', serif; line-height: 1.4em;"><?php if(isset($summary)) echo $summary; else echo $description?></div>
		<div class="right" style="height: 278px; width: 175px; background: url(/images/character_cop.png); margin-right: 70px"></div>
	</div>
</section>
<!-- BEGIN LIST MODE -->
<section id="partition-2" style="margin-bottom: 40px;">
	<div id="list-elements" style="padding-bottom: 20px; border-radius: 0 0 10px 10px">
		<div style="text-align: left; color: #666; font-size: 20px; font-weight: bold; margin: 20px 20px; border-bottom: 10px solid rgba(217, 219, 220, 1); width: 289px; padding-bottom: 8px;"><?=$category->name?> Articles</div><?php 
			$num_elements = count($elements);
			for ($count = 0; $count < $num_elements; $count++)
			{
				$element = $elements[$count];
				if($count % 7 === 0)
				{
					if($count >= 21)
						echo '<div class="left" style="width: 289px; margin-left: 15px; border-top: 10px solid rgba(217, 219, 220, 1); padding-top: 20px;">';
					else
						echo '<div class="left" style="width: 289px; margin-left: 15px;">';
				}
			?>
		<div class="list-element">
		<a class="title" href="/<?php if($element->category === $relid) echo $relslug; else echo $method;?>/<?php echo $element->slug?>" id="<?=$element->slug?>" data-toggle="modal"><?=$element->title?></a>
		</div>
		<?php
			if($count % 7 === 6 || $count === $num_elements - 1)
				echo '</div>';
		} //End outer for loop?>
	</div>
</section>
<!-- END LIST MODE -->