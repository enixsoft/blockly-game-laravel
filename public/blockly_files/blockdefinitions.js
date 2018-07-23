var Blockly = Blockly || {};

Blockly.Blocks['move_forward'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("move forward")
        .appendField(new Blockly.FieldImage("https://png.icons8.com/material/1600/up.png", 15, 15, "*"));
    this.setPreviousStatement(true, "Action");
    this.setNextStatement(true, "Action");
    this.setColour(160);
 this.setTooltip("Move the character forwards");
 this.setHelpUrl("");
  }
};

Blockly.Blocks['player'] = {
  init: function() {
    this.appendDummyInput()
        .appendField("Player")
        .appendField(new Blockly.FieldImage("https://www.gstatic.com/codesite/ph/images/star_on.gif", 15, 15, "*"));
    this.setNextStatement(true, "Action");
    this.setColour(300);
 this.setTooltip("This block refers to Player.");
 this.setHelpUrl("");
  }
};

Blockly.JavaScript['move_forward'] = function(block) {
  // TODO: Assemble JavaScript into code variable.	
  var code = 'moveForward();\n';
  return code;
};

Blockly.JavaScript['player'] = function(block) {
  // TODO: Assemble JavaScript into code variable.
  var code = 'Player:\n';
  return code;
};