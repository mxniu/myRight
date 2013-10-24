var astack = new Array();
var hstack = new Array();
var gvar = new Array();
var all_questions;
var num_of_questions;
var test_id;
var debug;
var max_seq = 0;
var autoback = false;

function loadExplanation(EXPLANATION)
{
	$("#explanation_box").fadeOut(500, function(){
		$('#explanation_frame').css("overflow", "hidden");
		$("#explanation_box").html(String(EXPLANATION)).fadeIn(500, function(){
			$('#explanation_frame').css("overflow", "auto");
			$('#explanation_frame').jScrollPane({
				horizontalGutter:5,
				verticalGutter:5,
				'showArrows': false
			});
			$('.jspScrollable').mouseenter(function(){
				$(this).find('.jspDrag').stop(true, true).animate({opacity: 1}, 200);
			});
			$('.jspScrollable').mouseleave(function(){
				$(this).find('.jspDrag').stop(true, true).animate({opacity: 0.5}, 200);
			});
		});
	});
}

function loadSideform(IS_FINAL)
{
	if(!IS_FINAL)
		var conversion_form = '<div id="back_to_explanation" style="position: absolute; bottom: 0px; left: 0px; font-size: 0.8em; color: #666">&#9668; Back</div>';
	else
		var conversion_form = '';
	
	conversion_form += '<div style="font-size: 1.3em; margin: 0 auto; text-align: center; font-weight: 300; position: relative;"><div>Contact Us for a</div><div>FREE CONSULTATION</div></div><div class="form_line" style="margin-top: 10px"><label>Name</label><input type="text" id="field_name" maxlength=50 class="sideinput"/></div><div class="form_line"><label>E-mail</label><input type="email" id="field_email" maxlength=100  class="sideinput"/></div><div class="form_line"><label>Phone</label><input type="tel" id="field_phone" maxlength=10 style="width: 105px" class="sideinput"/></div><div class="orange-button" id="result_submit" style="text-align: center">Submit</div><div class="warning_message" id="result_warning"></div>';
	$("#interface_sub_top").animate({height: 40}, 400, "linear", function(){
		$("#interface_sub_top").animate({height: 348}, 400);
		$("#explanation_box").fadeOut(0).html(conversion_form).fadeIn(200);
	
		$("#result_submit").click(function(){
		$('#result_warning').empty().append('<img src="http://i.imgur.com/qkKy8.gif" />');	
		$.post("/function/submit_results/",{ name: $("#field_name").attr("value"), email: $("#field_email").attr("value"), phone: $("#field_phone").attr("value"), test_id: test_id, time: Math.round(new Date().getTime() / 1000)}, function(data){
			if(String(data) != "")
			{
				$('#result_warning').empty().append(String(data));
				if(String(data) == "Thank you! A legal professional will contact you ASAP.")
				{
					$('#result_warning').css("color", "#27C22F");
					$("#field_name").attr("value", "");
					$("#field_email").attr("value", "");
					$("#field_phone").attr("value", "");
					$("div[id='result_check_terms']").css("background-position", "0px 0px")
				}
				else
				{
					$('#result_warning').css("color", "#F24122");
				}
			}
			});
		});
		
		$('#back_to_explanation').click(function(){
			var QUNIT = astack[astack.length - 1];
			loadExplanation(QUNIT['explanation']);
		});
	});
}

//window.onpopstate = popHandler;

function pushStateSequence(SEQ)
{
	/*window.history.ready = true;
	history.pushState({seq: SEQ}, null, null);
	max_seq = SEQ;*/
}

/*function popHandler(event)
{
	if(!window.history.ready && !event.originalEvent.state)
		return;

	if(autoback)
	{
		autoback = false;
		return;
	}
	
	if(event.state)
	{
		if(Number(event.state.seq) > max_seq)
		{
			autoback = true;
			window.history.back();
			return;
		}
		else
			max_seq = Number(event.state.seq);
	}
		
	if(hstack.length <= 0)
	{
		window.history.ready = false;
		window.history.back();
	}
	else if($('.result_box').css('display') === 'none')
	{
		var QUNIT = astack[astack.length - 1];
		var answer_array = QUNIT['answers'].split('|');	
		for(x in answer_array)
		{
			answer_array[x] = answer_array[x].split(',');
		}
		
		for(var x = astack.length - 1; x >= 0; x--)
		{
			for(y in answer_array)
			{
				if(answer_array[y][1] && astack[x]['cluster'] == answer_array[y][1])
				{
					astack.splice(x, 1);
					break;
				}
			}
		}
		
		//You are somewhere in the test, go ahead and pop off
		astack.push(hstack.pop());
		loadChildNode();
	}
	else
	{
		$(".result_box").fadeOut(500, function(){
			$("#test_interface").fadeIn(500);
			$("#beta_box").css('min-height', '300px');
			
			//You are somewhere in the test, go ahead and pop off
			astack.push(hstack.pop());
			loadChildNode();
		});
	}
}*/

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function trim(myString)     
{
    return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')     
}

function clearPath(answer_array)
{
	for(var x = astack.length - 1; x >= 0; x--)
	{
		for(y in answer_array)
		{
			if(answer_array[y][1] && astack[x]['cluster'] === answer_array[y][1])
			{
				if(answer_array[y][3])
				{
					//Delete downstream matches that correspond to this particular target/variable combo
					if(astack[x]['var_override'] === answer_array[y][3])
						astack.splice(x, 1);
					else
						break;
				}
				else
					astack.splice(x, 1);
				break;
			}
		}
	}
}

function pushSingleTarget(target, var_assign)
{
	for(x in all_questions)
	{
		if(all_questions[x]['cluster'] == target)
		{
			//Create 2nd copy to avoid pointers to the same data
			var temp = $.extend(true, [], all_questions[x]);
			if(var_assign)
			{
				temp['var_override'] = String(var_assign);
			}
			
			astack.push(temp);
		}
	}
}

function assignSingleVar(var_assign)
{
	//Figure out which variable operation
	if(String(var_assign).indexOf('+') === -1 && String(var_assign).indexOf('-') === -1 && String(var_assign).indexOf('*') === -1 && String(var_assign).indexOf('/') === -1)
	{
		//Add it to the gvar (global variable) hash table
		gvar[trim(String(var_assign).split("=")[0])] = trim(String(var_assign).split("=")[1]);
	}
	else
	{
		//Evaluate the RHS and assign
		var lhs = trim(String(var_assign).split("=")[0]);
		var rhs = trim(String(var_assign).split("=")[1]);
		
		for(key in gvar)
		{
			rhs = rhs.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
		}

		//Evaluate the math equation
		var eq = owenge.equation.parse(rhs);
		
		//Assign gvar
		gvar[lhs] = eq.answer;
	}
}

$.fn.loadResults = function()
{	
	$.post("/function/tracker", { type: "RLOAD", time: Math.round(new Date().getTime() / 1000), test_id: test_id} );
	
	//Display results!
	$("#test_interface").fadeOut(500, function(){
		$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>");
		$(".result_box").fadeIn(500);
	});
}

$.fn.disableClicks = function()
{
	$("div[id^='a_']").unbind('click');
	$("div#op_continue").unbind('click');
}

function loadChildNode()
{
	//Redirect to result if empty
	if(astack.length <= 0)
	{
		$(this).loadResults();
		return;
	}
	
	$("#test_interface").fadeOut(500, function(){
		$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>").fadeIn(500);
	});
	
	QUNIT = astack[astack.length - 1];
	
	//Assign some local variables
	var qtype = $.trim(QUNIT['type']);
	var preformatted_question = String(QUNIT['question']);
	
	//If variable is to be assigned...
	if(QUNIT['var_override'])
		assignSingleVar(QUNIT['var_override']);
	
	//CHECK FOR CONDITION BEING SATISFIED (after assigning variable)
	var condition = String(QUNIT['condition']);
	if(condition)
	{
		if(condition.indexOf('<=') !== -1)
		{
			for(key in gvar)
			{
				condition = condition.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
			}
		
			//Evaluate the RHS and assign
			var lhs = trim(condition.split("<=")[0]);
			var rhs = trim(condition.split("<=")[1]);
			
			if(!String(gvar[lhs]))
			{
				astack.pop();
				loadChildNode();
				return;
			}
			
			//Evaluate the math equation
			var lhs_eq = owenge.equation.parse(lhs);
			var rhs_eq = owenge.equation.parse(rhs);
			
			if(Number(lhs_eq.answer) > Number(rhs_eq.answer))
			{
				astack.pop();
				loadChildNode();
				return;
			}
		}
		else if(condition.indexOf('>=') !== -1)
		{		
			for(key in gvar)
			{
				condition = condition.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
			}
		
			//Evaluate the RHS and assign
			var lhs = trim(condition.split(">=")[0]);
			var rhs = trim(condition.split(">=")[1]);
			
			if(!String(gvar[lhs]))
			{
				astack.pop();
				loadChildNode();
				return;
			}
			
			//Evaluate the math equation
			var lhs_eq = owenge.equation.parse(lhs);
			var rhs_eq = owenge.equation.parse(rhs);
			
			if(Number(lhs_eq.answer) < Number(rhs_eq.answer))
			{
				astack.pop();
				loadChildNode();
				return;
			}
		}
		else if(condition.indexOf('<') !== -1)
		{
			for(key in gvar)
			{
				condition = condition.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
			}
		
			//Evaluate the RHS and assign
			var lhs = trim(condition.split("<")[0]);
			var rhs = trim(condition.split("<")[1]);
			
			if(!String(gvar[lhs]))
			{
				astack.pop();
				loadChildNode();
				return;
			}
			
			//Evaluate the math equation
			var lhs_eq = owenge.equation.parse(lhs);
			var rhs_eq = owenge.equation.parse(rhs);
			
			if(Number(lhs_eq.answer) >= Number(rhs_eq.answer))
			{
				astack.pop();
				loadChildNode();
				return;
			}
		}
		else if(condition.indexOf('>') !== -1)
		{
			for(key in gvar)
			{
				condition = condition.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
			}
		
			//Evaluate the RHS and assign
			var lhs = trim(condition.split(">")[0]);
			var rhs = trim(condition.split(">")[1]);
			
			if(!String(gvar[lhs]))
			{
				astack.pop();
				loadChildNode();
				return;
			}
			
			//Evaluate the math equation
			var lhs_eq = owenge.equation.parse(lhs);
			var rhs_eq = owenge.equation.parse(rhs);
			
			if(Number(lhs_eq.answer) <= Number(rhs_eq.answer))
			{
				astack.pop();
				loadChildNode();
				return;
			}
		}
		else if(condition.indexOf('!=') !== -1)
		{
			for(key in gvar)
			{
				condition = condition.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
			}
		
			//Evaluate the RHS and assign
			var lhs = trim(condition.split("=")[0]);
			var rhs = trim(condition.split("=")[1]);
			
			if(!String(gvar[lhs]))
			{
				astack.pop();
				loadChildNode();
				return;
			}
			
			//Evaluate the math equation
			var lhs_eq = owenge.equation.parse(lhs);
			var rhs_eq = owenge.equation.parse(rhs);
			
			if(Number(lhs_eq.answer) === Number(rhs_eq.answer))
			{
				astack.pop();
				loadChildNode();
				return;
			}
		}
		else if(condition.indexOf('=') !== -1)
		{
			for(key in gvar)
			{
				condition = condition.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
			}
		
			//Evaluate the RHS and assign
			var lhs = trim(condition.split("=")[0]);
			var rhs = trim(condition.split("=")[1]);
			
			if(!String(gvar[lhs]))
			{
				astack.pop();
				loadChildNode();
				return;
			}
			
			//Evaluate the math equation
			var lhs_eq = owenge.equation.parse(lhs);
			var rhs_eq = owenge.equation.parse(rhs);
			
			if(Number(lhs_eq.answer) !== Number(rhs_eq.answer))
			{
				astack.pop();
				loadChildNode();
				return;
			}
		}
	}
	
	var debug_output = '';
	//For everything assigned in gvar, substitute the value out of the question string
	for(key in gvar)
	{
		debug_output += key + ' = ' + gvar[key] + '\n';
	
		//CHANGE THIS LATER, THIS IS TO TEST FOR NUMBER OR STRING
		var numtest = Math.round(Number(gvar[key])*10)/10;
		
		//This is the rating!
		if(key === "es")
			var varnum = numtest;
		else
			var varnum = numberWithCommas(Number(gvar[key]).toFixed(2));
		if(numtest)
			preformatted_question = preformatted_question.replace(new RegExp('{' + key + '}', "gi"), varnum);
		else
			preformatted_question = preformatted_question.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
	}
	preformatted_question = preformatted_question.replace(new RegExp('{.*}', "gi"), '');
	
	if(debug && debug_output)
	{
		alert(debug_output);
	}
	
	//Move the progress bar
	if(qtype === "ZZ")
		$(".meter > span").stop(true).animate({width: 244}, 1000).css("border-radius", "8px");
	else if(qtype !== "MO")
	{
		if((Number(QUNIT['seq'])/num_of_questions)*244 >= $(".meter > span").width())
			$(".meter > span").stop(true).animate({width: (Number(QUNIT['seq'])/num_of_questions)*244}, 1000).css("border-radius", "20px 8px 8px 20px");
	}
	
	//Common preconfiguration
	var to_append = '<h1>' + preformatted_question + '</h1>';
	var answer_array = QUNIT['answers'].split('|');
	
	if(qtype !== "MO")
		$.post("/function/tracker", { type: "QLOAD", time: Math.round(new Date().getTime() / 1000), test_id: test_id, question: QUNIT['id']} );
	
	//Display the new array's question and answers on-screen
	if (qtype === "RS")
	{
		for(x in answer_array)
		{
			answer_array[x] = answer_array[x].split(',');
		}
		to_append += '<div class="left" style="width: 150px; margin-left: 50px;"><div id="rs_caption" style="font-size: 1.5em; width: 100%; text-align: center;"></div><img src="" id="rs_image"/></div><div class="right" style="width: 400px"><input type="range" style="margin-top: 50px" id="rs_slider" min="1" max="' + answer_array.length + '"></input></div>';
		to_append += '<div class="link-outer"><div class="link-inner" id="in_continue">Next &#9654;</div></div>';
		
		loadExplanation(QUNIT['explanation']);
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "650px");
			$("#test_interface").empty().append(to_append).css('margin-top', Math.abs((295-$('#test_interface').outerHeight())/2) + "px").fadeIn(500);
			$("#rs_caption").html(answer_array[Number($("#rs_slider").attr("value")) - 1][0]);
			$("#rs_image").attr("src", "/images/" + answer_array[Number($("#rs_slider").attr("value")) - 1][2]);
			
			$("#rs_slider").change(function(){
				$("#rs_caption").html(answer_array[Number($("#rs_slider").attr("value")) - 1][0]);
				$("#rs_image").attr("src", "/images/" + answer_array[Number($("#rs_slider").attr("value")) - 1][2]);
			});
			
			//Set up click event handlers
			$("div[id^='a_']").click(function() {
				$(this).disableClicks();
				var id = Number($(this).attr("id").split("_")[1]);
				var target = answer_array[id][1];
				var tag = answer_array[id][2];
				var var_assign;
				if(answer_array[id][3])
					var_assign = answer_array[id][3];
					
				$("div[id='check_" + id + "']").css("background-position", "0px -21px");
				
				if(tag)
				{
					//reorg_list(tag);
					if(tag.indexOf("http://") >= 0)
					{
						$("#test_interface").fadeOut(500, function(){
							$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>").fadeIn(500);
						});	
						return;
					}
				}
				
				hstack.push(astack.pop());
				
				clearPath(answer_array);
				
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
	else if (qtype == "MC")
	{
		for(x in answer_array)
		{
			answer_array[x] = answer_array[x].split(',');
			to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
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
	else if (qtype == "OP")
	{
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
				pushStateSequence(QUNIT['seq']);
				
				//Eat the next item in the stack
				loadChildNode();
			});
		});
	}
	else if (qtype == "MB" || qtype == "EX")
	{
		if(qtype === "EX")
		{
			preformatted_question = preformatted_question.replace(/&#44;/g, ",");
			preformatted_question = preformatted_question.replace(/&#39;/g, "'");
			preformatted_question = preformatted_question.replace(/&quot;/g, '"');
			preformatted_question = preformatted_question.replace(/&sect;/g, "§");
			preformatted_question = preformatted_question.replace(/&mdash;/g, "—");
			preformatted_question = preformatted_question.replace(/&mdash;/g, "--");
			to_append = '<h4>' + preformatted_question + '</h4>';
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
			if(answer_array[x][3])
				to_append += '<div class="link-outer"><div class="link-inner" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '">' + answer_array[x][0] + '</div></div>';
			else
				to_append += '<div class="link-outer"><div class="link-inner" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '">' + answer_array[x][0] + '</div></div>';
		}
		
		loadExplanation(QUNIT['explanation']);
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "650px");
			if(qtype === "EX")
				$("#test_interface").html(to_append).css('margin-top', Math.abs((260-$('#test_interface').outerHeight())/2) + "px").fadeIn(500);
			else
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
				var var_assign;
				if(answer_array[id][3])
					var_assign = answer_array[id][3];
				
				if(tag)
				{
					//reorg_list(tag);
					if(tag.indexOf("http://") >= 0)
					{
						$("#test_interface").fadeOut(500, function(){
							$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>").fadeIn(500);
						});	
						return;
					}
				}
				
				hstack.push(astack.pop());
					
				clearPath(answer_array);
				
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
	else if(qtype == "IN")
	{	
		for(x in answer_array)
		{
			answer_array[x] = answer_array[x].split(',');
			//to_append += '<div style="text-align: left;">'+ answer_array[x][0] +'</div><input type="text" class="biginput" id="a_'+ x + '" maxlength=10/>';
		}
		to_append += '<input type="text" class="biginput" id="a_0" maxlength=10 style="margin-top: 1em"/>';
		to_append += '<div class="warning_message" id="input_warning">&nbsp;</div>'
		to_append += '<div class="link-outer"><div class="link-inner" id="in_continue">Next &#9654;</div></div>';
		
		loadExplanation(QUNIT['explanation']);
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "650px");
			$("#test_interface").empty().append(to_append).css('margin-top', Math.abs((295-$('#test_interface').outerHeight())/2) + "px").fadeIn(500);
			
			$("#in_continue").click(function() {
				var this_input = $('input#a_0').attr("value");
				if(!this_input)
				{
					$("#input_warning").empty().append("Please enter a value");
					return;
				}
				
				$(this).disableClicks();
				
				hstack.push(astack.pop());
				//var user_responses = new Array();

				clearPath(answer_array);
				
				var temp_aa = $.extend(true, [], answer_array[0]);
				var target = temp_aa[0][1];
				var var_assign = temp_aa[0][3];
				
				//If targeted, go to target and assign variable downstream
				if(target)
					pushSingleTarget(target, var_assign);
				//Else assign the variable anyway, if exists
				else if(var_assign)
					assignSingleVar(var_assign);

				hstack[hstack.length - 1]['user_response'] = this_input;
				
				//PushState
				pushStateSequence(QUNIT['seq']);
				
				//Eat the next item in the stack
				loadChildNode();
			
			});
		});
	}
	else if(qtype == "MI")
	{
		for(x in answer_array)
		{
			answer_array[x] = answer_array[x].split(',');
			to_append += '<div id="prompt_'+ x + '" style="text-align: left; display: inline-block; width: 100px; margin-top: 10px;">'+ answer_array[x][0] +'</div><input type="number" class="biginput" style="display: inline-block; margin-top: 10px;" id="a_'+ x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '" maxlength=10 value="0"/><div class="clear"></div>';
		}
		to_append += '<div class="warning_message" id="input_warning">&nbsp;</div>';
		to_append += '<div class="link-outer"><div class="link-inner" id="in_continue">Next &#9654;</div></div>';
		
		loadExplanation(QUNIT['explanation']);
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "650px");
			$("#test_interface").empty().append(to_append).css('margin-top', Math.abs((295-$('#test_interface').outerHeight())/2) + "px").fadeIn(500);
			
			$("#in_continue").click(function() {
				var input_array = new Array();
				for(x in answer_array)
				{
					input_array[x] = $('input#a_' + x).attr("value");
					if(!input_array[x])
					{
						$("#input_warning").empty().append("Please enter a value for " + answer_array[x][0]);
						return;
					}
				}				
				
				$(this).disableClicks();
				
				hstack.push(astack.pop());
				//var user_responses = new Array();
				
				clearPath(answer_array);
				
				var target = String(answer_array[0][1]);
				//If targeted, go to target and assign variable downstream
				if(target)
					pushSingleTarget(target, var_assign);
					
				/* NOTE THIS MAY CAUSE DEDUNDANT VARIABLE ASSIGNMENT, BUT NO PROBLEM IN USAGE */
				
				for(a in answer_array)
				{
					var var_assign = String(answer_array[a][3]);
					//If not targeted, assign variable to gvars table anyway...
					if(var_assign)
					{
						//Unique to INPUTS, replace prenamed vars with inputs
						for(x in input_array)
						{
							var xmod = Number(x) + 1;
							
							var_assign = var_assign.replace('{' + xmod + '}', input_array[x]);
						}
					
						//Figure out which variable operation
						if(String(var_assign).indexOf('+') === -1 && String(var_assign).indexOf('-') === -1 && String(var_assign).indexOf('*') === -1 && String(var_assign).indexOf('/') === -1)
						{
							//Add it to the gvar (global variable) hash table
							gvar[trim(String(var_assign).split("=")[0])] = trim(String(var_assign).split("=")[1]);
						}
						else
						{
							//Evaluate the RHS and assign
							var lhs = trim(String(var_assign).split("=")[0]);
							var rhs = trim(String(var_assign).split("=")[1]);
							
							for(key in gvar)
							{
								rhs = rhs.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
							}
							//Evaluate the math equation
							var eq = owenge.equation.parse(rhs);
							//Assign gvar
							gvar[lhs] = eq.answer;
						}
						
					}
				}
					
				//hstack[hstack.length - 1]['user_response'] = this_input;
				
				//PushState
				pushStateSequence(QUNIT['seq']);
				
				//Eat the next item in the stack
				loadChildNode();
			});
		});
	}
	else if(qtype === "MO")
	{
		astack.pop();
		
		for(x in answer_array)
		{
			answer_array[x] = answer_array[x].split(',');
		}
		
		var target = String(answer_array[0][1]);
		//If targeted, go to target
		if(target)
		{
			for(x in all_questions)
			{
				if(all_questions[x]['cluster'] === target)
				{
					var temp = $.extend(true, [], all_questions[x]);
					
					astack.push(temp);
				}
			}
		}
		
		for(x in answer_array)
		{
			var lhs = trim(String(answer_array[x][0]).split("=")[0]);
			var rhs = trim(String(answer_array[x][0]).split("=")[1]);
			
			//Replace variables first..
			for(key in gvar)
			{
				rhs = rhs.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
			}	
			
			//Run custom functions second... [not yet installed]
			
			//Figure out which variable operation
			if(String(rhs).indexOf('+') === -1 && String(rhs).indexOf('-') === -1 && String(rhs).indexOf('*') === -1 && String(rhs).indexOf('/') === -1)
			{
				//Add it to the gvar (global variable) hash table
				gvar[lhs] = String(rhs);
			}
			else
			{
				//Evaluate the math equation
				var eq = owenge.equation.parse(rhs);
				//Assign gvar
				gvar[lhs] = eq.answer;
			}
		}
		//Eat the next item in the stack
		loadChildNode();
	}
	else if (qtype === "US")
	{
		for(x in answer_array)
		{
			answer_array[x] = answer_array[x].split(',');
		}
		to_append += '<div id="vmap" style="margin: 0 auto; width: 540px; height: 360px;"></div>';
		
		loadExplanation(QUNIT['explanation']);
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "650px");
			$("#test_interface").empty().append(to_append).css('margin-top', "0px").fadeIn(500);
			
			var state_set = false;
			
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
					if(state_set === true)
						return;
					state_set = true;
				
					gvar['STATE'] = code.toUpperCase();
					$('.jqvmap-label').remove();
					state_initialize();
					
					var target = answer_array[0][1];
					var tag = answer_array[0][2];
					var var_assign = answer_array[0][3];
				
					hstack.push(astack.pop());
					
					clearPath(answer_array);
					
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
				}
			});
		});
	}
	else if (qtype == "ZZ")
	{
		$.post("/function/tracker", { type: "RLOAD", time: Math.round(new Date().getTime() / 1000), test_id: test_id} );
		to_append = '<div style="width: 600px; text-align: left;" id="result_left">' + preformatted_question + '</div>';
		
		/*to_append = '<div class="left" style="margin-left: 15px;"><div style="width: 300px; height: 100px; border: 1px solid #999; box-shadow: 0 0 5px #BBB; border-radius: 0 0 8px 8px;"></div>';
		to_append += '<div style="margin-top: 20px; width: 260px; height: 278px; overflow: auto; text-align: left; border: 1px solid #999; box-shadow: 0 0 5px #BBB; border-radius: 8px;" id="result_left">' + preformatted_question + '</div></div>';*/
		
		to_append = to_append.replace(/&#44;/g, ",");
		to_append = to_append.replace(/&#39;/g, "'");
		to_append = to_append.replace(/&quot;/g, '"');
		to_append = to_append.replace(/&sect;/g, "§");
		to_append = to_append.replace(/&mdash;/g, "—");
		to_append = to_append.replace(/&mdash;/g, "--");
		to_append = to_append.replace(/&ndash;/g, "-");
		
		to_append += '</div>';
		
		loadSideform(true);
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "650px");
			//$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);	
			$("#test_interface").empty().append(to_append).css('margin-top', "0").fadeIn(500);	
			
			/*$('#contact_dropsource').removeClass("hidden").animate({height: 15, top: -15}, 500);
			setTimeout(function(){
				$('#contact_dropover').removeClass("hidden").animate({height: 400}, 500);
			}, 500);*/
			//Convert italics into tooltips...
			$("i").tooltip({ html: true });
			//Append icon
			$("i").append('<img src="/images/info_icon.png"/>');
		});
	}
	else if (qtype === "CS") 
	{
		//CUSTOM SELECTOR TYPE
		//Base off ID for now...
		
		//custom_selector(QUNIT['seq'], QUNIT, to_append, answer_array);
		custom_selector(QUNIT['id'], QUNIT, to_append, answer_array);
	}//Ends if loop
}

function clearDefault(el) {
  if (el.defaultValue==el.value) el.value = "";
}

$.fn.preload = function() {
	this.each(function(){
		$('<img/>')[0].src = this;
	});
}

function firstPage(NUM, DEBUG)
{	
	
	$.post("/function/tracker", { type: "BEGIN", time: Math.round(new Date().getTime() / 1000), test_id: NUM} );
	test_id = NUM;
	debug = DEBUG;
	
	//Initialize the gvar array if there is an ignition function which will do so...
	if($('#ignition_trigger').length)
		gvar = ignition();
	
	//Load the test into global var
	$(this).getIssue(test_id);
	
	$(['/images/main_contact_bar.png','/images/factor_sprites.png','/images/factor_body.png','/images/main_radiobutton.png','/images/main_checkbox.png','/images/lawyer_stock.jpg','/images/main_contact_chat.png','/images/main_contact_email.png','/images/main_contact_call.png']).preload();
	
	//initiateProgressBar();
	
	$('#character_contact').click(function(){
		$.post("/function/tracker", { type: "RSKIP", time: Math.round(new Date().getTime() / 1000), test_id: NUM} );
		loadSideform(false);
	});
	
	$('#contact_caption').click(function(){
		$.post("/function/tracker", { type: "RSKIP", time: Math.round(new Date().getTime() / 1000), test_id: NUM} );
		loadSideform(false);
	});
	
	$(".backbutton").click(function() {
		if(hstack.length <= 0)
		{
			$(".backbutton").unbind("click");
			window.history.back();
		}
		else if($('.result_box').css('display') === 'none')
		{
			var QUNIT = astack[astack.length - 1];
			var answer_array = QUNIT['answers'].split('|');	
			for(x in answer_array)
			{
				answer_array[x] = answer_array[x].split(',');
			}
			
			for(var x = astack.length - 1; x >= 0; x--)
			{
				for(y in answer_array)
				{
					if(answer_array[y][1] && astack[x]['cluster'] == answer_array[y][1])
					{
						astack.splice(x, 1);
						break;
					}
				}
			}
			
			//You are somewhere in the test, go ahead and pop off
			astack.push(hstack.pop());
			loadChildNode();
		}
		else
		{
			$(".result_box").fadeOut(500, function(){
				$("#test_interface").fadeIn(500);
				$("#beta_box").css('min-height', '300px');
				
				//You are somewhere in the test, go ahead and pop off
				astack.push(hstack.pop());
				loadChildNode();
			});
		}
	});
	
	$("#result_submit").click(function(){
		$('#result_warning').empty().append('<img src="http://i.imgur.com/qkKy8.gif" />');	
		$.post("/function/submit_results/",{ name: $("#field_name").attr("value"), email: $("#field_email").attr("value"), phone: $("#field_phone").attr("value"), test_id: test_id, time: Math.round(new Date().getTime() / 1000)}, function(data){
			if(String(data) != "")
			{
				$('#result_warning').empty().append(String(data));
				if(String(data) == "Thank you! A legal professional will contact you ASAP.")
				{
					$('#result_warning').css("color", "#27C22F");
					$("#field_name").attr("value", "");
					$("#field_email").attr("value", "");
					$("#field_phone").attr("value", "");
					$("div[id='result_check_terms']").css("background-position", "0px 0px")
				}
				else
				{
					$('#result_warning').css("color", "#F24122");
				}
			}
		});
	});
	
	//$(".ui-progress").css("width", "20%");
}

$.fn.getIssue = function(TESTNUM)
{
	$.post("/function/get_issue",{ test_id: TESTNUM },
		function(data){
			all_questions = data;
			//Start eating the stack
			$(this).eatStack();
		}, "json");
}

$.fn.eatStack = function()
{
	astack.length = 0;
	hstack.length = 0;
	
	//Set the number of questions
	num_of_questions = all_questions.length;
	
	//Initialize the active stack with factors
	for(x in all_questions)
	{
		if(!all_questions[x]['cluster'])
		{
			astack.push(all_questions[x]);
		}
	}
	
	//Eat the first of the stack
	loadChildNode();
}