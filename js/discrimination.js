//Default function, assigns new variables...
function ignition()
{
	var gvar = new Array();

	gvar['RESULT'] = 0;
	gvar['MODIFIER'] = 0;
	gvar['alt_calc'] = 0;
	
	return gvar;
}

function state_initialize()
{
	/*$.post("/function/discrimination_by_state",{ state_id: gvar['STATE'] },
		function(data){
			//Do nothing
		}, "json");*/
}

function setAltCalc()
{
	gvar['alt_calc'] = 1;
	gvar['RESULT'] = 1;
	gvar['MODIFIER'] = 1;
}

function custom_selector(QID, QUNIT, to_append, answer_array)
{
	switch(QID)
	{
		case "3224":
			discriminationType(QUNIT, to_append, answer_array);
			break;
		case "3225":
			loseJobType(QUNIT, to_append, answer_array);
			break;
		case "3228":
			atWork(QUNIT, to_append, answer_array);
			break;
		case "3239":
			harassmentType(QUNIT, to_append, answer_array);
			break;
		case "3255":
			otherReasons(QUNIT, to_append, answer_array);
			break;
		case "3250":
			datePicker(QUNIT, to_append, answer_array);
			break;
		case "3241":
			policeCall(QUNIT, to_append, answer_array);
			break;
		case "3242":
			medicalTreatment(QUNIT, to_append, answer_array);
			break;
		case "3244":
			severity(QUNIT, to_append, answer_array);
			break;
		case "3245":
			pyramid(QUNIT, to_append, answer_array);
			break;
		case "3249":
			employeeCount(QUNIT, to_append, answer_array);
			break;
		case "3257":
			touchMyBody(QUNIT, to_append, answer_array);
			break;
		case "3236":
			ageSlider(QUNIT, to_append, answer_array);
			break;
		case "3229":
			protectedClass1(QUNIT, to_append, answer_array);
			break;
		case "3230":
			protectedClass2(QUNIT, to_append, answer_array);
			break;
		case "3258":
			evidence(QUNIT, to_append, answer_array);
			break;
		case "3226":
		case "3240":
		case "3243":
		case "3291":
		case "3498":
			MC(QID, QUNIT, to_append, answer_array);
			break;
		case "3251":
		case "3252":
		case "3234":
			OP(QID, QUNIT, to_append, answer_array);
			break;
		case "3237":
		case "3238":
		case "3246":
		case "3394":
		case "3395":
		case "3446":
		case "3500":
		case "3504":
		case "3501":
		case "3502":
		case "3300":
			MB(QID, QUNIT, to_append, answer_array);
			break;
		case "3256":
			if(!gvar['CLASSES'])
				gvar['CLASSES'] = "";
			if(!gvar['AGE'])
				gvar['AGE'] = "0";
			if(!gvar['TYPE'])
				gvar['TYPE'] = "DISCRIM";
			if(gvar['MODIFIER'] <= 0)
				gvar['MODIFIER'] = 1;
			$.post("/function/discrimination_eligibility/",{ state: gvar['STATE'], classes: gvar['CLASSES'], age: gvar['AGE'], incident_date: gvar['INCIDENT_DATE'], type: gvar['TYPE'], num_employees: gvar['NUM_EMPLOYEES'], raw_score: (gvar['RESULT'] * gvar['MODIFIER']), alt_calc: gvar['alt_calc']},
				function(data){
					//alert("YOUR SCORE IS: " + data.score);
					ZZ(QID, QUNIT, to_append, answer_array, data.score, data.result);
				}, "json");
			break;
		default:
			break;
	}
}

function evidence(QUNIT, to_append, answer_array)
{
	var targets_to_queue = new Array();
	var vars_to_queue = new Array();
	var ids_to_queue = new Array();
	
	to_append += '<div style="height: 180px; width: 180px; background: url(/images/discrimination_evidence.png) no-repeat 0 0; display: inline-block; margin: 6px 4px; cursor: pointer" id="a_0"><div class="hidden" style="height: 105px; width: 105px; background: url(/images/discrimination_checkmark.png)" id="check_0"></div></div>';
	to_append += '<div style="height: 180px; width: 180px; background: url(/images/discrimination_evidence.png) no-repeat 0 -180px; display: inline-block; margin: 6px 4px; cursor: pointer" id="a_1"><div class="hidden" style="height: 105px; width: 105px; background: url(/images/discrimination_checkmark.png)" id="check_1"></div></div>';
	to_append += '<div style="height: 180px; width: 180px; background: url(/images/discrimination_evidence.png) no-repeat 0 -360px; display: inline-block; margin: 6px 4px; cursor: pointer" id="a_2"><div class="hidden" style="height: 105px; width: 105px; background: url(/images/discrimination_checkmark.png)" id="check_2"></div></div>';
	to_append += '<div class="clear"></div>';
	to_append += '<div id="caption" style="margin-top: 8px; color: #2676a0; font-size: 1.5em;">&nbsp;</div>';
	to_append += '<div class="link-outer" style="margin-top: 10px"><div class="link-inner" id="op_continue">Continue</div></div>';
	
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		$("div[id^='a_']").hover(function(){
				var id = Number($(this).attr("id").split("_")[1]);
				$("#caption").html(answer_array[id][0]);
				//$(this).css("background-position", "-180px " + (id * -180) + "px");
			}, function(){
				//var id = Number($(this).attr("id").split("_")[1]);
				$("#caption").html("&nbsp;");
				//$(this).css("background-position", "0 " + (id * -180) + "px");
			});
		/*$("div#nota").hover(function(){
				$(this).css("background-position", "-104px -1200px");
			}, function(){
				$(this).css("background-position", "0 -1200px");
			});*/
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var var_assign = answer_array[id][3];
			if($("div[id='check_" + id + "']").hasClass("hidden"))
			{
				$("div#nota_check").addClass("hidden");
				$("div[id='check_" + id + "']").removeClass("hidden");
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div[id='check_" + id + "']").addClass("hidden");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#nota").click(function() {
			var target = $(this).attr("data-target");
			var var_assign = $(this).attr("data-var");
			if($("div#nota_check").hasClass("hidden"))
			{
				$("div#nota_check").removeClass("hidden");
				$("div[id^='check_']").addClass("hidden");
				targets_to_queue.length = 0;
				vars_to_queue.length = 0;
				ids_to_queue.length = 0;
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div#nota_check").addClass("hidden");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#op_continue").click(function(){
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			
			if(targets_to_queue.length === 0 && vars_to_queue.length === 0 && $("div#nota").length)
			{
				//Set to nota if no checkbox selected
				targets_to_queue.push($("div#nota").attr("data-target"));
				vars_to_queue.push($("div#nota").attr("data-var"));
			}
			
			//Queue the targets
			for(var x = answer_array.length - 1; x >= 0; x--)
			{
				//For all questions in the active stack...
				for(var y = astack.length - 1; y >= 0; y--)
				{
					//If this questions is targeted and an active question is part of the target..
					if(answer_array[x][1] && astack[y]['cluster'] === answer_array[x][1])
					{
						//Eliminate exact matches (in case this was a backtrack, must eliminate old triggered questions)
						if(astack[y]['var_override'] === answer_array[x][3])
							astack.splice(y, 1);
						continue;
					}
				}
			
				if(!answer_array[x][1] || targets_to_queue.indexOf(answer_array[x][1]) == -1)
				{
					continue;
				}
				
				//ELIMINATE IF VARIABLE SET BUT NOT QUEUED
				if(vars_to_queue.indexOf(answer_array[x][3]) === -1)
					continue;
				
				for(y in all_questions)
				{
					if(all_questions[y]['cluster'] == answer_array[x][1])
					{
						var temp_q = $.extend(true, [], all_questions[y]);
						temp_q['var_override'] = String(answer_array[x][3]);
						
						//Splice the var from vars_to_queue as it has been accounted for...
						vars_to_queue.splice(vars_to_queue.indexOf(answer_array[x][3]), 1);
						
						astack.push(temp_q);
					}
				}
			}
			
			//Assign any leftover variables without targets...
			for(x in vars_to_queue)
			{
				if(!vars_to_queue[x])
					continue;
				
				assignSingleVar(vars_to_queue[x]);
			}
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function protectedClass1(QUNIT, to_append, answer_array)
{
	var targets_to_queue = new Array();
	var vars_to_queue = new Array();
	var ids_to_queue = new Array();
	
	to_append += '<div style="text-align: center">';
	for(x in answer_array)
	{
		if(x == 0)
			continue;
			
		answer_array[x] = answer_array[x].split(',');
		if(answer_array[x][0] == "nota")
		{
			to_append += '<div id="nota" style="height: 150px; width: 104px; background: url(/images/discrimination_classcards.png) no-repeat 0 -1200px; display: inline-block; cursor: pointer;" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '"><div class="hidden" style="height: 105px; width: 105px; background: url(/images/discrimination_checkmark.png)" id="nota_check"></div></div>';
		}
		else
		{
			to_append += '<div id="a_' + x + '" style="height: 150px; width: 104px; background: url(/images/discrimination_classcards.png) no-repeat 0 ' + ((x - 1) * -150) + 'px; display: inline-block; cursor: pointer;"><div class="hidden" style="height: 105px; width: 105px; background: url(/images/discrimination_checkmark.png)" id="check_' + x + '"></div></div>';
		}
	}
	
	to_append += '<div class="clear"></div></div>';
	to_append += '<div class="link-outer" style="margin-top: 20px"><div class="link-inner" id="op_continue">Continue</div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		$("div[id^='a_']").hover(function(){
				var id = Number($(this).attr("id").split("_")[1]);
				$(this).css("background-position", "-104px " + ((id - 1) * -150) + "px");
			}, function(){
				var id = Number($(this).attr("id").split("_")[1]);
				$(this).css("background-position", "0 " + ((id - 1) * -150) + "px");
			});
		$("div#nota").hover(function(){
				$(this).css("background-position", "-104px -1200px");
			}, function(){
				$(this).css("background-position", "0 -1200px");
			});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var var_assign = answer_array[id][3];
			if($("div[id='check_" + id + "']").hasClass("hidden"))
			{
				$("div#nota_check").addClass("hidden");
				$("div[id='check_" + id + "']").removeClass("hidden");
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div[id='check_" + id + "']").addClass("hidden");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#nota").click(function() {
			var target = $(this).attr("data-target");
			var var_assign = $(this).attr("data-var");
			if($("div#nota_check").hasClass("hidden"))
			{
				$("div#nota_check").removeClass("hidden");
				$("div[id^='check_']").addClass("hidden");
				targets_to_queue.length = 0;
				vars_to_queue.length = 0;
				ids_to_queue.length = 0;
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div#nota_check").addClass("hidden");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#op_continue").click(function(){
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			
			if(targets_to_queue.length === 0 && vars_to_queue.length === 0 && $("div#nota").length)
			{
				//Set to nota if no checkbox selected
				targets_to_queue.push($("div#nota").attr("data-target"));
				vars_to_queue.push($("div#nota").attr("data-var"));
			}
			
			//If harassment & sex discrimination -> sexual harassment instead of harassment.
			if(targets_to_queue.indexOf("Sex") >= 0)
				gvar['sex'] = 1;
			
			//Load up the classes yo
			var classes = new Array();
			
			if(ids_to_queue.indexOf(0) >= 0)
				classes.push("COMPLAINED");
			if(ids_to_queue.indexOf(1) >= 0)
				classes.push("RACE");
			if(ids_to_queue.indexOf(2) >= 0)
				classes.push("NATIONAL ORIGIN");
			if(ids_to_queue.indexOf(3) >= 0)
				classes.push("RELIGION");
			if(ids_to_queue.indexOf(4) >= 0)
				classes.push("SEX");
			if(ids_to_queue.indexOf(5) >= 0)
				classes.push("AGE");
			if(ids_to_queue.indexOf(6) >= 0)
				classes.push("DISABILITY");
			if(ids_to_queue.indexOf(7) >= 0)
				classes.push("HEIGHT/WEIGHT");
			if(ids_to_queue.indexOf(8) >= 0)
				classes.push("SEXUAL ORIENTATION");
			
			gvar['CLASSES'] = classes.join('|');
			
			//Queue the targets
			for(var x = answer_array.length - 1; x >= 0; x--)
			{
				//For all questions in the active stack...
				for(var y = astack.length - 1; y >= 0; y--)
				{
					//If this questions is targeted and an active question is part of the target..
					if(answer_array[x][1] && astack[y]['cluster'] === answer_array[x][1])
					{
						//Eliminate exact matches (in case this was a backtrack, must eliminate old triggered questions)
						if(astack[y]['var_override'] === answer_array[x][3])
							astack.splice(y, 1);
						continue;
					}
				}
			
				if(!answer_array[x][1] || targets_to_queue.indexOf(answer_array[x][1]) == -1)
				{
					continue;
				}
				
				//ELIMINATE IF VARIABLE SET BUT NOT QUEUED
				if(vars_to_queue.indexOf(answer_array[x][3]) === -1)
					continue;
				
				for(y in all_questions)
				{
					if(all_questions[y]['cluster'] == answer_array[x][1])
					{
						var temp_q = $.extend(true, [], all_questions[y]);
						temp_q['var_override'] = String(answer_array[x][3]);
						
						//Splice the var from vars_to_queue as it has been accounted for...
						vars_to_queue.splice(vars_to_queue.indexOf(answer_array[x][3]), 1);
						
						astack.push(temp_q);
					}
				}
			}
			
			//Assign any leftover variables without targets...
			for(x in vars_to_queue)
			{
				if(!vars_to_queue[x])
					continue;
				
				assignSingleVar(vars_to_queue[x]);
			}
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function protectedClass2(QUNIT, to_append, answer_array)
{
	var targets_to_queue = new Array();
	var vars_to_queue = new Array();
	var ids_to_queue = new Array();
	
	to_append += '<div style="text-align: center">';
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		if(answer_array[x][0] == "nota")
		{
			to_append += '<div id="nota" style="height: 150px; width: 104px; background: url(/images/discrimination_classcards2.png) no-repeat 0 -1200px; display: inline-block; cursor: pointer;" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '"><div class="hidden" style="height: 105px; width: 105px; background: url(/images/discrimination_checkmark.png)" id="nota_check"></div></div>';
		}
		else
		{
			to_append += '<div id="a_' + x + '" style="height: 150px; width: 104px; background: url(/images/discrimination_classcards2.png) no-repeat 0 ' + (x * -150) + 'px; display: inline-block; cursor: pointer;"><div class="hidden" style="height: 105px; width: 105px; background: url(/images/discrimination_checkmark.png)" id="check_' + x + '"></div></div>';
		}
	}
	
	to_append += '<div class="clear"></div></div>';
	to_append += '<div class="link-outer" style="margin-top: 20px"><div class="link-inner" id="op_continue">Continue</div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		$("div[id^='a_']").hover(function(){
				var id = Number($(this).attr("id").split("_")[1]);
				$(this).css("background-position", "-104px " + (id * -150) + "px");
			}, function(){
				var id = Number($(this).attr("id").split("_")[1]);
				$(this).css("background-position", "0 " + (id * -150) + "px");
			});
		$("div#nota").hover(function(){
				$(this).css("background-position", "-104px -1200px");
			}, function(){
				$(this).css("background-position", "0 -1200px");
			});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var var_assign = answer_array[id][3];
			if($("div[id='check_" + id + "']").hasClass("hidden"))
			{
				$("div#nota_check").addClass("hidden");
				$("div[id='check_" + id + "']").removeClass("hidden");
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div[id='check_" + id + "']").addClass("hidden");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#nota").click(function() {
			var target = $(this).attr("data-target");
			var var_assign = $(this).attr("data-var");
			if($("div#nota_check").hasClass("hidden"))
			{
				$("div#nota_check").removeClass("hidden");
				$("div[id^='check_']").addClass("hidden");
				targets_to_queue.length = 0;
				vars_to_queue.length = 0;
				ids_to_queue.length = 0;
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div#nota_check").addClass("hidden");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#op_continue").click(function(){
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			
			if(targets_to_queue.length === 0 && vars_to_queue.length === 0 && $("div#nota").length)
			{
				//Set to nota if no checkbox selected
				targets_to_queue.push($("div#nota").attr("data-target"));
				vars_to_queue.push($("div#nota").attr("data-var"));
			}
			
			//Load up the classes yo
			var classes = new Array();
			
			if(ids_to_queue.indexOf(0) >= 0)
				classes.push("MARITAL STATUS");
			if(ids_to_queue.indexOf(1) >= 0)
				classes.push("MILITARY STATUS");
			if(ids_to_queue.indexOf(2) >= 0)
				classes.push("SMOKER");
			if(ids_to_queue.indexOf(3) >= 0)
				classes.push("POLITICAL ACTIVITY");
			if(ids_to_queue.indexOf(4) >= 0)
				classes.push("ARREST RECORD");
			if(ids_to_queue.indexOf(6) >= 0)
				classes.push("IMMIGRATION STATUS");
			if(ids_to_queue.indexOf(7) >= 0)
				classes.push("MEDICAL RECORD");
			
			gvar['CLASSES'] = classes.join('|');
			
			//Queue the targets
			for(var x = answer_array.length - 1; x >= 0; x--)
			{
				//For all questions in the active stack...
				for(var y = astack.length - 1; y >= 0; y--)
				{
					//If this questions is targeted and an active question is part of the target..
					if(answer_array[x][1] && astack[y]['cluster'] === answer_array[x][1])
					{
						//Eliminate exact matches (in case this was a backtrack, must eliminate old triggered questions)
						if(astack[y]['var_override'] === answer_array[x][3])
							astack.splice(y, 1);
						continue;
					}
				}
			
				if(!answer_array[x][1] || targets_to_queue.indexOf(answer_array[x][1]) == -1)
				{
					continue;
				}
				
				//ELIMINATE IF VARIABLE SET BUT NOT QUEUED
				if(vars_to_queue.indexOf(answer_array[x][3]) === -1)
					continue;
				
				for(y in all_questions)
				{
					if(all_questions[y]['cluster'] == answer_array[x][1])
					{
						var temp_q = $.extend(true, [], all_questions[y]);
						temp_q['var_override'] = String(answer_array[x][3]);
						
						//Splice the var from vars_to_queue as it has been accounted for...
						vars_to_queue.splice(vars_to_queue.indexOf(answer_array[x][3]), 1);
						
						astack.push(temp_q);
					}
				}
			}
			
			//Assign any leftover variables without targets...
			for(x in vars_to_queue)
			{
				if(!vars_to_queue[x])
					continue;
				
				assignSingleVar(vars_to_queue[x]);
			}
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function ageSlider(QUNIT, to_append, answer_array)
{
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	to_append += '<div id="age_num" style="font-size: 5em; margin: 0 auto;"></div>'
	to_append += '<div style="width: 300px; margin: 0 auto;"><div style="position: relative"><div style="position: absolute; top: 23px; left: 57px;">1</div><div style="position: absolute; top: 23px; left: 233px;">80+</div><input type="range" style="margin-top: 50px" id="rs_slider" min="1" max="80" value="40"></input></div><div class="link-outer" style="margin-top: 30px"><div class="link-inner" id="in_continue">Next &#9654;</div></div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").html(to_append).css('margin-top', "25px").fadeIn(500);
		$("#age_num").html($("#rs_slider").attr("value"));
		
		$(":range").rangeinput({
			onSlide: function(event, i) {
				$("#age_num").html(i);
				if(i >= 80)
					$("#age_num").append("+");
			}
		});
		
		$("#rs_slider").change(function(){
			var i = $("#rs_slider").attr("value");
			$("#age_num").html(i);
			if(i >= 80)
				$("#age_num").append("+");
		});
		
		//Set up click event handlers
		$("#in_continue").click(function() {
			var this_input = $("#rs_slider").attr("value");
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			//var user_responses = new Array();
			
			clearPath(answer_array);
			
			gvar['AGE'] = Number(this_input);
			
			var temp_aa = $.extend(true, [], answer_array[0]);
			var target = temp_aa[1];
			var var_assign = "";
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);	
			
			//pushState
			pushStateSequence(QUNIT['seq']);
			
			//Eat the next item in the stack
			loadChildNode();
		
		});
	});
}

function touchMyBody(QUNIT, to_append, answer_array)
{
	var targets_to_queue = new Array();
	var vars_to_queue = new Array();
	var ids_to_queue = new Array();
	
	//Centered pixel offset from left... 
	var cpix = (150/2) - 7;
	var body = {
		"Face/Neck": {0: cpix, 1: 30, 2: 3},
		"Shoulders": {0: cpix - 27, 1: 60, 2: 2},
		"Chest": {0: cpix, 1: 70, 2: 4},
		"Arms/Hands": {0: cpix - 40, 1: 120, 2: 1},
		"Midsection": {0: cpix, 1: 115, 2: 3},
		"Groin": {0: cpix, 1: 150, 2: 5},
		"Legs": {0: cpix - 12, 1: 180, 2: 3},
		"Feet": {0: cpix - 10, 1: 275, 2: 3},
		"Back": {0: cpix + 20, 1: 110, 2: 1},
		"Buttocks": {0: cpix + 22, 1: 140, 2: 4}
	};
	
	to_append += '<div style="margin: 0 auto; position: relative; height: 300px; width: 150px; background: url(/images/discrimination_body.png) no-repeat 0 0;">';
	for(x in body)
	{
		to_append += '<div class="a_' + x + '" title="' + x + '" style="position:absolute; top: ' + body[x][1] + 'px; left: ' + body[x][0] + 'px; border-radius: 13px; height: 13px; width: 13px; background: url(/images/discrimination_bodypart.png) no-repeat 0 0; cursor: pointer;"><div class="hidden" style="height: 13px; width: 13px; border-radius: 13px; background: #FF4760; box-shadow: 0px 0px 10px #CC0000 inset, 0px 0px 8px 4px #FF3333;" id="check_' + x + '"></div></div>';
		if(x === "Shoulders" || x === "Arms/Hands" || x === "Legs" || x === "Feet")
			to_append += '<div class="a_' + x + '" title="' + x + '" style="position:absolute; top: ' + body[x][1] + 'px; right: ' + body[x][0] + 'px; border-radius: 13px; height: 13px; width: 13px; background: url(/images/discrimination_bodypart.png) no-repeat 0 0; cursor: pointer;"><div class="hidden" style="height: 13px; width: 13px; border-radius: 13px; background: #FF4760; box-shadow: 0px 0px 10px #CC0000 inset, 0px 0px 8px 4px #FF3333;" id="check_' + x + '"></div></div>';
	}
	to_append += '</div>';
	
	to_append += '<div class="link-outer"><div class="link-inner" id="op_continue">Continue</div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "5px").fadeIn(500);
		
		$("div[class^='a_']").tooltip({ html: true });
		$("div[class^='a_']").hover(function(){
				$(this).css("box-shadow", "0px 0px 10px #CC0000 inset, 0px 0px 4px 2px #FF3333");
			}, function(){
				$(this).css("box-shadow", "none");
			});
		
		var weights = new Array();
		
		//Set up click event handlers
		$("div[class^='a_']").click(function() {
			var id = $(this).attr("class").split("_")[1];
			if($(this).children("div").hasClass("hidden"))
			{
				$(this).children("div").removeClass("hidden");
				weights.push(body[id][2]);
			}
			else
			{
				$(this).children("div").addClass("hidden");
				weights.splice(weights.indexOf(body[id][2]), 1);
			}
		});
		
		$("div#op_continue").click(function(){
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			//var user_responses = new Array();
			
			clearPath(answer_array);
			
			//Assign weights
			var weight = Math.max.apply(Math, weights);
			if(weights.length > 1)
				weight += 0.25 * (weights.length - 1);
			gvar['RESULT'] += weight;
			
			answer_array[0] = answer_array[0].split(',');
			var temp_aa = $.extend(true, [], answer_array[0]);
			var target = temp_aa[1];
			var var_assign = temp_aa[3];
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);	
			
			//pushState
			pushStateSequence(QUNIT['seq']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function harassmentType(QUNIT, to_append, answer_array)
{
	if(gvar['sex'] === 1)
	{
		astack.pop();
		pushSingleTarget("SexualHarassment", "");
		loadChildNode();
		return;
	}

	var targets_to_queue = new Array();
	var vars_to_queue = new Array();
	var ids_to_queue = new Array();
	
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		if(answer_array[x][0] == "nota")
		{
			to_append += '<div id="nota" style="height: 160px; width: 120px; background: url(/images/discrimination_harassmentcards.png) no-repeat 0 -640px; display: inline-block; cursor: pointer;" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '"><div class="hidden" style="height: 105px; width: 105px; background: url(/images/discrimination_checkmark.png)" id="nota_check"></div></div>';
		}
		else
		{
			to_append += '<div id="a_' + x + '" style="height: 160px; width: 120px; background: url(/images/discrimination_harassmentcards.png) no-repeat 0 ' + (x * -160) + 'px; display: inline-block; cursor: pointer;"><div class="hidden" style="height: 105px; width: 105px; background: url(/images/discrimination_checkmark.png)" id="check_' + x + '"></div></div>';
		}
	}
	
	to_append += '<div class="link-outer" style="margin-top: 20px"><div class="link-inner" id="op_continue">Continue</div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		$("div[id^='a_']").hover(function(){
				var id = Number($(this).attr("id").split("_")[1]);
				$(this).css("background-position", "-120px " + (id * -160) + "px");
			}, function(){
				var id = Number($(this).attr("id").split("_")[1]);
				$(this).css("background-position", "0 " + (id * -160) + "px");
			});
		$("div#nota").hover(function(){
				$(this).css("background-position", "-120px -640px");
			}, function(){
				$(this).css("background-position", "0 -640px");
			});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var var_assign = answer_array[id][3];
			if($("div[id='check_" + id + "']").hasClass("hidden"))
			{
				$("div#nota_check").addClass("hidden");
				$("div[id='check_" + id + "']").removeClass("hidden");
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div[id='check_" + id + "']").addClass("hidden");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#nota").click(function() {
			var target = $(this).attr("data-target");
			var var_assign = $(this).attr("data-var");
			if($("div#nota_check").hasClass("hidden"))
			{
				$("div#nota_check").removeClass("hidden");
				$("div[id^='check_']").addClass("hidden");
				targets_to_queue.length = 0;
				vars_to_queue.length = 0;
				ids_to_queue.length = 0;
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div#nota_check").addClass("hidden");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#op_continue").click(function(){
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			
			if(targets_to_queue.length === 0 && vars_to_queue.length === 0 && $("div#nota").length)
			{
				//Set to nota if no checkbox selected
				targets_to_queue.push($("div#nota").attr("data-target"));
				vars_to_queue.push($("div#nota").attr("data-var"));
			}
			
			//Assign weights
			if(ids_to_queue.indexOf(0) >= 0)
			{
				var carryover = new Array();
				if(ids_to_queue.indexOf(1) >= 0)
					carryover.push(7);
				if(ids_to_queue.indexOf(2) >= 0)
					carryover.push(4.5);
				if(ids_to_queue.indexOf(3) >= 0)
					carryover.push(3);
				gvar['carryover'] = carryover;
			}
			else
			{
				var triggered = false;
				if(ids_to_queue.indexOf(1) >= 0)
				{
					gvar['RESULT'] += 7;
					triggered = true;
				}
				if(ids_to_queue.indexOf(2) >= 0)
					if(triggered)
						gvar['RESULT'] += 0.25;
					else
					{
						gvar['RESULT'] += 4.5;
						triggered = true;
					}
				if(ids_to_queue.indexOf(3) >= 0)
					if(triggered)
						gvar['RESULT'] += 0.25;
					else
					{
						gvar['RESULT'] += 3;
					}
			}
			
			
			//Queue the targets
			for(var x = answer_array.length - 1; x >= 0; x--)
			{
				//For all questions in the active stack...
				for(var y = astack.length - 1; y >= 0; y--)
				{
					//If this questions is targeted and an active question is part of the target..
					if(answer_array[x][1] && astack[y]['cluster'] === answer_array[x][1])
					{
						//Eliminate exact matches (in case this was a backtrack, must eliminate old triggered questions)
						if(astack[y]['var_override'] === answer_array[x][3])
							astack.splice(y, 1);
						continue;
					}
				}
			
				if(!answer_array[x][1] || targets_to_queue.indexOf(answer_array[x][1]) == -1)
				{
					continue;
				}
				
				//ELIMINATE IF VARIABLE SET BUT NOT QUEUED
				if(vars_to_queue.indexOf(answer_array[x][3]) === -1)
					continue;
				
				for(y in all_questions)
				{
					if(all_questions[y]['cluster'] == answer_array[x][1])
					{
						var temp_q = $.extend(true, [], all_questions[y]);
						temp_q['var_override'] = String(answer_array[x][3]);
						
						//Splice the var from vars_to_queue as it has been accounted for...
						vars_to_queue.splice(vars_to_queue.indexOf(answer_array[x][3]), 1);
						
						astack.push(temp_q);
					}
				}
			}
			
			//Assign any leftover variables without targets...
			for(x in vars_to_queue)
			{
				if(!vars_to_queue[x])
					continue;
				
				assignSingleVar(vars_to_queue[x]);
			}
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function employeeCount(QUNIT, to_append, answer_array)
{
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	to_append += '<div class="left"><div style="height: 60px; width: 30px; margin-left: 100px; background: url(/images/discrimination_employee.png) repeat-x 0 0" id="rs_image"></div>';
	to_append += '<div style="height: 60px; width: 0px; margin-left: 100px; background: url(/images/discrimination_employee.png) repeat-x 0 0" id="rs_image2"></div>';
	to_append += '<div style="height: 60px; width: 0px; margin-left: 100px; background: url(/images/discrimination_employee.png) repeat-x 0 0" id="rs_image3"></div>';
	to_append += '<div style="height: 60px; width: 0px; margin-left: 100px; background: url(/images/discrimination_employee.png) repeat-x 0 0" id="rs_image4"></div>';
	to_append += '</div><div class="right" style="width: 300px; margin-right: 50px"><div id="rs_caption" style="text-align: center; font-size: 2em;"></div><div style="position: relative"><div style="position: absolute; top: 23px; left: 57px;">1</div><div style="position: absolute; top: 23px; left: 233px;">20+</div><input type="range" style="margin-top: 50px" id="rs_slider" min="1" max="20" value="10"></input></div><div class="link-outer" style="margin-top: 30px"><div class="link-inner" id="in_continue">Next &#9654;</div></div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").html(to_append).css('margin-top', "25px").fadeIn(500);
		$("#rs_caption").html($("#rs_slider").attr("value"));
		
		$("#rs_image").css("width", "180px");
		$("#rs_image2").css("width", "120px");
		$("#rs_image3").css("width", "0px");
		$("#rs_image4").css("width", "0px");
		
		$(":range").rangeinput({
			onSlide: function(event, i) {
				$("#rs_caption").html(i);
				if(i >= 20)
					$("#rs_caption").append("+");
			
				if(Number(i) < 6)
				{
					$("#rs_image").css("width", (Number(i) * 30) + "px");
					$("#rs_image2").css("width", "0px");
					$("#rs_image3").css("width", "0px");
					$("#rs_image4").css("width", "0px");
				}
				else if(Number(i) < 12)
				{
					$("#rs_image").css("width", "180px");
					$("#rs_image2").css("width", ((Number(i) - 6) * 30) + "px");
					$("#rs_image3").css("width", "0px");
					$("#rs_image4").css("width", "0px");
				}
				else if(Number(i) < 18)
				{
					$("#rs_image").css("width", "180px");
					$("#rs_image2").css("width", "180px");
					$("#rs_image3").css("width", ((Number(i) - 12) * 30) + "px");
					$("#rs_image4").css("width", "0px");
				}
				else
				{
					$("#rs_image").css("width", "180px");
					$("#rs_image2").css("width", "180px");
					$("#rs_image3").css("width", "180px");
					$("#rs_image4").css("width", ((Number(i) - 18) * 30) + "px");
				}
			}
		});
		
		$("#rs_slider").change(function(){
			var i = $("#rs_slider").attr("value");
			$("#rs_caption").html(i);
			if(i >= 20)
				$("#rs_caption").append("+");
			
			if(Number(i) < 6)
			{
				$("#rs_image").css("width", (Number(i) * 30) + "px");
				$("#rs_image2").css("width", "0px");
				$("#rs_image3").css("width", "0px");
				$("#rs_image4").css("width", "0px");
			}
			else if(Number(i) < 12)
			{
				$("#rs_image").css("width", "180px");
				$("#rs_image2").css("width", ((Number(i) - 6) * 30) + "px");
				$("#rs_image3").css("width", "0px");
				$("#rs_image4").css("width", "0px");
			}
			else if(Number(i) < 18)
			{
				$("#rs_image").css("width", "180px");
				$("#rs_image2").css("width", "180px");
				$("#rs_image3").css("width", ((Number(i) - 12) * 30) + "px");
				$("#rs_image4").css("width", "0px");
			}
			else
			{
				$("#rs_image").css("width", "180px");
				$("#rs_image2").css("width", "180px");
				$("#rs_image3").css("width", "180px");
				$("#rs_image4").css("width", ((Number(i) - 18) * 30) + "px");
			}
		});
		
		//Set up click event handlers
		$("#in_continue").click(function() {
			var this_input = $("#rs_slider").attr("value");
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			//var user_responses = new Array();
			
			clearPath(answer_array);
			
			gvar['NUM_EMPLOYEES'] = Number(this_input);
			
			var temp_aa = $.extend(true, [], answer_array[0]);
			var target = temp_aa[1];
			var var_assign = "";
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);	
			
			//pushState
			pushStateSequence(QUNIT['seq']);
			
			//Eat the next item in the stack
			loadChildNode();
		
		});
	});
}

function severity(QUNIT, to_append, answer_array)
{
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	to_append += '<div class="left" style="height: 150px; width: 150px; margin-left: 100px; background: url(/images/discrimination_severity.png) no-repeat 0 -300px" id="rs_image"></div><div class="right" style="width: 300px; margin-right: 50px"><div style="position: relative"><div style="position: absolute; top: 23px; left: 57px;">1</div><div style="position: absolute; top: 23px; left: 100px;">2</div><div style="position: absolute; top: 23px; left: 145px;">3</div><div style="position: absolute; top: 23px; left: 189px;">4</div><div style="position: absolute; top: 23px; left: 233px;">5</div><input type="range" style="margin-top: 50px" id="rs_slider" min="1" max="5" value="3"></input></div><div class="link-outer" style="margin-top: 30px"><div class="link-inner" id="in_continue">Next &#9654;</div></div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").html(to_append).css('margin-top', "25px").fadeIn(500);
		$("#rs_caption").html(answer_array[Number($("#rs_slider").attr("value")) - 1][0]);
		
		$(":range").rangeinput({
			onSlide: function(event, i) {
				$("#rs_image").css("background-position", "0 " + ((Number(i) - 1) * -150) + "px");
			}
		});
		
		$("#rs_slider").change(function(){
			$("#rs_image").css("background-position", "0 " + ((Number($("#rs_slider").attr("value")) - 1) * -150) + "px");
		});
		
		//Set up click event handlers
		$("#in_continue").click(function() {
			var this_input = $('input#rs_slider').attr("value");
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			//var user_responses = new Array();
			
			clearPath(answer_array);
			
			var modifiers = new Array(0, 0, 0.1, 0.2, 0.3);
				gvar['MODIFIER'] += modifiers[Number(this_input) - 1];
			
			var temp_aa = $.extend(true, [], answer_array[Number(this_input) - 1]);
			var target = temp_aa[1];
			var var_assign = temp_aa[3];
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);	
			
			//pushState
			pushStateSequence(QUNIT['seq']);
			
			//Eat the next item in the stack
			loadChildNode();
		
		});
	});
}

function atWork(QUNIT, to_append, answer_array)
{
	to_append += '<div><div class="left" style="margin: 10px auto; position: relative; background: url(/images/discrimination_atwork.png) no-repeat 0 0; height: 230px; width: 230px; margin-left: 50px" id="atwork"></div>';
	to_append += '<div class="right" style="padding-top:25px">';
	
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		to_append += '<div class="option" style="width: 300px" id="a_' + x + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext" style="width: 250px">' + answer_array[x][0] + '</div></div>';
	}
	
	to_append += '</div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		//Set Hover States
		$("#a_0").hover(function(){
			$("#atwork").css("background-position", "0 -230px");
		}, function(){
			$("#atwork").css("background-position", "0 0");
		});
		$("#a_1").hover(function(){
			$("#atwork").css("background-position", "0 -460px");
		}, function(){
			$("#atwork").css("background-position", "0 0");
		});
		$("#a_2").hover(function(){
			$("#atwork").css("background-position", "0 -920px");
		}, function(){
			$("#atwork").css("background-position", "0 0");
		});
		$("#a_3").hover(function(){
			$("#atwork").css("background-position", "0 -1150px");
		}, function(){
			$("#atwork").css("background-position", "0 0");
		});
		$("#a_4").hover(function(){
			$("#atwork").css("background-position", "0 -1380px");
		}, function(){
			$("#atwork").css("background-position", "0 0");
		});
		$("#a_5").hover(function(){
			$("#atwork").css("background-position", "0 -1610px");
		}, function(){
			$("#atwork").css("background-position", "0 0");
		});
		$("#a_6").hover(function(){
			$("#atwork").css("background-position", "0 -1840px");
		}, function(){
			$("#atwork").css("background-position", "0 0");
		});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			$(this).disableClicks();
			$("div[id^='a_']").unbind("hover");
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			
			$("div[id='check_" + id + "']").css("background-position", "0px -21px");
			
			hstack.push(astack.pop());
			
			clearPath(answer_array);
			
			//If harassment is chosen, add harassment to queue AFTER adding protected class questions
			if(id === 0)
			{
				pushSingleTarget("Harassment", var_assign);
			}
			else if(id === 1)
			{
				pushSingleTarget("EqualPay", var_assign);
				gvar['TYPE'] = "EQPAY";
			}
			else if(id >= 2)
			{
				setAltCalc();
			}
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function pyramid(QUNIT, to_append, answer_array)
{
	to_append += '<div style="margin: 10px auto 0; height: 70px; width: 350px; background: url(/images/discrimination_pyramid.png) no-repeat 0 0; cursor: pointer" id="a_0"></div>';
	to_append += '<div style="margin: 0 auto; height: 57px; width: 350px; background: url(/images/discrimination_pyramid.png) no-repeat 0 -70px; cursor: pointer" id="a_1"></div>';
	to_append += '<div style="margin: 0 auto; height: 57px; width: 350px; background: url(/images/discrimination_pyramid.png) no-repeat 0 -127px; cursor: pointer" id="a_2"></div>';
	to_append += '<div style="margin: 0 auto; height: 59px; width: 350px; background: url(/images/discrimination_pyramid.png) no-repeat 0 -184px; cursor: pointer" id="a_3"></div>';

	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		$("#a_0").hover(function(){
			$("#a_0").css("background-position", "-350px 0");
		},function(){
			$("#a_0").css("background-position", "0 0");
		});
		$("#a_1").hover(function(){
			$("#a_1").css("background-position", "-350px -70px");
		},function(){
			$("#a_1").css("background-position", "0 -70px");
		});
		$("#a_2").hover(function(){
			$("#a_2").css("background-position", "-350px -127px");
		},function(){
			$("#a_2").css("background-position", "0 -127px");
		});
		$("#a_3").hover(function(){
			$("#a_3").css("background-position", "-350px -184px");
		},function(){
			$("#a_3").css("background-position", "0 -184px");
		});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			$(this).disableClicks();
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			
			$("div[id='check_" + id + "']").css("background-position", "0px -21px");
			
			hstack.push(astack.pop());
			
			clearPath(answer_array);
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function medicalTreatment(QUNIT, to_append, answer_array)
{
	to_append += '<div><div class="left" style="margin: 10px auto; position: relative; background: url(/images/discrimination_med.png) no-repeat 0 -400px; height: 200px; width: 200px; margin-left: 50px" id="med_treatment"></div>';
	to_append += '<div class="right" style="padding-top:25px">';
	
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		to_append += '<div class="option" style="width: 300px" id="a_' + x + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext" style="width: 250px">' + answer_array[x][0] + '</div></div>';
	}
	
	to_append += '</div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		//Set Hover States
		$("#a_0").hover(function(){
			$("#med_treatment").css("background-position", "0 0px");
		}, function(){
			$("#med_treatment").css("background-position", "0 -400px");
		});
		$("#a_1").hover(function(){
			$("#med_treatment").css("background-position", "0 -200px");
		}, function(){
			$("#med_treatment").css("background-position", "0 -400px");
		});
		$("#a_2").hover(function(){
			$("#med_treatment").css("background-position", "0 -400px");
		}, function(){
			$("#med_treatment").css("background-position", "0 -400px");
		});
		$("#a_3").hover(function(){
			$("#med_treatment").css("background-position", "0 -600px");
		}, function(){
			$("#med_treatment").css("background-position", "0 -400px");
		});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			$(this).disableClicks();
			$("div[id^='a_']").unbind("hover");
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			
			$("div[id='check_" + id + "']").css("background-position", "0px -21px");
			
			hstack.push(astack.pop());
			
			clearPath(answer_array);
			
			//Assign weights
			if(x === 0)
				gvar['RESULT'] += 2.5;
			else if(x === 1)
				gvar['RESULT'] += 2;
			else if(x === 2)
				gvar['RESULT'] += 3;
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function policeCall(QUNIT, to_append, answer_array)
{
	to_append += '<div style="margin: 10px auto; position: relative; background: url(/images/discrimination_policecall.png) no-repeat 0 -230px; height: 230px; width: 234px;" id="police_call"></div>';
	
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		answer_array[x][0] = answer_array[x][0].replace("&#44;", ",");
		answer_array[x][0] = answer_array[x][0].replace("&#39;", "'");
		answer_array[x][0] = answer_array[x][0].replace("&quot;", '"');
		answer_array[x][0] = answer_array[x][0].replace("&sect;", "§");
		answer_array[x][0] = answer_array[x][0].replace("&mdash;", "—");
		answer_array[x][0] = answer_array[x][0].replace("&mdash;", "--");
		
		to_append += '<div class="link-outer"><div class="link-inner" id="a_' + x + '">' + answer_array[x][0] + '</div></div>';
	}
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").html(to_append).css('margin-top', "20px").fadeIn(500);

		//Resize font if necessary
		for(x in answer_array) 
		{
			if(answer_array[x][0].length <6)
			{
				$('div#a_' + x).css("font-size", "1.5em");
			}
			else if (answer_array[x][0].length <21)
			{
				$('div#a_' + x).css("font-size", (0.5 + (0.067 *( 16 - (answer_array[x][0].length - 5))))+"em");
			}
			else
			{
				$('div#a_' + x).css("font-size", "0.5em");
			}
		}

		//Set Hover States
		$("#a_0").hover(function(){
			$("#police_call").css("background-position", "0 -460px");
		}, function(){
			$("#police_call").css("background-position", "0 -230px");
		});
		$("#a_1").hover(function(){
			$("#police_call").css("background-position", "0 0");
		}, function(){
			$("#police_call").css("background-position", "0 -230px");
		});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			$(this).disableClicks();
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			
			hstack.push(astack.pop());
				
			clearPath(answer_array);
			
			if(id === 0)
				gvar['RESULT'] += 3;
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);				

			//pushState
			pushStateSequence(QUNIT['seq']);
				
			//Eat the next item in the stack
			loadChildNode();
		});
	});

}

function datePicker(QUNIT, to_append, answer_array)
{
	to_append += '<input type="text" id="datepicker" class="custominput" style="margin-top: 20px;"/>';
	to_append += '<div class="warning_message" style="margin: 20px auto;" id="input_warning">&nbsp;</div>';
	to_append += '<div class="link-outer" style="margin: 20px auto; display: block"><div class="link-inner" id="op_continue">Next</div></div>';

	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500, function(){
			$("#datepicker").datepicker();
			$("#datepicker").datepicker("show");
			});

		$("div#op_continue").click(function(){
			var timestamp = Date.parse($("#datepicker").val());
			var today = new Date().getTime();
			
			if (isNaN(timestamp) === true)
			{
				$(".warning_message").html("Invalid Date");
				return;
			}
			else if (today < timestamp)
			{
				$(".warning_message").html("That date is in the future!");
				return;
			}
		
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			
			gvar['INCIDENT_DATE'] = timestamp;
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	
	});
}

function discriminationType(QUNIT, to_append, answer_array)
{
	to_append += '<div><div class="left" style="margin: 10px auto; position: relative; background: url(/images/discrimination_q1.png) no-repeat 0 -750px; height: 250px; width: 250px; margin-left: 50px" id="q1_image"></div>';
	to_append += '<div class="right" style="padding-top:25px">';
	
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		to_append += '<div class="option" style="width: 300px" id="a_' + x + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext" style="width: 250px">' + answer_array[x][0] + '</div></div>';
	}
	
	to_append += '</div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		//Set Hover States
		$("#a_0").hover(function(){
			$("#q1_image").css("background-position", "0 0px");
		}, function(){
			$("#q1_image").css("background-position", "0 -750px");
		});
		$("#a_1").hover(function(){
			$("#q1_image").css("background-position", "0 -250px");
		}, function(){
			$("#q1_image").css("background-position", "0 -750px");
		});
		$("#a_2").hover(function(){
			$("#q1_image").css("background-position", "0 -500px");
		}, function(){
			$("#q1_image").css("background-position", "0 -750px");
		});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			$(this).disableClicks();
			$("div[id^='a_']").unbind("hover");
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			
			$("div[id='check_" + id + "']").css("background-position", "0px -21px");
			
			hstack.push(astack.pop());
			
			clearPath(answer_array);
			
			if(id === 1)
				setAltCalc();
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function loseJobType(QUNIT, to_append, answer_array)
{
	to_append += '<div><div class="left" style="margin: 10px auto; position: relative; background: url(/images/discrimination_losejobtype.png) no-repeat 0 0; height: 230px; width: 230px; margin-left: 50px" id="losejobtype"></div>';
	to_append += '<div class="right" style="padding-top:25px">';
	
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		to_append += '<div class="option" style="width: 300px" id="a_' + x + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext" style="width: 250px">' + answer_array[x][0] + '</div></div>';
	}
	
	to_append += '</div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		//Set Hover States
		$("div[id^='a_']").hover(function(){
			var this_offset = (Number($(this).attr("id").split("_")[1]) + 1) * -230;
			$("#losejobtype").css("background-position", "0 " + this_offset + "px");
		}, function(){
			$("#losejobtype").css("background-position", "0 0");
		});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			$(this).disableClicks();
			$("div[id^='a_']").unbind("hover");
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			
			$("div[id='check_" + id + "']").css("background-position", "0px -21px");
			
			hstack.push(astack.pop());
			
			clearPath(answer_array);
			
			if(id <= 2 || id === 5)
				setAltCalc();
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function otherReasons(QUNIT, to_append, answer_array)
{
	to_append += '<div style="margin: 0 auto; position: relative; background: url(/images/discrimination_shelf.png) no-repeat 0 75px; height: 155px; width: 520px;">';
	
	to_append += '<div style="height: 100px; width: 100px; background: url(/images/discrimination_otheritems.png) no-repeat 0 0; display: inline-block; margin: 6px 4px; cursor: pointer" id="a_0"></div>';
	to_append += '<div style="height: 100px; width: 157px; background: url(/images/discrimination_angelwings.png) no-repeat 0 0; display: inline-block; margin: 6px 4px; cursor: pointer" id="a_1"></div>';
	to_append += '<div style="height: 100px; width: 100px; background: url(/images/discrimination_otheritems.png) no-repeat 0 -200px; display: inline-block; margin: 6px 4px; cursor: pointer" id="a_2"></div>';
	to_append += '<div style="height: 100px; width: 100px; background: url(/images/discrimination_otheritems.png) no-repeat 0 -300px; display: inline-block; margin: 6px 4px; cursor: pointer" id="a_3"></div>';
	
	to_append += '<div class="clear"></div>';
	to_append += '</div>';
	to_append += '<div id="caption" style="margin-top: 35px; color: #2676a0;font-size: 1.5em;">&nbsp;</div>';

	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		$("#a_0").hover(function(){
			$("#a_0").css("background-position", "-100px 0");
			$("#caption").html(answer_array[0][0]);
		},function(){
			$("#a_0").css("background-position", "0 0");
			$("#caption").html("&nbsp;");
		});
		$("#a_1").hover(function(){
			$("#a_1").css("background-position", "0 -100px");
			$("#caption").html(answer_array[1][0]);
		},function(){
			$("#a_1").css("background-position", "0 0");
			$("#caption").html("&nbsp;");
		});
		$("#a_2").hover(function(){
			$("#a_2").css("background-position", "-100px -200px");
			$("#caption").html(answer_array[2][0]);
		},function(){
			$("#a_2").css("background-position", "0 -200px");
			$("#caption").html("&nbsp;");
		});
		$("#a_3").hover(function(){
			$("#a_3").css("background-position", "-100px -300px");
			$("#caption").html("None of these");
		},function(){
			$("#a_3").css("background-position", "0 -300px");
			$("#caption").html("&nbsp;");
		});
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			$(this).disableClicks();
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			
			$("div[id='check_" + id + "']").css("background-position", "0px -21px");
			
			hstack.push(astack.pop());
			
			clearPath(answer_array);
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function MC(QID, QUNIT, to_append, answer_array)
{
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		to_append += '<div class="option" id="a_' + x + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
	}
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			$(this).disableClicks();
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			
			$("div[id='check_" + id + "']").css("background-position", "0px -21px");
			
			hstack.push(astack.pop());
			
			clearPath(answer_array);
			
			//ASSIGN VARIABLE HERE
			switch(QID)
			{
				case "3226":
					if(id === 0)
						setAltCalc();
					//If harassment is chosen, add harassment to queue AFTER adding protected class questions
					else if(id === 1)
					{
						pushSingleTarget("Harassment", var_assign);
					}
					break;
				case "3240":
					if(id === 0 || id === 1)
						gvar['RESULT'] += 1;
					else if(id === 2)
						gvar['RESULT'] += 3;
					break;
				case "3243":
					var modifiers = new Array(0.9, 1, 1.15, 1.3, 1.45);
					gvar['MODIFIER'] += modifiers[id];
					break;
				case "3291":
					if(id === 0)
					{
						gvar['skip_q14'] = 1;
						gvar['CLASSES'] = "RELIGION";
					}
					else if(id === 1)
					{
						gvar['accommodation_disability'] = 1;
						gvar['CLASSES'] = "DISABILITY";
					}
					break;
				case "3498":
					if(id === 0)
						gvar['RESULT'] += 8;
					else if(id === 1)
						gvar['RESULT'] += 6.5;
					else if(id === 2)
						gvar['RESULT'] += 2.5;
					break;
				default: 
					break;
			}
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function OP(QID, QUNIT, to_append, answer_array)
{
	switch(QID)
	{
		//If harassment got reached, but this is sexual harassment, go to sexual harassment branch instead.
		case "3239":
			if(gvar['sex'] === 1)
			{
				astack.pop();
				pushSingleTarget("SexualHarassment", "");
				loadChildNode();
				return;
			}
	}

	var targets_to_queue = new Array();
	var vars_to_queue = new Array();
	var ids_to_queue = new Array();
	
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		if(answer_array[x][0] == "nota")
		{
			to_append += '<div class="option" id="nota" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '"><div class="checkbox" id="nota_check"></div>&nbsp;<div class="optiontext">None of the above</div></div>';
		}
		else
		{
			to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '"><div class="checkbox" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
		}
	}
	
	to_append += '<div class="link-outer"><div class="link-inner" id="op_continue">Continue</div></div>';
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			if($("div[id='check_" + id + "']").css("background-position") == "0px 0px")
			{
				$("div#nota_check").css("background-position", "0px 0px");
				$("div[id='check_" + id + "']").css("background-position", "0px -23px");
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div[id='check_" + id + "']").css("background-position", "0px 0px");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#nota").click(function() {
			var target = $(this).attr("data-target");
			var var_assign = $(this).attr("data-var");
			if($("div#nota_check").css("background-position") == "0px 0px")
			{
				$("div#nota_check").css("background-position", "0px -23px");
				$("div[id^='check_']").css("background-position", "0px 0px");
				targets_to_queue.length = 0;
				vars_to_queue.length = 0;
				ids_to_queue.length = 0;
				targets_to_queue.push(target);
				vars_to_queue.push(var_assign);
				ids_to_queue.push(id);
			}
			else
			{
				$("div#nota_check").css("background-position", "0px 0px");
				targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
				vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				ids_to_queue.splice(ids_to_queue.indexOf(id), 1);
			}
		});
		$("div#op_continue").click(function(){
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			
			if(targets_to_queue.length === 0 && vars_to_queue.length === 0 && $("div#nota").length)
			{
				//Set to nota if no checkbox selected
				targets_to_queue.push($("div#nota").attr("data-target"));
				vars_to_queue.push($("div#nota").attr("data-var"));
			}
			
			//ASSIGN VARIABLES HERE
			switch(QID)
			{
				case "3251":
					if(gvar['carryover'].length > 1)
					{
						if(ids_to_queue.indexOf(0) >= 0)
							gvar['carryover'].push(5);
						if(ids_to_queue.indexOf(3) >= 0)
							gvar['carryover'].push(3.5);
						if(ids_to_queue.indexOf(1) >= 0)
							gvar['carryover'].push(2);
						
						var weight = Math.max.apply(Math, gvar['carryover']);
						if(gvar['carryover'].length > 1)
							weight += 0.25 * (gvar['carryover'].length - 1);
						gvar['RESULT'] += weight;
					}
					else
					{
						var tripped = false;
						if(ids_to_queue.indexOf(0) >= 0)
						{
							gvar['RESULT'] += 5;
							tripped = true;
						}
						
						if(ids_to_queue.indexOf(3) >= 0)
							if(tripped)
								gvar['RESULT'] += 0.25;
							else
							{
								gvar['RESULT'] += 3.5;
								tripped = true;
							}
						
						if(ids_to_queue.indexOf(1) >= 0)
							if(tripped)
								gvar['RESULT'] += 0.25;
							else
								gvar['RESULT'] += 2;
					}
					break;
				case "3252":
					var weights = new Array(3,2,4,6,5,8,10);
					var weights_to_queue = new Array();
					for(x in ids_to_queue)
					{
						weights_to_queue.push(weights[ids_to_queue[x]]);
					}
					var weight = Math.max.apply(Math, weights_to_queue);
					if(weights_to_queue.length > 1)
						weight += 0.25 * (weights_to_queue.length - 1);
					gvar['RESULT'] += weight;
					break;
				case "3234":
					if(gvar['skip_q14'] === 1)
					{
						pushSingleTarget("Accommodation2", "");
					}
					break;
			}
			
			//Queue the targets
			for(var x = answer_array.length - 1; x >= 0; x--)
			{
				//For all questions in the active stack...
				for(var y = astack.length - 1; y >= 0; y--)
				{
					//If this questions is targeted and an active question is part of the target..
					if(answer_array[x][1] && astack[y]['cluster'] === answer_array[x][1])
					{
						//Eliminate exact matches (in case this was a backtrack, must eliminate old triggered questions)
						if(astack[y]['var_override'] === answer_array[x][3])
							astack.splice(y, 1);
						continue;
					}
				}
			
				if(!answer_array[x][1] || targets_to_queue.indexOf(answer_array[x][1]) == -1)
				{
					continue;
				}
				
				//ELIMINATE IF VARIABLE SET BUT NOT QUEUED
				if(vars_to_queue.indexOf(answer_array[x][3]) === -1)
					continue;
				
				for(y in all_questions)
				{
					if(all_questions[y]['cluster'] == answer_array[x][1])
					{
						var temp_q = $.extend(true, [], all_questions[y]);
						temp_q['var_override'] = String(answer_array[x][3]);
						
						//Splice the var from vars_to_queue as it has been accounted for...
						vars_to_queue.splice(vars_to_queue.indexOf(answer_array[x][3]), 1);
						
						astack.push(temp_q);
					}
				}
			}
			
			//Assign any leftover variables without targets...
			for(x in vars_to_queue)
			{
				if(!vars_to_queue[x])
					continue;
				
				assignSingleVar(vars_to_queue[x]);
			}
			
			//PushState
			pushStateSequence(QUNIT['id']);
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function MB(QID, QUNIT, to_append, answer_array)
{
	switch(QID)
	{
		case "3237":
		case "3238":
			if(gvar['accommodation_disability'] === 1)
			{
				//Skip this
				astack.pop();
				loadChildNode();
				return;
			}
			break;
		case "3394":
			if(gvar['accommodation_disability'] === 1)
			{
				astack.pop();
				pushSingleTarget("Accommodation1", "");
				loadChildNode();
				return;
			}
			break;
	}

	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		answer_array[x][0] = answer_array[x][0].replace("&#44;", ",");
		answer_array[x][0] = answer_array[x][0].replace("&#39;", "'");
		answer_array[x][0] = answer_array[x][0].replace("&quot;", '"');
		answer_array[x][0] = answer_array[x][0].replace("&sect;", "§");
		answer_array[x][0] = answer_array[x][0].replace("&mdash;", "—");
		answer_array[x][0] = answer_array[x][0].replace("&mdash;", "--");
		to_append += '<div class="link-outer"><div class="link-inner" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '">' + answer_array[x][0] + '</div></div>';
	}
	
	loadExplanation(QUNIT['explanation']);
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		$("#test_interface").html(to_append).css('margin-top', Math.abs((295-$('#test_interface').outerHeight())/2) + "px").fadeIn(500);

		//Resize font if necessary
		for(x in answer_array) 
		{
			if(answer_array[x][0].length <6)
			{
				$('div#a_' + x).css("font-size", "1.5em");
			}
			else if (answer_array[x][0].length <21)
			{
				$('div#a_' + x).css("font-size", (0.5 + (0.067 *( 16 - (answer_array[x][0].length - 5))))+"em");
			}
			else
			{
				$('div#a_' + x).css("font-size", "0.5em");
			}
		}

		//Set up click event handlers
		$("div[id^='a_']").click(function() {
			$(this).disableClicks();
			var id = Number($(this).attr("id").split("_")[1]);
			var target = answer_array[id][1];
			var tag = answer_array[id][2];
			var var_assign = answer_array[id][3];
			var this_answer = Number($(this).html());
			
			hstack.push(astack.pop());
				
			clearPath(answer_array);
			
			switch(QID)
			{
				case "3246":
					if(id === 1)
						gvar['MODIFIER'] *= 0.5;
					break
				case "3237":
					if(id === 1 && gvar['alt_calc'] === 1)
						gvar['RESULT'] *= 0.5;
					break;
				case "3238":
					if(gvar['alt_calc'] === 1)
						if(id === 1)
							gvar['RESULT'] *= 0.5;
						else if(id === 2)
							gvar['RESULT'] *= 0.75;
					break;
				case "3395":
					if(id === 1 && gvar['alt_calc'] === 1)
						gvar['RESULT'] *= 0.65;
					break;
				case "3446":
					if(id === 1 && gvar['alt_calc'] === 1)
						gvar['RESULT'] *= 0.65;
					break;
				case "3500":
					if(id === 1)
						gvar['RESULT'] += 1;
					break;
				case "3504":
					switch(id)
					{
						case 0:
							gvar['RESULT'] -= 0.5;
							break;
						case 1:
							gvar['RESULT'] -= 1;
							break;
						case 2:
							gvar['RESULT'] -= 2;
							break;
						case 3:
							gvar['RESULT'] -= 3;
							break;
						case 4:
							gvar['RESULT'] -= 4;
							break;
					}
					break;
				case "3501":
					if(id === 1)
						gvar['RESULT'] += 1;
					break;
				case "3502":
					switch(id)
					{
						case 0:
							gvar['RESULT'] -= 0.5;
							break;
						case 1:
							gvar['RESULT'] -= 1;
							break;
						case 2:
							gvar['RESULT'] -= 2;
							break;
						case 3:
							gvar['RESULT'] -= 3.5;
							break;
						case 4:
							gvar['RESULT'] -= 5.5;
							break;
					}
					break;
				case "3300":
					if(id === 1 && gvar['alt_calc'] === 1)
						gvar['RESULT'] *= 0.55;
					break;
			}
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);

			//PushState
			pushStateSequence(QUNIT['seq']);
				
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function ZZ(QID, QUNIT, to_append, answer_array, score, result)
{
	$.post("/function/tracker", { type: "RLOAD", time: Math.round(new Date().getTime() / 1000), test_id: test_id} );
	
	
	//SIDE PANEL
	$("#explanation_box").fadeOut(500, function(){
		$("#explanation_box").html('').fadeIn(500);
	});
	
	//MAIN DISPLAY
	to_append = '<div class="left" style="margin-left: 15px;"><div style="text-align: left; width: 295px; padding-left: 5px; height: 100px; border: 1px solid #999; box-shadow: 0 0 5px #BBB; border-radius: 0 0 8px 8px;">';
	
	//Score display area..
	to_append += '<div>Your Score:</div>';
	var score_num = Math.round(score);
	if(score_num > 10)
		score_num = 10;
	else if(score_num < 0)
		score_num = 0;
	to_append += '<div style="background: url(/images/results_bar.png); height: 51px; width: 290px; position: relative; ">';
	to_append += '<div id="score_num" style="color: #FFF; font-weight: bold; position: absolute; bottom: 7px; left: 5px; text-align: center; width: 30px; font-size: 1.5em">0</div>';
	to_append += '<div style="background: url(/images/results_handle.png); height: 40px; width: 40px; position: absolute; bottom: 10px; left: 50px" id="results_handle"></div>';
	to_append += '</div>';
	
	to_append += '<div><i title="People with higher scores generally make more successful claims." style="font-style: normal; text-decoration: underline; cursor: pointer;">What does this score mean?</i></div>';
	to_append += '</div>';
	to_append += '<div style="margin-top: 20px; width: 260px; height: 278px; overflow: auto; text-align: left; border: 1px solid #999; box-shadow: 0 0 5px #BBB; border-radius: 8px;" id="result_left">' + String(result) + '</div></div>';
	
	to_append = to_append.replace(/&#44;/g, ",");
	to_append = to_append.replace(/&#39;/g, "'");
	to_append = to_append.replace(/&quot;/g, '"');
	to_append = to_append.replace(/&sect;/g, "§");
	to_append = to_append.replace(/&mdash;/g, "—");
	to_append = to_append.replace(/&mdash;/g, "--");
	to_append = to_append.replace(/&ndash;/g, "-");
	
	to_append += '</div>';
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "650px");
		//$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);	
		$("#test_interface").empty().append(to_append).css('margin-top', "0").fadeIn(500, function(){
			//Animate the score display
			var counter = score_num / 10;
			var timerId = setInterval(function() {
				if(counter + (score_num / 10) >= score_num)
				{
					clearInterval(timerId);
					$('#score_num').html(score_num);
					return;
				}
				$('#score_num').html(Math.round(counter));
				counter += score_num / 10;
			}, 70);
			$('#results_handle').animate({left: (score_num * 20) + 50}, 700);
		});	
		
		$('#contact_dropsource').removeClass("hidden").animate({height: 15, top: -15}, 500);
		setTimeout(function(){
			$('#contact_dropover').removeClass("hidden").animate({height: 420}, 500);
		}, 500);
		//Convert italics into tooltips...
		$("i").tooltip({ html: true });
		//Append icon
		$("i").append('<img src="/images/info_icon.png"/>');
		
		$("#dropover_submit").click(function(){
			$('#dropover_warning').empty().append('<img src="http://i.imgur.com/qkKy8.gif" />');	
			$.post("/function/submit_results/",{ name: $("#dropover_name").attr("value"), email: $("#dropover_email").attr("value"), phone: $("#dropover_phone").attr("value"), test_id: test_id, time: Math.round(new Date().getTime() / 1000)}, function(data){
				if(String(data) != "")
				{
					$('#dropover_warning').empty().append(String(data));
					if(String(data) == "Thank you! A legal professional will contact you ASAP.")
					{
						$('#dropover_warning').css("color", "#27C22F");
						$("#field_name").attr("value", "");
						$("#field_email").attr("value", "");
						$("#field_phone").attr("value", "");
					}
					else
					{
						$('#dropover_warning').css("color", "#F24122");
					}
				}
			});
		});
	});
}