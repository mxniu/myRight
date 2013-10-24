<!DOCTYPE html>
<html>
<head>
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
	<a href="#"><?=$heading?></a>
</h1>

<form method="post" accept-charset="utf-8" action="view_stats" />
	<label for="test_id">Test ID</label> 
	<?php
		echo form_dropdown('test_id', $tests);
	?><br/>
	
	<input type="submit" name="submit" value="Get Test" />
</form>

<?php if(isset($results)): ?>

Total visitors: <?=$results['total']?><br/>
Bounce Rate: <?=$results['bounce_rate']?><br/>
Average Time per User (non-bounce users): <?=$results['time_spent']?> minutes<br/>
Average Time per Visit (non-bounce users): <?=$results['time_per_visit']?> minutes<br/>
Average Engagement Depth (non-bounce users): <?=$results['engagement']?> clicks per user<br/>
Visits per User (non-bounce users): <?=$results['revisits']?> visits per user<br/>
<br/><br/>
<b>Bounces by question:</b><br/><br/>
<?=$results['bounce_counts']?>

<?php endif; ?>

</body>
</html>