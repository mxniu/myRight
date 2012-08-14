var astack = new Array();
var hstack = new Array();
var all_questions;
var num_of_questions;
var test_id;

function reorg_list(TAGNAME)
{
	var category_slug = $('#category-slug').html();
	var location_slug = $('#location-slug').html();

	var this_action = "../" + category_slug + "/" + TAGNAME + "?ajax";
	if(location_slug)
		this_action += "&location=" + location_slug;
	
	$.ajax({
		type: "POST",
		url: this_action,
		dataType: "html"
	}).done(function( data ) {
		$('#tag-title').html(TAGNAME);
		$('#list-elements').infinitescroll('destroy').html(data).infinitescroll({                      
		  state: {                                              
			isDestroyed: false,
			isDone: false                           
		  }
		}).infinitescroll({
			navSelector  : '#page_nav',    // selector for the paged navigation 
			nextSelector : '#page_nav a:first',  // selector for the NEXT link (to page 2)
			itemSelector : '.list-element',     // selector for all items you'll retrieve
			loading: {
				finishedMsg: 'No more articles to load.',
				img: 'http://i.imgur.com/qkKy8.gif'
			  }
			},
			function( newElements ) {
				$('#list-elements').append(newElements);
				$('.list-element').children('.title-wrapper').children('.title').unbind('click');
				$('.list-element').children('.title-wrapper').children('.title').click(function(e){
					var this_slug = $(this).attr('id');
					$('#myModal').modal('show');
					history.pushState({ slug: this_slug }, null, $('[id=' + this_slug + ']').attr('href'));
					$('#modalslug').html(this_slug);
					if(e.preventDefault){  
						e.preventDefault();  
					}else{  
						e.returnValue = false;  
						e.cancelBubble=true;  
					}
					return false;
				});
		});
		
		$('.list-element').children('.title-wrapper').children('.title').click(function(e){
			var this_slug = $(this).attr('id');
			$('#myModal').modal('show');
			history.pushState({ slug: this_slug }, null, $('[id=' + this_slug + ']').attr('href'));
			$('#modalslug').html(this_slug);
			if(e.preventDefault){
				e.preventDefault();  
			}else{  
				e.returnValue = false;
				e.cancelBubble=true;
			}
			return false;
		});
	});
}

$.fn.disableClicks = function()
{
	$("div[id^='a_']").unbind('click');
	$("div#op_continue").unbind('click');
}

function loadChildNode()
{
	$("#test_interface").fadeOut(500, function(){
		$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>").fadeIn(500);
	});
	
	//Redirect to result if empty
	if(astack.length <= 0)
	{
		$("#test_interface").fadeOut(500, function(){
			$("#test_interface").empty().append("<h1>This shit is done yo</h1>").fadeIn(500);
	});
	}
	
	QUNIT = astack[astack.length - 1];
	
	//Assign some local variables
	var qtype = $.trim(QUNIT['type']);
	//Common preconfiguration
	var to_append = '<h1>' + QUNIT['question'] + '</h1>';
	var answer_array = QUNIT['answers'].split('|');
	//Display the new array's question and answers on-screen
	if (qtype == "RS" || qtype == "MC")
	{
			for(x in answer_array)
			{
				answer_array[x] = answer_array[x].split(',');
				to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
			}
		$("#test_interface").fadeOut(500, function(){
			$("#test_interface").empty().append(to_append).fadeIn(500);
			
			//Show or hide the back button
			if(hstack.length > 0)
				$(".backbutton").fadeIn(500);
			else
				$(".backbutton").fadeOut(500);
			
			//Set up click event handlers
			$("div[id^='a_']").click(function() {
				$(this).disableClicks();
				var id = $(this).attr("id").split("_")[1];
				var target = $(this).attr("data-target");
				var tag = $(this).attr("data-tag");
				$("div[id='check_" + id + "']").css("background-position", "0px -21px");
				
				if(tag)
				{
					reorg_list(tag);
				}
				
				hstack.push(astack.pop());
				
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
	else if (qtype == "OP")
	{
		var targets_to_queue = new Array();
		for(x in answer_array)
			{
				answer_array[x] = answer_array[x].split(',');
				if(answer_array[x][0] == "nota")
				{
					to_append += '<div class="option" id="nota"><div class="checkbox" id="nota_check"></div>&nbsp;<div class="optiontext">None of the above</div></div>';
				}
				else
				{
					to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '"><div class="checkbox" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
				}
			}
		
		//to_append += '<div class="option" id="nota"><div class="checkbox" id="nota_check"></div>&nbsp;<div class="optiontext">None of the above</div></div>';
		to_append += '<div class="button_orange_thin" id="op_continue">Continue</div>';
		$("#test_interface").fadeOut(500, function(){
			$("#test_interface").empty().append(to_append).fadeIn(500);
			
			if(hstack.length > 0)
				$(".backbutton").fadeIn(500);
			else
				$(".backbutton").fadeOut(500);
			
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
				

				//Eat the next item in the stack
				loadChildNode();
			});
		});
	}
	else if (qtype == "MB" || qtype == "EX")
	{
			
			for(x in answer_array)
			{
				answer_array[x] = answer_array[x].split(',');
				/*if(answer_array[x][0].length > 20 && answer_array[x][0].indexOf('<br') == -1)
				{
					answer_array[x][0] = String(answer_array[x][0]).replace(" ", "<br />");
				}
				answer_array[x][0] = answer_array[x][0].replace("&#44;", ",");
				answer_array[x][0] = answer_array[x][0].replace("&#39;", "'");
				answer_array[x][0] = answer_array[x][0].replace("&quot;", '"');
				answer_array[x][0] = answer_array[x][0].replace("&sect;", "§");
				answer_array[x][0] = answer_array[x][0].replace("&mdash;", "—");
				answer_array[x][0] = answer_array[x][0].replace("&mdash;", "--");
				answer_array[x][0] = answer_array[x][0].replace("&ndash;", "-");*/
				to_append += '<div class="link-outer"><div class="link-inner" id="a_' + x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '">' + answer_array[x][0] + '</div></div>';
			}
		$("#test_interface").fadeOut(500, function(){
			$("#test_interface").empty().append(to_append).fadeIn(500);

			if(hstack.length > 0)
				$(".backbutton").fadeIn(500);
			else
				$(".backbutton").fadeOut(500);

			//Resize font if necessary
			for(x in answer_array) 
			{
				if(answer_array[x][0].length <4)
				{
					$('div#a_' + x).css("font-size", "1.5em");
				}
				else if (answer_array[x][0].length <17)
				{
					$('div#a_' + x).css("font-size", (1 + (0.06154 *(17 - answer_array[x][0].length)))+"em");
				}
				else
				{
					$('div#a_' + x).css("font-size", "1em");
				}
			}

			//Set up click event handlers
			$("div[id^='a_']").click(function() {
				$(this).disableClicks();
				var id = $(this).attr("id").split("_")[1];
				var target = $(this).attr("data-target");
				var tag = $(this).attr("data-tag");
				
				if(tag)
				{
					reorg_list(tag);
				}
				
				hstack.push(astack.pop());
					
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
		to_append += '<div class="link-outer"><div class="link-inner" id="in_continue">Submit</div></div>';
		
		$("#test_interface").fadeOut(500, function(){
			$("#test_interface").empty().append(to_append).fadeIn(500);
			if(hstack.length > 0)
				$(".backbutton").fadeIn(500);
			else
				$(".backbutton").fadeOut(500);
			
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
							astack.splice(x, 1);
							break;
						}
					}
				}
				
				//If targeted, go to target
				if(answer_array[0][1])
				{
					for(x in all_questions)
					{
						if(all_questions[x]['cluster'] == answer_array[0][1])
							astack.push(all_questions[x]);
					}
				}

				hstack[hstack.length - 1]['user_response'] = this_input;
				

				//Eat the next item in the stack
				loadChildNode();
			
			});
		});
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

function firstPage(NUM)
{	
	test_id = NUM;

	//Load the test into global var
	$(this).getIssue(test_id);
	$(['/images/main_contact_bar.png','/images/factor_sprites.png','/images/factor_body.png','/images/main_radiobutton.png','/images/main_checkbox.png','/images/lawyer_stock.jpg','/images/main_contact_chat.png','/images/main_contact_email.png','/images/main_contact_call.png']).preload();
	
	$(".backbutton").click(function() {			
		if(hstack.length <= 0)
			return;
		
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
		astack.push(hstack.pop())
		loadChildNode();	
	});
}

$.fn.getIssue = function(TESTNUM)
{
	$("#test_interface").fadeOut(500, function(){
		$("#test_interface").empty().append("<img src='http://i.imgur.com/qkKy8.gif' id='loading'/>").fadeIn(500);
	});	
	$.post("../function/get_issue",{ test_id: TESTNUM },
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