//MODEL
var DEFAULT_MODEL_JSON = 
'{'+
'	"step" : 1.0,'+
'	"transition": "LINEAR",'+
'	"sequences": ['+
'		[[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0]],'+
'		[[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0]],'+
'		[[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0]],'+
'		[[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0]],'+
'		[[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0]],'+
'		[[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0]],'+
'		[[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0]],'+
'		[[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0]]'+
'	]'+
'}';

var models = [];

var modelFormId = null;

function loadModel(modelObj,modelIndex)
{
	if(modelObj.value == "")
	{
		models[modelIndex] = JSON.parse(DEFAULT_MODEL_JSON);
	}
	else
	{
		models[modelIndex] = JSON.parse(modelObj.value);
	}
}

function saveModel(modelObj,modelIndex)
{
	modelObj.value = JSON.stringify(models[modelIndex]);
}

var SELECTABLE_COLORS = [
	{name: "red",
	value: [255,0,0]},
	{name: "yellow",
	value: [255,255,0]},
	{name: "green",
	value: [0,255,0]},
	{name: "cyan",
	value: [0,255,255]},
	{name: "blue",
	value: [0,0,255]},
	{name: "magenta",
	value: [255,0,255]},
	{name: "white",
	value: [255,255,255]},
	{name: "black",
	value: [0,0,0]}
];

function cancel(modelObj)
{
	loadModel(modelObj,0);
}
function save(modelObj)
{
	saveModel(modelObj,0);
	document.forms[modelFormId].submit();
}
function setTransition(transition,modelIndex)
{
	//update model
	models[modelIndex]["transition"]=transition;
	//update view
	$('.transitioncell').removeClass("selected");
	$('.transitioncell>.radiox').removeClass("fui-radio-checked");
	$(".transitioncell-"+transition).addClass("selected");
	$('.transitioncell-'+transition+'>.radiox').addClass("fui-radio-checked");
}
function setPeriod(period,modelIndex)
{
	//update model
	models[modelIndex]["step"]=period;
	//update view
	$('.periodcell').removeClass("selected");
	$('.periodcell>span').removeClass("fui-radio-checked");
	$(".periodcell-"+(Math.floor(period*1000))).addClass("selected");
	$('.periodcell-'+(Math.floor(period*1000))+'>span').addClass("fui-radio-checked");
}

function readTransition(modelIndex)
{
	setTransition(models[modelIndex]["transition"],modelIndex);
}
function readPeriod(modelIndex)
{
	setPeriod(models[modelIndex]["step"],modelIndex);
}

var selectedColor;

function setColor(selectableColor)
{
	//Update the view
	$('.colorcell').removeClass("selected");
	$('.colorcell>span').removeClass("fui-radio-checked");
	$('.colorcell-'+selectableColor["name"]).addClass("selected");
	$('.colorcell-'+selectableColor["name"]+'>span').addClass("fui-radio-checked");
	//Update the state
	selectedColor = selectableColor;
}
function updateCell(index,lightIndex,modelIndex)
{
	//read from model
	var curColor = models[modelIndex]["sequences"][lightIndex][index];
	//read from state
	var newColor = selectedColor["value"];
	//combine
	if(isColorMatch(curColor,newColor))
		newColor = muteColor(curColor);
	var cssVal = "#"+hex(newColor[0])+hex(newColor[1])+hex(newColor[2]);
	//update view
	$(".maincell-"+index+"-"+lightIndex).css("color",cssVal);
	//update model
	models[modelIndex]["sequences"][lightIndex][index] = newColor;
}
function hex(v)
{
	var r = "";
	if(v<16)r="0";
	r += v.toString(16);
	return r;
}
function isColorMatch(curColor,newColor)
{
	for(i = 0; i < 3; i++)
	{
		if((curColor[i] == 0 && newColor[i] > 0) ||
		   (curColor[i] > 0 && newColor[i] == 0))
			return false;
	}
	return true;
}
function muteColor(color)
{
	var r = [0,0,0];
	for(i = 0; i < 3; i++)
	{
		r[i] = Math.floor(color[i]/2);
		if(r[i] <20)
			r[i] = 0
//		r[i] = Math.max(color[i]-64,0);
	}
	return r;
}

function generateVisualTable (obj,suffix,modelIndex) {
	var table = $('<table style="width:100%"></table>').addClass('editorTable');
	var row = $('<tr></tr>').addClass('editorRow');
	for(var colI = 0; colI < 12; colI++)
	{
		var cell = generateVisualCell(0,colI,suffix,modelIndex);
		if(cell) row.append(cell);
	}
	table.append(row);
	obj.append(table);
	//console.log(table);
}


function generateVisualCell(row,col,suffix,modelIndex)
//callbacks required: save, cancel, setTransition
//or instead of callbacks we could use IDs and have a decorator tie the input to the controller

//callbacks tied to these objects: setLightColor, setIndex
{
	var cell = $('<td style="padding:2px"></td>');
	if(row == 0 && col >= 0 && col <= 7) //light cell
	{
		var button = $('<a href="#fakelink" class="btn btn-block btn-lg btn-primary">&nbsp;</a>');
		var lightIndex = col;
		button.addClass("lightcell");
		button.addClass("lightcell"+suffix+"-"+lightIndex);
		cell.append(button);
	}
	else
	{
		//pass
	}

	return cell;
}

function generateEditorTable (obj,modelObj,suffix,modelIndex) {
	var table = $('<table style="width:100%"></table>').addClass('editorTable');
	for(var rowI = 0; rowI < 12; rowI++)
	{
		var row = $('<tr></tr>').addClass('editorRow');
		for(var colI = 0; colI < 12; colI++)
		{
			var cell = generateEditorCell(rowI,colI,modelObj,suffix,modelIndex);
			if(cell) row.append(cell);
		}
		table.append(row);
	}
	obj.append(table);
	console.log(table);
}

function generateEditorCell(row,col,modelObj,suffix,modelIndex)
//callbacks required: save, cancel, setTransition
//or instead of callbacks we could use IDs and have a decorator tie the input to the controller

//callbacks tied to these objects: setLightColor, setIndex
{
	var cell = $('<td style="padding:2px"></td>');
	if(row == 0 && col == 2) //cancel button
	{
		var button = $('<a href="#fakelink" class="btn btn-block btn-lg btn-danger"><span class="fui-cross"></span></a>');
		cell.attr('colspan',2);
		//TODO: set class
		button.click(function(){cancel(modelObj)});
		cell.append(button);
	}
	if(row == 0 && (col == 3 || col == 9)){ //blank space
		return null;
	}
	else if(row == 0 && col == 8)//save button
	{
		var button = $('<a href="#fakelink" class="btn btn-block btn-lg btn-success"><span class="fui-check"></span></a>');
		cell.attr('colspan',2);
		//TODO: set class
		cell.click(function(){save(modelObj)});
		cell.append(button);
	}
	else if(row == 2 && col >= 2 && col <= 9) //light cell
	{
		var button = $('<a href="#fakelink" class="btn btn-block btn-lg btn-primary">&nbsp;</a>');
		var lightIndex = col - 2;
		button.addClass("lightcell");
		button.addClass("lightcell"+suffix+"-"+lightIndex);
		cell.append(button);
	}
	else if(row >= 4 && row <=6 && col == 0) //transition cell
	{
		var button = $('<a href="#fakelink" class="btn btn-block btn-lg btn-primary"><span class="fui-radio-unchecked radiox"></span> </a>');
		var transition = "STEP";
		if(row == 4){
			button.append("<span style='font-size:large'>&#8851;</span>");
		}
		if(row == 5){
			transition = "LINEAR";
			button.append("<span style='font-size:large'>&#8896;</span>");
		}
		if(row == 6){
			transition = "SIN";
			button.append("<span style='font-size:large'>&#8767;</span>");
		}
		button.addClass("transitioncell");
		button.addClass("transitioncell-"+transition);
		button.click(function(){setTransition(transition,modelIndex)}); //TODO: check syntax for closure
		cell.append(button);
	}
	else if(row >= 8 && col == 0) //Period cell
	{
		var button = $('<a href="#fakelink" class="btn btn-block btn-lg btn-primary"><span class="fui-radio-unchecked"></span> </a>');
		var period = 0.5;
		if(row == 8){
			button.append("&#189;");
		}
		if(row == 9){
			period = 1;
			button.append(1);
		}
		if(row == 10){
			period = 2;
			button.append(2);
		}
		if(row == 11){
			period = 5;
			button.append(5);
		}
		//button.append('');
		button.addClass("periodcell");
		button.addClass("periodcell-"+(Math.floor(period*1000)));
		button.click(function(){setPeriod(period,modelIndex)});//TODO: check closure syntax
		//cell.text("P"+period);
		cell.append(button);
	}
	else if(row >= 4 && col == 11) //Color cell
	{
		var button = $('<a href="#fakelink" class="btn btn-block btn-lg"><span class="fui-radio-unchecked"></span></a>');
		var colorIndex = row - 4;
		var selectableColor = SELECTABLE_COLORS[colorIndex];
		button.addClass("colorcell");
		button.addClass("colorcell-"+selectableColor["name"]);
		button.click(function(){setColor(selectableColor)});
		cell.append(button);
	}
	else if(row >= 4 && col >= 2 && col <= 9)//main cell
	{
		var button = $('<a href="#fakelink" class="btn btn-block btn-lg"><span class="fui-checkbox-unchecked"></span></a>');
		var index = row - 4;
		var lightIndex = col - 2;
		button.addClass("maincell");
		button.addClass("maincell-"+index);
		button.addClass("maincell-"+index+"-"+lightIndex);
		button.click(function(){updateCell(index,lightIndex,modelIndex)});//TODO: check closure Syntax
		//button.text(index+"x"+lightIndex);
		cellColor = models[modelIndex]["sequences"][lightIndex][index];
		var cssVal = "#"+hex(cellColor[0])+hex(cellColor[1])+hex(cellColor[2]);
		//update view
		button.css("color",cssVal);
		cell.append(button);
	}
	else
	{
		//pass
	}

	return cell;
}

var controlLoopPeriod = 0.1;

function iteration(suffix,modelIndex)
{
	var t = (new Date()).getTime();
	updateLights(suffix,modelIndex);
	setTimeout(function(){iteration(suffix,modelIndex)},controlLoopPeriod*1000-(new Date()).getTime()+t);
}

var timeNow = null;

var globalIndex = 0;

function incrIndex(modelIndex)
{
	globalIndex += 1;
	if(globalIndex >= 8)
	{
		globalIndex = 0;
	}

	$(".maincell").addClass("inactivecell");
	$(".maincell"+globalIndex).removeClass("activecell");
	$(".maincell-"+globalIndex).removeClass("inactivecell");
	$(".maincell-"+globalIndex).addClass("activecell");

	for(var row = 0; row < 8; row++)
	{
		for(var col = 0; col < 8; col++)
		{
			if(row == globalIndex)
			{
				$(".maincell-"+row+"-"+col).css('color','#ECF0F1');
				$(".maincell-"+row+"-"+col).css('background-color',models[modelIndex]["sequences"][col][row]);
			}
			else
			{
				$(".maincell-"+row+"-"+col).css('background-color','#ECF0F1');
				$(".maincell-"+row+"-"+col).css('color',models[modelIndex]["sequences"][col][row]);
			}
		}
	}
}

function updateLights(suffix,modelIndex)
{
	var t = (new Date()).getTime();
	var d = null;
	if(timeNow == null)
	{
		d = 0;
		timeNow = t;
	}
	else
	{
		d = t - timeNow;
		if(d > models[modelIndex]["step"]*1000)
		{
			timeNow = t;
			d = 0;
			incrIndex(modelIndex);
		}
	}
	f = (1.0*d)/models[modelIndex]["step"];
	for( i = 0; i < 8; i++)
	{
		//console.log(i);
		var updateColour = genUpdateColour(f,
			models[modelIndex]["transition"],
			models[modelIndex]["sequences"][i][globalIndex],
			models[modelIndex]["sequences"][i][(globalIndex == 7)?0:(globalIndex+1)]);
		updateLight(i,updateColour,suffix);
	}
}

function updateLight(index,updateColour,suffix)
{
	//console.log(updateColour);
	var cssVal = "#"+hex(updateColour[0])+hex(updateColour[1])+hex(updateColour[2]);
	$(".lightcell"+suffix+"-"+index).css("background-color",cssVal);
}

function genUpdateColour(f,transition,current,next)
{
	updateColour = [0,0,0];
	f=f*1.0/1000;
	//console.log(f);
	if(transition == "LINEAR")
	{
		for(j = 0; j < 3; j++)
		{
			updateColour[j] = Math.round(current[j]*(1.0-f)+next[j]*f);
		}
		return updateColour;
	}
	if(transition == "SIN")
	{
		var x = (Math.cos(f*Math.PI)+1)/2;
		for(j = 0; j < 3; j++)
		{
			updateColour[j] = Math.round(current[j]*x+next[j]*(1.0-x));
		}
		return updateColour;
	}
	return current;
}

function initEditor(jsonObj, tableContainer, formId)
{
	loadModel($(jsonObj)[0],0);
	console.log(models[0]);
	generateEditorTable($(tableContainer),$(jsonObj)[0],"",0);
	setColor(SELECTABLE_COLORS[0]);
	readTransition(0);
	readPeriod(0);
	iteration("",0);
	modelFormId = formId;
}