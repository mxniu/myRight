<!DOCTYPE html>
<html>
<head>
	<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
	<script src="http://scripts.embed.ly/p/0.1/jquery.preview.full.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="http://scripts.embed.ly/p/0.1/css/preview.css" />
</head>
<body>
<h2><?=$heading?></h2>

<?php echo validation_errors(); ?>

<form method="post" accept-charset="utf-8" action="admin808" />
	<label for="category">Category</label> 
	<?php
		echo form_dropdown('category', $categories);
	?><br/>
	
	<input type="submit" name="submit" value="Load Category" />
	<input type="submit" name="submit" value="Clear DB Cache" />
	<input type="submit" name="submit" value="Update Tags" />
</form>

<?php if(isset($elements) || isset($element_data)): ?>

<form method="post" accept-charset="utf-8" action="admin808" />
	<label for="element">Element</label> 
	<?php
		echo form_dropdown('element', $elements);
	?><br/>
	
	<input type="hidden" name="category" value="<?=$category?>"/>
	
	<input type="submit" name="submit" value="Load Element" /> 
</form>

<form method="post" accept-charset="utf-8" action="admin808" />

	<label for="id">ID:</label>
	<input type="input" name="id" readonly="readonly" style="width: 50px; border: none;" <?php if(isset($element_data)) echo 'value="'.$element_data->id.'"'; ?>/><br/>
	
	<label for="category">Category:</label>
	<input type="input" name="category" readonly="readonly" style="width: 100px; border: none;" value="<?=$category?>"/><br/>

	<label for="type">Type</label>
	<?php
		if(isset($element_data)) 
			echo form_dropdown('type', array('primary'=>'primary', 'secondary'=>'secondary', 'news'=>'news', 'photo'=>'photo'), $element_data->type);
		else
			echo form_dropdown('type', array('primary'=>'primary', 'secondary'=>'secondary', 'news'=>'news', 'photo'=>'photo'));
	?><br/>

	<label for="url">URL (include http://)</label> 
	<input type="input" name="url" style="width: 300px" <?php if(isset($element_data)) echo 'value="'.$element_data->url.'"'; ?>/><br />
	
	<label for="title">Title</label> 
	<input type="input" name="title" style="width: 300px" maxlength="200" <?php if(isset($element_data)) echo 'value="'.$element_data->title.'"'; ?>/><br />

	<label for="summary">Summary</label>
	<textarea name="summary" rows="10" cols="50" maxlength="1000"><?php if(isset($element_data)) echo $element_data->summary; ?></textarea><br />
	
	<label for="tags">Tags (tag1,tag2,...)</label>
	<input type="input" name="tags" style="width: 300px" maxlength="200" <?php if(isset($element_data)) echo 'value="'.$element_data->tags.'"'; ?>/><br />

	<label for="location">Location</label>
	<input type="input" name="location" style="width: 300px" maxlength="50" <?php if(isset($element_data)) echo 'value="'.$element_data->location.'"'; ?>/><br />
	
	<label for="votes">Votes</label>
	<input type="number" name="votes" min="-10" max="200" <?php if(isset($element_data)) echo 'value="'.$element_data->votes.'"'; else echo 'value="0"' ?>/><br />
	
	<input type="submit" name="submit" value="Add" /> 
	<input type="submit" name="submit" value="Edit" /> 
	<input type="submit" name="submit" value="Delete" /> 

</form>
	
<form>
	<label for="url">URL for metadata</label> 
	<input type="input" name="url" id="preview_trigger" style="width: 300px"/><br />
</form>

<?php endif; ?>
<script>
$(function() {
	$('#preview_trigger').preview({key:'4383b83484f042a5b93b771da83e776e'});
});
</script>
</body>
</html>