<section id="content">
<section class="link-submit-form">
	<h2 class="counting"><?=$count?> articles and counting.</h2>
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
</section>
<section id="options" class="clearfix">
	<div class="option-logo">
		<h1><?=$title?></h1>
	</div>
	<div class="option-combo">
	  <ul id="sort" class="option-set clearfix" data-option-key="sortBy">
      	<li><a href="#rating" data-option-value="rating" class="selected" style="border-left: 1px solid black">rating</a></li>
	    <li><a href="#date" data-option-value="date">date</a></li>
	    <li><a href="#alphabetical" data-option-value="alphabetical">a-z</a></li>
	  </ul>
	</div>
	<div class="option-combo">
	  <ul id="filter" class="option-set clearfix" data-option-key="filter">
	    <li><a href="#show-all" data-option-value="*" class="selected" style="border-left: 1px solid black">all</a></li>
	    <li><a href="#news" data-option-value=".news, .photo">news</a></li>
	    <li><a href="#resources" data-option-value=".info, .primary, .secondary">resources</a></li>
	  </ul>
	</div>
</section>