import * as Blockly from 'blockly/core';
import 'blockly/blocks';
import 'blockly/javascript';
// import * as En from 'blockly/msg/en';
import 'jquery';
import * as $ from 'jquery';
import {createBlocklyBlocks} from '../Game/BlocklyDefinitions';

let workspacePlayground = null;

export { createBlocklyBlocks };

export function createOriginal (){
	var blocklyArea = document.getElementById('blocklyArea');
	var blocklyDiv = document.getElementById('blocklyDiv');
	var demoWorkspace = Blockly.inject(blocklyDiv,
		{media: '../../media/',
			toolbox: document.getElementById('toolbox')});

	var onresize = function(e) {
		// Compute the absolute coordinates and dimensions of blocklyArea.
		var element = blocklyArea;
		var x = 0;
		var y = 0;
		do {
			x += element.offsetLeft;
			y += element.offsetTop;
			element = element.offsetParent;
		} while (element);
		// Position blocklyDiv over blocklyArea.
		blocklyDiv.style.left = x + 'px';
		blocklyDiv.style.top = y + 'px';
		blocklyDiv.style.width = blocklyArea.offsetWidth + 'px';
		blocklyDiv.style.height = blocklyArea.offsetHeight + 'px';
		Blockly.svgResize(demoWorkspace);
	};

	window.addEventListener('resize', onresize, false);

	onresize();

	Blockly.svgResize(demoWorkspace);
}

export function createWorkspacePlayground(blocklyDiv, blocklyArea, startBlocks, config)
{
	workspacePlayground = Blockly.inject(blocklyDiv, config); 

	Blockly.Xml.domToWorkspace(
		Blockly.Xml.textToDom(startBlocks),
		workspacePlayground
	);	

	disableContextMenus();
	scrollWorkspace();

	$(window).resize(() =>     
		onResize(blocklyDiv, blocklyArea)
	);
	onResize(blocklyDiv, blocklyArea);
	

	return workspacePlayground;
}

export function scrollWorkspace()
{
	var metrics = Blockly.mainWorkspace.getMetrics();
	var toolboxWidth = Blockly.mainWorkspace.flyout_.width_;
	var toolboxHeight = Blockly.mainWorkspace.flyout_.height_;

	var newScrollX = ((metrics.contentWidth - metrics.viewWidth) / 2) + (toolboxWidth * 0.8);
	var newScrollY = ((metrics.contentHeight - metrics.viewHeight) / 2) + (toolboxHeight * 0.1);

	Blockly.mainWorkspace.scrollbar.set(newScrollX, newScrollY);

	Blockly.mainWorkspace.scrollX = newScrollX;
	Blockly.mainWorkspace.scrollY = newScrollY;
	Blockly.mainWorkspace.render();
}

export function highlightBlock(id)
{
	workspacePlayground.highlightBlock(id);      
}

export function disableContextMenus()
{

	Blockly.showContextMenu_ = function (e) {
	};
	Blockly.ContextMenu.show = function (e) {
	};
}

export function changeFacingDirectionImage(imageUrl, direction) 
{
	const player = getBlocksByType('playerDirection'); 

	// this.facingDirection = direction; TO DO: change this logic
	// player[0].setFieldValue(app.$global.Url(`game/${direction}.png`), 'facingDirection_image');
}

function getBlocksByType(type)
{
	//one type block only
	var blocks = [];
	for (var blockID in workspacePlayground.blockDB_) 
	{
		if (workspacePlayground.blockDB_[blockID].type == type) {
			blocks.push(workspacePlayground.blockDB_[blockID]);
		}
	}
	return(blocks);
}

function onResize(blocklyDiv, blocklyArea) 
{
	// Compute the absolute coordinates and dimensions of blocklyArea.
	var element = blocklyArea;
	var x = 0;
	var y = 0;
	do {
		x += element.offsetLeft;
		y += element.offsetTop;
		element = element.offsetParent;
	} while (element);
	// Position blocklyDiv over blocklyArea.

	blocklyDiv.style.left = x + 'px';
	blocklyDiv.style.top = y + 'px';
	blocklyDiv.style.width = blocklyArea.offsetWidth + 'px';
	blocklyDiv.style.height = blocklyArea.offsetHeight + 'px';

	Blockly.svgResize(workspacePlayground); // o_O
}