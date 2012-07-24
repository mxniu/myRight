	var astack = new Array();
	var fstack = new Array();
	var hstack = new Array();
	var progress = 0;
	var firstq = 0;
	var num1 = 0;
	var num2 = 0;
	var num3 = 0;
	var address = 0;
	var all_questions;
	var num_of_questions;
	var current_factor;
	
	$.fn.addHoverEffect = function()
	{
		//Also activate the tooltips
		/*$("a[title]").tooltip();
		$("i[title]").tooltip();*/
		$("big[title]").tooltip({tipClass : "bigtip", position: "top right", offset: [0, -70]});
	}
	
	$.fn.loadResults = function(NUM)
	{
		$(".content").fadeOut(500, function(){
						$(".tooltip").css("display", "none");
						$(".content").empty().append("<img src='loading.gif' id='loading'/>").fadeIn(500);
		});
		var resultset = NUM;
		$(".address").attr("value", resultset);
		$(".table_name").attr("value", "results");
		//Do some database action
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var response_string = xmlhttp.responseText;
				
				//Convert the response into an array
				var a = response_string.split("|");
				
				//Increment the progress bar
				$("span#pb").progressBar(100, { showText: false});
				
				//Calculate Result!
				var result_qualifier = "";
				var show_form = true;
				if(Number(a[7]) == 9)
				{
					//This is the Independent Contractor/Employee Test
					if(weight <= Number(a[4]))
						result_qualifier = "probably are an Independent Contractor.";
					else if(weight > Number(a[4]) && weight <= Number(a[5]))
						result_qualifier = "may be an Independent Contractor.";
					else if(weight > Number(a[5]) && weight <= Number(a[6]))
						result_qualifier = "may be an Employee.";
					else if(weight > Number(a[6]))
						result_qualifier = "probably are an Employee.";
					else
						result_qualifier = "(bug alert!)";
						
					show_form = false;
				}
				else
				{
					if(weight <= Number(a[4]))
						result_qualifier = "<font color=red>may or may not</font>";
					else if(weight > Number(a[4]) && weight <= Number(a[5]))
						result_qualifier = "<font color=tomato>possibly</font>";
					else if(weight > Number(a[5]) && weight <= Number(a[6]))
						result_qualifier = "<font color=goldenrod>probably</font>";
					else if(weight > Number(a[6]))
						result_qualifier = "<font color=green>most likely</font>";
					else
						result_qualifier = "(bug alert!)";
				}
				
				

				var to_append = '<h1>You ' + result_qualifier + ' ' + String(a[2]) + '</h1>';
				
				if(Number(a[7]) == 12 && num3 > 0 && weight > Number(a[4]))
				{
					to_append += '<h3>Your weekly benefit will be approximately $' + num3 + '</h3>';
				}
				
				if(!show_form)
				{
					to_append += '<h3>Click on "Back to Claims" at the top right to select the proper answer.</h3>';
				}
				else
				{
					to_append += '<h3>This website is for EDUCATIONAL PURPOSES ONLY and NOT legal advice.<br />You should always <b>consult an attorney</b> regarding your legal claims,<br />but <i title="To be added">here</i> is how we arrived at your results.</h3>';
					
					//Dummy data for result form, will change later
					to_append += '<div class="result_form"><h3><b>Complete this form</b> to contact local attorneys that specialize<br/>in <b>' + String(a[1]) + '</b></h3><form>';
					to_append += '<h4>Name:&nbsp;<input type="text" name="name" class="customtext" maxlength=50></h4>';
					to_append += '<h4>E-mail:&nbsp;<input type="text" name="email" class="customtext" maxlength=100></h4>';
					to_append += '<h4>Describe your situation (optional):<br/><textarea name="description" cols="50" rows="8"></textarea></h4>';
					to_append += '<h4>Please select attorneys you would like to contact:</h4>';
					
					//Generate lawyer entry
					to_append += '<div class="result_lawyer"><div class="result_cbox"><a href = "#" id="a1" onclick="return false;"><img src="../images/main_checkedbox.png" id="check1" height="24" width="27"/></a></div><div class="result_avatarbox" style="background: url(../images/results_avatar3.png)"></div><div class="result_text"><strong>Smith, Smith, & Hovens, LLC</strong><br/>John Edward Smith<br/><big title="';
					//Here are the tooltip contents
					to_append += '<div class=&quot;bigtip_left&quot;><div class=&quot;bigtip_topleft&quot;><div><strong>Top Practices</strong></div><div>1. Bankruptcy</div><div>2. DUIs</div><div>3. Restraining Orders</div></div><div class=&quot;bigtip_middleleft&quot;><div style=&quot;margin-bottom: 10px;&quot;>Attorneys</div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div></div><div class=&quot;bigtip_bottomleft&quot;>3 Practitioners</div></div><div class=&quot;bigtip_center&quot;><div class=&quot;bigtip_topcenter&quot;>Years of Experience</div><div class=&quot;bigtip_middlecenter&quot;><img src=&quot;../images/results_pillar.png&quot;></div><div class=&quot;bigtip_bottomcenter&quot;>20 Years</div></div><div class=&quot;bigtip_right&quot;><div class=&quot;bigtip_topright&quot;>Number of Cases</div><div class=&quot;bigtip_middleright&quot;><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot; style=&quot;background-position: 88%;&quot;><img src=&quot;../images/results_briefcase.png&quot;></div></div><div class=&quot;bigtip_bottomright&quot;>312 Cases</div></div>';
					//Close it up
					to_append += '">Quick Stats</big></div></div>';
					
					to_append += '<div class="result_lawyer"><div class="result_cbox"><a href = "#"  id="a2" onclick="return false;"><img src="../images/main_checkedbox.png" id="check2" height="24" width="27"/></a></div><div class="result_avatarbox" style="background: url(../images/results_avatar2.png)"></div><div class="result_text"><strong>Reardon, Lancaster, & Oppenheimer LLC</strong><br/>Heather Reardon<br/><big title="';
					to_append += '<div class=&quot;bigtip_left&quot;><div class=&quot;bigtip_topleft&quot;><div><strong>Top Practices</strong></div><div>1. Criminal Defense</div><div>2. Expungement</div><div>3. Slip and Fall</div></div><div class=&quot;bigtip_middleleft&quot;><div style=&quot;margin-bottom: 10px;&quot;>Attorneys</div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div></div><div class=&quot;bigtip_bottomleft&quot;>3 Practitioners</div></div><div class=&quot;bigtip_center&quot;><div class=&quot;bigtip_topcenter&quot;>Years of Experience</div><div class=&quot;bigtip_middlecenter&quot; style=&quot;background-position: center 65%;&quot;><img src=&quot;../images/results_pillar.png&quot;></div><div class=&quot;bigtip_bottomcenter&quot;>34 Years</div></div><div class=&quot;bigtip_right&quot;><div class=&quot;bigtip_topright&quot;>Number of Cases</div><div class=&quot;bigtip_middleright&quot;><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot; style=&quot;background-position: 16%;&quot;><img src=&quot;../images/results_briefcase.png&quot;></div></div><div class=&quot;bigtip_bottomright&quot;>384 Cases</div></div>';
					to_append += '">Quick Stats</big></div></div>';
					
					to_append += '<div class="result_lawyer"><div class="result_cbox"><a href = "#" id="a3" onclick="return false;"><img src="../images/main_checkedbox.png" id="check3" height="24" width="27"/></a></div><div class="result_avatarbox" style="background: url(../images/results_avatar4.png)"></div><div class="result_text"><strong>The Law Offices of Christian Mesnick</strong><br/>Christian J. Mesnick<br/><big title="';
					to_append += '<div class=&quot;bigtip_left&quot;><div class=&quot;bigtip_topleft&quot;><div><strong>Top Practices</strong></div><div>1. DUIs</div><div>2. Slip and Fall</div><div>3. Medical Malpractice</div></div><div class=&quot;bigtip_middleleft&quot;><div style=&quot;margin-bottom: 10px;&quot;>Attorneys</div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div></div><div class=&quot;bigtip_bottomleft&quot;>1 Practitioner</div></div><div class=&quot;bigtip_center&quot;><div class=&quot;bigtip_topcenter&quot;>Years of Experience</div><div class=&quot;bigtip_middlecenter&quot; style=&quot;background-position: center 35%;&quot;><img src=&quot;../images/results_pillar.png&quot;></div><div class=&quot;bigtip_bottomcenter&quot;>12 Years</div></div><div class=&quot;bigtip_right&quot;><div class=&quot;bigtip_topright&quot;>Number of Cases</div><div class=&quot;bigtip_middleright&quot;><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot; style=&quot;background-position: 50%;&quot;><img src=&quot;../images/results_briefcase.png&quot;></div></div><div class=&quot;bigtip_bottomright&quot;>152 Cases</div></div>';
					to_append += '">Quick Stats</big></div></div>';
					
					to_append += '<div class="result_lawyer"><div class="result_cbox"><a href = "#" id="a4" onclick="return false;"><img src="../images/main_checkedbox.png" id="check4" height="24" width="27"/></a></div><div class="result_avatarbox" style="background: url(../images/results_avatar5.png)"></div><div class="result_text"><strong>Hoon, Arguendillo, & Esperanto LLC</strong><br/>Taekwon Hoon<br/><big title="';
					to_append += '<div class=&quot;bigtip_left&quot;><div class=&quot;bigtip_topleft&quot;><div><strong>Top Practices</strong></div><div>1. Copyright</div><div>2. Trademark</div><div>3. Real Estate</div></div><div class=&quot;bigtip_middleleft&quot;><div style=&quot;margin-bottom: 10px;&quot;>Attorneys</div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div></div><div class=&quot;bigtip_bottomleft&quot;>3 Practitioners</div></div><div class=&quot;bigtip_center&quot;><div class=&quot;bigtip_topcenter&quot;>Years of Experience</div><div class=&quot;bigtip_middlecenter&quot; style=&quot;background-position: center 55%;&quot;><img src=&quot;../images/results_pillar.png&quot;></div><div class=&quot;bigtip_bottomcenter&quot;>22 Years</div></div><div class=&quot;bigtip_right&quot;><div class=&quot;bigtip_topright&quot;>Number of Cases</div><div class=&quot;bigtip_middleright&quot;><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot; style=&quot;background-position: 60%;&quot;><img src=&quot;../images/results_briefcase.png&quot;></div></div><div class=&quot;bigtip_bottomright&quot;>239 Cases</div></div>';
					to_append += '">Quick Stats</big></div></div>';
					
					to_append += '<div class="result_lawyer"><div class="result_cbox"><a href = "#" id="a5" onclick="return false;"><img src="../images/main_checkedbox.png" id="check5" height="24" width="27"/></a></div><div class="result_avatarbox" style="background: url(../images/results_avatar1.png)"></div><div class="result_text"><strong>Legal Services of Greater County</strong><br/>Arlene Fitzwater<br/><big title="';
					to_append += '<div class=&quot;bigtip_left&quot;><div class=&quot;bigtip_topleft&quot;><div><strong>Top Practices</strong></div><div>1. Child Custody</div><div>2. Divorce</div><div>3. Unemployment</div></div><div class=&quot;bigtip_middleleft&quot;><div style=&quot;margin-bottom: 10px;&quot;>Attorneys</div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div></div><div class=&quot;bigtip_bottomleft&quot;>6 Practitioners</div></div><div class=&quot;bigtip_center&quot;><div class=&quot;bigtip_topcenter&quot;>Years of Experience</div><div class=&quot;bigtip_middlecenter&quot; style=&quot;background-position: center 20%;&quot;><img src=&quot;../images/results_pillar.png&quot;></div><div class=&quot;bigtip_bottomcenter&quot;>2 Years</div></div><div class=&quot;bigtip_right&quot;><div class=&quot;bigtip_topright&quot;>Number of Cases</div><div class=&quot;bigtip_middleright&quot;><div class=&quot;bigtip_case&quot; style=&quot;background-position: 40%;&quot;><img src=&quot;../images/results_briefcase.png&quot;></div></div><div class=&quot;bigtip_bottomright&quot;>60 Cases</div></div>';
					to_append += '">Quick Stats</big></div></div>';
					
					to_append += '<div class="result_lawyer"><div class="result_cbox"><a href = "#" id="a6" onclick="return false;"><img src="../images/main_checkedbox.png" id="check6" height="24" width="27"/></a></div><div class="result_avatarbox" style="background: url(../images/results_avatar7.png)"></div><div class="result_text"><strong>Speirs & Falsworth, LLC</strong><br/>Aaron Speirs<br/><big title="';
					to_append += '<div class=&quot;bigtip_left&quot;><div class=&quot;bigtip_topleft&quot;><div><strong>Top Practices</strong></div><div>1. Slip and Fall</div><div>2. Medical Malpractice</div><div>3. Domestic Violence</div></div><div class=&quot;bigtip_middleleft&quot;><div style=&quot;margin-bottom: 10px;&quot;>Attorneys</div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div></div><div class=&quot;bigtip_bottomleft&quot;>2 Practitioners</div></div><div class=&quot;bigtip_center&quot;><div class=&quot;bigtip_topcenter&quot;>Years of Experience</div><div class=&quot;bigtip_middlecenter&quot; style=&quot;background-position: center 48%;&quot;><img src=&quot;../images/results_pillar.png&quot;></div><div class=&quot;bigtip_bottomcenter&quot;>19 Years</div></div><div class=&quot;bigtip_right&quot;><div class=&quot;bigtip_topright&quot;>Number of Cases</div><div class=&quot;bigtip_middleright&quot;><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot; style=&quot;background-position: 20%;&quot;><img src=&quot;../images/results_briefcase.png&quot;></div></div><div class=&quot;bigtip_bottomright&quot;>281 Cases</div></div>';
					to_append += '">Quick Stats</big></div></div>';
					
					to_append += '<div class="result_lawyer"><div class="result_cbox"><a href = "#" id="a7" onclick="return false;"><img src="../images/main_checkedbox.png" id="check7" height="24" width="27"/></a></div><div class="result_avatarbox" style="background: url(../images/results_avatar6.png)"></div><div class="result_text"><strong>Englemeyer & Hauptmeiser, LLC</strong><br/>Thomas Marshall Englemeyer<br/><big title="';
					to_append += '<div class=&quot;bigtip_left&quot;><div class=&quot;bigtip_topleft&quot;><div><strong>Top Practices</strong></div><div>1. Tax</div><div>2. Wills & Trusts</div><div>3. Estate Planning</div></div><div class=&quot;bigtip_middleleft&quot;><div style=&quot;margin-bottom: 10px;&quot;>Attorneys</div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div><div class=&quot;bigtip_prac&quot;><img src=&quot;../images/results_prac.png&quot;></div></div><div class=&quot;bigtip_bottomleft&quot;>2 Practitioners</div></div><div class=&quot;bigtip_center&quot;><div class=&quot;bigtip_topcenter&quot;>Years of Experience</div><div class=&quot;bigtip_middlecenter&quot; style=&quot;background-position: center 75%;&quot;><img src=&quot;../images/results_pillar.png&quot;></div><div class=&quot;bigtip_bottomcenter&quot;>41 Years</div></div><div class=&quot;bigtip_right&quot;><div class=&quot;bigtip_topright&quot;>Number of Cases</div><div class=&quot;bigtip_middleright&quot;><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot;><img src=&quot;../images/results_briefcase.png&quot;></div><div class=&quot;bigtip_case&quot; style=&quot;background-position: 10%;&quot;><img src=&quot;../images/results_briefcase.png&quot;></div></div><div class=&quot;bigtip_bottomright&quot;>491 Cases</div></div>';
					to_append += '">Quick Stats</big></div></div>';
	
					to_append += '</form><br/><div class="link-outer"><div class="link-inner" style="font-size: 32px;">Submit</div></div></div>';
				}
				
				//Display results!
				$(".content").fadeOut(500, function(){
					if(show_form)
					{
						$(".container").css("height", "1940px");
					}
    				$(".content").empty().append(to_append).fadeIn(500);
					
					$("#a1").click(function() {
						if($("#check1").attr("src") == "../images/main_checkedbox.png")
							$("#check1").attr("src", "../images/main_checkbox.png");
						else 
							$("#check1").attr("src", "../images/main_checkedbox.png");
					});
					$("#a2").click(function() {
						if($("#check2").attr("src") == "../images/main_checkedbox.png")
							$("#check2").attr("src", "../images/main_checkbox.png");
						else 
							$("#check2").attr("src", "../images/main_checkedbox.png");
					});
					$("#a3").click(function() {
						if($("#check3").attr("src") == "../images/main_checkedbox.png")
							$("#check3").attr("src", "../images/main_checkbox.png");
						else 
							$("#check3").attr("src", "../images/main_checkedbox.png");
					});
					$("#a4").click(function() {
						if($("#check4").attr("src") == "../images/main_checkedbox.png")
							$("#check4").attr("src", "../images/main_checkbox.png");
						else 
							$("#check4").attr("src", "../images/main_checkedbox.png");
					});
					$("#a5").click(function() {
						if($("#check5").attr("src") == "../images/main_checkedbox.png")
							$("#check5").attr("src", "../images/main_checkbox.png");
						else 
							$("#check5").attr("src", "../images/main_checkedbox.png");
					});
					$("#a6").click(function() {
						if($("#check6").attr("src") == "../images/main_checkedbox.png")
							$("#check6").attr("src", "../images/main_checkbox.png");
						else 
							$("#check6").attr("src", "../images/main_checkedbox.png");
					});
					$("#a7").click(function() {
						if($("#check7").attr("src") == "../images/main_checkedbox.png")
							$("#check7").attr("src", "../images/main_checkbox.png");
						else 
							$("#check7").attr("src", "../images/main_checkedbox.png");
					});
					$(this).addHoverEffect();
						
				});
			}
		  }
		xmlhttp.open("GET","getresults.php?rs="+resultset,true);
		xmlhttp.send();
	}
	
	$.fn.getTest = function(NUM)
	{
		$(".content").fadeOut(500, function(){
				$(".tooltip").css("display", "none");
				$(".content").empty().append("<img src='loading.gif' id='loading'/>").fadeIn(500);
		});
		$.post("gettestdepth.php",{ sendValue: NUM },
            function(data){
				firstq = Number(data.firstq);
				//Increment the progress bar based on the depth
				/*progress = testdepth;
				$("span#pb").progressBar( progress, { showText: false});*/
				//Get the testdepth and firstq
				$(this).loadChildNode(firstq);
            }, "json");
	}
	
	$.fn.disableClicks = function(answer_array)
	{
		$("#a1").unbind('click');
	}

	function loadChildNode(QUNIT)
	{
		$(".content").fadeOut(500, function(){
						$(".tooltip").css("display", "none");
						$(".content").empty().append("<img src='loading.gif' id='loading'/>").fadeIn(500);
		});
		//Assign some local variables
		var qtype = $.trim(QUNIT['type']);
		
		//Common preconfiguration
		var to_append = '<h1>' + QUNIT['question'] + '</h1>';
		var answer_array = QUNIT['answers'].split('|');
		$(this).animateFactor(QUNIT['factor']);
		
				//Display the new array's question and answers on-screen
				if (qtype == "RS" || qtype == "MC")
				{
						for(x in answer_array)
						{
							answer_array[x] = answer_array[x].split(',');
							to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '"><img src="../images/main_checkbox.png" id="check_' + x + '" height="24" width="27"/>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
						}
					$(".content").fadeOut(500, function(){
						$("span#pb").css("display", "inline-block").css("margin-top", "30px");
						$(".content").empty().append(to_append).fadeIn(500);
						progress = 10 + (Number(QUNIT['seq'])/num_of_questions) * 90;
						$("span#pb").progressBar( progress, { showText: false});
						
						//Set up click event handlers
						$("div[id^='a_']").click(function() {
							var id = $(this).attr("id").split("_")[1];
							var target = $(this).attr("data-target");
							$("img[id='check_" + id + "']").attr("src", "../images/main_checkedbox.png");
							
							//If targeted, go to target
							if(target)
							{
								for(x in all_questions)
								{
									if(all_questions[x]['cluster'] == target)
										astack.push(all_questions[x]);
								}
							}
							
							//Eat the next item in the stack
							loadChildNode(astack.pop());
						});
						$(this).addHoverEffect();
					});
					$('#tips_blurb').fadeOut(500, function(){
							$('#tips_blurb').empty().append(QUNIT['tips']).fadeIn(500);	
						});
				}
				else if (qtype == "OP")
				{
					var targets_to_queue = new Array();
					/*if(answer_array.length > 5)
					{
						to_append += '<div class="optionbox">';
						for(var x = 0; x < answer_array.length / 2; x++)
						{
							answer_array[x] = answer_array[x].split(',');
							to_append += '<div class="option mini" id="a_' + x + '" data-target="' + answer_array[x][1] + '"><img src="../images/main_checkbox.png" id="check_' + x + '" height="24" width="27"/>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div><br />';
						}
						to_append += '</div><div class="optionbox">';
						for(var x = answer_array.length / 2; x < answer_array.length; x++)
						{
							answer_array[x] = answer_array[x].split(',');
							to_append += '<div class="option mini" id="a_' + x + '" data-target="' + answer_array[x][1] + '"><img src="../images/main_checkbox.png" id="check_' + x + '" height="24" width="27"/>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div><br />';
						}
						to_append += '</div>';
						
					}
					else
					{*/
					for(x in answer_array)
						{
							answer_array[x] = answer_array[x].split(',');
							to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '"><img src="../images/main_checkbox.png" id="check_' + x + '" height="24" width="27"/>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
	
						}
					//}
					to_append += '<div class="link-outer"><div class="link-inner" id="op_continue">Continue</div></div>';
					$(".content").fadeOut(500, function(){
						$("span#pb").css("display", "inline-block").css("margin-top", "30px");
						$(".content").empty().append(to_append).fadeIn(500);
						progress = 10 + (Number(QUNIT['seq'])/num_of_questions) * 90;
						$("span#pb").progressBar( progress, { showText: false});
						
						//Set up click event handlers
						$("div[id^='a_']").click(function() {
							var id = $(this).attr("id").split("_")[1];
							var target = $(this).attr("data-target");
							if($("img[id='check_" + id + "']").attr("src") == "../images/main_checkbox.png")
							{
								$("img[id='check_" + id + "']").attr("src", "../images/main_checkedbox.png");
								targets_to_queue.push(target);
							}
							else
							{
								$("img[id='check_" + id + "']").attr("src", "../images/main_checkbox.png");
								targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
							}
						});
						$("div#op_continue").click(function(){
							//Queue the targets
							
							for(var x = answer_array.length - 1; x >= 0; x--)
							{
								if(targets_to_queue.indexOf(answer_array[x][1]) == -1 || !answer_array[x][1])
								{
									continue;
								}
								for(y in all_questions)
								{
									if(all_questions[y]['cluster'] == answer_array[x][1])
										astack.push(all_questions[y]);
								}
							}
							
							//Eat the next item in the stack
							loadChildNode(astack.pop());
						});
						
						$(this).addHoverEffect();
					});
					$('#tips_blurb').fadeOut(500, function(){
							$('#tips_blurb').empty().append(QUNIT['tips']).fadeIn(500);	
						});
				}
				else if (qtype == "MB")
				{
						for(x in answer_array)
						{
							answer_array[x] = answer_array[x].split(',');
							if(answer_array[x][0].length > 20 && answer_array[x][0].indexOf('<br') == -1)
							{
								answer_array[x][0] = String(answer_array[x][0]).replace(" ", "<br />");
							}
							to_append += '<div class="link-outer"><div class="link-inner" id="a_' + answer_array[x][0] + '" data-target="' + answer_array[x][1] + '">' + answer_array[x][0] + '</div></div>';
						}
					$(".content").fadeOut(500, function(){
						$("span#pb").css("display", "inline-block").css("margin-top", "30px");
						$(".content").empty().append(to_append).fadeIn(500);
						progress = 10 + (Number(QUNIT['seq'])/num_of_questions) * 90;
						$("span#pb").progressBar( progress, { showText: false});
						
						//Resize font if necessary
						for(x in answer_array) 
						{
							if(answer_array[x][0].length <4)
							{
								$('div#a_' + answer_array[x][0]).css("font-size", "32px");
							}
							else if(answer_array[x][0].length <6)
							{
								$('div#a_' + answer_array[x][0]).css("font-size", "28px");
							}
							else if (answer_array[x][0].length <17)
							{
								$('div#a_' + answer_array[x][0]).css("font-size", "25px");
							}
							else
							{
								$('div#a_' + answer_array[x][0]).css("font-size", "23px");
							}
						}
						
						//Set up click event handlers
						$("div[id^='a_']").click(function() {
							var id = $(this).attr("id").split("_")[1];
							var target = $(this).attr("data-target");
							$("img[id='check_" + id + "']").attr("src", "../images/main_checkedbox.png");
								
							//If targeted, go to target
							if(target)
							{
								for(x in all_questions)
								{
									if(all_questions[x]['cluster'] == target)
										astack.push(all_questions[x]);
								}
							}	
								
							//Eat the next item in the stack
							loadChildNode(astack.pop());
						});
						$(this).addHoverEffect();
					});
					$('#tips_blurb').fadeOut(500, function(){
							$('#tips_blurb').empty().append(QUNIT['tips']).fadeIn(500);	
						});
				}
				else if(a[2] == "WC46")
				{ 
					if(num1 != 0)
					{
						weight = Number(num1);
						num1 = 0;
						
						var back_target = stack.pop();
						wstack.pop();
						$(this).loadChildNode(back_target);
					}
					else
					{
						if(weight < 0)
						{
							wstack.push(0);
							stack.push(Number(address));
							$(this).loadResults(a[1]);
						}
						else
						{
							num1 = Number(weight);
							wstack.push(0);
							stack.push(Number(address));
							$(this).loadChildNode(a[10]);
						}
					}
				}
				else if(a[2] == "UB29" || a[2] == "UB31")
				{ 
					num1 = 0; num2 = 0; num3 = 0;
					var to_append = '<h1>' + a[3] + '</h1>';
					to_append += '<div style="font-size: 22px"><input type="text" class="biginput" id="userinput1" maxlength=9 style="margin-bottom: 5px"/></div>';
					to_append += '<div class="warning_message">&nbsp;</div>'
					to_append += '<div class ="link-outer"><div class="link-inner" id="a_yes">Submit</div></div>';
					
					$(".content").fadeOut(500, function(){
						$(".endprescreen").fadeOut(500);
						$(".endtest").fadeIn(500);
						$(".container").css("height", "579px");
						$(".content").empty().append(to_append).fadeIn(500);
						progress = 25 + ((75.0/testdepth) * (Number(a[23]) - 1));
						$("span#pb").progressBar( progress, { showText: false});
						$("#a_yes").click(function() {
							var userinput1 = Number($("#userinput1").attr("value"));
							if(isNaN(userinput1) || userinput1 < 0)
							{
								$(".warning_message").empty().append("Please enter a valid number");
							}
							else
							{
								$("#a_yes").unbind('click');
								weight += Number(a[15]);
								num1 = userinput1;
								if(b[0] === '1')
									gate_keys += String(b[1]);
								if(Number(a[10]) > 0)
								{
									
									wstack.push(Number(a[15]));
									stack.push(Number(address));
									$(this).loadChildNode(a[10]);
								}
								else 
								{
									wstack.push(Number(a[15]));
									stack.push(Number(address));
									$(this).loadResults(a[1]);
								}
							}
						});
						$(this).addHoverEffect();
					});
				}
				else if(a[2] == "UB32")
				{
					num2 = 0; num3 = 0;
					//Determine appropriate date strings
					var d = new Date();
					var cmonth = d.getMonth();
					var cyear = d.getFullYear();
					var q1 = "";
					var q2 = "";
					var q3 = "";
					var q4 = "";
					if(cmonth == 1 || cmonth == 2 || cmonth == 3)
					{
						q1 = "January-March " + String(cyear-1);
						q2 = "April-June " + String(cyear-1);
						q3 = "July-September " + String(cyear-1);
						q4 = "October-December " + String(cyear-1);
					}
					else if(cmonth == 4 || cmonth == 5 || cmonth == 6)
					{
						q1 = "April-June " + String(cyear-1);
						q2 = "July-September " + String(cyear-1);
						q3 = "October-December " + String(cyear-1);
						q4 = "January-March " + String(cyear);
					}
					else if(cmonth == 7 || cmonth == 8 || cmonth == 9)
					{
						q1 = "July-September " + String(cyear-1);
						q2 = "October-December " + String(cyear-1);
						q3 = "January-March " + String(cyear);
						q4 = "April-June " + String(cyear);
					}
					else if(cmonth == 10 || cmonth == 11 || cmonth == 12)
					{
						q1 = "October-December " + String(cyear-1);
						q2 = "January-March " + String(cyear);
						q3 = "April-June " + String(cyear);
						q4 = "July-September " + String(cyear);
					}
					
					var to_append = '<h1>' + a[3] + '</h1>';
					to_append += '<h3><div style="width: 300px; text-align: left; display: inline-block">'+ q1 +'</div><input type="text" class="biginput" id="userinput1" maxlength=9/></h3>';
					to_append += '<h3><div style="width: 300px; text-align: left; display: inline-block">'+ q2 +'</div><input type="text" class="biginput" id="userinput2" maxlength=9/></h3>';
					to_append += '<h3><div style="width: 300px; text-align: left; display: inline-block">'+ q3 +'</div><input type="text" class="biginput" id="userinput3" maxlength=9/></h3>';
					to_append += '<h3><div style="width: 300px; text-align: left; display: inline-block">'+ q4 +'</div><input type="text" class="biginput" id="userinput4" maxlength=9/></h3>';
					to_append += '<div class="warning_message">&nbsp;</div>'
					to_append += '<div class ="link-outer"><div class="link-inner" id="a_yes">Submit</div></div>';
					
					$(".content").fadeOut(500, function(){
						$(".endprescreen").fadeOut(500);
						$(".endtest").fadeIn(500);
						$(".container").css("height", "579px");
						$(".content").empty().append(to_append).fadeIn(500);
						progress = 25 + ((75.0/testdepth) * (Number(a[23]) - 1));
						$("span#pb").progressBar( progress, { showText: false});
						$("#a_yes").click(function() {
							var userinput1 = Number($("#userinput1").attr("value"));
							var userinput2 = Number($("#userinput2").attr("value"));
							var userinput3 = Number($("#userinput3").attr("value"));
							var userinput4 = Number($("#userinput4").attr("value"));
							if(isNaN(userinput1) || userinput1 < 0)
							{
								$(".warning_message").empty().append("Please enter a valid number for " + q1);
							}
							else if(isNaN(userinput2) || userinput2 < 0)
							{
								$(".warning_message").empty().append("Please enter a valid number for " + q2);
							}
							else if(isNaN(userinput3) || userinput3 < 0)
							{
								$(".warning_message").empty().append("Please enter a valid number for " + q3);
							}
							else if(isNaN(userinput4) || userinput4 < 0)
							{
								$(".warning_message").empty().append("Please enter a valid number for " + q4);
							}
							else
							{
								$("#a_yes").unbind('click');
								weight += Number(a[15]);
								
								//Calculate max
								num2 = Math.max(userinput1, userinput2, userinput3, userinput4);
								//Do the math
								var base_period_wages = userinput1 + userinput2 + userinput3 + userinput4;
								var ptwA = (num1 - 25);
								if((num1 * .75) > ptwA)
									ptwA = num1 * .75;
								if(num2 < 900 || (num2 < 1300 && base_period_wages <= 1.25 * num2) )
								{
									wstack.push(Number(a[15]));
									stack.push(Number(address));
									$(this).loadResults(a[1]);
								}
								else
								{
									var weekly_benefit = 0;
									if(num2 > 1832.99)
									{
										weekly_benefit = num2/26;
										if(weekly_benefit > 450)
											weekly_benefit = 450;
									}
									else
									{
										var ub_table = new Array(948.99, 974.99, 1000.99, 1026.99, 1052.99, 1078.99, 1117.99, 1143.99, 1169.99, 1195.99, 1221.99, 1247.99, 1286.99, 1312.99, 1338.99, 1364.99, 1403.99, 1429.99, 1455.99, 1494.99, 1520.99, 1546.99, 1585.99, 1611.99, 1637.99, 1676.99, 1702.99, 1741.99, 1767.99, 1806.99, 1832.99); 
										for(var i = 0; i < ub_table.length; i++)
										{
											if(num2 < ub_table[i])
											{
												weekly_benefit = 40+i;
												break;
											}
										}
									}
									
									if(ptwA >= weekly_benefit)
									{
										wstack.push(Number(a[15]));
										stack.push(Number(address));
										$(this).loadResults(a[1]);
									}
									else
									{
										ptwA = (num1 - 25);
										if((num1 * .75) < ptwA)
											ptwA = num1 * .75;
										weekly_benefit -= ptwA;
										
										//Set the weekly benefit
										num3 = Math.ceil(weekly_benefit);
										
										wstack.push(Number(a[15]));
										stack.push(Number(address));
										$(this).loadChildNode(a[10]);
									}
								}
								//End else
							}
							//End click action else
						});
						//End fadeout nest
						$(this).addHoverEffect();
					});
				}
				//Ends if loop
		
		
	}

	function clearDefault(el) {
	  if (el.defaultValue==el.value) el.value = ""
	}
	
	function clearAfterSubmit() {
	  $(".suggestion").attr("value", "Type a suggestion here");
	}
	
	$.fn.preload = function() {
		this.each(function(){
			$('<img/>')[0].src = this;
		});
	}
	
	$.fn.firstPage = function(NUM)
	{	
		//Load the test into global var
		$(this).getIssue(NUM);
	
		/*---- BELOW THIS LINE IS OLD SHIT ----*/
	
		$(this).addHoverEffect();
		
		$("#pb").progressBar( 0, { showText: false});
		
		$(".backbutton").click(function() {
			//You are somewhere in the test, go ahead and pop off
			var back_target = history.pop();
			$(this).loadChildNode(back_target);	
		});
	}
	
	$.fn.getIssue = function(TESTNUM)
	{
		$(".content").fadeOut(500, function(){
						$(".tooltip").css("display", "none");
						$(".content").empty().append("<img src='loading.gif' id='loading'/>").fadeIn(500);
		});	
		$.post("getissue.php",{ sendValue: TESTNUM },
            function(data){
				all_questions = data;
				//Start eating the stack
				$(this).eatStack();
			}, "json");
	}
	
	$.fn.eatStack = function()
	{
		//Set the number of questions
		num_of_questions = all_questions.length;
		
		//Initialize the active stack with factors
		for(x in all_questions)
		{
			if(!all_questions[x]['cluster'])
			{
				astack.push(all_questions[x]);
				fstack.unshift(all_questions[x]);
			}
		}
		setupFactors();
		
		//Eat the first of the stack
		loadChildNode(astack.pop());
	}
	
	function setupFactors()
	{		
		for(var x = 0; x < fstack.length; x++)
		{
			if(x == 0)
				$('.factorbar').append('<div class="factor" id="factor_' + fstack[x]['factor'] + '"><div class="factor_left_end"></div><div class="factor_body">' + fstack[x]['factor'] + '</div><div class="factor_right"></div></div>');
			else if (x == fstack.length -1)
				$('.factorbar').append('<div class="factor" id="factor_' + fstack[x]['factor'] + '"><div class="factor_left"></div><div class="factor_body">' + fstack[x]['factor'] + '</div><div class="factor_right_end"></div></div>');
			else
				$('.factorbar').append('<div class="factor" id="factor_' + fstack[x]['factor'] + '"><div class="factor_left"></div><div class="factor_body">' + fstack[x]['factor'] + '</div><div class="factor_right"></div></div>');
		}
	}
	
	$.fn.animateFactor = function(FACTORNAME)
	{
		if(!FACTORNAME)
			return;
		else
		{
			current_factor = FACTORNAME;
			
			//Setup click functions
			$("div[id^='factor_']").click(function() {});
			var start_triggering = 1;
			for(y in fstack)
			{
				if(fstack[y]['factor'] == current_factor)
					{
						start_triggering = 0;
					}
					else if(start_triggering == 1)
					{
						$("div[id^='factor_"+fstack[y]['factor']+"']").hover(function() {
							var this_factor = $(this).attr("id").split("_")[1];
							$("div[id^='factor_"+this_factor+"']").children().css('background-position', function(i,v){
								return v.replace(/-?\d+px$/, '-27px');
							});
						}, function() {
							var this_factor = $(this).attr("id").split("_")[1];
							if(this_factor != current_factor)
								$("div[id^='factor_"+this_factor+"']").children().css('background-position', function(i,v){
									return v.replace(/-?\d+px$/, '0px');
								});
						});
						
						$("div[id^='factor_"+fstack[y]['factor']+"']").click(function() {
						var this_factor = $(this).attr("id").split("_")[1];
						//Empty the array
						astack = [];
						start_adding = 0;
						
						//Repush the relevant factors
						for(x in fstack)
						{
							if(fstack[x]['factor'] == this_factor)
							{
								start_adding = 1;
								astack.unshift(fstack[x]);
							}
							else if(start_adding == 1)
							{
								astack.unshift(fstack[x]);
							}
						}
						
						//Eat the first of the stack
						loadChildNode(astack.pop());
					});
				}
			}
			$("div[id^='factor_']").children().css('background-position', function(i,v){
				return v.replace(/-?\d+px$/, '0px');
			});
			$("div[id^='factor_"+FACTORNAME+"']").children().css('background-position', function(i,v){
					return v.replace(/-?\d+px$/, '-27px');
			});
		}
	}