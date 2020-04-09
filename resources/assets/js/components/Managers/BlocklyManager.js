import * as Blockly from 'blockly/core';
import 'blockly/blocks';
import 'blockly/javascript';
// import * as En from 'blockly/msg/en';
import * as $ from 'jquery';
import {createBlocklyBlocks} from './BlocklyDefinitions';

Blockly.JavaScript.STATEMENT_PREFIX = '%1\n';

let workspacePlayground = null;

function createWorkspacePlayground(blocklyDiv, blocklyArea, startBlocks, config)
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

function scrollWorkspace()
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

function deleteAllBlocks()
{
	let allBlocks = workspacePlayground.getAllBlocks();
	for (let i = 0; i<allBlocks.length; i++)
	{
		if(allBlocks[i].type != 'player' && allBlocks[i].type != 'playerDirection')
		{
			allBlocks[i].dispose();
		}
	}      
}

function disableContextMenus()
{

	Blockly.showContextMenu_ = function (e) {
	};
	Blockly.ContextMenu.show = function (e) {
	};
}

function changeFacingDirectionImage(imageUrl, direction) 
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

function getWorkspaceCode()
{
	return Blockly.JavaScript.workspaceToCode(workspacePlayground);
}

function clearFailedBlocks(failedBlock)
{
	failedBlock.forEach((block) => {	
		switch(block.type)
		{
		case 'do_while_not_finished':
			block.setColour(230);
			break;
		case 'for':
			block.setColour(230);
			break;
		case 'if_next_tile_is':
			block.setColour(210);
			break;
		case 'if_next_tile_has':
			block.setColour(210);
			break;
		default:
			block.setColour(160);
			break;
		}
	});
	failedBlock.splice(0, failedBlock.length);
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

export default { changeFacingDirectionImage, deleteAllBlocks, createWorkspacePlayground, createBlocklyBlocks, getWorkspaceCode, clearFailedBlocks};