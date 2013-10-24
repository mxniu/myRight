//Default function, assigns new variables...
function ignition()
{
	var gvar = new Array();

	var STATE = $("#state_id").html();
	gvar["STATE"] = STATE;
	
	var sol1=["KY", "LA", "TN"];
	var sol2=["AK", "AZ", "CA", "AL", "VI", "CO", "GA", "KS", "OK", "WV", "CT", "DE", "HI", "IL", "IN", "IA", "ID", "MN", "NV", "NJ", "OH", "OR", "PA", "TX"];
	var sol3=["MS", "NM", "NY", "RI", "SD", "WA", "DC", "MD", "NC", "AR", "MA", "MI", "MT", "NH", "SC", "VT", "WI"];
	var sol4=["FL", "NE", "UT", "WY"];
	var sol5=["MO"];
	var sol6=["ME", "ND"];
	
	if($.inArray(STATE, sol1) >= 0)
	{
		gvar["SOL"] = "year";
	}
	else if($.inArray(STATE, sol2) >= 0)
	{
		gvar["SOL"] = "2 years";
	}
	else if($.inArray(STATE, sol3) >= 0)
	{
		gvar["SOL"] = "3 years";
	}
	else if($.inArray(STATE, sol4) >= 0)
	{
		gvar["SOL"] = "4 years";
	}
	else if($.inArray(STATE, sol5) >= 0)
	{
		gvar["SOL"] = "5 years";
	}
	else
	{
		gvar["SOL"] = "6 years";
	}
	
	//Jurisdictional variable assign
	var comparative = ["KY", "LA", "AK", "AZ", "CA", "MS", "NM", "NY", "RI", "SD", "WA", "FL", "MO"];
	var contributory = ["AL", "DC", "VA", "MD", "NC"];
	var mod50 = ["TN", "CO", "GA", "KS", "OK", "WV", "AR", "NE", "UT", "ME", "ND", "ID"];
	var mod51 = [];
	
	if($.inArray(STATE, comparative) >= 0)
	{
		gvar["THRESHOLD"] = 100;
		gvar["RULEPERCENT"] = 100;
		gvar["RULENAME"] = "pure comparative negligence";
	}
	else if($.inArray(STATE, contributory) >= 0)
	{
		gvar["THRESHOLD"] = 40;
		gvar["RULEPERCENT"] = 0;
		gvar["RULENAME"] = "contributory negligence";
	}
	else if($.inArray(STATE, mod50) >= 0)
	{
		gvar["THRESHOLD"] = 90;
		gvar["RULEPERCENT"] = 50;
		gvar["RULENAME"] = "modified contributory negligence";
	}
	else
	{
		gvar["THRESHOLD"] = 90;
		gvar["RULEPERCENT"] = 51;
		gvar["RULENAME"] = "modified contributory negligence";
	}
	
	/*preload images*/
	$(['/images/brake_sprites.png','/images/traffic_nolight.png','/images/taillight.png','/images/crash_sprites.png','/images/traffic_light.png','/images/scale_left.jpg','/images/scale_right.png','/images/scale_arm.png','/images/scale_base.png','/images/pain5.png','/images/pain4.png','/images/pain3.png','/images/pain2.png','/images/pain1.png']).preload();
	
	return gvar;
}

function custom_selector(SEQ, QUNIT, to_append, answer_array)
{
	switch(SEQ)
	{
	case "1":
	case "2":
		crashType(QUNIT, to_append, answer_array);
		break;
	case "3":
		brakes(QUNIT, to_append, answer_array);
		break;
	case "4":
	case "5":
		taillight(QUNIT, to_append, answer_array);
		break;
	case "6":
		trafficLight(QUNIT, to_append, answer_array);
		break;
	case "7":
	case "10":
		scale(QUNIT, to_append, answer_array);
		break;
	case "23":
		dollarAmounts(QUNIT, to_append, answer_array);
		break;
	case "25":
		recoveryTime(QUNIT, to_append, answer_array);
		break;
	case "26":
		painSuffering(QUNIT, to_append, answer_array);
		break;
	default:
		break;
	}
}

function painSuffering(QUNIT, to_append, answer_array)
{
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	to_append += '<div class="left" style="width: 150px; margin-left: 50px;"><img src="/images/pain3.png" id="rs_image"/></div><div class="right" style="width: 300px"><div style="position: relative"><div style="position: absolute; top: 23px; left: 57px;">1</div><div style="position: absolute; top: 23px; left: 100px;">2</div><div style="position: absolute; top: 23px; left: 145px;">3</div><div style="position: absolute; top: 23px; left: 189px;">4</div><div style="position: absolute; top: 23px; left: 233px;">5</div><input type="range" style="margin-top: 50px" id="rs_slider" min="1" max="5" value="3"></input></div><div class="link-outer" style="margin-top: 30px"><div class="link-inner" id="in_continue">Submit</div></div></div>';
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "600px");
		$("#test_interface").html(to_append).css('margin-top', "25px").fadeIn(500);
		$("#rs_caption").html(answer_array[Number($("#rs_slider").attr("value")) - 1][0]);
		
		$(":range").rangeinput({
			onSlide: function(event, i) {
				$("#rs_image").attr("src", "/images/pain" + Number(i) + ".png");
			}
		});
		
		$("#rs_slider").change(function(){
			//$("#rs_caption").html(answer_array[Number($("#rs_slider").attr("value")) - 1][0]);
			$("#rs_image").attr("src", "/images/pain" + (Number($("#rs_slider").attr("value"))) + ".png");
		});
		
		//Set up click event handlers
		$("#in_continue").click(function() {
			var this_input = $('input#rs_slider').attr("value");
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			//var user_responses = new Array();
			
			clearPath(answer_array);
			
			var temp_aa = $.extend(true, [], answer_array[Number(this_input) - 1]);
			var target = temp_aa[1];
			var var_assign = temp_aa[3];
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);	
			
			//Eat the next item in the stack
			loadChildNode();
		
		});
	});
}

function scale(QUNIT, to_append, answer_array)
{
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	to_append += '<div class="left" style="position: relative; width: 150px; height: 300px; margin-left: 50px; display: block;"><div style="position: absolute; z-index: 0; top: 3px; left: 58px; background: url(/images/scale_base.png); width:104px;height:240px" id="scale_base"></div><div style="position: absolute; z-index: 10; top: 0px; left: 0px; background: url(/images/scale_arm.png); width:216px;height:48px;" id="scale_arm"></div><div style="position: absolute; z-index: 0; top: 30px; left: -40px; background: url(/images/scale_left.png); width:103px;height:108px" id="scale_left"></div><div style="position: absolute; z-index: 0; top: 30px; left: 155px; background: url(/images/scale_right.png); width:103px;height:108px" id="scale_right"></div></div><div class="right" style="width: 300px"><div id="rs_caption" style="font-size: 1.5em; width: 100%; text-align: center;">50%</div>';
	to_append += '<div style="position: relative"><div style="position: absolute; top: 23px; left: 53px;">0%</div><div style="position: absolute; top: 23px; left: 135px;">50%</div><div style="position: absolute; top: 23px; left: 220px;">100%</div><input type="range" style="margin-top: 50px" id="rs_slider" min="0" max="100" value="50"></input></div><div class="link-outer" style="margin-top: 30px"><div class="link-inner" id="in_continue">Submit</div></div></div>';
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "600px");
		$("#test_interface").html(to_append).css('margin-top', "25px").fadeIn(500);
		//$("#rs_caption").html(answer_array[Number($("#rs_slider").attr("value")) - 1][0]);
		
		$(":range").rangeinput({
			onSlide: function(event, i) {
				var this_value = i;

				$("#rs_caption").html(this_value + "%");
				
				$("#scale_arm").css("-webkit-transform", "rotate(" + ((this_value - 50) / 3) + "deg)");
				$("#scale_arm").css("-o-transform", "rotate(" + ((this_value - 50) / 3) + "deg)");
				$("#scale_arm").css("-moz-transform", "rotate(" + ((this_value - 50) / 3) + "deg)");
				$("#scale_arm").css("transform", "rotate(" + ((this_value - 50) / 3) + "deg)");
				
				$("#scale_arm").css("left", ((this_value - 50) * -1 / 10) + "px" );
				
				$("#scale_left").css("top", ((this_value - 110) * -1 / 2) + "px" );
				$("#scale_right").css("top", ((this_value + 10) / 2) + "px" );
				if(this_value <= 50)
				{
					$("#scale_left").css("left", ((this_value + 110) * -1 / 4) + "px" );
					$("#scale_right").css("left", ((this_value - 825) * -1 / 5) + "px" );
				}
				else
				{
					$("#scale_left").css("left", ((this_value + 140) * -1 / 5) + "px" );
					$("#scale_right").css("left", ((this_value - 670) * -1 / 4) + "px" );
				}
			}
		});
		
		$("#rs_slider").change(function(){
			var this_value = Number($("#rs_slider").attr("value"));
			/*if(this_value < 25)
				$("#rs_caption").html("Mostly My Fault");
			else if(this_value < 50)
				$("#rs_caption").html("Partially My Fault");
			else if(this_value === 50)
				$("#rs_caption").html("Equal Fault");
			else if(this_value < 75)
				$("#rs_caption").html("Partially Their Fault");
			else
				$("#rs_caption").html("Mostly Their Fault");*/
			$("#rs_caption").html(this_value + "%");
			
			$("#scale_arm").css("-webkit-transform", "rotate(" + ((this_value - 50) / 3) + "deg)");
			$("#scale_arm").css("left", ((this_value - 50) * -1 / 10) + "px" );
			
			$("#scale_left").css("top", ((this_value - 110) * -1 / 2) + "px" );
			$("#scale_right").css("top", ((this_value + 10) / 2) + "px" );
			if(this_value <= 50)
			{
				$("#scale_left").css("left", ((this_value + 110) * -1 / 4) + "px" );
				$("#scale_right").css("left", ((this_value - 825) * -1 / 5) + "px" );
			}
			else
			{
				$("#scale_left").css("left", ((this_value + 140) * -1 / 5) + "px" );
				$("#scale_right").css("left", ((this_value - 670) * -1 / 4) + "px" );
			}
		});
		
		//Set up click event handlers
		$("#in_continue").click(function() {
			var this_input = $('input#rs_slider').attr("value");
			$(this).disableClicks();
			
			hstack.push(astack.pop());
			//var user_responses = new Array();

			clearPath(answer_array);
			
			var temp_aa = $.extend(true, [], answer_array[0]);
			var target = temp_aa[1];
			var var_assign = temp_aa[3];
			
			//replace prenamed vars with inputs
			var_assign = var_assign.replace('{1}', this_input);
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);
			
			//Eat the next item in the stack
			loadChildNode();
		
		});
	});
}

function crashType(QUNIT, to_append, answer_array)
{
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	to_append += '<div style="display: inline-block; margin: 6px 12px; background: url(/images/crash_sprites.png) 0 0 no-repeat; height: 154px; width: 154px; cursor: pointer;" id="crash_rearend"></div>';
	to_append += '<div style="display: inline-block; margin: 6px 12px; background: url(/images/crash_sprites.png) 0 -154px no-repeat; height: 154px; width: 154px; cursor: pointer;" id="crash_leftturn"></div>';
	//to_append += '<div class="clear"></div>';
	to_append += '<div style="display: inline-block; margin: 6px 12px; background: url(/images/crash_sprites.png) 0 -308px no-repeat; height: 154px; width: 154px; cursor: pointer;" id="crash_drunk"></div>';
	to_append += '<div style="display: inline-block; margin: 6px 12px; background: url(/images/crash_sprites.png) 0 -462px no-repeat; height: 154px; width: 154px; cursor: pointer;" id="crash_none"></div>';
	to_append += '<div class="clear"></div>';
	to_append += '<div id="caption" style="font-size: 1.5em;">&nbsp;</div>';
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "800px");
		$("#test_interface").html(to_append).css('margin-top', "25px").fadeIn(500);
		
		$("#crash_rearend").hover(function(){
			$("#crash_rearend").css("background-position", "-154px 0");
			$("#caption").html("Rear-ended by other driver");
		},function(){
			$("#crash_rearend").css("background-position", "0 0");
			$("#caption").html("&nbsp;");
		});
		$("#crash_drunk").hover(function(){
			$("#crash_drunk").css("background-position", "-154px -308px");
			$("#caption").html("Other Driver was Intoxicated");
		},function(){
			$("#crash_drunk").css("background-position", "0 -308px");
			$("#caption").html("&nbsp;");
		});
		$("#crash_leftturn").hover(function(){
			$("#crash_leftturn").css("background-position", "-154px -154px");
			$("#caption").html("Other Driver was making a left turn");
		},function(){
			$("#crash_leftturn").css("background-position", "0 -154px");
			$("#caption").html("&nbsp;");
		});
		$("#crash_none").hover(function(){
			$("#crash_none").css("background-position", "-154px -462px");
			$("#caption").html("Other");
		},function(){
			$("#crash_none").css("background-position", "0 -462px");
			$("#caption").html("&nbsp;");
		});
		
		//Set up click event handlers
		$("div[id^='crash_']").click(function() {
			$(this).disableClicks();
			//$("#traffic_red").unbind("hover");
			var id = $(this).attr("id").split("_")[1];
			
			hstack.push(astack.pop());
			
			clearPath(answer_array);
		
			var temp_aa;
			if(id === "rearend")
			{
				temp_aa = $.extend(true, [], answer_array[0]);
			}
			else if(id === "leftturn")
			{
				temp_aa = $.extend(true, [], answer_array[1]);
			}
			else if(id === "drunk")
			{
				temp_aa = $.extend(true, [], answer_array[2]);
			}
			else if(id === "none")
			{
				temp_aa = $.extend(true, [], answer_array[3]);
			}
			
			var target = temp_aa[1];
			var var_assign = temp_aa[3];
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);				

			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function trafficLight(QUNIT, to_append, answer_array)
{
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	to_append += '<div style="position: relative; margin: 0 auto; background: url(/images/traffic_light.png) 0 0; height: 91px; width: 100px; cursor: pointer;" id="traffic_red"><div class="hidden" style="background: #FF0000; position: absolute; top: 13px; left: 16px; height: 68px; width: 68px; border-radius: 48px; box-shadow: 0px 0px 40px #950000 inset, 0px 0px 40px #FF0000;"></div></div><div style="position: relative; margin: 0 auto; background: url(/images/traffic_light.png) 0 -91px; height: 91px; width: 100px; cursor: pointer;" id="traffic_yellow"><div class="hidden" style="background: #FFFF00; position: absolute; top: 13px; left: 16px; height: 68px; width: 68px; border-radius: 48px; box-shadow: 0px 0px 40px #656500 inset, 0px 0px 40px #FFFF00;"></div></div><div style="position: relative; margin: 0 auto; background: url(/images/traffic_light.png) 0 -183px; height: 92px; width: 100px; cursor: pointer;" id="traffic_green"><div class="hidden" style="background: #00FF00; position: absolute; top: 11px; left: 17px; height: 68px; width: 68px; border-radius: 48px; box-shadow: 0px 0px 40px #004500 inset, 0px 0px 40px #00FF00;"></div></div>';
	to_append += '<div style="background: url(/images/traffic_nolight.png); height: 100px; width: 100px; cursor: pointer; margin: 15px auto 0;" id="traffic_none"></div>';
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "600px");
		$("#test_interface").html(to_append).css('margin-top', "25px").fadeIn(500);

		$("#traffic_red").hover(function(){
			$("#traffic_red>div").removeClass("hidden");
		}, function(){
			$("#traffic_red>div").addClass("hidden");
		});
		$("#traffic_yellow").hover(function(){
			$("#traffic_yellow>div").removeClass("hidden");
		}, function(){
			$("#traffic_yellow>div").addClass("hidden");
		});
		$("#traffic_green").hover(function(){
			$("#traffic_green>div").removeClass("hidden");
		}, function(){
			$("#traffic_green>div").addClass("hidden");
		});
		$("#traffic_none").hover(function(){
			$("#traffic_none").css("background-position", "0 -100px");
		}, function(){
			$("#traffic_none").css("background-position", "0 0");
		});
		
		//Set up click event handlers
		$("div[id^='traffic_']").click(function() {
			$(this).disableClicks();
			$("#traffic_red").unbind("hover");
			$("#traffic_yellow").unbind("hover");
			$("#traffic_green").unbind("hover");
			var id = $(this).attr("id").split("_")[1];
			
			hstack.push(astack.pop());
			
			clearPath(answer_array);
		
			var temp_aa;
			if(id === "red")
			{
				temp_aa = $.extend(true, [], answer_array[2]);
			}
			else if(id === "yellow")
			{
				temp_aa = $.extend(true, [], answer_array[1]);
			}
			else if(id === "green")
			{
				temp_aa = $.extend(true, [], answer_array[0]);
			}
			else if(id === "none")
			{
				temp_aa = $.extend(true, [], answer_array[3]);
			}
			
			var target = temp_aa[1];
			var var_assign = temp_aa[3];
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);				

			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function taillight(QUNIT, to_append, answer_array)
{
	to_append += '<div style="margin: 10px auto; position: relative; background: url(/images/taillight.png); height: 98px; width: 150px;">';
	to_append += '<div style="background: #FF4760; position: absolute; top: 34px; left: 108px; height: 12px; width: 12px; border-radius: 12px; box-shadow: 0px 0px 10px #CC0000 inset, 0px 0px 16px 8px #FF3333;" id="taillight_left"></div>';
	to_append += '<div style="background: #FF4760; position: absolute; top: 34px; left: 30px; height: 12px; width: 12px; border-radius: 12px; box-shadow: 0px 0px 10px #CC0000 inset, 0px 0px 16px 8px #FF3333;" id="taillight_right"></div>';
	to_append += '</div>';
	
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
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "600px");
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

		//Set Hover States
		$("#a_1").hover(function(){
			$("#taillight_left").addClass("hidden");
		}, function(){
			$("#taillight_left").removeClass("hidden");
		});
		$("#a_2").hover(function(){
			$("#taillight_left").addClass("hidden");
			$("#taillight_right").addClass("hidden");
		}, function(){
			$("#taillight_left").removeClass("hidden");
			$("#taillight_right").removeClass("hidden");
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
			
			hstack.push(astack.pop());
				
			clearPath(answer_array);
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);				

			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function brakes(QUNIT, to_append, answer_array)
{
	to_append += '<div style="margin: 10px auto; position: relative; background: url(/images/brake_sprites.png) no-repeat 0 -113px; height: 113px; width: 150px;" id="brakes"></div>';
	
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
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "600px");
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

		//Set Hover States
		$("#a_0").hover(function(){
			$("#brakes").css("background-position", "0 -226px");
		}, function(){
			$("#brakes").css("background-position", "0 -113px");
		});
		$("#a_1").hover(function(){
			$("#brakes").css("background-position", "0 0");
		}, function(){
			$("#brakes").css("background-position", "0 -113px");
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
			
			hstack.push(astack.pop());
				
			clearPath(answer_array);
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);				

			//Eat the next item in the stack
			loadChildNode();
		});
	});
}

function recoveryTime(QUNIT, to_append, answer_array)
{
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
	}
	to_append += '<div class="left" style="position: relative; width: 250px; height: 300px; margin-left: 40px; display: block;">';
	
	to_append += '<div style="height: 250px; width: 220px; border-radius: 10px; box-shadow:5px 5px 5px #999, 0px 0px 15px #CCC inset; background: url(/images/paper_texture.png) repeat;"><div style="padding-top: 5px; height: 45px; border-radius: 10px 10px 0 0; background: #bf1e2e; border-bottom: 3px solid #8c180f; box-shadow: 0px 1px 3px rgba(000,000,000,0.5), inset -1px 15px 19px rgba(218,126,133,1); color: #fff; text-align: center; font-size: 2em; font-weight: bold" id="month_label">Months</div><div id="month_count" style="padding-top: 50px; font-size: 5em;">&le;1</div></div>';
	
	to_append += '</div>';
	to_append += '<div class="right" style="width: 300px"><div style="position: relative;"><div style="position: absolute; top: 23px; left: 30px;">&le;1 month</div><div style="position: absolute; top: 23px; left: 204px;">6+ months</div><input type="range" style="margin-top: 50px;" id="red_cross_slider" min="0" max="3" value="0"></input></div><div class="link-outer" style="margin-top: 30px"><div class="link-inner" id="in_continue">Submit</div></div></div>';
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "600px");
		$("#test_interface").html(to_append).css('margin-top', "25px").fadeIn(500);

		$(":range").rangeinput({
			onSlide: function(event, i) {
				var this_value = i;
			
				if(this_value === 0)
				{
					$("#month_label").html("Month");
					$("#month_count").html("&le;1");
				}
				else if(this_value === 1)
				{
					$("#month_label").html("Months");
					$("#month_count").html("1-3");
				}
				else if(this_value === 2)
				{
					$("#month_label").html("Months");
					$("#month_count").html("4-6");
				}
				else if(this_value === 3)
				{
					$("#month_label").html("Months");
					$("#month_count").html("6+");
				}
			}
		});
		
		$("#red_cross_slider").change(function(){
			var this_value = Number($("#red_cross_slider").attr("value"));
			
			if(this_value === 0)
			{
				$("#month_label").html("Month");
				$("#month_count").html("&le;1");
			}
			else if(this_value === 1)
			{
				$("#month_label").html("Months");
				$("#month_count").html("1-3");
			}
			else if(this_value === 2)
			{
				$("#month_label").html("Months");
				$("#month_count").html("4-6");
			}
			else if(this_value === 3)
			{
				$("#month_label").html("Months");
				$("#month_count").html("6+");
			}
		});
		
		//Set up click event handlers
		$("#in_continue").click(function() {
			var this_input = $('input#red_cross_slider').attr("value");
			$(this).disableClicks();
			
			hstack.push(astack.pop());

			clearPath(answer_array);
			
			var temp_aa = $.extend(true, [], answer_array[Number(this_input)]);
			var target = temp_aa[1];
			var var_assign = temp_aa[3];
			
			//If targeted, go to target and assign variable downstream
			if(target)
				pushSingleTarget(target, var_assign);
			//Else assign the variable anyway, if exists
			else if(var_assign)
				assignSingleVar(var_assign);
			
			//Eat the next item in the stack
			loadChildNode();
		
		});
	});
}

function dollarAmounts(QUNIT, to_append, answer_array)
{
	//Yellow notepad start
	to_append += '<div style="height: 370px; width: 400px; -moz-border-radius: 8px; -webkit-border-radius: 8px; border-radius: 8px; margin: 0 auto; background: url(/images/yellow_pad.png); position: relative; box-shadow: 0 0 10px #CCC; border: 1px solid #DDD">';
	//Red line
	to_append += '<div style="position: absolute; height: 318px; width: 1px; top: 52px; left: 67px; background: rgba(255, 0, 72, 0.4)"></div>';
	to_append += '<div style="position: absolute; height: 318px; width: 1px; top: 52px; left: 65px; background: rgba(255, 0, 72, 0.4)"></div>';
	//Blue lines...
	to_append += '<div style="position: absolute; width: 400px; height: 1px; top: 114px; left: 0; background: rgba(74, 154, 255, 0.4)"></div>';
	to_append += '<div style="position: absolute; width: 400px; height: 1px; top: 162px; left: 0; background: rgba(74, 154, 255, 0.4)"></div>';
	to_append += '<div style="position: absolute; width: 400px; height: 1px; top: 210px; left: 0; background: rgba(74, 154, 255, 0.4)"></div>';
	to_append += '<div style="position: absolute; width: 400px; height: 1px; top: 258px; left: 0; background: rgba(74, 154, 255, 0.4)"></div>';to_append += '<div style="position: absolute; width: 400px; height: 1px; top: 306px; left: 0; background: rgba(74, 154, 255, 0.4)"></div>';
	to_append += '<div style="position: absolute; width: 400px; height: 1px; top: 354px; left: 0; background: rgba(74, 154, 255, 0.4)"></div>';
	//Heading section...
	to_append += '<div style="padding-top: 8px; height: 42px; border-radius: 8px 8px 0 0; background: #8c5e3d; border-bottom: 2px solid #573924; box-shadow:  0px 1px 3px rgba(000,000,000,0), inset 0px 7px 6px rgba(195,170,153,0.7); color: #fff; text-align: center; font-size: 1.7em; font-weight: bold; margin-bottom: 15px;">Cost of Accident</div>';
	for(x in answer_array)
	{
		answer_array[x] = answer_array[x].split(',');
		to_append += '<div id="prompt_'+ x + '" style="text-align: left; display: inline-block; width: 100px; margin-top: 10px; color: #000">'+ answer_array[x][0] +'</div>&#36;<input type="number" class="biginput" style="display: inline-block; margin-top: 10px; margin-left: 5px; border: none; border-bottom: 2px solid #333; box-shadow: none; background: rgba(255, 0, 72, 0.2); border-radius: 0; color: #000; padding-top: 6px; padding-bottom: 0px; box-shadow: inset 0px 0px 20px rgba(127, 0, 36, 0.3);" id="a_'+ x + '" data-target="' + answer_array[x][1] + '" data-tag="' + answer_array[x][2] + '" data-var="' + answer_array[x][3] + '" maxlength=10 value="0"/><div class="clear"></div>';
	}
	to_append += '<div class="warning_message" id="input_warning">&nbsp;</div>'
	to_append += '<div class="link-outer" style="position: relative; z-index: 100"><div class="link-inner" id="in_continue">Submit</div></div>';
	to_append += '</div>';
	
	$("#test_interface").fadeOut(500, function(){
		$("#beta_box").css("width", "600px");
		$("#test_interface").empty().append(to_append).css('margin-top', "25px").fadeIn(500);
		
		$("#a_0").focus(function(){
			$("#a_0").css("background", "none");
		});
		$("#a_0").blur(function(){
			$("#a_0").css("background", "rgba(0, 255, 0, 0.3)");
			$("#a_0").css("box-shadow", "inset 0 0 20px rgba(0, 127, 14, 0.4)");
		});
		$("#a_1").focus(function(){
			$("#a_1").css("background", "none");
		});
		$("#a_1").blur(function(){
			$("#a_1").css("background", "rgba(0, 255, 0, 0.3)");
			$("#a_1").css("box-shadow", "inset 0 0 20px rgba(0, 127, 14, 0.4)");
		});
		$("#a_2").focus(function(){
			$("#a_2").css("background", "none");
		});
		$("#a_2").blur(function(){
			$("#a_2").css("background", "rgba(0, 255, 0, 0.3)");
			$("#a_2").css("box-shadow", "inset 0 0 20px rgba(0, 127, 14, 0.4)");
		});
		$("#a_3").focus(function(){
			$("#a_3").css("background", "none");
		});
		$("#a_3").blur(function(){
			$("#a_3").css("background", "rgba(0, 255, 0, 0.3)");
			$("#a_3").css("box-shadow", "inset 0 0 20px rgba(0, 127, 14, 0.4)");
		});
		
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
			
			//Eat the next item in the stack
			loadChildNode();
		});
	});
}