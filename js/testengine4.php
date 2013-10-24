<?php
	Header("content-type: application/javascript");
?>
var astack = new Array();
var hstack = new Array();
var gvar = new Array();
var all_questions;
var num_of_questions;
var test_id;
var debug;

function trim(myString)     
{
    return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')     
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
	{
		//Figure out which variable operation
		if(String(QUNIT['var_override']).indexOf('+') === -1 && String(QUNIT['var_override']).indexOf('-') === -1 && String(QUNIT['var_override']).indexOf('*') === -1 && String(QUNIT['var_override']).indexOf('/') === -1)
		{
			//Add it to the gvar (global variable) hash table
			gvar[trim(String(QUNIT['var_override']).split("=")[0])] = trim(String(QUNIT['var_override']).split("=")[1]);
		}
		else
		{
			//Evaluate the RHS and assign
			var lhs = trim(String(QUNIT['var_override']).split("=")[0]);
			var rhs = trim(String(QUNIT['var_override']).split("=")[1]);
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
	
		var varnum = Math.round(Number(gvar[key])*100)/100;
		if(varnum)
			preformatted_question = preformatted_question.replace(new RegExp('{' + key + '}', "gi"), varnum);
		else
			preformatted_question = preformatted_question.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
	}
	preformatted_question = preformatted_question.replace(new RegExp('{.*}', "gi"), '');
	
	if(debug && debug_output)
	{
		alert(debug_output);
	}
	
	//Common preconfiguration
	var to_append = '<h1>' + preformatted_question + '</h1>';
	var answer_array = QUNIT['answers'].split('|');
	
	$.post("/function/tracker", { type: "QLOAD", time: Math.round(new Date().getTime() / 1000), test_id: test_id, question: QUNIT['id']} );
	
	//Display the new array's question and answers on-screen
	if (qtype === "RS")
	{
		for(x in answer_array)
		{
			answer_array[x] = answer_array[x].split(',');
		}
		to_append += '<div class="left" style="width: 150px; margin-left: 50px;"><div id="rs_caption" style="font-size: 1.5em; width: 100%; text-align: center;"></div><img src="" id="rs_image"/></div><div class="right" style="width: 400px"><input type="range" style="margin-top: 50px" id="rs_slider" min="1" max="' + answer_array.length + '"></input></div>';
		to_append += '<div class="link-outer"><div class="link-inner" id="in_continue">Submit</div></div>';
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "600px");
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
				var id = $(this).attr("id").split("_")[1];
				var target = $(this).attr("data-target");
				var tag = $(this).attr("data-tag");
				var var_assign = $(this).attr("data-var");
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
				
				for(var x = astack.length - 1; x >= 0; x--)
				{
					for(y in answer_array)
					{
						if(answer_array[y][1] && astack[x]['cluster'] == answer_array[y][1])
						{
							if(answer_array[y][3])
								if(astack[x]['var_override'] === answer_array[y][3])
									astack.splice(x, 1);
								else
									break;
							else
								astack.splice(x, 1);
							break;
						}
					}
				}
				
				//If targeted, go to target
				if(target)
				{
					
					for(x in all_questions)
					{
						if(all_questions[x]['cluster'] == target)
						{
							var temp = $.extend(true, [], all_questions[x]);
							if(var_assign)
								temp['var_override'] = String(var_assign);
							
							astack.push(temp);
						}
					}
				}
				else
				{
					//If not targeted, assign variable to gvars table anyway...
					if(var_assign)
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
				}
				
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
			if(answer_array[x][3])
				//New code with variable field
				to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
			else
				//Legacy code without variable field (phase out)
				to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
		}
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "600px");
			$("#test_interface").empty().append(to_append).css('margin-top', Math.abs((295-$('#test_interface').outerHeight())/2) + "px").fadeIn(500);
			
			//Set up click event handlers
			$("div[id^='a_']").click(function() {
				$(this).disableClicks();
				var id = $(this).attr("id").split("_")[1];
				var target = $(this).attr("data-target");
				var tag = $(this).attr("data-tag");
				var var_assign = $(this).attr("data-var");
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
				
				for(var x = astack.length - 1; x >= 0; x--)
				{
					for(y in answer_array)
					{
						if(answer_array[y][1] && astack[x]['cluster'] == answer_array[y][1])
						{
							if(answer_array[y][3])
								if(astack[x]['var_override'] === answer_array[y][3])
									astack.splice(x, 1);
								else
									break;
							else
								astack.splice(x, 1);
							break;
						}
					}
				}
				
				//If targeted, go to target
				if(target)
				{
					
					for(x in all_questions)
					{
						if(all_questions[x]['cluster'] == target)
						{
							var temp = $.extend(true, [], all_questions[x]);
							if(var_assign)
								temp['var_override'] = String(var_assign);
							
							astack.push(temp);
						}
					}
				}
				else
				{
					//If not targeted, assign variable to gvars table anyway...
					if(var_assign)
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
				}
				
				//Eat the next item in the stack
				loadChildNode();
			});
		});
	}
	else if (qtype == "OP")
	{
		var targets_to_queue = new Array();
		var vars_to_queue = new Array();
		
		for(x in answer_array)
			{
				answer_array[x] = answer_array[x].split(',');
				if(answer_array[x][0] == "nota")
				{
					to_append += '<div class="option" id="nota" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '"><div class="checkbox" id="nota_check"></div>&nbsp;<div class="optiontext">None of the above</div></div>';
				}
				else
				{
					if(answer_array[x][3])
						to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '"><div class="checkbox" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
					else
						to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '"><div class="checkbox" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
				}
			}
		
		to_append += '<div class="link-outer"><div class="link-inner" id="op_continue">Continue</div></div>';
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "600px");
			$("#test_interface").empty().append(to_append).css('margin-top', Math.abs((295-$('#test_interface').outerHeight())/2) + "px").fadeIn(500);
			
			//Set up click event handlers
			$("div[id^='a_']").click(function() {
				var id = $(this).attr("id").split("_")[1];
				var target = $(this).attr("data-target");
				var var_assign = $(this).attr("data-var");
				if($("div[id='check_" + id + "']").css("background-position") == "0px 0px")
				{
					$("div#nota_check").css("background-position", "0px 0px");
					$("div[id='check_" + id + "']").css("background-position", "0px -23px");
					targets_to_queue.push(target);
					vars_to_queue.push(var_assign);
				}
				else
				{
					$("div[id='check_" + id + "']").css("background-position", "0px 0px");
					targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
					vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
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
					targets_to_queue.push(target);
					vars_to_queue.push(var_assign);
				}
				else
				{
					$("div#nota_check").css("background-position", "0px 0px");
					targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
					vars_to_queue.splice(vars_to_queue.indexOf(var_assign), 1);
				}
			});
			$("div#op_continue").click(function(){
				$(this).disableClicks();
				
				hstack.push(astack.pop());
				var user_responses = new Array();

				if($("div#nota_check").css("background-position") == "0px -23px")
				{
					user_responses.push(answer_array.length - 1);
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
							if(answer_array[x][3])
								if(astack[y]['var_override'] === answer_array[x][3])
									astack.splice(y, 1);
								else
									continue;
							else
								astack.splice(y, 1);
							continue;
						}
					}
				
					if(targets_to_queue.indexOf(answer_array[x][1]) == -1)
					{
						continue;
					}
					
					//ELIMINATE IF VARIABLE SET BUT NOT QUEUED
					if(answer_array[x][3])
						if(vars_to_queue.indexOf(answer_array[x][3]) === -1)
							continue;
					
					if(!answer_array[x][1])
					{
						user_responses.push(x);
						continue;
					}
					user_responses.push(x);
					for(y in all_questions)
					{
						if(all_questions[y]['cluster'] == answer_array[x][1])
						{
							var temp_q = $.extend(true, [], all_questions[y]);
							if(answer_array[x][3])
							{
								temp_q['var_override'] = String(answer_array[x][3]);
								
								//Splice the var from vars_to_queue as it has been accounted for...
								vars_to_queue.splice(vars_to_queue.indexOf(answer_array[x][3]), 1);
							}
							
							astack.push(temp_q);
						}
					}
				}
				
				
				//Assign any leftover variables without targets...
				for(x in vars_to_queue)
				{
					if(!vars_to_queue[x])
						continue;
					
					//Figure out which variable operation
					if(String(vars_to_queue[x]).indexOf('+') === -1 && String(vars_to_queue[x]).indexOf('-') === -1 && String(vars_to_queue[x]).indexOf('*') === -1 && String(vars_to_queue[x]).indexOf('/') === -1)
					{
						//Add it to the gvar (global variable) hash table
						gvar[trim(String(vars_to_queue[x]).split("=")[0])] = trim(String(vars_to_queue[x]).split("=")[1]);
					}
					else
					{
						//Evaluate the RHS and assign
						var lhs = trim(String(vars_to_queue[x]).split("=")[0]);
						var rhs = trim(String(vars_to_queue[x]).split("=")[1]);
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

				hstack[hstack.length - 1]['user_response'] = user_responses;
				

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
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "600px");
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
				var id = $(this).attr("id").split("_")[1];
				var target = $(this).attr("data-target");
				var tag = $(this).attr("data-tag");
				var var_assign = $(this).attr("data-var");
				
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
					
				for(var x = astack.length - 1; x >= 0; x--)
				{
					for(y in answer_array)
					{
						if(answer_array[y][1] && astack[x]['cluster'] == answer_array[y][1])
						{
							if(answer_array[y][3])
								if(astack[x]['var_override'] === answer_array[y][3])
									astack.splice(x, 1);
								else
									break;
							else
								astack.splice(x, 1);
							break;
						}
					}
				}

				//If targeted, go to target
				if(target)
				{
					for(x in all_questions)
					{
						if(all_questions[x]['cluster'] == target)
						{
							var temp = $.extend(true, [], all_questions[x]);
							if(var_assign)
								temp['var_override'] = String(var_assign);
							
							astack.push(temp);
						}
					}
				}
				else
				{
					//If not targeted, assign variable to gvars table anyway...
					if(var_assign)
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
				}				

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
		to_append += '<div class="link-outer"><div class="link-inner" id="in_continue">Submit</div></div>';
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "600px");
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

				for(var x = astack.length - 1; x >= 0; x--)
				{
					for(y in answer_array)
					{
						if(answer_array[y][1] && astack[x]['cluster'] == answer_array[y][1])
						{
							if(answer_array[y][3])
								if(astack[x]['var_override'] === answer_array[y][3])
									astack.splice(x, 1);
								else
									break;
							else
								astack.splice(x, 1);
							break;
						}
					}
				}
				
				var target = $.extend(true, [], answer_array[0][1]);
				var var_assign = $.extend(true, [], answer_array[0][3]);
				//If targeted, go to target
				if(target)
				{
					for(x in all_questions)
					{
						if(all_questions[x]['cluster'] == target)
						{
							var temp = $.extend(true, [], all_questions[x]);
							if(var_assign)
								temp['var_override'] = String(var_assign);
							
							astack.push(temp);
						}
					}
				}
				else
				{
					//If not targeted, assign variable to gvars table anyway...
					if(var_assign)
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
				}	

				hstack[hstack.length - 1]['user_response'] = this_input;
				
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
		to_append += '<div class="warning_message" id="input_warning">&nbsp;</div>'
		to_append += '<div class="link-outer"><div class="link-inner" id="in_continue">Submit</div></div>';
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "600px");
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
				
				for(var x = astack.length - 1; x >= 0; x--)
				{
					for(y in answer_array)
					{
						if(answer_array[y][1] && astack[x]['cluster'] === answer_array[y][1])
						{
							if(astack[x]['var_override'] === answer_array[y][3])
								astack.splice(x, 1);
							else
								break;
						}
					}
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
							if(var_assign)
								temp['var_override'] = String(var_assign);
							
							astack.push(temp);
						}
					}
				}
				
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
			//Evaluate the RHS and assign
			var lhs = trim(String(answer_array[x][0]).split("=")[0]);
			var rhs = trim(String(answer_array[x][0]).split("=")[1]);
			
			for(key in gvar)
			{
				rhs = rhs.replace(new RegExp('{' + key + '}', "gi"), gvar[key]);
			}	
			
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
	else if (qtype == "ZZ")
	{
		$.post("/function/tracker", { type: "RLOAD", time: Math.round(new Date().getTime() / 1000), test_id: test_id} );
		to_append = '<div class="left" style="width: 400px; text-align: left; border-right: 1px dashed #666; padding-right: 50px"><h4 style="padding-top: 0">' + preformatted_question + '</h4><div style="padding-left: 25px"><a href="mailto:info@myright.me" id="email-us-yo"><img src="/images/icon_email.png" style="margin-right: 10px">E-mail Us</a></div></div><div class="right" style="width: 315px">';
		
		if(String(answer_array[0]).length > 5)
		{
			for(x in answer_array)
			{
				answer_array[x] = answer_array[x].split(',');
				answer_array[x][0] = answer_array[x][0].replace(/&#44;/g, ",");
				answer_array[x][0] = answer_array[x][0].replace(/&#39;/g, "'");
				answer_array[x][0] = answer_array[x][0].replace(/&quot;/g, '"');
				answer_array[x][0] = answer_array[x][0].replace(/&sect;/g, "§");
				answer_array[x][0] = answer_array[x][0].replace(/&mdash;/g, "—");
				answer_array[x][0] = answer_array[x][0].replace(/&mdash;/g, "--");
				answer_array[x][0] = answer_array[x][0].replace(/&ndash;/g, "-");
				to_append += String(answer_array[x][0]);
			}
		}
		else
		{
			to_append += '<div style="font-size: 1.6em; margin: 0 auto; text-align: center; font-weight: 300;"><div>Contact Us for a</div><div>FREE CONSULTATION</div></div><div class="form_line" style="margin-top: 20px"><label>Name</label><input type="text" id="field_name" maxlength=50 class="custominput"/></div><div class="form_line"><label>E-mail</label><input type="email" id="field_email" maxlength=100  class="custominput"/></div><div class="form_line"><label>Phone</label><input type="tel" id="field_phone" maxlength=10 style="width: 6em" class="custominput"/><div style="display:inline; margin-left: 1em; font-size: 0.8em; font-style: italic; color: #999">just the digits</div></div><div class="orange-button" id="result_submit">Submit</div><div class="warning_message" id="result_warning"></div>';
			//to_append += '<div style="background: url(/images/lawyer_team.png); height: 151px; width: 226px; margin: 10px auto"></div>';
		}
		
		to_append += '</div>';
		
		$("#test_interface").fadeOut(500, function(){
			$("#beta_box").css("width", "800px");
			$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);	
			
			/*$('#lzad').click(function(){
				_kmq.push(['record', 'Conversion']);
				$.post("/function/tracker", { type: "AFCLK", time: Math.round(new Date().getTime() / 1000), test_id: NUM} );
			});*/
			
			$('#email-us-yo').click(function(){
				hstack.push(astack.pop());	
				$(this).loadResults();
				return;
			});
			
			$("#result_submit").click(function(){
			$('#result_warning').empty().append('<img src="http://i.imgur.com/qkKy8.gif" />');	
			$.post("/function/submit_results",{ name: $("#field_name").attr("value"), email: $("#field_email").attr("value"), phone: $("#field_phone").attr("value"), test_id: test_id, time: Math.round(new Date().getTime() / 1000)}, function(data){
				if(String(data) != "")
				{
					$('#result_warning').empty().append(String(data));
					if(String(data) == "Thank you! A legal professional will contact you ASAP.")
					{
						_kmq.push(['record', 'Conversion']);
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
		});
	}//Custom stuff follows here
	<?php echo ; ?>
	//Ends if loop
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
	
	$('#find-a-lawyer').click(function(){
		$.post("/function/tracker", { type: "RSKIP", time: Math.round(new Date().getTime() / 1000), test_id: NUM} );
		hstack.push(astack.pop());	
		$(this).loadResults();
		return;
	});
	
	$('.lawyer-listing').click(function(){
		$.post("/function/tracker", { type: "RSKIP", time: Math.round(new Date().getTime() / 1000), test_id: NUM} );
		hstack.push(astack.pop());	
		$(this).loadResults();
		return;
	});
	
	$('#email-us-yo').click(function(){
		hstack.push(astack.pop());	
		$(this).loadResults();
		return;
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