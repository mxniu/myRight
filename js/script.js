	var weight = 0;
	var gate_keys = '';
	var stack = new Array();
	var pstack = new Array();
	var wstack = new Array();
	var progress = 0;
	var PDEPTH = 7;
	var testdepth = 0;
	var progress_at_entry = 0;
	var firstq = 0;
	var num1 = 0;
	var num2 = 0;
	var num3 = 0;
	var search_query = '';
	var address = 0;
	
	$.fn.addHoverEffect = function()
	{
		//Also activate the tooltips
		$("a[title]").tooltip();
		$("i[title]").tooltip();
		$("big[title]").tooltip({tipClass : "bigtip", position: "top right", offset: [0, -70]});
	}
	
	$.fn.endTest = function()
	{
		//Terminate test and use pstack instead
		wstack = new Array();
		weight = 0;
		gate_keys = '';
		testdepth = 0;
		stack = new Array();
					
		progress = Number(progress_at_entry);
		$("span#pb").progressBar( progress, { showText: false});
		progress_at_entry = 0;
					
		var back_target = pstack.pop();
		$(this).prescreen(back_target);
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
                testdepth = Number(data.depth);
				firstq = Number(data.firstq);
				//Increment the progress bar based on the depth
				/*progress = testdepth;
				$("span#pb").progressBar( progress, { showText: false});*/
				//Get the testdepth and firstq
				$(this).loadChildNode(firstq);
            }, "json");
	}
	
	$.fn.inputSearch = function(INPUT)
	{
		$(".sidead").fadeIn(500);
		$(".figure").fadeOut(500);
		$(".first_question").fadeOut(500);
		$(".endtest").fadeOut(500);
		$(".demotests").fadeOut(500);
		
		$(".address").attr("value", INPUT);
		$(".table_name").attr("value", "search_results");
		$(".content").fadeOut(500, function(){
				$(".tooltip").css("display", "none");
				$(".content").empty().append("<img src='loading.gif' id='loading'/>").fadeIn(500);
		});
		$.post("gettestsearch.php",{ sendValue: INPUT },
            function(data){
				{
						alert('query run');
						var to_append = '<h1>These legal issues may apply to your case:</h1>';	
						var test_array;
						for(var i = 0; i<Number(data.count); i++)
						{
							if(i == 0)
								test_array[0] = String(data.array1).split(",");
							if(i == 1)
								test_array[1] = String(data.array2).split(",");
							if(i == 2)
								test_array[2] = String(data.array3).split(",");
							if(i == 3)
								test_array[3] = String(data.array4).split(",");
							if(i == 4)
								test_array[4] = String(data.array5).split(",");
							if(i == 5)
								test_array[5] = String(data.array6).split(",");
						}
						for(var i = 0; i<test_array.length; i++)
						{
							if(test_array[i][0] > 20 && test_array[i][0].indexOf('<br') == -1)
							{
								test_array[i][0] = String(test_array[i][0]).replace(" ", "<br />");
							}
							to_append += '<div class="link-outer"><div class="link-inner" id="a' + (Number(i)+1) + '">' + test_array[i][0] + '</div></div>';
						}
						$(".content").fadeOut(500, function(){
							$(".endtest").fadeOut(500);
							$(".endprescreen").fadeIn(500);
							$(".backbutton").fadeIn(500);
							$(".container").css("height", "579px");
							$(".content").empty().css("margin-top", "20px").css("width", "565px").append(to_append).fadeIn(500);
							//Resize font if necessary
							for(var i = 0; i < test_array.length; i++) 
							{
								if(test_array[i][0].length <6)
								{
									$('div#a' + (i+1)).css("font-size", "28px");
								}
								else if (test_array[i][0].length <17)
								{
									$('div#a' + (i+1)).css("font-size", "25px");
								}
								else
								{
									$('div#a' + (i+1)).css("font-size", "23px");
								}
							}
							$("span#pb").css("display", "inline-block").css("margin-top", "30px");
							$("#a1").click(function() {
								$(this).disableClicks();
								//Set progress bar to 25 by default, save the current progress
								progress_at_entry = new Number(progress);
									
								//Push old node onto the pstack
								pstack.push(Number("S"));
								search_query = INPUT;
								testdepth = test_array[0][1];
								$(this).loadChildNode(test_array[0][2]);
							});
							$("#a2").click(function() {
								$(this).disableClicks();
								//Set progress bar to 25 by default, save the current progress
								progress_at_entry = new Number(progress);
									
								//Push old node onto the pstack
								pstack.push(Number("S"));
								search_query = INPUT;
								testdepth = test_array[1][1];
								$(this).loadChildNode(test_array[1][2]);
							});
							$("#a3").click(function() {
								$(this).disableClicks();
								//Set progress bar to 25 by default, save the current progress
								progress_at_entry = new Number(progress);
									
								//Push old node onto the pstack
								pstack.push(Number("S"));
								search_query = INPUT;
								testdepth = test_array[2][1];
								$(this).loadChildNode(test_array[2][2]);
							});
							$("#a4").click(function() {
								$(this).disableClicks();
								//Set progress bar to 25 by default, save the current progress
								progress_at_entry = new Number(progress);
									
								//Push old node onto the pstack
								pstack.push(Number("S"));
								search_query = INPUT;
								testdepth = test_array[3][1];
								$(this).loadChildNode(test_array[3][2]);
							});
							$("#a5").click(function() {
								$(this).disableClicks();
								//Set progress bar to 25 by default, save the current progress
								progress_at_entry = new Number(progress);
									
								//Push old node onto the pstack
								pstack.push(Number("S"));
								search_query = INPUT;
								testdepth = test_array[4][1];
								$(this).loadChildNode(test_array[4][2]);
							});
							$("#a6").click(function() {
								$(this).disableClicks();
								//Set progress bar to 25 by default, save the current progress
								progress_at_entry = new Number(progress);
									
								//Push old node onto the pstack
								pstack.push(Number("S"));
								search_query = INPUT;
								testdepth = test_array[5][1];
								$(this).loadChildNode(test_array[5][2]);
							});
							$(this).addHoverEffect();
						});
					}
            }, "json");
	}
	
	$.fn.disableClicks = function()
	{
		$("#a1").unbind('click');
		$("#a2").unbind('click');
		$("#a3").unbind('click');
		$("#a4").unbind('click');
		$("#a5").unbind('click');
		$("#a6").unbind('click');
		$("#a7").unbind('click');
		$("#a8").unbind('click');
		$("#a9").unbind('click');
		$("#a10").unbind('click');
	}

	$.fn.loadChildNode = function(NUM)
	{
		$(".content").fadeOut(500, function(){
						$(".tooltip").css("display", "none");
						$(".content").empty().append("<img src='loading.gif' id='loading'/>").fadeIn(500);
		});
		address = NUM;
		$(".address").attr("value", address);
		$(".table_name").attr("value", "questions");
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
				var b;
				
				//Check for gate locks
					if(String(a[21]).length > 0)
					{
						if(gate_keys.indexOf(String(a[21])) < 0)
							if(Number(a[22]) > 0)
							{
								$(this).loadChildNode(a[22]);
								return;
							}
							else 
							{
								$(this).loadResults(a[1]);
								return;
							}
					}
				
				if(String(a[20]).length > 0)
				{
					b = String(a[20]).split(".");
				}
				else
				{
					b = ['0',''];
				}
				
				//Increment the progress bar
				//$("#pb").progressBar(10+((Number(a[19])/(Number(a[20])+1))*90), { showText: false});
				
				//Display the new array's question and answers on-screen
				if(a[2] == "YN")
				{
					var to_append = '<h1>' + a[3] + '</h1><div class ="link-outer_small"><div class="link-inner_small" id="a_yes">Yes</div></div><div class ="link-outer_small"><div class="link-inner_small" id="a_no">No</div></div>';
					$(".content").fadeOut(500, function(){
						$(".endprescreen").fadeOut(500);
						$(".endtest").fadeIn(500);
						$(".container").css("height", "579px");
						$(".content").empty().append(to_append).fadeIn(500);
						progress = 25 + ((75.0/testdepth) * (Number(a[23]) - 1));
						$("span#pb").progressBar( progress, { showText: false});
						$("#a_yes").click(function() {
							$("#a_yes").unbind('click');
							$("#a_no").unbind('click');
							weight += Number(a[15]);
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
						});
						$("#a_no").click(function() {
							$("#a_yes").unbind('click');
							$("#a_no").unbind('click');
							weight += Number(a[16]);
							if(b[0] === '2')
								gate_keys += String(b[1]);
							if(Number(a[11]) > 0)
							{
								
								wstack.push(Number(a[16]));
								stack.push(Number(address));
								$(this).loadChildNode(a[11]);
							}
							else
							{
								wstack.push(Number(a[16]));
								stack.push(Number(address)); 
								$(this).loadResults(a[1]);
							}
						});
						$(this).addHoverEffect();
					});
				}
				else if (a[2] == "RS" || a[2] == "MC")
				{
					var to_append = '<h1>' + a[3] + '</h1>';
					if(Number(a[4]) > 5)
					{
						for(var i = 0; i<5; i++)
						{
							to_append += '<div class="option" id="a' + (Number(i)+1) + '"><img src="../images/main_checkbox.png" id="check' + (Number(i)+1) + '" height="24" width="27"/>&nbsp;<div class="optiontext">' + a[5+i] + '</div></div><br />';
						}
						for(var i = 5; i<Number(a[4]); i++)
						{
							to_append += '<div class="option" id="a' + (Number(i)+1) + '"><img src="../images/main_checkbox.png" id="check' + (Number(i)+1) + '" height="24" width="27"/>&nbsp;<div class="optiontext">' + a[19+i] + '</div></div><br />';
						}
					}
					else
					{
						for(var i = 0; i<Number(a[4]); i++)
						{
							to_append += '<div class="option" id="a' + (Number(i)+1) + '"><img src="../images/main_checkbox.png" id="check' + (Number(i)+1) + '" height="24" width="27"/>&nbsp;<div class="optiontext">' + a[5+i] + '</div></div><br />';
						}
					}
					
					$(".content").fadeOut(500, function(){
						$(".endprescreen").fadeOut(500);
						$(".endtest").fadeIn(500);
						//Adjust container if necessary
						if(Number(a[4]) > 5)
						{
							$(".container").css("height", "1000px");
						}
						else
						{
							$(".container").css("height", "579px");
						}
						
						$(".content").empty().append(to_append).fadeIn(500);
						progress = 25 + ((75.0/testdepth) * (Number(a[23]) - 1));
						$("span#pb").progressBar( progress, { showText: false});
						$("#a1").click(function() {
								$(this).disableClicks();
							weight += Number(a[15]);
							$("#check1").attr("src", "../images/main_checkedbox.png");
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
						});
						$("#a2").click(function() {
								$(this).disableClicks();
							weight += Number(a[16]);
							$("#check2").attr("src", "../images/main_checkedbox.png");
							if(b[0] === '2')
								gate_keys += String(b[1]);
							if(Number(a[11]) > 0)
							{
								
								wstack.push(Number(a[16]));
								stack.push(Number(address));
								$(this).loadChildNode(a[11]);
							}
							else 
							{
								wstack.push(Number(a[16]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a3").click(function() {
								$(this).disableClicks();
							weight += Number(a[17]);
							$("#check3").attr("src", "../images/main_checkedbox.png");
							if(b[0] === '3')
								gate_keys += String(b[1]);
							if(Number(a[12]) > 0)
							{
								
								wstack.push(Number(a[17]));
								stack.push(Number(address));
								$(this).loadChildNode(a[12]);
							}
							else 
							{
								wstack.push(Number(a[17]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a4").click(function() {
								$(this).disableClicks();
							weight += Number(a[18]);
							$("#check4").attr("src", "../images/main_checkedbox.png");
							if(b[0] === '4')
								gate_keys += String(b[1]);
							if(Number(a[13]) > 0)
							{
								
								wstack.push(Number(a[18]));
								stack.push(Number(address));
								$(this).loadChildNode(a[13]);
							}
							else 
							{
								wstack.push(Number(a[18]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a5").click(function() {
								$(this).disableClicks();
							weight += Number(a[19]);
							$("#check5").attr("src", "../images/main_checkedbox.png");
							if(b[0] === '5')
								gate_keys += String(b[1]);
							if(Number(a[14]) > 0)
							{
								
								wstack.push(Number(a[19]));
								stack.push(Number(address));
								$(this).loadChildNode(a[14]);
							}
							else 
							{
								wstack.push(Number(a[19]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a6").click(function() {
								$(this).disableClicks();
							weight += Number(a[34]);
							$("#check6").attr("src", "../images/main_checkedbox.png");
							if(b[0] === '6')
								gate_keys += String(b[1]);
							if(Number(a[29]) > 0)
							{
								
								wstack.push(Number(a[34]));
								stack.push(Number(address));
								$(this).loadChildNode(a[29]);
							}
							else 
							{
								wstack.push(Number(a[34]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a7").click(function() {
								$(this).disableClicks();
							weight += Number(a[35]);
							$("#check7").attr("src", "../images/main_checkedbox.png");
							if(b[0] === '7')
								gate_keys += String(b[1]);
							if(Number(a[30]) > 0)
							{
								
								wstack.push(Number(a[35]));
								stack.push(Number(address));
								$(this).loadChildNode(a[30]);
							}
							else 
							{
								wstack.push(Number(a[35]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a8").click(function() {
								$(this).disableClicks();
							weight += Number(a[36]);
							$("#check8").attr("src", "../images/main_checkedbox.png");
							if(b[0] === '8')
								gate_keys += String(b[1]);
							if(Number(a[31]) > 0)
							{
								
								wstack.push(Number(a[36]));
								stack.push(Number(address));
								$(this).loadChildNode(a[31]);
							}
							else 
							{
								wstack.push(Number(a[36]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a9").click(function() {
								$(this).disableClicks();
							weight += Number(a[37]);
							$("#check9").attr("src", "../images/main_checkedbox.png");
							if(b[0] === '9')
								gate_keys += String(b[1]);
							if(Number(a[32]) > 0)
							{
								
								wstack.push(Number(a[37]));
								stack.push(Number(address));
								$(this).loadChildNode(a[32]);
							}
							else 
							{
								wstack.push(Number(a[37]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a10").click(function() {
								$(this).disableClicks();
							weight += Number(a[38]);
							$("#check10").attr("src", "../images/main_checkedbox.png");
							if(b[0] === '10')
								gate_keys += String(b[1]);
							if(Number(a[33]) > 0)
							{
								
								wstack.push(Number(a[38]));
								stack.push(Number(address));
								$(this).loadChildNode(a[33]);
							}
							else 
							{
								wstack.push(Number(a[38]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$(this).addHoverEffect();
					});
				}
				else if (a[2] == "MB")
				{
					var to_append = '<h1>' + a[3] + '</h1>';
					if(Number(a[4]) > 5)
					{
						for(var i = 0; i<5; i++)
						{
							if(a[5+i].length > 20 && a[5+i].indexOf('<br') == -1)
							{
								a[5+i] = String(a[5+i]).replace(" ", "<br />");
							}
							to_append += '<div class="link-outer"><div class="link-inner" id="a' + (Number(i)+1) + '">' + a[5+i] + '</div></div>';
						}
						for(var i = 5; i<Number(a[4]); i++)
						{
							if(a[19+i].length > 20 && a[19+i].indexOf('<br') == -1)
							{
								a[19+i] = String(a[19+i]).replace(" ", "<br />");
							}
							to_append += '<div class="link-outer"><div class="link-inner" id="a' + (Number(i)+1) + '">' + a[19+i] + '</div></div>';
						}
					}
					else
					{
						for(var i = 0; i<Number(a[4]); i++)
						{
							if(a[5+i].length > 20 && a[5+i].indexOf('<br') == -1)
							{
								a[5+i] = String(a[5+i]).replace(" ", "<br />");
							}
							to_append += '<div class="link-outer"><div class="link-inner" id="a' + (Number(i)+1) + '">' + a[5+i] + '</div></div>';
						}
					}
					$(".content").fadeOut(500, function(){
						$(".endprescreen").fadeOut(500);
						$(".endtest").fadeIn(500);
						$(".container").css("height", "579px");
						$(".content").empty().append(to_append).fadeIn(500);
						
						//Resize font if necessary
						if(Number(a[4]) > 5)
						{
							for(var i = 5; i < 10; i++) 
							{
								if(a[i].length <6)
								{
									$('div#a' + (i-4)).css("font-size", "28px");
								}
								else if (a[i].length <17)
								{
									$('div#a' + (i-4)).css("font-size", "25px");
								}
								else
								{
									$('div#a' + (i-4)).css("font-size", "23px");
								}
							}
							for(var i = 24; i < Number(a[4]) + 19; i++) 
							{
								if(a[i].length <6)
								{
									$('div#a' + (i-18)).css("font-size", "28px");
								}
								else if (a[i].length <17)
								{
									$('div#a' + (i-18)).css("font-size", "25px");
								}
								else
								{
									$('div#a' + (i-18)).css("font-size", "23px");
								}
							}
						}
						else
						{
							for(var i = 5; i < Number(a[4]) + 5; i++) 
							{
								if(a[i].length <6)
								{
									$('div#a' + (i-4)).css("font-size", "28px");
								}
								else if (a[i].length <17)
								{
									$('div#a' + (i-4)).css("font-size", "25px");
								}
								else
								{
									$('div#a' + (i-4)).css("font-size", "23px");
								}
							}
						}
						
						progress = 25 + ((75.0/testdepth) * (Number(a[23]) - 1));
						$("span#pb").progressBar( progress, { showText: false});
						$("#a1").click(function() {
								$(this).disableClicks();
							weight += Number(a[15]);
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
						});
						$("#a2").click(function() {
								$(this).disableClicks();
							weight += Number(a[16]);
							if(b[0] === '2')
								gate_keys += String(b[1]);
							if(Number(a[11]) > 0)
							{
								
								wstack.push(Number(a[16]));
								stack.push(Number(address));
								$(this).loadChildNode(a[11]);
							}
							else 
							{
								wstack.push(Number(a[16]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a3").click(function() {
								$(this).disableClicks();
							weight += Number(a[17]);
							if(b[0] === '3')
								gate_keys += String(b[1]);
							if(Number(a[12]) > 0)
							{
								
								wstack.push(Number(a[17]));
								stack.push(Number(address));
								$(this).loadChildNode(a[12]);
							}
							else 
							{
								wstack.push(Number(a[17]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a4").click(function() {
								$(this).disableClicks();
							weight += Number(a[18]);
							if(b[0] === '4')
								gate_keys += String(b[1]);
							if(Number(a[13]) > 0)
							{
								
								wstack.push(Number(a[18]));
								stack.push(Number(address));
								$(this).loadChildNode(a[13]);
							}
							else 
							{
								wstack.push(Number(a[18]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a5").click(function() {
								$(this).disableClicks();
							weight += Number(a[19]);
							if(b[0] === '5')
								gate_keys += String(b[1]);
							if(Number(a[14]) > 0)
							{
								
								wstack.push(Number(a[19]));
								stack.push(Number(address));
								$(this).loadChildNode(a[14]);
							}
							else 
							{
								wstack.push(Number(a[19]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a6").click(function() {
								$(this).disableClicks();
							weight += Number(a[34]);
							if(b[0] === '6')
								gate_keys += String(b[1]);
							if(Number(a[29]) > 0)
							{
								
								wstack.push(Number(a[34]));
								stack.push(Number(address));
								$(this).loadChildNode(a[29]);
							}
							else 
							{
								wstack.push(Number(a[34]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a7").click(function() {
								$(this).disableClicks();
							weight += Number(a[35]);
							if(b[0] === '7')
								gate_keys += String(b[1]);
							if(Number(a[30]) > 0)
							{
								
								wstack.push(Number(a[35]));
								stack.push(Number(address));
								$(this).loadChildNode(a[30]);
							}
							else 
							{
								wstack.push(Number(a[35]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a8").click(function() {
								$(this).disableClicks();
							weight += Number(a[36]);
							if(b[0] === '8')
								gate_keys += String(b[1]);
							if(Number(a[31]) > 0)
							{
								
								wstack.push(Number(a[36]));
								stack.push(Number(address));
								$(this).loadChildNode(a[31]);
							}
							else 
							{
								wstack.push(Number(a[36]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a9").click(function() {
								$(this).disableClicks();
							weight += Number(a[37]);
							if(b[0] === '9')
								gate_keys += String(b[1]);
							if(Number(a[32]) > 0)
							{
								
								wstack.push(Number(a[37]));
								stack.push(Number(address));
								$(this).loadChildNode(a[32]);
							}
							else 
							{
								wstack.push(Number(a[37]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$("#a10").click(function() {
								$(this).disableClicks();
							weight += Number(a[38]);
							if(b[0] === '10')
								gate_keys += String(b[1]);
							if(Number(a[33]) > 0)
							{
								
								wstack.push(Number(a[38]));
								stack.push(Number(address));
								$(this).loadChildNode(a[33]);
							}
							else 
							{
								wstack.push(Number(a[38]));
								stack.push(Number(address));
								$(this).loadResults(a[1]);
							}
						});
						$(this).addHoverEffect();
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
		  }
		
		
		xmlhttp.open("GET","getnewpage.php?l="+address,true);
		xmlhttp.send();
	}

	function clearDefault(el) {
	  if (el.defaultValue==el.value) el.value = ""
	}
	
	function clearAfterSubmit() {
	  $(".suggestion").attr("value", "Type a suggestion here");
	}

	$.fn.prescreen = function(NUM) { 
		$(".sidead").fadeIn(500);
		$(".figure").fadeOut(500);
		$(".first_question").fadeOut(500);
		$(".endtest").fadeOut(500);
		$(".demotests").fadeOut(500);
		
		$(".ltl_button").click(function() {
			var post_address = 'qid=' + address;
			TINY.box.show({url:'getqinfo.php',post:post_address,boxid:'infobox', height:500, width:780}, function(){
				$('#scrollbar1').tinyscrollbar();
			});
		});
		
		address = NUM;
		$(".address").attr("value", address);
		$(".table_name").attr("value", "prescreen");
		if(address == "S")
		{
			$(this).inputSearch(search_query);
			return;
		}
		else if(address > 0 && address != 1 && address != 6 && address != 7 && address != 8)
		{
			$(".content").fadeOut(500, function(){
				$(".tooltip").css("display", "none");
				$(".content").empty().append("<img src='loading.gif' id='loading'/>").fadeIn(500);
			});
			//Load a prescreening question
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
					
					//Display the new array's question and answers on-screen
					if(a[1] == "YN")
					{
						var to_append = '<h1>' + a[2] + '</h1><div class ="link-outer_small"><div class="link-inner_small" id="a_yes">Yes</div></div><div class ="link-outer_small"><div class="link-inner_small" id="a_no">No</div></div>';
						$(".content").fadeOut(500, function(){
							$(".endtest").fadeOut(500);
							$(".endprescreen").fadeIn(500);
							$(".backbutton").fadeIn(500);
							$(".container").css("height", "579px");
							$(".content").empty().css("margin-top", "20px").css("width", "565px").append(to_append).fadeIn(500);
							$("span#pb").css("display", "inline-block").css("margin-top", "30px");
							$(".ltl_blurb").empty().append("Click on the tabs or Learn the Law to learn more about this question. This functionality is being continuously rolled in with the next version, so check back soon for updates.");
							$("#a_yes").click(function() {
								$(this).disableClicks();
								$("#a_yes").unbind('click');
								$("#a_no").unbind('click');
								if(Number(a[14]) >= 0)
								{
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[14]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[14]);
								}
							});
							$("#a_no").click(function() {
								$(this).disableClicks();
								$("#a_yes").unbind('click');
								$("#a_no").unbind('click');
								if(Number(a[15]) >= 0)
								{
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[15]);
								}
								else
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[15]);
									
								}
							});
							$(this).addHoverEffect();
						});
					}
					else if (a[1] == "RS" || a[1] == "MC")
					{
						var to_append = '<h1>' + a[2] + '</h1>';
						for(var i = 0; i<Number(a[3]); i++)
						{
							to_append += '<div class="option" id="a' + (Number(i)+1) + '"><img src="../images/main_checkbox.png" id="check' + (Number(i)+1) + '" height="24" width="27"/>&nbsp;<div class="optiontext">' + a[4+i] + '</div></div><br />';
						};
						$(".content").fadeOut(500, function(){
							$(".endtest").fadeOut(500);
							$(".endprescreen").fadeIn(500);
							$(".backbutton").fadeIn(500);
							$(".ltl_blurb").empty().append("Click on the tabs or Learn the Law to learn more about this question. This functionality is being continuously rolled in with the next version, so check back soon for updates.");
							//Adjust container if necessary
							if(Number(a[3]) > 5)
							{
								$(".container").css("height", "1000px");
							}
							else
							{
								$(".container").css("height", "579px");
							}
							
							$(".content").empty().css("margin-top", "20px").css("width", "565px").append(to_append).fadeIn(500);
							$("span#pb").css("display", "inline-block").css("margin-top", "30px");
							$("#a1").click(function() {
								$(this).disableClicks();
								$("#check1").attr("src", "../images/main_checkedbox.png");
								if(Number(a[14]) >= 0)
								{
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[14]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[14]);
									
								}
							});
							$("#a2").click(function() {
								$(this).disableClicks();
								$("#check2").attr("src", "../images/main_checkedbox.png");
								if(Number(a[15]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[15]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[15]);
									
								}
							});
							$("#a3").click(function() {
								$(this).disableClicks();
								$("#check3").attr("src", "../images/main_checkedbox.png");
								if(Number(a[16]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[16]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[16]);
									
								}
							});
							$("#a4").click(function() {
								$(this).disableClicks();
								$("#check4").attr("src", "../images/main_checkedbox.png");
								if(Number(a[17]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[17]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[17]);
									
								}
							});
							$("#a5").click(function() {
								$(this).disableClicks();
								$("#check5").attr("src", "../images/main_checkedbox.png");
								if(Number(a[18]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[18]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[18]);
									
								}
							});
							$("#a6").click(function() {
								$(this).disableClicks();
								$("#check6").attr("src", "../images/main_checkedbox.png");
								if(Number(a[19]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[19]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[19]);
									
								}
							});
							$("#a7").click(function() {
								$(this).disableClicks();
								$("#check7").attr("src", "../images/main_checkedbox.png");
								if(Number(a[20]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[20]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[20]);
									
								}
							});
							$("#a8").click(function() {
								$(this).disableClicks();
								$("#check8").attr("src", "../images/main_checkedbox.png");
								if(Number(a[21]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[21]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[21]);
									
								}
							});
							$("#a9").click(function() {
								$(this).disableClicks();
								$("#check9").attr("src", "../images/main_checkedbox.png");
								if(Number(a[22]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[22]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[22]);
									
								}
							});
							$("#a10").click(function() {
								$(this).disableClicks();
								$("#check10").attr("src", "../images/main_checkedbox.png");
								if(Number(a[23]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[23]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[23]);
									
								}
							});
							$(this).addHoverEffect();
						});
					}
					else if (a[1] == "MB")
					{
						var to_append = '<h1>' + a[2] + '</h1>';		
						for(var i = 0; i<Number(a[3]); i++)
						{
							if(a[4+i].length > 20 && a[4+i].indexOf('<br') == -1)
							{
								a[4+i] = String(a[4+i]).replace(" ", "<br />");
							}
							to_append += '<div class="link-outer"><div class="link-inner" id="a' + (Number(i)+1) + '">' + a[4+i] + '</div></div>';
						}
						$(".content").fadeOut(500, function(){
							$(".endtest").fadeOut(500);
							$(".endprescreen").fadeIn(500);
							$(".backbutton").fadeIn(500);
							$(".container").css("height", "579px");
							$(".content").empty().css("margin-top", "20px").css("width", "565px").append(to_append).fadeIn(500);
							$(".ltl_blurb").empty().append("Click on the tabs or Learn the Law to learn more about this question. This functionality is being continuously rolled in with the next version, so check back soon for updates.");
							//Resize font if necessary
							for(var i = 4; i < Number(a[3]) + 4; i++) 
							{
								if(a[i].length <6)
								{
									$('div#a' + (i-3)).css("font-size", "28px");
								}
								else if (a[i].length <17)
								{
									$('div#a' + (i-3)).css("font-size", "25px");
								}
								else
								{
									$('div#a' + (i-3)).css("font-size", "23px");
								}
							}
							$("span#pb").css("display", "inline-block").css("margin-top", "30px");
							$("#a1").click(function() {
								$(this).disableClicks();
								if(Number(a[14]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[14]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[14]);
									
								}
							});
							$("#a2").click(function() {
								$(this).disableClicks();
								if(Number(a[15]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[15]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[15]);
									
								}
							});
							$("#a3").click(function() {
								$(this).disableClicks();
								if(Number(a[16]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[16]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[16]);
									
								}
							});
							$("#a4").click(function() {
								$(this).disableClicks();
								if(Number(a[17]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[17]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[17]);
									
								}
							});
							$("#a5").click(function() {
								$(this).disableClicks();
								if(Number(a[18]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[18]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[18]);
									
								}
							});
							$("#a6").click(function() {
								$(this).disableClicks();
								if(Number(a[19]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[19]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[19]);
									
								}
							});
							$("#a7").click(function() {
								$(this).disableClicks();
								if(Number(a[20]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[20]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[20]);
									
								}
							});
							$("#a8").click(function() {
								$(this).disableClicks();
								if(Number(a[21]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[21]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[21]);
									
								}
							});
							$("#a9").click(function() {
								$(this).disableClicks();
								if(Number(a[22]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[22]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[22]);
									
								}
							});
							$("#a10").click(function() {
								$(this).disableClicks();
								if(Number(a[23]) >= 0)
								{
									
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
									pstack.push(Number(address));
									$(this).prescreen(a[23]);
								}
								else 
								{
									//Set progress bar to 25 by default, save the current progress
									progress_at_entry = new Number(progress);
									
									//Push old node onto the pstack
									pstack.push(Number(address));
									//Get the test's depth and first question
									$(this).getTest(a[23]);
									
								}
							});
							$(this).addHoverEffect();
						});
					}
				
				}
				
			  }
			
			
			xmlhttp.open("GET","../getprescreen.php?l="+address,true);
			xmlhttp.send();
		}
		else
		{
			//Show the under construction guy
			$(".content").fadeOut(500, function(){
				$(".backbutton").fadeIn(500);
				$(".container").css("height", "579px");
    			$(".content").empty().css("margin-top", "20px").css("width", "565px").append('<img src="images/main_construction.jpeg"/><h1>This test isn\'t done yet!</h1><h3>But rest assured, we\'re working hard to build it at this very moment.</h3>').fadeIn(500);
			});
		}
		
	}
	
	$.fn.preload = function() {
		this.each(function(){
			$('<img/>')[0].src = this;
		});
	}
	
	$.fn.firstPage = function()
	{
		$(['../main_button2.png', '../main_button3.png','../loading.gif','../images/main_figure0.jpeg','../images/main_figure1.jpeg','../images/main_figure2.jpeg','../images/main_figure3.jpeg','../images/main_figure4.jpeg','../images/main_figure5.jpeg','../images/main_figure6.jpeg','../images/main_figure7.jpeg','../images/main_figure8.jpeg','../images/black.png', '../main_back2.png', '../main_back3.png', '../images/progressbarlarge.png', '../images/progressbg_greenlarge.png', '../main_watermark3.png']).preload();
		
		/*$("#11").click(function() {
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
			$(this).prescreen(1);
		});*/
		$("#12").click(function() {
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
			$(this).prescreen(2);
		});
		$("#13").click(function() {
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
			$(this).prescreen(3);
		});
		$("#14").click(function() {
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
			$(this).prescreen(4);
		});
		$("#15").click(function() {
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
			$(this).prescreen(5);
		});
		/*$("#16").click(function() {
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
			$(this).prescreen(6);
		});
		$("#17").click(function() {
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
			$(this).prescreen(7);
		});
		$("#18").click(function() {
									progress = progress + (25.0/PDEPTH);
									$("span#pb").progressBar( progress, { showText: false});
			$(this).prescreen(8);
		});*/
		
		$(this).addHoverEffect();
		
		$("#pb").progressBar( 0, { showText: false});
		
		$(".backbutton").click(function() {
			if(testdepth == 0)
			{
				//You've already exited a test
				if(pstack.length <=0)
				{
					//You're going back to the first screen
					location.replace('main2.php');
				}
				else
				{
					//You are in prescreen
					
					progress = progress - (25.0/PDEPTH);
					$("span#pb").progressBar( progress, { showText: false});
					
					var back_target = pstack.pop();
					$(this).prescreen(back_target);
				}
			}
			else
			{
				//You're in a test
				if(stack.length <= 0)
				{
					if(pstack.length <= 0)
					{
						//You're going back to the first screen
						location.replace('main2.php');
					}
					//You are on the first node of the test, terminate test and use pstack instead
					wstack = new Array();
					weight = 0;
					gate_keys = '';
					testdepth = 0;
					
					progress = Number(progress_at_entry);
					$("span#pb").progressBar( progress_at_entry, { showText: false});
					progress_at_entry = 0;
					
					var back_target = pstack.pop();
					$(this).prescreen(back_target);
				}
				else
				{
					//You are somewhere in the test, go ahead and pop off
					var back_target = stack.pop();
					var weight_pop = wstack.pop();
					weight = weight - weight_pop;
					$(this).loadChildNode(back_target);
				}
			}	
		});
		
		$(".endtest").click(function() {
			$(this).endTest();
		});
		
		$(".endprescreen").click(function() {
			//You're going back to the first screen
			location.replace('main2.php');
		});
		
		$(".demotests").click(function() {
			progress = progress + (25.0/PDEPTH);
			$("span#pb").progressBar( progress, { showText: false});
			$(this).prescreen(45);
		});
		
		$("#search_init").click(function() {
			$(this).inputSearch($("#search_field").attr("value"));
		});
		
		$("#11").hover(function(){
			 	$(".figure").css("background", "url('../images/main_figure1.jpeg') no-repeat center");
				$(".ltl_blurb").empty().append("Not Active");
			});
		$("#12").hover(function(){
			 	$(".figure").css("background", "url('../images/main_figure2.jpeg') no-repeat center");
				$(".ltl_blurb").empty().append("The Physical & Mental Injury category includes issues such as domestic violence, auto accidents, slip and fall, and emotional trauma.");
			});
		$("#13").hover(function(){
			 	$(".figure").css("background", "url('../images/main_figure3.jpeg') no-repeat center");
				$(".ltl_blurb").empty().append("The Property & Housing category includes issues such as landlord/tenant rights, foreclosures, and personal and intellectual property.");
			});
		$("#14").hover(function(){
			 	$(".figure").css("background", "url('../images/main_figure4.jpeg') no-repeat center");
				$(".ltl_blurb").empty().append("The Job/Work Related category includes issues such as unemployment benefits, workers' compensation, and workplace harassment.");
			});
		$("#15").hover(function(){
			 	$(".figure").css("background", "url('../images/main_figure5.jpeg') no-repeat center");
				$(".ltl_blurb").empty().append("The Criminal category includes issues such as improper arrests and stops, record clearing/expungement, DUIs, and drug charges.");
			});
		$("#16").hover(function(){
			 	$(".figure").css("background", "url('../images/main_figure6.jpeg') no-repeat center");
				$(".ltl_blurb").empty().append("Not Active");
			});
		$("#17").hover(function(){
			 	$(".figure").css("background", "url('../images/main_figure7.jpeg') no-repeat center");
				$(".ltl_blurb").empty().append("Not Active");
			});
		$("#18").hover(function(){
			 	$(".figure").css("background", "url('../images/main_figure8.jpeg') no-repeat center");
				$(".ltl_blurb").empty().append("Not Active");
			});						
	}

	$(document).ready(function () {
		  $(this).firstPage();
	});