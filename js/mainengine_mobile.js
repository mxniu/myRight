	var astack = new Array();
	var all_questions;
	var num_of_questions;
	var test_id;
	
	$.fn.disableClicks = function()
	{
		//$("div[id^='a_']").unbind('click');
		//$("div#op_continue").unbind('click');
	}

	function loadChildNode()
	{
		$(".content").fadeOut(250, function(){
						$(".tooltip").css("display", "none");
						$(".content").empty().append("<img src='/images/ajax-loader.gif' id='loading'/>").fadeIn(250);
		});
		
		//Redirect to result if empty
		if(astack.length <= 0)
		{
			$(this).getResult();
			return;
		}
		
		QUNIT = astack[astack.length - 1];
		
		//$.post("tracker.php", { type: "QLOAD", time: Math.round(new Date().getTime() / 1000), test_id: test_id, question: String(QUNIT['question'])} );
		
		//Assign some local variables
		var qtype = $.trim(QUNIT['type']);
		//Common preconfiguration
		var to_append = '<h1>' + QUNIT['question'] + '</h1>';
		var answer_array = QUNIT['answers'].split('|');
				//Display the new array's question and answers on-screen
				if (qtype == "OP")
				{
					var targets_to_queue = new Array();
					for(x in answer_array)
						{
							answer_array[x] = answer_array[x].split(',');
							if(answer_array[x][0] == "nota")
							{
								to_append += '<div class="option" id="nota" data-target="' + answer_array[x][1] + '"><div class="checkbox" id="nota_check"></div>&nbsp;<div class="optiontext">None of the above</div></div>';
							}
							else
							{
								to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '"><div class="checkbox" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
							}
						}
					
					//to_append += '<div class="option" id="nota"><div class="checkbox" id="nota_check"></div>&nbsp;<div class="optiontext">None of the above</div></div>';
					to_append += '<div class="button_orange_thin" id="op_continue">Continue</div>';
					$(".content").fadeOut(250, function(){
						$(".content").empty().append(to_append).fadeIn(250);
						
						//Set up click event handlers
						$("div[id^='a_']").click(function() {
							var id = $(this).attr("id").split("_")[1];
							var target = $(this).attr("data-target");
							if($("div[id='check_" + id + "']").css("background-position") == "0px 0px")
							{
								$("div#nota_check").css("background-position", "0px 0px");
								$("div[id='check_" + id + "']").css("background-position", "0px -23px");
								targets_to_queue.push(target);
							}
							else
							{
								$("div[id='check_" + id + "']").css("background-position", "0px 0px");
								targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
							}
						});
						$("div#nota").click(function() {
							var target = $(this).attr("data-target");
							if($("div#nota_check").css("background-position") == "0px 0px")
							{
								$("div#nota_check").css("background-position", "0px -23px");
								$("div[id^='check_']").css("background-position", "0px 0px");
								targets_to_queue.length = 0;
								targets_to_queue.push(target);
							}
							else
							{
								$("div#nota_check").css("background-position", "0px 0px");
								targets_to_queue.splice(targets_to_queue.indexOf(target), 1);
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
								for(var y = astack.length - 1; y >= 0; y--)
								{
									if(answer_array[x][1] && astack[y]['cluster'] == answer_array[x][1])
									{
										astack.splice(y, 1);
										continue;
									}
								}
								if(targets_to_queue.indexOf(answer_array[x][1]) == -1)
								{
									continue;
								}
								if(!answer_array[x][1])
								{
									user_responses.push(x);
									continue;
								}
								user_responses.push(x);
								for(y in all_questions)
								{
									if(all_questions[y]['cluster'] == answer_array[x][1])
										astack.push(all_questions[y]);
								}
							}

							hstack[hstack.length - 1]['user_response'] = user_responses;
							hstack[hstack.length - 1]['answer_array'] = answer_array;

							//Eat the next item in the stack
							loadChildNode();
						});
					});
				}
				else if (qtype == "MB" || qtype == "RS" || qtype == "MC")
				{
						
						for(x in answer_array)
						{
							answer_array[x] = answer_array[x].split(',');
							answer_array[x][0] = answer_array[x][0].replace("&#44;", ",");
							answer_array[x][0] = answer_array[x][0].replace("&#39;", "'");
							answer_array[x][0] = answer_array[x][0].replace("&quot;", '"');
							answer_array[x][0] = answer_array[x][0].replace("&sect;", "§");
							answer_array[x][0] = answer_array[x][0].replace("&mdash;", "—");
							answer_array[x][0] = answer_array[x][0].replace("&mdash;", "--");
							answer_array[x][0] = answer_array[x][0].replace("&ndash;", "-");
							to_append += '<a href="#" data-role="button" class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '">' + answer_array[x][0] + '</a>';
						}
					$(".content").fadeOut(250, function(){
						$(".content").empty().append(to_append).trigger( "create" ).fadeIn(250);

						//Set up click event handlers
						$("a[id^='a_']").click(function() {
							$(this).disableClicks();
							//var id = $(this).attr("id").split("_")[1];
							var target = $(this).attr("data-target");

							astack.pop();
							/*hstack.push(astack.pop());		
							hstack[hstack.length - 1]['user_response'] = [id];
							hstack[hstack.length - 1]['answer_array'] = answer_array;
								
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
							}*/

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
					to_append += '<a href="#" data-role="button" class="option" id="in_continue">Continue</a>';
					
					$(".content").fadeOut(250, function(){
						$(".content").empty().append(to_append).trigger( "create" ).fadeIn(250);
						
						$("#in_continue").click(function() {
							/*for(x in answer_array)
							{
								var this_input = $('input#a_' + x).attr("value");
								if(!this_input)
								{
									$("#input_warning").empty().append("Please enter a value for " + answer_array[x][0]);
									return;
								}
							}*/
							var this_input = $('input#a_0').attr("value");
							if(!this_input)
							{
								$("#input_warning").empty().append("Please enter a value");
								return;
							}
							
							
							$(this).disableClicks();
							
							astack.pop();
							/*hstack.push(astack.pop());
							//var user_responses = new Array();
	
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
							}*/
							
							/*for(x in answer_array)
							{
								user_responses.push(x);
							}*/
							
							//If targeted, go to target
							if(answer_array[0][1])
							{
								for(x in all_questions)
								{
									if(all_questions[x]['cluster'] == answer_array[0][1])
										astack.push(all_questions[x]);
								}
							}
	
							/*hstack[hstack.length - 1]['user_response'] = this_input;
							hstack[hstack.length - 1]['answer_array'] = answer_array;*/
	
							//Eat the next item in the stack
							loadChildNode();
						
						});
					});
				}//Ends if loop
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
		test_id = NUM;
	
		//Load the test into global var
		$(this).getIssue(test_id);
		$(['/images/main_contact_bar.png','/images/factor_sprites.png','/images/factor_body.png','//images/ajax-loader.gif','/images/main_radiobutton.png','/images/main_checkbox.png','/images/lawyer_stock.jpg','/images/main_contact_chat.png','/images/main_contact_email.png','/images/main_contact_call.png']).preload();
	}
	
	$.fn.getIssue = function(TESTNUM)
	{
		$(".content").stop(true, true).empty().append("<img src='/images/ajax-loader.gif' id='loading'/>").animate({opacity: 1.0}, 250);
		$.post("getissue.php",{ sendValue: TESTNUM },
            function(data){
				all_questions = data;
				//Start eating the stack
				$(this).eatStack();
			}, "json");
	}
	
	$.fn.eatStack = function()
	{
		astack.length = 0;
		
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
	
$( document ).bind( "pagebeforeshow", function () { 
	$(this).firstPage(42);
});