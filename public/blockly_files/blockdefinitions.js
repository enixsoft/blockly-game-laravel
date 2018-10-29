var Blockly = Blockly || {};

Blockly.Blocks['move_right'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("move right")
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
        .appendField("move left")
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
        .appendField("move up")
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
        .appendField("move down")
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
        .appendField("attack")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/color/sword.png", 30, 30, "*"))
        .appendField(new Blockly.FieldDropdown([["right","right"], ["left","left"], ["up","up"], ["down","down"]]), "direction");
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
        .appendField("use")
        .appendField(new Blockly.FieldImage("blockly_files/lever.png", 30, 30, "*"))
        .appendField(new Blockly.FieldDropdown([["right","right"], ["left","left"], ["up","up"], ["down","down"]]), "direction");
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
        .appendField("open")
        .appendField(new Blockly.FieldImage("blockly_files/chest.png", 30, 30, "*"))
        .appendField(new Blockly.FieldDropdown([["right","right"], ["left","left"], ["up","up"], ["down","down"]]), "direction");
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
        .appendField("jump")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/ios/50/000000/trampoline-park-filled.png", 20, 20, "*"))
		.appendField(new Blockly.FieldDropdown([["right","right"], ["left","left"], ["up","up"], ["down","down"]]), "direction");
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
        .appendField("Player  ")
        .appendField(new Blockly.FieldImage("blockly_files/logo-head-small.png", 70, 70, "*"));
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
        .appendField(new Blockly.FieldImage("blockly_files/arrow.png", 70, 70, "*"));   
    this.setColour(100);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['cameraplus'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Camera+  ")
        .appendField(new Blockly.FieldImage("blockly_files/plus.png", 70, 70, "*"));   
    this.setColour(95);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['cameraminus'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Camera-  ")
        .appendField(new Blockly.FieldImage("blockly_files/minus.png", 70, 70, "*"));   
    this.setColour(95);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['load'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Load  ")
        .appendField(new Blockly.FieldImage("blockly_files/load.png", 70, 70, "*"));   
    this.setColour(95);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['save'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Save  ")
        .appendField(new Blockly.FieldImage("blockly_files/save.png", 70, 70, "*"));   
    this.setColour(95);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['restart'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Restart  ")
        .appendField(new Blockly.FieldImage("blockly_files/logo-head-small.png", 70, 70, "*"));   
    this.setColour(0);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['reload'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Reload  ")
        .appendField(new Blockly.FieldImage("blockly_files/logo-head-small.png", 70, 70, "*"));   
    this.setColour(0);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};




Blockly.JavaScript['move_left'] = function(block) {
  // TODO: Assemble JavaScript into code variable.	
  var code = 'moveLeft();\n';
  return code;
};

Blockly.JavaScript['move_right'] = function(block) {
  // TODO: Assemble JavaScript into code variable.	
  var code = 'moveRight();\n';
  return code;
};

Blockly.JavaScript['move_up'] = function(block) {
  // TODO: Assemble JavaScript into code variable.	
  var code = 'moveUp();\n';
  return code;
};

Blockly.JavaScript['move_down'] = function(block) {
  // TODO: Assemble JavaScript into code variable.	
  var code = 'moveDown();\n';
  return code;
};

Blockly.JavaScript['attack'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var dropdown_direction = block.getFieldValue('direction');	
  var code = 'attack(' + dropdown_direction + ');\n';
  return code;
};

Blockly.JavaScript['use'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var dropdown_direction = block.getFieldValue('direction');	
  var code = 'use(' + dropdown_direction + ');\n';
  return code;
};

Blockly.JavaScript['open'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var dropdown_direction = block.getFieldValue('direction');	
  var code = 'open(' + dropdown_direction + ');\n';
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

Blockly.JavaScript['restart'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = '\n';
  return code;
};

Blockly.JavaScript['reload'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = '\n';
  return code;
};