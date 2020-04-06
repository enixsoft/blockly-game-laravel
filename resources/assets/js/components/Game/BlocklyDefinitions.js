import Blockly from 'blockly';

export function createBlocklyBlocks(url)
{
	Blockly.Blocks['do_while_not_finished'] = {
		init: function() {
			this.appendDummyInput()       
				.appendField('opakuj pokiaľ nie je hrdina v cieli')
				.appendField(new Blockly.FieldImage(url + 'game/cycle-arrows.png', 25, 25, '*'));
			this.appendStatementInput('NAME')
				.setCheck(null);
			this.setInputsInline(false);
			this.setPreviousStatement(true, null);		
			this.setColour(230);
			this.setTooltip('Tento blok predstavuje cyklus typu doWhile. Všetky bloky vložené do tohto bloku sa budú opakovať, kým sa hrdina nedostane do cieľa zadanej úlohy.');
		}
	};

	Blockly.Blocks['for'] = {
		init: function() {
			this.appendDummyInput()       
				.appendField('opakuj ')
				.appendField(new Blockly.FieldNumber('1'), 'count')
				.appendField('krát')
				.appendField(new Blockly.FieldImage(url + 'game/cycle-arrows.png', 25, 25, '*'));
			this.appendStatementInput('NAME')
				.setCheck(null);
			this.setInputsInline(false);
			this.setPreviousStatement(true, null); 
			this.setNextStatement(true, 'Action');	
			this.setColour(230);
			this.setTooltip('Tento blok predstavuje cyklus typu for. Všetky bloky vložené do tohto bloku sa postupne vykonajú presne toľko krát, ako je nastavené.');
		}
	};

	Blockly.Blocks['if_next_tile_is'] = {
		init: function() {
			this.appendDummyInput()       
				.appendField('ak v smere nasleduje ')		
				.appendField(new Blockly.FieldDropdown([['voda', 'water'], ['stena', 'wall']]), 'type')
				.appendField(new Blockly.FieldImage(url + 'game/refresh.png', 25, 25, '*'));
			this.appendStatementInput('NAME')
				.setCheck(null);
			this.setInputsInline(false);
			this.setPreviousStatement(true, null); 
			this.setNextStatement(true, 'Action');	
			this.setColour(210);
			this.setTooltip('Tento blok predstavuje podmienku. Všetky bloky vložené do tohto bloku sa vykonajú, ak v smere hrdinu nasleduje to, čo je nastavené.');
		}
	};


	Blockly.Blocks['if_next_tile_has'] = {
		init: function() {
			this.appendDummyInput()       
				.appendField('ak v smere na dlaždici je ')		
				.appendField(new Blockly.FieldDropdown([['zničiteľná vec', 'destructible'], ['páka', 'lever'], ['truhlica', 'chest'], ['pasca', 'trap']]), 'type')
				.appendField(new Blockly.FieldImage(url + 'game/refresh.png', 25, 25, '*'));
			this.appendStatementInput('NAME')
				.setCheck(null);
			this.setInputsInline(false);
			this.setPreviousStatement(true, null); 
			this.setNextStatement(true, 'Action');	
			this.setColour(210);
			this.setTooltip('Tento blok predstavuje podmienku. Všetky bloky vložené do tohto bloku sa vykonajú, ak sa v smere hrdinu na nasledujúcej dlaždici nachádza to, čo je nastavené.');
		}
	};

	Blockly.Blocks['move_forward'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('choď o 1 krok v smere')
				.appendField(new Blockly.FieldImage(url + 'game/resize-corners.png', 20, 20, '*'));		
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina sa presunie o jeden krok v aktuálnom smere.');
		}
	};

	Blockly.Blocks['rotate_character_left'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('otočiť hrdinu o 90° doľava')
				.appendField(new Blockly.FieldImage(url + 'game/rotate-left.png', 20, 20, '*'));		
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Tento blok mení smer, hrdina sa otočí o 90 stupňov doľava.');
		}
	};

	Blockly.Blocks['rotate_character_right'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('otočiť hrdinu o 90° doprava')
				.appendField(new Blockly.FieldImage(url + 'game/rotate-right.png', 20, 20, '*'));		
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Tento blok mení smer, hrdina sa otočí o 90 stupňov doprava.');
		}
	};


	Blockly.Blocks['move_right'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('choď o')		
				.appendField(new Blockly.FieldNumber('1'), 'steps')
				.appendField('doprava')
				.appendField(new Blockly.FieldImage(url + 'game/right-block.png', 20, 20, '*'));
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina vykoná smerom doprava počet nastavených krokov.');
		}
	};


	Blockly.Blocks['move_left'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('choď o')		
				.appendField(new Blockly.FieldNumber('1'), 'steps')
				.appendField('doľava')
				.appendField(new Blockly.FieldImage(url + 'game/left-block.png', 20, 20, '*'));
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina vykoná smerom doľava počet nastavených krokov.');
		}
	};

	Blockly.Blocks['move_up'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('choď o')		
				.appendField(new Blockly.FieldNumber('1'), 'steps')
				.appendField('hore')
				.appendField(new Blockly.FieldImage(url + 'game/up-block.png', 20, 20, '*'));       
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
	
			this.setTooltip('Hrdina vykoná smerom hore počet nastavených krokov.');
		}
	};

	Blockly.Blocks['move_down'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('choď o')		
				.appendField(new Blockly.FieldNumber('1'), 'steps')
				.appendField('dole')
				.appendField(new Blockly.FieldImage(url + 'game/down-block.png', 20, 20, '*'));
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina vykoná smerom dole počet nastavených krokov.');
		}
	};

	Blockly.Blocks['attack'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('zaútoč')
				.appendField(new Blockly.FieldImage(url + 'game/sword.png', 30, 30, '*'))
				.appendField(new Blockly.FieldDropdown([['doprava','right'], ['doľava','left'], ['hore','up'], ['dole','down']]), 'direction');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina záutočí v nastavenom smere. Ak sa v smere nachádza zničiteľná vec, bude zničená.');
		}
	};

	Blockly.Blocks['attack_forward'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('zaútoč')
				.appendField(new Blockly.FieldImage(url + 'game/sword.png', 30, 30, '*'))
				.appendField('v smere');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina záutočí v aktuálnom smere. Ak sa v smere nachádza zničiteľná vec, bude zničená.');
		}
	};

	Blockly.Blocks['use'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('použi')
				.appendField(new Blockly.FieldImage(url + 'game/lever.png', 30, 30, '*'))
				.appendField(new Blockly.FieldDropdown([['napravo','right'], ['naľavo','left'], ['hore','up'], ['dole','down']]), 'direction');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina použije páku v nastavenom smere.');
		}
	};

	Blockly.Blocks['use_forward'] = {
		init: function() {
			this.appendDummyInput()        
				.appendField('použi ')		
				.appendField(new Blockly.FieldImage(url + 'game/lever.png', 30, 30, '*'))      
				.appendField('v smere');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);	
			this.setTooltip('Hrdina použije páku v aktuálnom smere.');
		}
	};

	Blockly.Blocks['open'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('otvor')
				.appendField(new Blockly.FieldImage(url + 'game/chest.png', 30, 30, '*'))
				.appendField(new Blockly.FieldDropdown([['napravo','right'], ['naľavo','left'], ['hore','up'], ['dole','down']]), 'direction');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);	
			this.setTooltip('Hrdina otvorí truhlicu v nastavenom smere.');
		}
	};

	Blockly.Blocks['open_forward'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('otvor')
				.appendField(new Blockly.FieldImage(url + 'game/chest.png', 30, 30, '*'))
				.appendField('v smere');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina otvorí truhlicu v aktuálnom smere.');
		}
	};

	Blockly.Blocks['jump'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('skoč')
				.appendField(new Blockly.FieldImage(url + 'game/trampoline-park-filled.png', 20, 20, '*'))
				.appendField(new Blockly.FieldDropdown([['doprava','right'], ['doľava','left'], ['hore','up'], ['dole','down']]), 'direction');
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina skočí v nastavenom smere.');
		}
	};

	Blockly.Blocks['jump_forward'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('skoč dopredu v smere')
				.appendField(new Blockly.FieldImage(url + 'game/trampoline-park-filled.png', 20, 20, '*'));	
			this.setPreviousStatement(true, 'Action');
			this.setNextStatement(true, 'Action');
			this.setColour(160);
			this.setTooltip('Hrdina skočí v aktuálnom smere.');
		}
	};



	Blockly.Blocks['player'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('Hrdina  ')
				.appendField(new Blockly.FieldImage(url + 'game/logo-head-small.png', 70, 70, '*'));   
			this.setNextStatement(true, 'Action');
			this.setColour(300);	
			this.setTooltip('Základný blok. Po kliknutí na tento blok alebo na tlačidlo Spustiť bloky hrdina vykonáva všetky bloky umiestnené pod týmto blokom.');
		}
	};

	Blockly.Blocks['playerDirection'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('Hrdina  ')
				.appendField(new Blockly.FieldImage(url + 'game/logo-head-small.png', 70, 70, '*'))		
				.appendField(new Blockly.FieldImage(url + 'game/nodirection.png', 70, 70, '*'),'facingDirection_image');   
			this.setNextStatement(true, 'Action');
			this.setColour(300);
			this.setTooltip('Základný blok, zobrazuje aktuálny smer hrdinu, ktorý sa dať meniť blokmi s otáčaním. Po kliknutí na tento blok alebo na tlačidlo Spustiť bloky hrdina vykonáva všetky bloky umiestnené pod týmto blokom.');
		}
	};


	Blockly.Blocks['run'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('Run code ')
				.appendField(new Blockly.FieldImage(url + 'game/arrow.png', 70, 70, '*'));   
			this.setColour(100);	
			this.setTooltip('Spustiť.');
		}
	};

	Blockly.Blocks['cameraplus'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('Camera+  ')
				.appendField(new Blockly.FieldImage(url + 'game/plus.png', 70, 70, '*'));   
			this.setColour(95);
			this.setTooltip('Priblížiť.');
		}
	};

	Blockly.Blocks['cameraminus'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('Camera-  ')
				.appendField(new Blockly.FieldImage(url + 'game/minus.png', 70, 70, '*'));   
			this.setColour(95);
			this.setTooltip('Oddialiť.');
		}
	};

	Blockly.Blocks['load'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('Load  ')
				.appendField(new Blockly.FieldImage(url + 'game/load.png', 70, 70, '*'));   
			this.setColour(95);
			this.setTooltip('Načítať uloženú hru.');
		}
	};

	Blockly.Blocks['save'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('Save  ')
				.appendField(new Blockly.FieldImage(url + 'game/save.png', 70, 70, '*'));   
			this.setColour(95);
			this.setTooltip('Uložiť hru.');
		}
	};

	Blockly.Blocks['reload'] = {
		init: function() {
			this.appendDummyInput()
				.appendField('Reload  ')
				.appendField(new Blockly.FieldImage(url + 'game/logo-head-small.png', 70, 70, '*'));   
			this.setColour(0);
			this.setTooltip('Znovu načítať hernú časť.');
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