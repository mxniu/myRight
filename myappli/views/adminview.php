<!DOCTYPE html>
<html>
<head>
	<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
	<script src="http://scripts.embed.ly/p/0.1/jquery.preview.full.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="http://scripts.embed.ly/p/0.1/css/preview.css" />
	<link href='http://fonts.googleapis.com/css?family=Lato:700,400,300|Open+Sans:300, 400,600,700' rel='stylesheet' type='text/css'>
	<style type="text/css">
		h1.logo {
		display: inline-block;
		margin: -2px 15px 0 30px;
		font-family: 'Lato', sans-serif;
		}
		
		h1.logo a {
			background: url("/images/logo45x25.png") no-repeat scroll 0 19px transparent;
			font-size: 28px;
			font-weight: 400;
			height: 30px;
			padding: 12px 5px 18px 57px;
			display: inline-block;
			color: #333;
			text-decoration: none;
		}
	</style>
</head>
<body>
<h1 class="logo">
	<a href="#">myRight</a>
</h1>
<section class="content">

<?php echo validation_errors(); ?>

<form method="post" accept-charset="utf-8" action="/admin808" />
	<label for="category">Category</label> 
	<?php
		echo form_dropdown('category', $categories);
	?><br/>
	
	<input type="submit" name="submit" value="Load Category" />
	<input type="submit" name="submit" value="Clear DB Cache" />
	<input type="submit" name="submit" value="Update Tags" />
</form>

<form method="post" accept-charset="utf-8" action="/admin808" />
	<label for="tag">Tag</label> 
	<?php
		if(isset($tag)):
			echo form_dropdown('tag', $tags, $tag->id);
		else:
			echo form_dropdown('tag', $tags);
		endif;
	?><br/>
	
	<input type="submit" name="submit" value="Load Tag" />
</form>

<?php if(isset($tag)): ?>

<form method="post" accept-charset="utf-8" action="/admin808" />
	<label for="id">ID:</label>
	<input type="input" name="id" readonly="readonly" style="width: 50px; border: none;" <?php echo 'value="'.$tag->id.'"'; ?>/><br/>
	
	<label for="description">Description</label>
	<textarea name="description" rows="10" cols="50" maxlength="500"><?php echo $tag->description; ?></textarea><br />
	
	<label for="test_id">Test ID</label> 
	<input type="input" name="test_id" style="width: 100px" <?php echo 'value="'.$tag->test_id.'"'; ?>/><br />
	
	<input type="submit" name="submit" value="Edit Tag" /> 
</form>

<?php elseif(isset($elements) || isset($element_data)): ?>

<form method="post" accept-charset="utf-8" action="/admin808" />
	<label for="element">Element</label> 
	<?php
		echo form_dropdown('element', $elements);
	?><br/>
	
	<input type="hidden" name="category" value="<?=$category?>"/>
	
	<input type="submit" name="submit" value="Load Element" /> 
</form>

<form method="post" accept-charset="utf-8" action="/admin808" />

	<label for="id">ID:</label>
	<input type="input" name="id" readonly="readonly" style="width: 50px; border: none;" <?php if(isset($element_data)) echo 'value="'.$element_data->id.'"'; ?>/><br/>
	
	<label for="category">Category:</label>
	<input type="input" name="category" readonly="readonly" style="width: 100px; border: none;" value="<?=$category?>"/><br/>

	<label for="type">Type</label>
	<?php
		if(isset($element_data)) 
			echo form_dropdown('type', array('primary'=>'primary', 'secondary'=>'secondary', 'news'=>'news', 'document'=>'document'), $element_data->type);
		else
			echo form_dropdown('type', array('primary'=>'primary', 'secondary'=>'secondary', 'news'=>'news', 'document'=>'document'));
	?><br/>

	<label for="url">URL (include http://)</label> 
	<input type="input" name="url" style="width: 300px" <?php if(isset($element_data)) echo 'value="'.$element_data->url.'"'; ?>/><br />
	
	<label for="title">Title</label> 
	<input type="input" name="title" style="width: 300px" maxlength="200" <?php if(isset($element_data)) echo 'value="'.$element_data->title.'"'; ?>/><br />

	<label for="summary">Summary</label>
	<textarea name="summary" rows="10" cols="50"><?php if(isset($element_data)) echo $element_data->summary; ?></textarea><br />
	
	<label for="tags">Tags (tag1,tag2,...)</label>
	<input type="input" name="tags" style="width: 300px" maxlength="200" <?php if(isset($element_data)) echo 'value="'.$element_data->tags.'"'; ?>/><br />

	<label for="location">Location</label>
	<input type="input" name="location" style="width: 300px" maxlength="50" <?php if(isset($element_data)) echo 'value="'.$element_data->location.'"'; ?>/><br />
	
	<label for="votes">Votes</label>
	<input type="number" name="votes" min="-10" max="200" <?php if(isset($element_data)) echo 'value="'.$element_data->votes.'"'; else echo 'value="0"' ?>/><br />
	
	<label for="poster">Poster</label>
	<?php
		if(isset($element_data))
			echo form_dropdown('poster', $posters, $element_data->poster);
		else
			echo form_dropdown('poster', $posters);
	?><br/>
	
	<input type="submit" name="submit" value="Add" /> 
	<input type="submit" name="submit" value="Edit" /> 
	<input type="submit" name="submit" value="Delete" /> 

</form>

</section>

<?php endif; ?>
</body>
</html>