var Blockly = Blockly || {};

Blockly.Blocks['move_right'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("move right")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/material/1600/right.png", 15, 15, "*"));
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
        .appendField(new Blockly.FieldImage("https://png.icons8.com/material/1600/left.png", 15, 15, "*"));
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Move the character left");
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

Blockly.JavaScript['player'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = 'Player:\n';
  return code;
};