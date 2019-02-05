var Blockly = Blockly || {};

Blockly.Blocks['do_while_not_finished'] = {
  init: function() {
    this.appendDummyInput()       
        .appendField("opakuj pokiaľ nie je hrdina v cieli")
		.appendField(new Blockly.FieldImage("https://png.icons8.com/icon/6454/cycle-arrows", 25, 25, "*"))
    this.appendStatementInput("NAME")
        .setCheck(null);
    this.setInputsInline(false);
	this.setPreviousStatement(true, null);		
    this.setColour(230);
 this.setTooltip("");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['for'] = {
  init: function() {
    this.appendDummyInput()       
        .appendField("opakuj ")
		.appendField(new Blockly.FieldNumber('1'), 'count')
		.appendField("krát")
		.appendField(new Blockly.FieldImage("https://png.icons8.com/icon/6454/cycle-arrows", 25, 25, "*"))
    this.appendStatementInput("NAME")
        .setCheck(null);
    this.setInputsInline(false);
	this.setPreviousStatement(true, null); 
	this.setNextStatement(true, "Action");	
    this.setColour(230);
 this.setTooltip("");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['if_current_tile_is'] = {
  init: function() {
    this.appendDummyInput()       
        .appendField("ak hrdina stojí na ")		
		.appendField(new Blockly.FieldDropdown([["tlačidle", "button"], ["akejkoľvek dlaždici", "any"]]), "type")
		.appendField(new Blockly.FieldImage("https://png.icons8.com/icon/6454/cycle-arrows", 25, 25, "*"))
    this.appendStatementInput("NAME")
        .setCheck(null);
    this.setInputsInline(false);
	this.setPreviousStatement(true, null); 
	this.setNextStatement(true, "Action");	
    this.setColour(210);
 this.setTooltip("");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['if_next_tile_is'] = {
  init: function() {
    this.appendDummyInput()       
        .appendField("ak v smere nasleduje ")		
		.appendField(new Blockly.FieldDropdown([["tlačidlo", "button"], ["akákoľvek dlaždica", "any"], ["voda", "water"], ["stena", "wall"]]), "type")
		.appendField(new Blockly.FieldImage("https://png.icons8.com/icon/6454/cycle-arrows", 25, 25, "*"))
    this.appendStatementInput("NAME")
        .setCheck(null);
    this.setInputsInline(false);
	this.setPreviousStatement(true, null); 
	this.setNextStatement(true, "Action");	
    this.setColour(210);
 this.setTooltip("");
 this.setHelpUrl("");
  }
};


Blockly.Blocks['move_forward'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("choď o 1 krok v smere")
		.appendField(new Blockly.FieldImage("https://png.icons8.com/icon/6454/resize-corners", 20, 20, "*"));		
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Move the character right");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['rotate_character_left'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("otočiť hrdinu doľava")
		.appendField(new Blockly.FieldImage("https://png.icons8.com/icon/6454/right-up2", 20, 20, "*"));		
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Move the character right");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['rotate_character_right'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("otočiť hrdinu doprava")
		.appendField(new Blockly.FieldImage("https://png.icons8.com/icon/6454/right-down2", 20, 20, "*"));		
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Move the character right");
 this.setHelpUrl("");
  }
};


Blockly.Blocks['move_right'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("choď o")		
        .appendField(new Blockly.FieldNumber('1'), 'steps')
		.appendField("doprava")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/material/1600/right.png", 20, 20, "*"));
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Move the character right");
 this.setHelpUrl("");
  }
};


Blockly.Blocks['move_left'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("choď o")		
        .appendField(new Blockly.FieldNumber('1'), 'steps')
		.appendField("doľava")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/material/1600/left.png", 20, 20, "*"));
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Move the character left");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['move_up'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("choď o")		
        .appendField(new Blockly.FieldNumber('1'), 'steps')
		.appendField("hore")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/material/1600/up.png", 20, 20, "*"));       
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Move the character up");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['move_down'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("choď o")		
        .appendField(new Blockly.FieldNumber('1'), 'steps')
		.appendField("dole")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/material/1600/down.png", 20, 20, "*"));
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Move the character down");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['attack'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("zaútoč")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/color/sword.png", 30, 30, "*"))
        .appendField(new Blockly.FieldDropdown([["doprava","right"], ["doľava","left"], ["hore","up"], ["dole","down"]]), "direction");
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Character attacks");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['attack_forward'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("zaútoč")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/color/sword.png", 30, 30, "*"))
        .appendField("v smere");
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Character attacks");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['use'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("použi")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/lever.png", 30, 30, "*"))
        .appendField(new Blockly.FieldDropdown([["napravo","right"], ["naľavo","left"], ["hore","up"], ["dole","down"]]), "direction");
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Character uses");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['use_forward'] = {
  init: function() {
    this.appendDummyInput()        
		.appendField("použi ")		
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/lever.png", 30, 30, "*"))      
		.appendField("v smere");
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Character uses");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['open'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("otvor")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/chest.png", 30, 30, "*"))
        .appendField(new Blockly.FieldDropdown([["napravo","right"], ["naľavo","left"], ["hore","up"], ["dole","down"]]), "direction");
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Character opens");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['open_forward'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("otvor")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/chest.png", 30, 30, "*"))
        .appendField("v smere");
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Character opens");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['jump'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("skoč")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/ios/50/000000/trampoline-park-filled.png", 20, 20, "*"))
		.appendField(new Blockly.FieldDropdown([["doprava","right"], ["doľava","left"], ["hore","up"], ["dole","down"]]), "direction");
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("The character jumps");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['jump_forward'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("skoč dopredu v smere")
		.appendField(new Blockly.FieldImage("https://png.icons8.com/ios/50/000000/trampoline-park-filled.png", 20, 20, "*"));	
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
  this.setTooltip("The character jumps");
 this.setHelpUrl("");
  }
};



Blockly.Blocks['player'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Hrdina  ")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/logo-head-small.png", 70, 70, "*"))		
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/nodirection.png", 70, 70, "*"),"facingDirection_image");   
    this.setNextStatement(true, "Action");
    this.setColour(300);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['run'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Run code ")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/arrow.png", 70, 70, "*"));   
    this.setColour(100);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['cameraplus'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Camera+  ")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/plus.png", 70, 70, "*"));   
    this.setColour(95);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['cameraminus'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Camera-  ")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/minus.png", 70, 70, "*"));   
    this.setColour(95);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['load'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Load  ")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/load.png", 70, 70, "*"));   
    this.setColour(95);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['save'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Save  ")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/save.png", 70, 70, "*"));   
    this.setColour(95);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['reload'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Reload  ")
        .appendField(new Blockly.FieldImage("http://localhost/blockly-web-project/game/logo-head-small.png", 70, 70, "*"));   
    this.setColour(0);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};


Blockly.JavaScript['move_forward'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var steps = 1;
  var code = 'moveForward(' + steps + ');\n';
  return code;
};

Blockly.JavaScript['rotate_character_left'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var direction = "left";
  var code = 'rotateCharacter(' + direction + ');\n';
  return code;
};

Blockly.JavaScript['rotate_character_right'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var direction = "right";
  var code = 'rotateCharacter(' + direction + ');\n';
  return code;
};


Blockly.JavaScript['jump_forward'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var steps = 1;
  var code = 'jumpForward(' + steps + ');\n';
  return code;
};

Blockly.JavaScript['move_left'] = function(block) {
  // TODO: Assemble JavaScript into code variable.	
  var steps = block.getFieldValue('steps');
  var code = 'moveLeft(' + steps + ');\n';
  return code;
};

Blockly.JavaScript['move_right'] = function(block) {
  // TODO: Assemble JavaScript into code variable.	
  var steps = block.getFieldValue('steps'); 
  var code = 'moveRight(' + steps + ');\n';
  return code;
};

Blockly.JavaScript['move_up'] = function(block) {
  // TODO: Assemble JavaScript into code variable.	
  var steps = block.getFieldValue('steps');  
  var code = 'moveUp(' + steps + ');\n';
  return code;
};

Blockly.JavaScript['move_down'] = function(block) {
  // TODO: Assemble JavaScript into code variable.	
  var steps = block.getFieldValue('steps'); 
  var code = 'moveDown(' + steps + ');\n';
  return code;
};

Blockly.JavaScript['attack'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
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
  // TODO: Assemble JavaScript into code variable.
  var dropdown_direction = block.getFieldValue('direction');	
  var code = 'open(' + dropdown_direction + ');\n';
  return code;
};

Blockly.JavaScript['open_forward'] = function(block) {

  var code = 'openForward();\n';
  return code;
};

Blockly.JavaScript['jump'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var dropdown_direction = block.getFieldValue('direction');	
  var code = 'jump(' + dropdown_direction + ');\n';
  return code;
};

Blockly.JavaScript['player'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = 'Player:\n';
  return code;
};

Blockly.JavaScript['run'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = '\n';
  return code;
};

Blockly.JavaScript['cameraplus'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = '\n';
  return code;
};

Blockly.JavaScript['cameraminus'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = '\n';
  return code;
};

Blockly.JavaScript['load'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = '\n';
  return code;
};

Blockly.JavaScript['save'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = '\n';
  return code;
};

Blockly.JavaScript['reload'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
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

Blockly.JavaScript['if_current_tile_is'] = function(block) {  
  var statements_name = Blockly.JavaScript.statementToCode(block, 'NAME');
  var type = block.getFieldValue('type');    
  var code = 'ifCurrentTileIs(' + type + '){\n' + statements_name + '};\n';
  return code;  
};

Blockly.JavaScript['if_next_tile_is'] = function(block) {  
  var statements_name = Blockly.JavaScript.statementToCode(block, 'NAME');
  var type = block.getFieldValue('type');    
  var code = 'ifNextTileIs(' + type + '){\n' + statements_name + '};\n';
  return code;  
};