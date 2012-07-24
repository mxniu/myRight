	var astack = new Array();
	var fstack = new Array();
	var hstack = new Array();
	var all_questions;
	var num_of_questions;
	var current_factor;
	var test_id;
	var result_array;
	var totalWidth;
	var geocoder;
	var map;
	var street_address;
	var factor_text_color;
	
	$.fn.loadResults = function()
	{
		//Calculate Result!
		var result_qualifier = "may";

		var to_append = '<h1>You ' + result_qualifier + ' ' + result_array[0]['claim_string'] + '</h1>';
				
		to_append += 'This information is for EDUCATIONAL PURPOSES ONLY and is NOT legal advice. We have NOT yet formed an attorney-client relationship.';
					
		//Dummy data for result form, will change later
		to_append += '<div class="result_form"><h3><b>Complete this form</b> to send me your answers and I will contact you as soon as possible.</h3><form>';
		to_append += '<div>Name:&nbsp;<input type="text" name="name" class="custominput" maxlength=50></div>';
		to_append += '<div>E-mail:&nbsp;<input type="text" name="email" class="custominput" maxlength=100></div>';
		to_append += '<div>Message (optional):</div><div><textarea name="description" class="customtextarea" cols="50" rows="8"></textarea></div>';
		
		$('#report_window').empty();
		var factor_sum = 0;
		var factor_count = 0;
		for(x in fstack)
		{
			var total_responses = 0;
			var total_rated_responses = 0;
			var total_rated = 0;
			for(y in hstack)
			{
				if(hstack[y]['factor'] == fstack[x]['factor'] && hstack[y]['user_response'])
				{
					total_responses++;
					var all_response = hstack[y]['user_response'];
					for(z in all_response)
					{
						var this_response = all_response[z];
						if(!hstack[y]['answer_array'][this_response])
							continue;
						if(Number(hstack[y]['answer_array'][this_response][2]) >= 1 && Number(hstack[y]['answer_array'][this_response][2]) <= 5)
						{
							total_rated_responses++;
							total_rated += Number(hstack[y]['answer_array'][this_response][2]);
						}
					}	
				}
			}
			
			var check_bg_pos;
			if(total_responses == 0)
				check_bg_pos = 0;
			else
				check_bg_pos = -23;
			/*else if(pros > 0)
				check_bg_pos = -46;
			else if(cons > 1)
				check_bg_pos = -69;*/
			
			
			if(total_rated_responses <= 0)
			{
				$('#report_window').append('<div style="height: 26px"><div style="width: 300px"><div class="checkbox" style="margin-right: 5px; background-position: 0px ' + check_bg_pos + 'px"></div>' + fstack[x]['factor'] + '</div></div>');
			}
			else
			{
				var percentage = 0;
				percentage = 20 + ((total_rated/total_rated_responses - 1) / 4) * 70;	
				percentage = Math.round(percentage);
				
				factor_count++;
				factor_sum += percentage;
				
			$('#report_window').append('<div style="height: 26px"><div style="width: 300px; float: left;"><div class="checkbox" style="margin-right: 5px; background-position: 0px ' + check_bg_pos + 'px"></div>' + fstack[x]['factor'] + '</div><div style="float: right">' + percentage + '%</div></div>');
			}	
		}
		
		var total_percentage = Math.round(factor_sum/factor_count);
		if(total_percentage)
			$('#report_window').append('<div style="height: 26px"><div style="width: 300px; float: left;">Your Case Rating:</div><div class="end_percentage">' + total_percentage + '%</div></div>');
				
		$.post("tracker.php", { type: "RLOAD", time: Math.round(new Date().getTime() / 1000), test_id: test_id} );
				
		//Display results!
		$(".mainframe_left").fadeOut(500, function(){
    		$(".mainframe_right").fadeOut(500, function(){
				$(".result_frame").fadeIn(500, function(){
				});
			});
		});
		$("a[title]").tooltip();
	}
	
	$.fn.getResult = function()
	{
		$(".content").fadeOut(500, function(){
						$(".tooltip").css("display", "none");
						$(".content").empty().append("<img src='loading.gif' id='loading'/>").fadeIn(500);
		});	
		
		$.post("getresults.php",{ sendValue: test_id },
            function(data){
				result_array = data;
				$(this).loadResults();
            }, "json");
	}
	
	$.fn.disableClicks = function()
	{
		$("div[id^='a_']").unbind('click');
		$("div#op_continue").unbind('click');
	}

	function loadChildNode()
	{
		$(".content").fadeOut(500, function(){
						$(".tooltip").css("display", "none");
						$(".content").empty().append("<img src='loading.gif' id='loading'/>").fadeIn(500);
		});
		
		//Redirect to result if empty
		if(astack.length <= 0)
		{
			$(this).getResult();
			return;
		}
		
		
		
		QUNIT = astack[astack.length - 1];
		
		$.post("tracker.php", { type: "QLOAD", time: Math.round(new Date().getTime() / 1000), test_id: test_id, question: String(QUNIT['question'])} );
		
		
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
							to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '"><div class="radiobutton" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
						}
					$(".content").fadeOut(500, function(){
						$(".content").empty().append(to_append).fadeIn(500);
						
						//Show or hide the back button
						if(hstack.length > 0)
							$(".backbutton").fadeIn(500);
						else
							$(".backbutton").fadeOut(500);
							
						//Default the tab selection
						$("#accordion").data("tabs").click(Number(QUNIT['sidepane']));
						
						//Set up click event handlers
						$("div[id^='a_']").click(function() {
							$(this).disableClicks();
							var id = $(this).attr("id").split("_")[1];
							var target = $(this).attr("data-target");
							$("div[id='check_" + id + "']").css("background-position", "0px -17px");
							
							hstack.push(astack.pop());
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
								to_append += '<div class="option" id="a_' + x + '" data-target="' + answer_array[x][1] + '"><div class="checkbox" id="check_' + x + '"></div>&nbsp;<div class="optiontext">' + answer_array[x][0] + '</div></div>';
							}
						}
					
					//to_append += '<div class="option" id="nota"><div class="checkbox" id="nota_check"></div>&nbsp;<div class="optiontext">None of the above</div></div>';
					to_append += '<div class="button_orange_thin" id="op_continue">Continue</div>';
					$(".content").fadeOut(500, function(){
						$(".content").empty().append(to_append).fadeIn(500);
						
						if(hstack.length > 0)
							$(".backbutton").fadeIn(500);
						else
							$(".backbutton").fadeOut(500);
						
						//Default the tab selection
						$("#accordion").data("tabs").click(Number(QUNIT['sidepane']));
						
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
				else if (qtype == "MB")
				{
						
						for(x in answer_array)
						{
							answer_array[x] = answer_array[x].split(',');
							if(answer_array[x][0].length > 20 && answer_array[x][0].indexOf('<br') == -1)
							{
								answer_array[x][0] = String(answer_array[x][0]).replace(" ", "<br />");
							}
							answer_array[x][0] = answer_array[x][0].replace("&#44;", ",");
							answer_array[x][0] = answer_array[x][0].replace("&#39;", "'");
							answer_array[x][0] = answer_array[x][0].replace("&quot;", '"');
							answer_array[x][0] = answer_array[x][0].replace("&sect;", "§");
							answer_array[x][0] = answer_array[x][0].replace("&mdash;", "—");
							answer_array[x][0] = answer_array[x][0].replace("&mdash;", "--");
							answer_array[x][0] = answer_array[x][0].replace("&ndash;", "-");
							to_append += '<div class="link-outer"><div class="link-inner" id="a_' + x + '" data-target="' + answer_array[x][1] + '">' + answer_array[x][0] + '</div></div>';
						}
					$(".content").fadeOut(500, function(){
						$(".content").empty().append(to_append).fadeIn(500);

						if(hstack.length > 0)
							$(".backbutton").fadeIn(500);
						else
							$(".backbutton").fadeOut(500);

						//Default the tab selection
						$("#accordion").data("tabs").click(Number(QUNIT['sidepane']));

						//Resize font if necessary
						for(x in answer_array) 
						{
							if(answer_array[x][0].length <4)
							{
								$('div#a_' + x).css("font-size", "2em");
							}
							else if (answer_array[x][0].length <17)
							{
								$('div#a_' + x).css("font-size", (1.2 + (0.06154 *(17 - answer_array[x][0].length)))+"em");
							}
							else
							{
								$('div#a_' + x).css("font-size", "1.2em");
							}
						}

						//Set up click event handlers
						$("div[id^='a_']").click(function() {
							$(this).disableClicks();
							var id = $(this).attr("id").split("_")[1];
							var target = $(this).attr("data-target");

							hstack.push(astack.pop());		
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
					
					$(".content").fadeOut(500, function(){
						$(".content").empty().append(to_append).fadeIn(500);
						if(hstack.length > 0)
							$(".backbutton").fadeIn(500);
						else
							$(".backbutton").fadeOut(500);
						
						//Default the tab selection
						$("#accordion").data("tabs").click(Number(QUNIT['sidepane']));
						
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
	
							hstack[hstack.length - 1]['user_response'] = this_input;
							hstack[hstack.length - 1]['answer_array'] = answer_array;
	
							//Eat the next item in the stack
							loadChildNode();
						
						});
					});
				}//Ends if loop
				
				$('#tips_blurb').fadeOut(500, function(){
					$('#tips_blurb').empty().append(QUNIT['tips']).fadeIn(500);
				});
				$('#examples_blurb').fadeOut(500, function(){
					$('#examples_blurb').empty().append(QUNIT['examples']).fadeIn(500);	
				});
				$('#explans_blurb').fadeOut(500, function(){
					$('#explans_blurb').empty().append(QUNIT['explans']).fadeIn(500);
				});
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
		$(['/images/main_contact_bar.png','/images/factor_sprites.png','/images/factor_body.png','/loading.gif','/images/main_radiobutton.png','/images/main_checkbox.png','/images/lawyer_stock.jpg','/images/main_contact_chat.png','/images/main_contact_email.png','/images/main_contact_call.png']).preload();
		
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
		
		$('#back_to_test').click(function(){
			if($('.result_frame').css('display') != 'none')
			{
				$(".result_frame").fadeOut(500, function(){
					$(".mainframe_left").fadeIn(500);
					$(".mainframe_right").fadeIn(500);
				});
			}
			
			if(hstack.length <= 0)
				return;
			//You are somewhere in the test, go ahead and pop off
			astack.push(hstack.pop())
			loadChildNode();
		});
		
		$("div#factorleft").hover(function(){
			var currentScroll = $('div.factorbox').scrollLeft();
			if(currentScroll <= 0)
				return;
			else
				$('div.factorbox').animate({scrollLeft: 0}, currentScroll*2);
		}, function(){
			$('div.factorbox').stop().clearQueue();
		});
		
		$("div#factorright").hover(function(){
			var currentScroll = $('div.factorbox').scrollLeft();
			var factorWidth = totalWidth;
			if(currentScroll >= factorWidth)
				return;
			else
				$('div.factorbox').animate({scrollLeft: factorWidth}, (factorWidth-currentScroll)*2);
		}, function(){
			$('div.factorbox').stop().clearQueue();
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
		astack.length = 0;
		hstack.length = 0;
		fstack.length = 0;
		
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
		loadChildNode();
	}
	
	function setupFactors()
	{
		totalWidth = 0;
		
		for(var x = 0; x < fstack.length; x++)
		{
			if(x == 0)
				$('.factorbar').append('<li class="factor" id="factor_' + fstack[x]['factor'] + '"><div class="factor_left_end"></div><div class="factor_body">' + fstack[x]['factor'] + '</div><div class="factor_right"></div></li>');
			else if (x == fstack.length -1)
				$('.factorbar').append('<li class="factor" id="factor_' + fstack[x]['factor'] + '"><div class="factor_left"></div><div class="factor_body">' + fstack[x]['factor'] + '</div><div class="factor_right_end"></div></li>');
			else
				$('.factorbar').append('<li class="factor" id="factor_' + fstack[x]['factor'] + '"><div class="factor_left"></div><div class="factor_body">' + fstack[x]['factor'] + '</div><div class="factor_right"></div></li>');
		}
		
		for(x in fstack)
		{
			totalWidth += $('li[id="factor_' + fstack[x]['factor'] + '"]').outerWidth(true);
		}
		$('.factorwrap').css('width', (totalWidth + 20) + 'px');
		
		$("li[id^='factor_']").hover(function(){
			var this_factor = $(this).attr("id").split("_")[1];
			if(this_factor == current_factor)
				return;
			$("li[id^='factor_"+this_factor+"']").css('color', '#FFF');
			$("li[id^='factor_"+this_factor+"']>div.factor_body").css('background', $('.bottom_nav').css('color'));
			},function(){
			var this_factor = $(this).attr("id").split("_")[1];
			if(this_factor == current_factor)
				return;
			$("li[id^='factor_"+this_factor+"']").css('color', '#000');
			$("li[id^='factor_"+this_factor+"']>div.factor_body").css('background', '#FFF');
		});
		
		$("li[id^='factor_']").click(function() {
						var this_factor = $(this).attr("id").split("_")[1];
						if(this_factor == current_factor)
							return;
						
						hstack.push(astack.pop());	
						
						//Empty the array
						astack.length = 0;
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
						loadChildNode();
					});
	}
	
	$.fn.animateFactor = function(FACTORNAME)
	{
		if(!FACTORNAME)
			return;
		else
		{
			current_factor = FACTORNAME;
			
			//Setup click functions	
					
			$("li[id^='factor_']").css('color', '#000');
			$("li[id^='factor_']>div.factor_body").css('background-color', '#FFF');
			$("li[id^='factor_"+current_factor+"']").css('color', '#FFF');
			$("li[id^='factor_"+current_factor+"']>div.factor_body").css('background', $('.bottom_nav').css('color'));
			
			
			var factorOffset = $("li[id^='factor_"+FACTORNAME+"']").position().left;
			$('div.factorbox').animate({scrollLeft: factorOffset}, 200);
		}
	}
	
	function initialize() {
	geocoder = new google.maps.Geocoder();
  	var myOptions = {
    	zoom: 14,
    	mapTypeId: google.maps.MapTypeId.ROADMAP
  	}
  	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  	codeAddress(street_address);
}

function codeAddress(ADDRESS) {
    //var address = document.getElementById("address").value;
    
	geocoder.geocode( { 'address': ADDRESS}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
		var infowindow = new google.maps.InfoWindow({
		  content: $('#firmname').html()+'<br/>'+street_address.split('|')[0]+'<br/>'+street_address.split('|')[1]
		});
		infowindow.open(map, marker);
      } else {
        //alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }

function loadScript() {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyBo33LwlcRukE9zE594qLrc_ByTc-V9iZ4&sensor=false&callback=initialize";
  document.body.appendChild(script);
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

$(document).ready(function () { 
 	street_address = $('#street_address').html();
	
	$('.contact_button_image').hover(function(){
		var this_image = $(this).attr("id").split("_")[1];
		$(this).clearQueue().animate({
			width: '96px',
			height: '96px',
			'background-size': '96px'
		}, 200);
		$("div[id^='caption_" + this_image + "']").stop().clearQueue().animate({opacity: 0}, 100);
	},function(){
		var this_image = $(this).attr("id").split("_")[1];
		$(this).clearQueue().animate({
			width: '76px',
			height: '76px',
			'background-size': '76px'
		}, 200);
		$("div[id^='caption_" + this_image + "']").stop().clearQueue().animate({opacity: 1.0}, 600);
	});

   $("#accordion").tabs(
    "#accordion div.pane",
    {tabs: 'div.menu_tab', effect: 'slide'}
  );
  
  $("div[rel^='#']").overlay({top: '20%', mask: {
        color: '#000',
        opacity: 0.0
      }, left: 'center'});
  
   $("a[rel^='#overlay_']").overlay({top: '20%', mask: {
        color: '#000',
        opacity: 0.0
      }, left: 'center'});
  /*$("#explans_scrollbar").rangeinput({// slide the DIV along with the range using jQuery's css() method
	onSlide: function(ev, step)  {
		$('#explans_blurb').css({top: step});
	}
  });*/
 
  	// get the src parameter and split it down to the search query string
	var var1 = getUrlVars()["test_id"];

  	if(var1) 
		$(this).firstPage(var1);
	else 
		$(this).firstPage(21);

	window.onbeforeunload = function() {
		 var is_overlay = getUrlVars()["is_overlay"];
		 
		 if(is_overlay)
		 {
			
		 }
		 else
    		return "Leaving this page will cause you to lose your answers.";
	};
	
	$('#map_button').click(function(){
		if(!map)
			loadScript();
		else
			codeAddress(street_address);
	});
	
	$("#result_submit").click(function(){
			$('#result_warning').empty().append('<img src="images/ajax-loader.gif" />');	
			if($("div[id='result_check_answers']").css("background-position") == "0px 0px")
			{
				$('#result_warning').css("color", "#F24122");
				$('#result_warning').empty().append('You must agree to submit your answers');
				return;
			}
			if($("div[id='result_check_terms']").css("background-position") == "0px 0px")
			{
				$('#result_warning').css("color", "#F24122");
				$('#result_warning').empty().append('You must agree to the Terms of Use');
				return;
			}
			$.post("result_submit.php",{ name: $("#field_name").attr("value"), email: $("#field_email").attr("value"), phone: $("#field_phone").attr("value")}, function(data){
				if(String(data) != "")
				{
					$('#result_warning').empty().append(String(data));
					if(String(data) == "Answers submitted! Thank you.")
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
		
	$("#email_submit").click(function(){
			$('#email_warning').empty().append('<img src="images/ajax-loader.gif" />');
			$.post("email_submit.php",{ name: $("#field_overlay_name").attr("value"), email: $("#field_overlay_email").attr("value"), message: $("#field_overlay_message").attr("value")}, function(data){
				if(String(data) != "")
				{
					$('#email_warning').empty().append(String(data));
					if(String(data) == "Message submitted! Thank you.")
					{
						$('#email_warning').css("color", "#27C22F");
						$("#field_overlay_name").attr("value", "");
						$("#field_overlay_email").attr("value", "");
						$("#field_overlay_message").attr("value", "");
					}
					else
					{
						$('#email_warning').css("color", "#F24122");
					}
				}
				});
		});
		
	$("div[id^='result_option_']").click(function() {
		var id = $(this).attr("id").split("_")[2];
		if($("div[id='result_check_" + id + "']").css("background-position") == "0px 0px")
		{
			if(id == "terms" && ($("div[id='overlay_terms']").css("display") != "none" || $("div[id='overlay_privacy']").css("display") != "none"))
				return;
			else
				$("div[id='result_check_" + id + "']").css("background-position", "0px -23px");
		}
		else
		{
			$("div[id='result_check_" + id + "']").css("background-position", "0px 0px");
		}
	});
	
	$("div#close_overlay").click(function(){
		$("a[rel='#overlay_startover']").data("overlay").close();
		$("a[rel='#overlay_gotoresults']").data("overlay").close();
	});
	
	$("div#start_over").click(function(){
		$("a[rel='#overlay_startover']").data("overlay").close();
		$(this).eatStack();
	});
	
	$("div#skip_ahead").click(function(){
		$("a[rel='#overlay_gotoresults']").data("overlay").close();
		hstack.push(astack.pop());	
		$(this).getResult();
	});
	
	$('div#full_report').click(function(){
		var factors = new Array();
		for(x in fstack)
			factors.push(fstack[x]['factor']);
		$('#full_report_factor_list').attr('value', factors.join('|'));
		
		$('#full_report_username').attr('value', $('#username').html());
		
		$('#full_report_history').attr('value', JSON.stringify(hstack));
		document.getElementById('full_report_form').submit();
	});
	
	$.post("tracker.php", { type: "BEGIN", time: Math.round(new Date().getTime() / 1000), test_id: test_id} );
	
});