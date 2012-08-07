<!DOCTYPE html>
<html>
<body>
<h2><?=$heading?></h2>

<form method="post" accept-charset="utf-8" action="test_editor" />
	<label for="test_id">Test ID</label> 
	<?php
		echo form_dropdown('test_id', $tests);
	?><br/>
	
	<input type="submit" name="submit" value="Load Test" />
	<input type="submit" name="submit" value="Create Test" />
</form>

<?php if(isset($test)): ?>

<form method="post" accept-charset="utf-8" action="test_editor" />
	<label for="id">Question</label> 
	<?php
		echo form_dropdown('id', $test);
	?><br/>
	
	<input type="hidden" name="test_id" value="<?php echo $this->input->post('test_id') ?>"/>
	
	<input type="submit" name="submit" value="Load Question" />
</form>

<?php endif; ?>

<?php if(isset($question) || isset($test)): ?>

<form method="post" accept-charset="utf-8" action="test_editor" />
	<label for="id">ID:</label>
	<input type="input" name="id" readonly="readonly" style="width: 50px; border: none;" value="<?php echo (isset($question) ? $question->id : "") ?>"/><br/>
	
	<label for="test_id">Test ID:</label>
	<input type="input" name="test_id" readonly="readonly" style="width: 100px; border: none;" value="<?php echo (isset($question) ? $question->test_id : $this->input->post('test_id')) ?>"/><br/>

	<label for="type">Type</label>
	<?php
		if(isset($question)) 
			echo form_dropdown('type', array('MB'=>'Multi-button', 'MC'=>'Multiple Choice'), $question->type);
		else
			echo form_dropdown('type', array('MB'=>'Multi-button', 'MC'=>'Multiple Choice'));
	?><br/>
	
	<label for="question">Question</label> 
	<input type="input" name="question" style="width: 400px" value="<?php echo (isset($question) ? $question->question : "") ?>"/><br />
	
	<label for="cluster">Cluster</label> 
	<input type="input" name="cluster" style="width: 400px" value="<?php echo (isset($question) ? $question->cluster : "") ?>"/><br />
	
	<label for="seq">Seq</label> 
	<input type="input" name="seq" style="width: 100px" value="<?php echo (isset($question) ? $question->seq : "") ?>"/><br />
	
	<?php 
	if(isset($question)):
		$answers_array = explode("|",$question->answers);
			
		for($i = 1; $i <= 5; $i++)
		{
			if(isset($answers_array[$i-1])):
				//Explode the answer unit into an answer-link pair
				$answer_unit = explode(",",$answers_array[$i-1]);
				
				$preformat_question = $answer_unit[0];
				$formatted_question = str_replace('"', '&#34;', $preformat_question);
			else:
				$answer_unit = array("", "", "");
				$formatted_question = "";
			endif;
			
			echo "Answer ".$i.":&nbsp;<input type=\"text\" name=\"answer".$i."\" maxlength=250 style=\"width:340px;\" value=\"".$formatted_question."\">&nbsp;";
			echo "Link ".$i.":&nbsp;<input type=\"text\" name=\"link".$i."\" maxlength=20 value=\"".$answer_unit[1]."\">&nbsp;";
			echo "Tag Link".$i.":&nbsp;<input type=\"text\" name=\"tag".$i."\" value=\"".$answer_unit[2]."\">&nbsp;";
			
			echo "<br />";
		}
	else:
		for($i = 1; $i <= 5; $i++)
		{
			echo "Answer ".$i.":&nbsp;<input type=\"text\" name=\"answer".$i."\" maxlength=250 style=\"width:340px;\">&nbsp;";
			echo "Link ".$i.":&nbsp;<input type=\"text\" name=\"link".$i."\" maxlength=20>&nbsp;";
			echo "Tag Link".$i.":&nbsp;<input type=\"text\" name=\"tag".$i."\">&nbsp;";
			
			echo "<br />";
		}
	endif;
	?>
	
	<input type="submit" name="submit" value="Add" /> 
	<input type="submit" name="submit" value="Edit" /> 
	<input type="submit" name="submit" value="Delete" /> 

</form>

<?php endif; ?>

</body>
</html>