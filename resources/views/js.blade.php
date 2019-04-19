<script>
if (/Mobi|Android/i.test(navigator.userAgent))
  this.mobile = true;    
else
  this.mobile = false;

var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";


eventer(messageEvent,function(e) 
{
  console.log('Web-side script has received message from game:  ', e.data);
  
  switch(e.data.action)
  {
     case "unlock":
    {
      
      $('#send_code_button').attr("onclick", "runCode()").end();
      $('#send_code_button').attr("class", "btn btn-success mr-3").end();  
      $('#send_code_button').html('<i class="fas fa-play"></i> Spustiť bloky').end(); 
      $('#send_code_button').attr("disabled", false).end(); 
      
      $('#show_task_button').attr("disabled", false).end(); 
      $('#delete_blocks_button').attr("disabled", false).end(); 
      $('#report_bug_button').attr("disabled", false).end(); 

      workspacePlayground.highlightBlock(null);
      this.locked = false;
      break;
    }
    
    case "start":
    {
     
    if(this.mobile)
    {
  
  cameraPlus();
  cameraPlus();
  cameraPlus();
  cameraPlus();


    $('#navbar-brand').attr('href', '#');
    $('#navbar-brand').html('BLOCKLY HRA <i class="fas fa-expand-arrows-alt"></i>');
    
    
  var goFS = document.getElementById("navbar-brand");



 goFS.addEventListener("click", function fullscreen() {
    var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
        (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
        (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
        (document.msFullscreenElement && document.msFullscreenElement !== null);

    var docElm = document.documentElement;
    if (!isInFullScreen) {
        if (docElm.requestFullscreen) {
            docElm.requestFullscreen();
        } else if (docElm.mozRequestFullScreen) {
            docElm.mozRequestFullScreen();
        } else if (docElm.webkitRequestFullScreen) {
            docElm.webkitRequestFullScreen();
        } else if (docElm.msRequestFullscreen) {
            docElm.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
    }, false);



    }  
    

     startGame();
     break;     
    }
    
    case "introduction":
    {   
    

    this.level_start = Date.now(); 

    if(this.progress==0)
      levelIntroduced(e.data.content); 
    else
      mainTaskIntroduced(e.data.content);   


     break;     
    }
    
    case "highlightProgress":
    {
     highlightBlock(e.data.content);
     break;     
    }

     case "highlightFailure":
    {   
     
      block = workspacePlayground.getBlockById(e.data.content);
      block.setColour(0); //COMMAND FAILED BLOCK IS RED 
      failedBlock.push(block);
      break;     
    }

    case "mainTaskCompleted":
    {

      workspacePlayground.highlightBlock(null);
      $('#send_code_button').attr("disabled", true).end();       
      
      this.task_end = Date.now();
      
      mainTaskCompleted(e.data.content);

      break;     
    }

    case "commandFailed": 
    {      

      workspacePlayground.highlightBlock(null);
      $('#send_code_button').attr("disabled", true).end();       

      commandFailed(e.data.content);
     
      break;     
    }

    case "mainTaskFailed": 
    {

      workspacePlayground.highlightBlock(null);
      $('#send_code_button').attr("disabled", true).end();

      mainTaskFailed(e.data.content);
     
      break;     
    }

    case "stoppedExecution": 
    {

      workspacePlayground.highlightBlock(null);
      $('#send_code_button').attr("disabled", true).end();

      stoppedExecution(e.data.content);

      break;     
    }


    case "nextMainTask":
    {

      workspacePlayground.highlightBlock(null);      
      mainTaskIntroduced(e.data.content);
      break;

    }
    case "allMainTasksFinished":
    {

      allMainTasksFinished();
      break;     
    }

    case "save":
    {
      saveObjectToJson(e.data.content);
      break;     
    }

    case "changeFacingDirection":
    {
      
      if(this.category==2)
      changeFacingDirectionImage(e.data.content);
    }



  }

  },false);

  var failedBlock = [];  

  var toolbox = {!! json_encode($xmlToolbox) !!};

  var savedGame = {!! $savedGame !!};

  var tasks =  {!! $jsonTasks !!};

  var modals =  {!! $jsonModals !!}; 

  var ratings =  {!! $jsonRatings !!}; 

  
  this.locked = true;
  this.available_modal = 1;
  this.ajaxError = false;

  this.category = {{ $category }};
  this.level    = {{ $level }};
  this.progress = savedGame.progress;
  this.rating   = 0;
  this.ruleError = 0;


  this.level_start = new Date();
  this.task_start = new Date();
  this.task_end = new Date();
  this.code = "";
  this.main_task = 0;
  
  this.saveObjectToString = savedGame.json;


  this.savedGameParsed = JSON.parse(savedGame.json);
  this.facingDirection = "";
  

  var blocklyArea = document.getElementById('blocklyArea');
  var blocklyDiv = document.getElementById('blocklyDiv');

  if(this.mobile)
  {
  var workspacePlayground = Blockly.inject(blocklyDiv,
   {toolbox: toolbox, scrollbars:  true, toolboxPosition: 'end', horizontalLayout:true, trashcan: true, zoom: {wheel: true}});
  workspacePlayground.scale = 0.6;

  }
  else
  {
  var workspacePlayground = Blockly.inject(blocklyDiv,
    {toolbox: toolbox, trashcan: true, scrollbars: true}); 
  } 



  Blockly.Xml.domToWorkspace(document.getElementById('startBlocks'),
                              workspacePlayground); 
  disableContextMenus();

  scrollWorkspace();




  if(this.category==2)  
  changeFacingDirectionImage(this.savedGameParsed.character.facingDirection);






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


  
 function showTaskButton() 
 {
  
          var modalStructure = {
  
          title: tasks[this.main_task].introduction_modal.title, 
          text: tasks[this.main_task].introduction_modal.text,
          image: getModalImageLink(tasks[this.main_task].introduction_modal.image, "level")

          };

          
          showDynamicModal("mainTaskShowed", modalStructure);

  }

 function deleteBlocksButton() 
   {
  
         
         var allBlocks = workspacePlayground.getAllBlocks();

         for (let i = 0; i<allBlocks.length; i++)
         {       

          if(allBlocks[i].type != "player" && allBlocks[i].type != "playerDirection")
          {
            
            allBlocks[i].dispose();
          }

         }
  }

  $('#reportBugModal').find('#reportBugTextArea').on("input", function()
  {
    
    var maxlength = $(this).attr("maxlength");
    var currentLength = $(this).val().length;

    var text = '';


    if( currentLength >= maxlength )
    {        
      text = "Dosiahli ste maximum povolených znakov.";
      $('#reportBugModal').find('#modal-text').html(text).end();

    }
    else
    {       
       text = "Ešte môžete napísať " + ( + maxlength - currentLength) + " znakov.";
       $('#reportBugModal').find('#modal-text').html(text).end();
    }

  });

  function reportBugButton() 
  {     
     var modal = $('#reportBugModal').modal();
     modal.show();

  }
  
  function reportBug() 
  { 
    if(isUserLoggedIn())
     {
      
    var user = {!! auth()->check() ? auth()->user() : 'guest' !!};

    var report = $('#reportBugModal').find('#reportBugTextArea').val();


    $.ajax({
     headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: 'POST', 
    url: '{{url('')}}/game/reportbug', 
    data: {'username' : user.username, 'category': this.category, 'level': this.level, 'report': report }, 
    success: function(response){ 
        console.log("reportbug object sent succesfully");  
    },
    error: function(textStatus, errorThrown) {        
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        console.log(textStatus);
        setAjaxError();        
    }
    });

    }
  
  }

  function changeFacingDirectionImage(direction) 
  {

    var player = getBlocksByType("playerDirection"); 

    this.facingDirection = direction;

    switch(direction)
    {
        case "right":
        {
          
          player[0].setFieldValue("{{ asset('game') }}/right.png", "facingDirection_image");
          break;
        }
        
        case "left":
        {
          player[0].setFieldValue("{{ asset('game') }}/left.png", "facingDirection_image");
          break;
        }

        case "up":
        {
          player[0].setFieldValue("{{ asset('game') }}/up.png", "facingDirection_image");
          break;
        }

        case "down":
        {
          player[0].setFieldValue("{{ asset('game') }}/down.png", "facingDirection_image");
          break;
        }


    }  

  
   }



  function blockClickController(event) 
  {  

    if(this.category==2)
    var player = getBlocksByType("playerDirection"); 
    else
    var player = getBlocksByType("player"); 

    /*           DEVELOPER BLOCKS
    var cameraplus = getBlocksByType("cameraplus");
    var cameraminus = getBlocksByType("cameraminus");
    var load = getBlocksByType("load");
    var save = getBlocksByType("save");
    var reload = getBlocksByType("reload"); 
    */          

    if(event.element=="click")
    {     
  
      blockToCheck = Blockly.selected;

 
     
      if(blockToCheck.id == player[0].id)
      {
        
        if(!this.locked)
          runCode();


        blockToCheck.unselect();
      }
      
      /*      DEVELOPER BLOCKS
      else if(blockToCheck.id == save[0].id)
      {
        saveGame();
        blockToCheck.unselect();
      }
      else if(blockToCheck.id == reload[0].id)
      {
        reloadIframe();
        blockToCheck.unselect();
      }  
        else if(blockToCheck.id == cameraplus[0].id)
      {
         cameraPlus();
        
         blockToCheck.unselect();
        
      }
      else if(blockToCheck.id == cameraminus[0].id)
      {
        cameraMinus();
      
        blockToCheck.unselect();
      }
       else if(blockToCheck.id == load[0].id)
      {
         loadGame();
         blockToCheck.unselect();
      }
      */
      
    }    
  }

  workspacePlayground.addChangeListener(blockClickController);  

  var onresize = function(e) 
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

  };
  
  
  $(window).resize(function() {    
    onresize();
  });
 
  onresize();
     
  function saveObjectToJson(object) 
  {
      
      var saveToDatabaseEnabled = true;
      
      var myJSON = JSON.stringify(object);
      this.saveObjectToString = myJSON;  

      if(saveToDatabaseEnabled)
      {
        saveJsonToDatabase();
      }

  }

  function saveJsonToDatabase() 
  {     
    
     if(isUserLoggedIn())
     {
      
    var user = {!! auth()->check() ? auth()->user() : 'guest' !!};

    $.ajax({
     headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: 'POST', 
    url: '{{url('')}}/game/savegame', 
    data: {'save' : this.saveObjectToString, 'user' : user.username, 'category': this.category, 'level': this.level, 'progress': this.progress }, //category + level
    success: function(response){ 
        console.log("save object sent succesfully");  
    },
    error: function(textStatus, errorThrown) {        
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        console.log(textStatus);
        setAjaxError(); 
    }
    });

    }
                   
  }

  function updateIngameProgress(task) 
  {

    if(isUserLoggedIn())
    {
 
    var progress = tasks[task].progress;

    var user = {!! auth()->check() ? auth()->user() : 'guest' !!};

    $.ajax({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: 'POST', 
    url: '{{url('')}}/game/updateingameprogress', 
    data: {'progress' : progress, 'user' : user.username, 'category': this.category, 'level': this.level }, //category + level
    success: function(response){ 
   console.log("ingameprogress object sent succesfully");  
    },
    error: function(textStatus, errorThrown) {        
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        console.log(textStatus);
        setAjaxError();  
    }
    });

    }
              
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

  function runCode()
  {

      
      $('#send_code_button').attr("onclick", "stopExecution()").end(); 
      $('#send_code_button').attr("class", "btn btn-danger mr-3").end(); 
      $('#send_code_button').html('<i class="fas fa-times"></i> Zastaviť vykonávanie').end(); 
 
      $('#show_task_button').attr("disabled", true).end(); 
      $('#delete_blocks_button').attr("disabled", true).end(); 
      $('#report_bug_button').attr("disabled", true).end(); 

      this.locked = true;
     

        if(failedBlock.length>0)
        {
          
          switch(failedBlock[0].type)
          {
            case "do_while_not_finished":
            failedBlock[0].setColour(230);
            break;

            case "for":
            failedBlock[0].setColour(230);
            break;

            case "if_next_tile_is":
            failedBlock[0].setColour(210);
            break;

            case "if_next_tile_has":
            failedBlock[0].setColour(210);
            break;


            default:
            failedBlock[0].setColour(160);
            break;


          }
          
          failedBlock.splice(0);
        }

        Blockly.JavaScript.STATEMENT_PREFIX = '%1\n';

        this.code = Blockly.JavaScript.workspaceToCode(workspacePlayground);   
        
        console.log(this.code);
        sendMessage(this.code);
  }

    function stopExecution()
    {

        var code = "stopExecution\n";
        
        sendMessage(code);


  }

    function cameraPlus()
    {

        var code = "camera+\n";
        
        sendMessage(code);


  }
    function cameraMinus()
    {

        var code = "camera-\n";
        
        sendMessage(code);

  }

    function saveGame()
    {

        
        var code = "save\n";

        sendMessage(code);  
        

  }

    function loadGame()
    {

        var code = "load\n";

        code +=  this.saveObjectToString;

        sendMessage(code);

  }

   function startGame()
   {

        var code = "start\n";
        code +=  this.saveObjectToString;        
        

        sendMessage(code);
  }


  function continueGame()
  {

    //workspacePlayground.clear();

    sendMessage("continue\n");

  }

  function reloadIframe()
  {

      document.getElementById("app-frame").src = document.getElementById("app-frame").src;

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

  function mainTaskIntroduced(task)
  {
     
     this.task_start = Date.now();

     task = "mainTask" + task;

     this.main_task = task;

     var modalStructure = {
  
     title: tasks[task].introduction_modal.title, 
     text: tasks[task].introduction_modal.text,
     image: getModalImageLink(tasks[task].introduction_modal.image, "level")

     };
     
    setTimeout(function(){

    showDynamicModal("mainTaskIntroduced", modalStructure);

    },500);     

  }

  function allMainTasksFinished()
  {    
     
     var modalStructure = {
  
     title: tasks.level.finish_modal.title,
     text: tasks.level.finish_modal.text,
     image:  getModalImageLink(tasks.level.finish_modal.image, "common")   

     };

    setTimeout(function(){

    showDynamicModal("allMainTasksFinished", modalStructure);

    },500);   


  }

  function levelIntroduced(task)
  {        
       
    var modalStructure = {
  
     title: tasks.level.welcome_modal.title,
     text:  tasks.level.welcome_modal.text,
     image: getModalImageLink(tasks.level.welcome_modal.image, "level"),
     task: task 

     };

    setTimeout(function(){

    showDynamicModal("levelIntroduced", modalStructure);

    },500);

  }

  function mainTaskCompleted(object)
  {     
    
     var task = "mainTask" + object.currentMainTask;    

     if(rateMainTaskCompletion(object))
     {


     this.progress = tasks[task].progress;

     var modalStructure = {
  
     title: tasks[task].success_modal.title,
     text:  tasks[task].success_modal.text,
     image:  getModalImageLink(tasks[task].success_modal.image, "common") 

     };  

     updateIngameProgress(task);

     createLogOfGameplay("mainTaskCompleted", object);
     
     setTimeout(function(){

     showDynamicModal("mainTaskCompleted", modalStructure);

     },500);   
   

     }
     else
     {

     mainTaskFailedRule(object);

     }


  }

  function mainTaskFailed(object)
  {

     var task = "mainTask" + object.currentMainTask;
     
     var modalStructure = {
  
     title: modals["maintaskfailed"].modal.title,   
     text:  modals["maintaskfailed"].modal.text,
     image: getModalImageLink(modals["maintaskfailed"].modal.image, "common")

     };

     createLogOfGameplay("mainTaskFailed", object);

     setTimeout(function(){

     showDynamicModal("mainTaskFailed", modalStructure);

     },500);  

  }

    function mainTaskFailedRule(object)
    {

     var task = "mainTask" + object.currentMainTask;
     
     var modalStructure = {
  
     title: modals["maintaskfailed"].modal.title,   
     text:  ratings[task].rules[this.ruleError].error,
     image: getModalImageLink(modals["maintaskfailed"].modal.image, "common")

     };

     createLogOfGameplay("mainTaskFailedRule", object);

     setTimeout(function(){

     showDynamicModal("mainTaskFailed", modalStructure);

     },500); 


  }


    function stoppedExecution(object)
  {
          
     var modalStructure = {
  
     title: modals["stoppedexecution"].modal.title,   
     text:  modals["stoppedexecution"].modal.text,
     image: getModalImageLink(modals["stoppedexecution"].modal.image, "common")

     };

     createLogOfGameplay("stoppedExecution", object);

     setTimeout(function(){

     showDynamicModal("mainTaskFailed", modalStructure);

     },500); 


  }


  function rateMainTaskCompletion(object)
  {
      var task = "mainTask" + object.currentMainTask;

      var isCorrect = true;
      var mistakeCount = 0;
      var playerSolution = String(object.commandArray);      
      playerSolution = playerSolution.split(",");
      this.code = playerSolution.slice();

      console.log(ratings);

      var solution = ratings[task].solution;
      solution = solution.split(",");

      //if there are any rules check if the solution passes 
      if(ratings[task].hasOwnProperty("rules"))
      {


            var ruleType;
            var rulesCount = Object.keys(ratings[task].rules).length;
            
            var ruleCount = 0;
            var actualCount = 0;

            

            for (var j=0; j<rulesCount;j++)
            {              
               if(j>0 && !isCorrect)
               {
               break;
               }

               this.ruleError = j;

               actualCount = 0;

               ruleType = ratings[task].rules[j].blocks.split(",");                       
               
               ruleCount = ratings[task].rules[j].count;

               isCorrect = false;

               for(var k in ruleType)
               {
               
               if(actualCount<ruleCount)
               {
                  for(var l in playerSolution)
                  {
                      if(playerSolution[l].startsWith(ruleType[k]))
                      {
                  
                      actualCount++;
                
                      if(actualCount==ruleCount)
                      {
                      isCorrect = true;    
                      break;
                      }
                      }
                  }
               }

               }


          }       
          
      }


      if(playerSolution.length==solution.length) //player's solution has same length as defined solution, but the order of blocks could be different
      {      
              var index = -1;

              for(var h=0; h<solution.length; h++)
              {

              index = -1;
              
              for(var i=0; i<playerSolution.length; i++)
              {

                  if(playerSolution[i]==solution[h])
                  {             
                    index = i;
                    break;
                  }            

              }

              if(index != -1)
                playerSolution.splice(index, 1);
              else
                mistakeCount++;


              console.log("H = " + h);
              console.log("playerSolution ");
              console.log(playerSolution);
              console.log("solution ");
              console.log(solution);
              console.log("mistakeCount ");
              console.log(mistakeCount);

              }                 
           
              if(mistakeCount < 4)
                this.rating = 5 - mistakeCount;
              else
                this.rating = 1;       


      }
      else //player's solution has different length than defined solution
      {
       
              if(playerSolution.length > solution.length)
              {
              
              mistakeCount = + playerSolution.length - solution.length;
                
              if(mistakeCount < 4)
                this.rating = 5 - mistakeCount;
              else
                this.rating = 1;


              }
              else
              {
                this.rating = 5;
              }

      }

      

      console.log("mistakeCount" + mistakeCount);
      console.log("ruleError" + this.ruleError);

 
      
      if(isCorrect) 
      {   
        return true; 
      }
      else
      { 
        this.rating = 0;
        return false;
      } 

      

    }



    function commandFailed(object)
    {
    
     console.log(object);    
     

     var title = "";
     var text = "";
     var image = "";

     if(object.commandNumber==1)
      text = "Váš prvý Blockly blok je chybný: <br>" 
     else if(object.commandNumber==2)
      text = "Váš prvý Blockly blok fungoval, ale v nasledujúcom nastala chyba: <br>"
     else 
      text = "Niekoľko vašich Blockly blokov fungovalo, ale potom nastala chyba: <br>"

      title = modals[object.failureType].modal.title;
      text += modals[object.failureType].modal.text; 
      image = getModalImageLink(modals[object.failureType].modal.image, "common");


     text += "<br> Chybný blok je zafarbený na červeno."


     var modalStructure = {
  
     title: title,
     text:  text,
     image: image

     };

     createLogOfGameplay("commandFailed", object);

     setTimeout(function(){

     showDynamicModal("mainTaskFailed", modalStructure);

     },500); 

  }

  function createLogOfGameplay(type, object)
  {

   if(isUserLoggedIn())
   {   

   var user =  {!! auth()->check() ? auth()->user() : 'guest' !!};   

   var level_start = convertDateToTime(this.level_start);
   var task = String(object.currentMainTask);
   var task_start = convertDateToTime(this.task_start);
   var task_end = null;
   var task_elapsed_time = null;
   var rating = null;
   var code = "";

   if(object.commandArray.length!=0)   
   code = String(object.commandArray);
   else
   code = "<empty>";

   var result = type;


   switch(type)
   {

    case "mainTaskCompleted":
    {
      task_elapsed_time = this.task_end - this.task_start;      
      task_elapsed_time = task_elapsed_time / 1000;
      task_end = convertDateToTime(this.task_end);
      rating = this.rating;
      break;

    }
    case "commandFailed":
    {

      result = object.failureType;
      break;
    }

   }


   $.ajax({
     headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method: 'POST', 
    url: '{{url('')}}/game/createlogofgameplay', 
    data: {'username' : user.username, 'category': this.category, 'level': this.level, 'level_start': level_start,
    'task': task, 'task_start': task_start, 'task_end': task_end, 'task_elapsed_time': task_elapsed_time, 'rating': rating, 'code': code, 'result': result}, 
    success: function(response){ 
    console.log("gameplay object sent succesfully");  
    },
    error: function(textStatus, errorThrown) {        
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        console.log(textStatus);
        setAjaxError();  
    }
    });

    }

    /* OBJECT STRUCTURE

    ("commandFailed", 
      {
      currentMainTask: currentMainTask[3],
      failureType: failuretype,
      commandNumber: this.commandsCurrent,
      commandArray: this.commandArray                                    
      });

      ("mainTaskFailed", {
        currentMainTask: mainTaskNumber,                                                        
        commandArray: this.commandArray

        }); 

      ("mainTaskCompleted", {
        currentMainTask: taskNumber,                                                        
        commandArray: this.entity.script.commandInterpreter.commandArray                                    
      });

    */



  }

  function convertDateToTime(dateToConvert)
  {
  
  function addZero(i) {
     if (i < 10) {
      i = "0" + i;
      }
     return i;
    }

  var date = new Date(dateToConvert);
  
  var h = addZero(date.getUTCHours());
  var m = addZero(date.getUTCMinutes());
  var s = addZero(date.getUTCSeconds());
  var hms = h + ":" + m + ":" + s;
  return hms;

  }

  function convertRatingToStars()
  {

    var result = '';
    for(var i=0; i < this.rating; i++)
    {
      result += '<i class="fas fa-star" style="color:#F9C10A"></i>';     
    }

    return result;

  }

    function convertCodeForModal()
  {

    var result = '';
    for(var i=0; i < this.code.length; i++)
    {
      result += this.code[i] + '<br>';     
    }

    return result;

  }


  function getModalImageLink(imageType, location)
  {
    var modalImageUrl = "{{ asset('game') }}";    

    if(location==="level")
    {    

    return modalImageUrl + '/' + this.category + 'x' + this.level + '/' + imageType + '.png';

    }
    else
    {
      return modalImageUrl + '/' + "common" + '/' + imageType + '.png';
    }


  }



  function showDynamicModal(type, modalStructure)
  {

      var modal = '';
      var html = '';

      if(this.available_modal==1)
      {
        this.available_modal=2;
        modal = $('#centeredModal1').modal();
      }
      else
      {
        this.available_modal=1;
        modal = $('#centeredModal2').modal();
      }

      if(this.ajaxError)
      {
        type = "ajaxError";
        modalStructure.title = modals["ajaxerror"].modal.title;  
        modalStructure.text = modals["ajaxerror"].modal.text;  
        modalStructure.image = getModalImageLink(modals["ajaxerror"].modal.image, "common");  
      }    



    switch(type)
    {

    case "levelIntroduced":
    {
     
    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    'mainTaskIntroduced('+ modalStructure.task +')';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Pokračovať';
    modal.find('#modal-button').html(html).end();   

    break;

    }

    case "mainTaskIntroduced":
    {
     
    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    'continueGame()';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Pokračovať';
    modal.find('#modal-button').html(html).end();     

    break;
    }

    case "mainTaskShowed":
    {
     
    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    '';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Pokračovať';
    modal.find('#modal-button').html(html).end();    

    break;
    }

    case "mainTaskCompleted":
    {
     
    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    
    var task_elapsed_time = this.task_end - this.task_start; 
    task_elapsed_time = convertDateToTime(task_elapsed_time);

    html += '<br><br> <h4><i class="fas fa-stopwatch"></i> Čas:</h4>'+ task_elapsed_time;
    html += '<br><br> <h4><a data-toggle="collapse" href="#collapseCode"><i class="fas fa-code"></i> Kód:</a></h4>'
    html += '<div class="collapse" id="collapseCode">';
    html += '<div><code>';
    html += convertCodeForModal();
    html += '</div></code>';
    html += '</div>';
    html += '<br><br> <h4><i class="fas fa-star-half-alt"></i> Hodnotenie:</h4>' + convertRatingToStars();
    modal.find('#modal-text').html(html).end();  
  


    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    'continueGame()';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Pokračovať';
    modal.find('#modal-button').html(html).end();   

    break;
    }


    case "mainTaskFailed":
    {
     
    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html =    'loadGame()';
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Skúsiť znova';
    modal.find('#modal-button').html(html).end();     

  

    break;
    }

    case "ajaxError":
    {
     
    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;
    modal.find('#modal-text').html(html).end();

    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    html = 'window.location.href=\''; 
    html += '{{ url('/')}}' + '\';'; 
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Ukončiť hru';
    modal.find('#modal-button').html(html).end();     

  

    break;
    }


    case "allMainTasksFinished":
    {
     
    html = modalStructure.title;
    modal.find('#modal-heading').html(html).end();

    html = modalStructure.text;  
    modal.find('#modal-text').html(html).end();  


    html = modalStructure.image;
    modal.find('#modal-image').attr("src", html).end(); 

    
    html = 'window.location.href=\''; 
    html += '{{ url('/')}}' + '/start/' + this.category + '/' + (this.level+1) + '\';';    
    modal.find('#modal-button').attr("onclick", html).end(); 
    html = 'Ďalšia úroveň';
    modal.find('#modal-button').html(html).end();    

    break;
    }

    }  


    modal.modal('show'); 




  }

    function setAjaxError()
  {
    this.ajaxError = true;
  }    

  function sendMessage(messageForGame)
  {
        var iframe = document.getElementById("app-frame");
        
        iframe.contentWindow.postMessage
        (
        { message: messageForGame }, 
    
        "https://playcanv.as/p/62c28f63/"
        //"{{url('')}}"
        );

  }

  function isUserLoggedIn()
  {    
  var loggedIn = {{ auth()->check() ? true : false }};
  if (loggedIn)  
    return true;  
  else   
    return false;
  }

</script>