import Blockly from 'blockly';

export function createBlocklyBlocks(url, locales)
{
	console.log(locales);
	Blockly.Blocks['do_while_not_finished'] = {
		init: function() {
			this.appendDummyInput()       
				.appendField(locales.doWhileField)
				.appendField(new Blockly.FieldImage(url + 'game/cycle-arrows.png', 25, 25, '*'));
			this.appendStatementInput('NAME')
				.setCheck(null);
			this.setInputsInline(false);
			this.setPreviousStatement(true, null);		
			this.setColour(230);
			this.setTooltip(locales.doWhileTooltip);
		}
	};

	Blockly.Blocks['for'] = {
		init: function() {
			this.appendDummyInput()       
				.appendField(locales.forRepeat)
				.appendField(new Blockly.FieldNumber('1'), 'count')
				.appendField(locales.forTimes)
				.appendField(new Blockly.FieldImage(url + 'game/cycle-arrows.png', 25, 25, '*'));
			this.appendStatementInput('NAME')
				.setCheck(null);
			this.setInputsInline(false);
			this.setPreviousStatement(true, null); 
			this.setNextStatement(true, 'Action');	
			this.setColour(230);
			this.setTooltip(locales.forTooltip);
		}
	};

	Blockly.Blocks['if_next_tile_is'] = {
		init: function() {
			this.appendDummyInput()       
				.appendField(locales.ifNextIsField)		
				.appendField(new Blockly.FieldDropdown([[locales.water, 'water'], [locales.wall, 'wall']]), 'type')
				.appendField(new Blockly.FieldImage(url + 'game/refresh.png', 25, 25, '*'));
			this.appendStatementInput('NAME')
				.setCheck(null);
			this.setInputsInline(false);
			this.setPreviousStatement(true, null); 
			this.setNextStatement(true, 'Action');	
			this.setColour(210);
			this.setTooltip(locales.ifNextIsTooltip);
		}
	};


	Blockly.Blocks['if_next_tile_has'] = {
		init: function() {
			this.appendDummyInput()       
				.appendField(locales.ifNextHasField)		
				.appendField(new Blockly.FieldDropdown([[locales.destructible, 'destructible'], [locales.lever, 'lever'], [locales.chest, 'chest'], [locales.trap, 'trap']]), 'type')
				.appendField(new Blockly.FieldImage(url + 'game/refresh.png', 25, 25, '*'));
			this.appendStatementInput('NAME')
				.setCheck(null);
			this.setInputsInline(false);
			this.setPreviousStatement(true, null); 
			this.setNextStatement(true, 'Action');	
			this.setColour(210);
			this.setTooltip(locales.ifNextHasTooltip);
		}
	};

	Blockly.Blocks['move_forward'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.moveForwardField)
				.appendField(new Blockly.FieldImage(url + 'game/resize-corners.png', 20, 20, '*'));		
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.moveForwardTooltip);
		}
	};

	Blockly.Blocks['rotate_character_left'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.rotateLeftField)
				.appendField(new Blockly.FieldImage(url + 'game/rotate-left.png', 20, 20, '*'));		
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.rotateLeftTooltip);
		}
	};

	Blockly.Blocks['rotate_character_right'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.rotateRightField)
				.appendField(new Blockly.FieldImage(url + 'game/rotate-right.png', 20, 20, '*'));		
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.rotateRightTooltip);
		}
	};


	Blockly.Blocks['move_right'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.moveField)		
				.appendField(new Blockly.FieldNumber('1'), 'steps')
				.appendField(locales.right)
				.appendField(new Blockly.FieldImage(url + 'game/right-block.png', 20, 20, '*'));
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.moveRightTooltip);
		}
	};


	Blockly.Blocks['move_left'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.moveField)		
				.appendField(new Blockly.FieldNumber('1'), 'steps')
				.appendField(locales.left)
				.appendField(new Blockly.FieldImage(url + 'game/left-block.png', 20, 20, '*'));
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.moveLeftTooltip);
		}
	};

	Blockly.Blocks['move_up'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.moveField)		
				.appendField(new Blockly.FieldNumber('1'), 'steps')
				.appendField(locales.up)
				.appendField(new Blockly.FieldImage(url + 'game/up-block.png', 20, 20, '*'));       
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
	
			this.setTooltip(locales.moveUpTooltip);
		}
	};

	Blockly.Blocks['move_down'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.moveField)	
				.appendField(new Blockly.FieldNumber('1'), 'steps')
				.appendField(locales.down)
				.appendField(new Blockly.FieldImage(url + 'game/down-block.png', 20, 20, '*'));
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.moveDownTooltip);
		}
	};

	Blockly.Blocks['attack'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.attackField)
				.appendField(new Blockly.FieldImage(url + 'game/sword.png', 30, 30, '*'))
				.appendField(new Blockly.FieldDropdown([[locales.right,'right'], [locales.left,'left'], [locales.up,'up'], [locales.down,'down']]), 'direction');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.attackTooltip);
		}
	};

	Blockly.Blocks['attack_forward'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.attackField)
				.appendField(new Blockly.FieldImage(url + 'game/sword.png', 30, 30, '*'))
				.appendField(locales.inDirection);
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.attackForwardTooltip);
		}
	};

	Blockly.Blocks['use'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.useField)
				.appendField(new Blockly.FieldImage(url + 'game/lever.png', 30, 30, '*'))
				.appendField(new Blockly.FieldDropdown([[locales.right,'right'], [locales.left,'left'], [locales.up,'up'], [locales.down,'down']]), 'direction');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.useTooltip);
		}
	};

	Blockly.Blocks['use_forward'] = {
		init: function() {
			this.appendDummyInput()        
				.appendField(locales.useField)		
				.appendField(new Blockly.FieldImage(url + 'game/lever.png', 30, 30, '*'))      
				.appendField(locales.inDirection);
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);	
			this.setTooltip(locales.useForwardTooltip);
		}
	};

	Blockly.Blocks['open'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.open)
				.appendField(new Blockly.FieldImage(url + 'game/chest.png', 30, 30, '*'))
				.appendField(new Blockly.FieldDropdown([[locales.right,'right'], [locales.left,'left'], [locales.up,'up'], [locales.down,'down']]), 'direction');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);	
			this.setTooltip(locales.openTooltip);
		}
	};

	Blockly.Blocks['open_forward'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.open)
				.appendField(new Blockly.FieldImage(url + 'game/chest.png', 30, 30, '*'))
				.appendField(locales.inDirection)
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.openForwardTooltip);		
		}
	};

	Blockly.Blocks['jump'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.jump)
				.appendField(new Blockly.FieldImage(url + 'game/trampoline-park-filled.png', 20, 20, '*'))
				.appendField(new Blockly.FieldDropdown([[locales.right,'right'], [locales.left,'left'], [locales.up,'up'], [locales.down,'down']]), 'direction');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.jumpTooltip);
		}
	};

	Blockly.Blocks['jump_forward'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.jumpForward)
				.appendField(new Blockly.FieldImage(url + 'game/trampoline-park-filled.png', 20, 20, '*'));	
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip(locales.jumpForwardTooltip);
		}
	};



	Blockly.Blocks['player'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.player)
				.appendField(new Blockly.FieldImage(url + 'game/logo-head-small.png', 70, 70, '*'));   
			this.setNextStatement(true, 'Action');
			this.setColour(300);	
			this.setTooltip(locales.playerTooltip);
		}
	};

	Blockly.Blocks['playerDirection'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.player)
				.appendField(new Blockly.FieldImage(url + 'game/logo-head-small.png', 70, 70, '*'))		
				.appendField(new Blockly.FieldImage(url + 'game/nodirection.png', 70, 70, '*'),'facingDirection_image');   
			this.setNextStatement(true, 'Action');
			this.setColour(300);
			this.setTooltip(locales.playerDirectionTooltip);
		}
	};


	Blockly.Blocks['run'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.run)
				.appendField(new Blockly.FieldImage(url + 'game/arrow.png', 70, 70, '*'));   
			this.setColour(100);	
			this.setTooltip(locales.run);
		}
	};

	Blockly.Blocks['cameraplus'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.cameraPlus)
				.appendField(new Blockly.FieldImage(url + 'game/plus.png', 70, 70, '*'));   
			this.setColour(95);
			this.setTooltip(locales.cameraPlus);
		}
	};

	Blockly.Blocks['cameraminus'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.cameraMinus)
				.appendField(new Blockly.FieldImage(url + 'game/minus.png', 70, 70, '*'));   
			this.setColour(95);
			this.setTooltip(locales.cameraMinus);
		}
	};

	Blockly.Blocks['load'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.load)
				.appendField(new Blockly.FieldImage(url + 'game/load.png', 70, 70, '*'));   
			this.setColour(95);
			this.setTooltip(locales.load);
		}
	};

	Blockly.Blocks['save'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.save)
				.appendField(new Blockly.FieldImage(url + 'game/save.png', 70, 70, '*'));   
			this.setColour(95);
			this.setTooltip(locales.save);
		}
	};

	Blockly.Blocks['reload'] = {
		init: function() {
			this.appendDummyInput()
				.appendField(locales.reload)
				.appendField(new Blockly.FieldImage(url + 'game/logo-head-small.png', 70, 70, '*'));   
			this.setColour(0);
			this.setTooltip(locales.reload);
		}
	};


	Blockly.JavaScript['move_forward'] = function(block) {  
		var steps = 1;
		var code = 'moveForward(' + steps + ');\n';
		return code;
	};

	Blockly.JavaScript['rotate_character_left'] = function(block) {  
		var direction = 'left';
		var code = 'rotateCharacter(' + direction + ');\n';
		return code;
	};

	Blockly.JavaScript['rotate_character_right'] = function(block) {  
		var direction = 'right';
		var code = 'rotateCharacter(' + direction + ');\n';
		return code;
	};


	Blockly.JavaScript['jump_forward'] = function(block) {  
		var steps = 1;
		var code = 'jumpForward(' + steps + ');\n';
		return code;
	};

	Blockly.JavaScript['move_left'] = function(block) {
		var steps = block.getFieldValue('steps');
		var code = 'moveLeft(' + steps + ');\n';
		return code;
	};

	Blockly.JavaScript['move_right'] = function(block) {  	
		var steps = block.getFieldValue('steps'); 
		var code = 'moveRight(' + steps + ');\n';
		return code;
	};

	Blockly.JavaScript['move_up'] = function(block) {  	
		var steps = block.getFieldValue('steps');  
		var code = 'moveUp(' + steps + ');\n';
		return code;
	};

	Blockly.JavaScript['move_down'] = function(block) {  	
		var steps = block.getFieldValue('steps'); 
		var code = 'moveDown(' + steps + ');\n';
		return code;
	};

	Blockly.JavaScript['attack'] = function(block) {  
		var dropdown_direction = block.getFieldValue('direction');	
		var code = 'attack(' + dropdown_direction + ');\n';
		return code;
	};

	Blockly.JavaScript['attack_forward'] = function(block) {
		var code = 'attackForward();\n';
		return code;
	};

	Blockly.JavaScript['use'] = function(block) {
		var dropdown_direction = block.getFieldValue('direction');	
		var code = 'use(' + dropdown_direction + ');\n';
		return code;
	};

	Blockly.JavaScript['use_forward'] = function(block) {
		var code = 'useForward();\n';
		return code;
	};

	Blockly.JavaScript['open'] = function(block) {  
		var dropdown_direction = block.getFieldValue('direction');	
		var code = 'open(' + dropdown_direction + ');\n';
		return code;
	};

	Blockly.JavaScript['open_forward'] = function(block) {
		var code = 'openForward();\n';
		return code;
	};

	Blockly.JavaScript['jump'] = function(block) {  
		var dropdown_direction = block.getFieldValue('direction');	
		var code = 'jump(' + dropdown_direction + ');\n';
		return code;
	};

	Blockly.JavaScript['player'] = function(block) {  
		var code = 'Player:\n';
		return code;
	};

	Blockly.JavaScript['playerDirection'] = function(block) {  
		var code = 'Player:\n';
		return code;
	};

	Blockly.JavaScript['run'] = function(block) {  
		var code = '\n';
		return code;
	};

	Blockly.JavaScript['cameraplus'] = function(block) {  
		var code = '\n';
		return code;
	};

	Blockly.JavaScript['cameraminus'] = function(block) {  
		var code = '\n';
		return code;
	};

	Blockly.JavaScript['load'] = function(block) {  
		var code = '\n';
		return code;
	};

	Blockly.JavaScript['save'] = function(block) {  
		var code = '\n';
		return code;
	};

	Blockly.JavaScript['reload'] = function(block) {  
		var code = '\n';
		return code;
	};

	Blockly.JavaScript['do_while_not_finished'] = function(block) {
		var statements_name = Blockly.JavaScript.statementToCode(block, 'NAME'); 
		var code = 'doWhileNotFinished(){\n' + statements_name + '};\n';
		return code;  
	};

	Blockly.JavaScript['for'] = function(block) {
		var statements_name = Blockly.JavaScript.statementToCode(block, 'NAME');
		var count = block.getFieldValue('count');    
		var code = 'for(' + count + '){\n' + statements_name + '};\n';
		return code;  
	};


	Blockly.JavaScript['if_next_tile_is'] = function(block) {
		var statements_name = Blockly.JavaScript.statementToCode(block, 'NAME');
		var type = block.getFieldValue('type');    
		var code = 'ifNextTileIs(' + type + '){\n' + statements_name + '};\n';
		return code;  
	};

	Blockly.JavaScript['if_next_tile_has'] = function(block) {
		var statements_name = Blockly.JavaScript.statementToCode(block, 'NAME');
		var type = block.getFieldValue('type');    
		var code = 'ifNextTileHas(' + type + '){\n' + statements_name + '};\n';
		return code;  
	};
}