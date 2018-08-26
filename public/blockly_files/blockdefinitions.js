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
        .appendField(new Blockly.FieldImage("https://png.icons8.com/color/sword.png", 20, 20, "*"))
        .appendField(new Blockly.FieldDropdown([["right","right"], ["left","left"], ["up","up"], ["down","down"]]), "direction");
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Character attacks");
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

Blockly.JavaScript['player'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = 'Player:\n';
  return code;
};