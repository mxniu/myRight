<style>
.adobo {display: block; padding: 20px 0; width: 960px; text-align: left}
.adobo h3 {margin: 0 auto 20px;}
.adobo a {margin: 0px 20px; display: inline-block; font-size: 0.8em;}
.adobo a:hover {text-decoration: underline;}

#state_preview {height: 250px; width: 250px; background-image: url(/images/states.png); background-position: 0 250px; background-repeat: no-repeat}
</style>
<script src="/js/jquery.vmap.min.js"></script>
<script src="/js/jquery.vmap.usa.js"></script>
<section style="padding-top: 80px; width: 100%; background: url(/images/bg_gray.jpg);">
	<section class="container_12">
		<h1 style="margin: 0 auto; color: #FFF; font-size: 3em;"><?=$title?></h1>
	</section>
</section>
<section style="background: url(/images/bg_road.jpg) no-repeat 0 60px ;">
	<section class="container_12">
		<div class="default_pane" style="font-family: georgia, serif; margin: 20px 0 0; font-weight: 400; font-size: 1em; width: 625px; line-height: 1.4em; background: rgba(255, 225, 154, 0.9);">
			<p style="margin-top: 15px">If you have been injured in a car accident, or any other auto accident involving a bus, truck, tractor, or other vehicles, you may be entitled to justice and the right to get your fair share of compensation. An accident lawyer or personal injury attorney can help show that you were not at fault may prove that another driver caused the accident. Each state has slightly different laws regarding accident injuries, so explore this site to learn more about the specific laws of your state.</p>
		</div>
	</section>
	<section class="container_12" style="text-align: center; padding-bottom: 25px; margin-bottom: 40px">
		<div class="adobo default_pane" style="margin: 35px auto">
			<div id="vmap" style="margin: 0 auto; width: 900px; height: 600px;"></div>
			<div class="left" style="width: 175px; margin-left: 30px">
				<div><a href="alabama/" id="alabama">Alabama</a></div>
				<div><a href="alaska/" id="alaska">Alaska</a></div>
				<div><a href="arizona/" id="arizona">Arizona</a></div>
				<div><a href="arkansas/" id="arkansas">Arkansas</a></div>
				<div><a href="california/" id="california">California</a></div>
				<div><a href="colorado/" id="colorado">Colorado</a></div>
				<div><a href="connecticut/" id="connecticut">Connecticut</a></div>
				<div><a href="delaware/" id="delaware">Delaware</a></div>
				<div><a href="dc/" id="dc">District of Columbia</a></div>
				<div><a href="florida/" id="florida">Florida</a></div>
				<div><a href="georgia/" id="georgia">Georgia</a></div>
			</div>
			<div class="left" style="width: 175px">
				<div><a href="hawaii/" id="hawaii">Hawaii</a></div>
				<div><a href="idaho/" id="idaho">Idaho</a></div>
				<div><a href="illinois/" id="illinois">Illinois</a></div>
				<div><a href="indiana/" id="indiana">Indiana</a></div>
				<div><a href="iowa/" id="iowa">Iowa</a></div>
				<div><a href="kansas/" id="kansas">Kansas</a></div>
				<div><a href="kentucky/" id="kentucky">Kentucky</a></div>
				<div><a href="louisiana/" id="louisiana">Louisiana</a></div>
				<div><a href="maine/" id="maine">Maine</a></div>
				<div><a href="maryland/" id="maryland">Maryland</a></div>
			</div>
			<div class="left" style="width: 175px">
				<div><a href="massachusetts/" id="massachusetts">Massachusetts</a></div>
				<div><a href="michigan/" id="michigan">Michigan</a></div>
				<div><a href="minnesota/" id="minnesota">Minnesota</a></div>
				<div><a href="mississippi/" id="mississippi">Mississippi</a></div>
				<div><a href="missouri/" id="missouri">Missouri</a></div>
				<div><a href="montana/" id="montana">Montana</a></div>
				<div><a href="nebraska/" id="nebraska">Nebraska</a></div>
				<div><a href="nevada/" id="nevada">Nevada</a></div>
				<div><a href="new-hampshire" id="new-hampshire">New Hampshire</a></div>
				<div><a href="new-jersey" id="new-jersey">New Jersey</a></div>
			</div>
			<div class="left" style="width: 175px">
				<div><a href="new-mexico" id="new-mexico">New Mexico</a></div>
				<div><a href="new-york" id="new-york">New York</a></div>
				<div><a href="north-carolina" id="north-carolina">North Carolina</a></div>
				<div><a href="north-dakota" id="north-dakota">North Dakota</a></div>
				<div><a href="ohio/" id="ohio">Ohio</a></div>
				<div><a href="oklahoma/" id="oklahoma">Oklahoma</a></div>
				<div><a href="oregon/" id="oregon">Oregon</a></div>
				<div><a href="pennsylvania/" id="pennsylvania">Pennsylvania</a></div>
				<div><a href="rhode-island" id="rhode-island">Rhode Island</a></div>
				<div><a href="south-carolina" id="south-carolina">South Carolina</a></div>
			</div>
			<div class="left" style="width: 120px">
				<div><a href="south-dakota" id="south-dakota">South Dakota</a></div>
				<div><a href="tennessee/" id="tennessee">Tennessee</a></div>
				<div><a href="texas/" id="texas">Texas</a></div>
				<div><a href="utah/" id="utah">Utah</a></div>
				<div><a href="vermont/" id="vermont">Vermont</a></div>
				<div><a href="virginia/" id="virginia">Virginia</a></div>
				<div><a href="washington/" id="washington">Washington</a></div>
				<div><a href="west-virginia" id="west-virginia">West Virginia</a></div>
				<div><a href="wisconsin/" id="wisconsin">Wisconsin</a></div>
				<div><a href="wyoming/" id="wyoming">Wyoming</a></div>
			</div>
			<!--<div class="right" style="margin-right: 80px; margin-top: 100px;" id="state_preview"></div>-->
		</div>
	</section>
</section>
<script>
jQuery('#vmap').vectorMap({
    map: 'usa_en',
    backgroundColor: null,
	borderColor: '#333',
	borderOpacity: 0.8,
	borderWidth: 2,
    color: '#999',
    hoverColor: '#19B5EF',
    selectedColor: '#19B5EF',
    enableZoom: false,
    showTooltip: true,
	onRegionClick: function(event, code, region)
    {
		if(code === "dc")
			window.location.href = "dc/";
		else 
			window.location.href = region.toLowerCase().replace(/ /g,'-') + "/";
    }
});
/*$('#alabama').hover(function(){$('#state_preview').css('background-position', '0px 0px');});
$('#alaska').hover(function(){$('#state_preview').css('background-position', '0px -250px');});
$('#arizona').hover(function(){$('#state_preview').css('background-position', '0px -500px');});
$('#arkansas').hover(function(){$('#state_preview').css('background-position', '0px -750px');});
$('#california').hover(function(){$('#state_preview').css('background-position', '0px -1000px');});
$('#colorado').hover(function(){$('#state_preview').css('background-position', '0px -1250px');});
$('#connecticut').hover(function(){$('#state_preview').css('background-position', '0px -1500px');});
$('#delaware').hover(function(){$('#state_preview').css('background-position', '0px -1750px');});
$('#dc').hover(function(){$('#state_preview').css('background-position', '0px -2000px');});
$('#florida').hover(function(){$('#state_preview').css('background-position', '0px -2250px');});
$('#georgia').hover(function(){$('#state_preview').css('background-position', '0px -2500px');});
$('#hawaii').hover(function(){$('#state_preview').css('background-position', '0px -2750px');});
$('#idaho').hover(function(){$('#state_preview').css('background-position', '0px -3000px');});
$('#illinois').hover(function(){$('#state_preview').css('background-position', '0px -3250px');});
$('#indiana').hover(function(){$('#state_preview').css('background-position', '0px -3500px');});
$('#iowa').hover(function(){$('#state_preview').css('background-position', '0px -3750px');});
$('#kansas').hover(function(){$('#state_preview').css('background-position', '0px -4000px');});
$('#kentucky').hover(function(){$('#state_preview').css('background-position', '0px -4250px');});
$('#louisiana').hover(function(){$('#state_preview').css('background-position', '0px -4500px');});
$('#maine').hover(function(){$('#state_preview').css('background-position', '0px -4750px');});
$('#maryland').hover(function(){$('#state_preview').css('background-position', '0px -5000px');});
$('#massachusetts').hover(function(){$('#state_preview').css('background-position', '0px -5250px');});
$('#michigan').hover(function(){$('#state_preview').css('background-position', '0px -5500px');});
$('#minnesota').hover(function(){$('#state_preview').css('background-position', '0px -5750px');});
$('#mississippi').hover(function(){$('#state_preview').css('background-position', '0px -6000px');});
$('#missouri').hover(function(){$('#state_preview').css('background-position', '0px -6250px');});
$('#montana').hover(function(){$('#state_preview').css('background-position', '0px -6500px');});
$('#nebraska').hover(function(){$('#state_preview').css('background-position', '0px -6750px');});
$('#nevada').hover(function(){$('#state_preview').css('background-position', '0px -7000px');});
$('#new-hampshire').hover(function(){$('#state_preview').css('background-position', '0px -7250px');});
$('#new-jersey').hover(function(){$('#state_preview').css('background-position', '0px -7500px');});
$('#new-mexico').hover(function(){$('#state_preview').css('background-position', '0px -7750px');});
$('#new-york').hover(function(){$('#state_preview').css('background-position', '0px -8000px');});
$('#north-carolina').hover(function(){$('#state_preview').css('background-position', '0px -8250px');});
$('#north-dakota').hover(function(){$('#state_preview').css('background-position', '0px -8500px');});
$('#ohio').hover(function(){$('#state_preview').css('background-position', '0px -8750px');});
$('#oklahoma').hover(function(){$('#state_preview').css('background-position', '0px -9000px');});
$('#oregon').hover(function(){$('#state_preview').css('background-position', '0px -9250px');});
$('#pennsylvania').hover(function(){$('#state_preview').css('background-position', '0px -9500px');});
$('#rhode-island').hover(function(){$('#state_preview').css('background-position', '0px -9750px');});
$('#south-carolina').hover(function(){$('#state_preview').css('background-position', '0px -10000px');});
$('#south-dakota').hover(function(){$('#state_preview').css('background-position', '0px -10250px');});
$('#tennessee').hover(function(){$('#state_preview').css('background-position', '0px -10500px');});
$('#texas').hover(function(){$('#state_preview').css('background-position', '0px -10750px');});
$('#utah').hover(function(){$('#state_preview').css('background-position', '0px -11000px');});
$('#vermont').hover(function(){$('#state_preview').css('background-position', '0px -11250px');});
$('#virginia').hover(function(){$('#state_preview').css('background-position', '0px -11500px');});
$('#washington').hover(function(){$('#state_preview').css('background-position', '0px -11750px');});
$('#west-virginia').hover(function(){$('#state_preview').css('background-position', '0px -12000px');});
$('#wisconsin').hover(function(){$('#state_preview').css('background-position', '0px -12250px');});
$('#wyoming').hover(function(){$('#state_preview').css('background-position', '0px -12500px');});*/
</script>