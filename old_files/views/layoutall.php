<!-- BEGIN LIST MODE -->
<section id="list-elements" style="margin-top: 52px">
<div style="text-align: center; font-style: italic; font-weight: bold; padding: 5px 7px; border-bottom: 1px solid #CCC; border-left: 1px solid #CCC;border-right: 1px solid #CCC;color: #666; font-size: 14px;  background: url(../images/bg_square.png); width: 150px; margin-left: 10px;"><?php if(sizeof($elements) > 0) echo "Available Categories"; else echo "No Categories"; ?></div>
<?php foreach ($elements as $element): ?>
	<div class="list-element">
		<div class="title-wrapper"><a class="title" href="../<?php echo $element->slug?>" id="<?=$element->slug?>" data-toggle="modal"><?=$element->name?></a></div>
	</div>
<?php endforeach; ?>
</section>