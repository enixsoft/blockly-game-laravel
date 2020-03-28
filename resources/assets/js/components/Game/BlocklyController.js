import * as Blockly from 'blockly/core';
import 'blockly/blocks';
import 'blockly/javascript';
// import * as En from 'blockly/msg/en';
import '../Game/BlocklyDefinitions';
import 'jquery';

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

function highlightBlock(id)
{
    workspacePlayground.highlightBlock(id);      
}

function disableContextMenus()
{

   Blockly.showContextMenu_ = function (e) {
      };
      Blockly.ContextMenu.show = function (e) {
      };
}

export default {scrollWorkspace, highlightBlock,  disableContextMenus}