<template>
<header class="game-header">
<div class="game-container">
<div class="row h-100 w-100 no-padding">
    <div class="col-lg-6 no-padding">
        <iframe id="app-frame" class="game-playcanvas" ref="iframe"  
        :src="this.$global.Url(`game/playcanvas/${levelString}.html`)"></iframe> 
        <!-- src="https://playcanv.as/e/p/62c28f63/"></iframe>-->             
    </div>
    <div class="col-lg-6 no-padding">
        <div class="row h-100 w-100 no-padding">
            <div class="col-lg-12 game-blockly" id="blocklyArea" ref="blocklyArea">            
            </div>
            <div class= "col-lg-12 game-buttons mx-auto text-center" id="gameButtons">
            <!-- <div class= "btn-group" role="group">
                <button type="button" id="send_code_button" class="btn btn-success mr-3" onclick="runCode()" disabled><i class="fas fa-play"></i> Spustiť bloky</button>
                <button type="button" id="show_task_button" class="btn btn-success mr-3" onclick="showTaskButton()" disabled><i class="fas fa-tasks"></i> Zadanie úlohy</button>
                <button type="button" id="delete_blocks_button" class="btn btn-success mr-3" onclick="deleteBlocksButton()" disabled><i class="fas fa-trash"></i> Vymazať všetky bloky</button>       
                <button type="button" id="report_bug_button" class="btn btn-success mr-3" onclick="reportBugButton()" disabled><i class="fas fa-bug"></i> Nahlásiť chybu</button>                 
            </div> -->
            <div class= "btn-group d-flex" role="group">
                <button type="button" id="send_code_button" class="btn btn-success mr-3 w-100" onclick="runCode()" disabled><i class="fas fa-play"></i> Spustiť bloky</button>
                <button type="button" id="show_task_button" class="btn btn-success mr-3 w-100" onclick="showTaskButton()" disabled><i class="fas fa-tasks"></i> Zadanie úlohy</button>
                <button type="button" id="delete_blocks_button" class="btn btn-success mr-3 w-100" onclick="deleteBlocksButton()" disabled><i class="fas fa-trash"></i> Vymazať všetky bloky</button>       
                <button type="button" id="report_bug_button" class="btn btn-success mr-3 w-100" onclick="reportBugButton()" disabled><i class="fas fa-bug"></i> Nahlásiť chybu</button>                 
            </div>
            </div>
        </div>
    </div>
</div>
</div>
<div id="blocklyDiv" ref="blocklyDiv" style="position: absolute;"></div>
</header>
</template>

<script>
// import '../../../../../public/blockly/blockly_compressed';
// import '../../../../../public/blockly/blocks_compressed';
// import '../../../../../public/blockly/javascript_compressed';
// import '../../../../../public/blockly/msg/js/en';
import * as Blockly from 'blockly/core';
import 'blockly/blocks';
import 'blockly/javascript';
// import * as En from 'blockly/msg/en';
// import '../Game/BlocklyDefinitions';
import * as $ from 'jquery';
import * as BlocklyController from '../Game/BlocklyController';
import { convertDateToTime, sendRequest, getModalImageLink } from '../Game/Common';
import ModalManager from '../Managers/ModalManager';

// const headers = {
// 	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// };

export default {
	data(){
		return {
			failedBlock: [],
			toolbox: this.gameData.xmlToolbox,
			savedGame: this.gameData.savedGame,
			tasks: JSON.parse(this.gameData.jsonTasks),
			modals: JSON.parse(this.gameData.jsonModals),
			ratings: JSON.parse(this.gameData.jsonRatings),
			locked: true,
			available_modal: 1,
			ajaxError: false,
			levelString: `${this.category}x${this.level}`,
			progress: this.gameData.savedGame.progress,
			rating: 0,
			ruleError: 0,
			level_start: new Date(),
			task_start: new Date(),
			task_end: new Date(),
			code: '',
			main_task: 0,
			saveObjectToString: this.gameData.savedGame.json,
			savedGameParsed: JSON.parse(this.gameData.savedGame.json),
			facingDirection: '',
			workspacePlayground: undefined
		};
	},
	props: {
		category: String,
		level: String,
		gameData: Object
	},
	created(){
		BlocklyController.createBlocklyBlocks(this.$global.Url());
	},        
	mounted() {
		console.log('GameHeader mounted:');   
		console.log(this.$data);	
		
		this.workspacePlayground = BlocklyController.createWorkspacePlayground(
			this.$refs.blocklyDiv, 
			this.$refs.blocklyArea, 
			this.startBlocks, 
			{
				toolbox: this.toolbox, trashcan: true, scrollbars: true
			}
			/* MOBILE TO DO
			{
				toolbox: toolbox, scrollbars:  true, toolboxPosition: 'end', horizontalLayout:true, trashcan: true, zoom: {wheel: true}
			}
			 workspacePlayground.scale = 0.6;
			*/
		);

		if(this.category == 2){
			BlocklyController.changeFacingDirectionImage(this.savedGameParsed.character.facingDirection);
		}
		
		ModalManager.enableModals(this.modals);
		window.addEventListener('message', this.eventer);      
	},
	methods: {
		eventer(e)
		{
			console.log('Web-side script has received message from game:  ', e.data);
			switch(e.data.action)
			{
			case 'unlock':
			{
				this.enableButtons();
				this.workspacePlayground.highlightBlock(null);
				this.locked = false;
				break;
			}
			case 'start':
			{
				// if(this.mobile) TO DO				
				this.sendMessage(`start\n${this.saveObjectToString}`);
				break;     
			}
			case 'introduction':
			{
				this.level_start = Date.now(); 

				if(this.progress==0)
				{				
					const modalStructure = {  
						title: this.tasks.level.welcome_modal.title,
						text:  this.tasks.level.welcome_modal.text,
						image: getModalImageLink(this.tasks.level.welcome_modal.image, 'level'),
						task: e.data.content
					};
					ModalManager.showDynamicModal('levelIntroduced', modalStructure);
					break;
				}

				this.task_start = Date.now();
				this.main_task = 'mainTask' + e.data.content;

				const modalStructure = {  
					title: this.tasks[this.main_task].introduction_modal.title, 
					text: this.tasks[this.main_task].introduction_modal.text,
					image: getModalImageLink(this.$global.Url('game'), this.tasks[this.main_task].introduction_modal.image, 'level')
				};

				ModalManager.showDynamicModal('mainTaskIntroduced', modalStructure);			
				break;     
			}

			case 'highlightProgress':
			{
				this.highlightBlock(e.data.content);
				break;     
			}

			case 'highlightFailure':
			{                    
				let block = this.workspacePlayground.getBlockById(e.data.content);
				block.setColour(0); //COMMAND FAILED BLOCK IS RED 
				this.failedBlock.push(block);
				break;     
			}
			case 'mainTaskCompleted':
			{
				this.workspacePlayground.highlightBlock(null);
				$('#send_code_button').attr('disabled', true).end();       
                    
				this.task_end = Date.now();
                    
				this.mainTaskCompleted(e.data.content);
				break;     
			}
			case 'commandFailed': 
			{
				this.workspacePlayground.highlightBlock(null);
				$('#send_code_button').attr('disabled', true).end();
				this.commandFailed(e.data.content);                    
				break;     
			}
			case 'mainTaskFailed': 
			{

				this.workspacePlayground.highlightBlock(null);
				$('#send_code_button').attr('disabled', true).end();

				this.mainTaskFailed(e.data.content);                    
				break;     
			}
			case 'stoppedExecution': 
			{

				this.workspacePlayground.highlightBlock(null);
				$('#send_code_button').attr('disabled', true).end();

				this.stoppedExecution(e.data.content);
				break;     
			}
			case 'nextMainTask':
			{
				this.workspacePlayground.highlightBlock(null);      
				this.mainTaskIntroduced(e.data.content);
				break;
			}
			case 'allMainTasksFinished':
			{
				this.allMainTasksFinished();
				break;     
			}
			case 'save':
			{
				this.saveObjectToJson(e.data.content);
				break;     
			}
			case 'changeFacingDirection':
			{                    
				if(this.category==2)
					this.changeFacingDirectionImage(e.data.content);
			}
			}
		},
		enableButtons()
		{
			$('#send_code_button').attr('onclick', 'runCode()').end();
			$('#send_code_button').attr('class', 'btn btn-success mr-3').end();  
			$('#send_code_button').html('<i class="fas fa-play"></i> Spustiť bloky').end(); 
			$('#send_code_button').attr('disabled', false).end(); 
                
			$('#show_task_button').attr('disabled', false).end(); 
			$('#delete_blocks_button').attr('disabled', false).end(); 
			$('#report_bug_button').attr('disabled', false).end(); 
		},
		async createLogOfGameplay(type, object)
		{
			if(this.isUserLoggedIn)
			{
				return;
			}
			const level_start = convertDateToTime(this.level_start);
			const task = String(object.currentMainTask);
			const task_start = convertDateToTime(this.task_start);
			let task_end = null;
			let task_elapsed_time = null;
			let rating = null;
			let code = '';

			if(object.commandArray.length!=0)   
				code = String(object.commandArray);
			else
				code = '<empty>';

			let result = type;

			switch(type)
			{
			case 'mainTaskCompleted':
			{
				task_elapsed_time = this.task_end - this.task_start;      
				task_elapsed_time = task_elapsed_time / 1000;
				task_end = convertDateToTime(this.task_end);
				rating = this.rating;
				break;
			}
			case 'commandFailed':
			{
				result = object.failureType;
				break;
			}
			}

			const data = {'username' : this.userName, 'category': this.category, 'level': this.level, 'level_start': level_start,
				'task': task, 'task_start': task_start, 'task_end': task_end, 'task_elapsed_time': task_elapsed_time, 'rating': rating, 'code': code, 'result': result
			};
            
			try {
				await sendRequest({method:'POST', url: this.$global.Url('createlogofgameplay'), data});           
			}
			catch (e) {
				this.ajaxError = true;                     
			}
		},
		sendMessage(message)
		{        
			this.$refs.iframe.contentWindow.postMessage(
				{ message },    
				//"https://playcanv.as/p/62c28f63/"
				this.$global.Url()
			);
		}
	},
	computed: {
		isUserLoggedIn()
		{
			return this.$global.User ? true : false;
		},
		userName()
		{             
			return this.$global.User ? this.$global.User.username : undefined;
		},
		startBlocks()
		{
			//TO DO: move to back end
			let xmlString;
			switch(this.category){
			case '1':
				xmlString = '<xml><block type="player" movable="false" deletable="false" inline="false" x="0" y="0"></block></xml>';
				break;
			case '2':
				xmlString =  '<xml><block type="player" movable="false" deletable="false" inline="false" x="0" y="0"></block></xml>';
				break;
			default:
				xmlString =  '<xml><block type="player" movable="false" deletable="false" inline="false" x="0" y="0"></block></xml>';
				break;
			}
			// return ( new window.DOMParser() ).parseFromString(xmlString, 'text/xml');
			return xmlString;
		}
	},
	destroyed(){
		window.removeEventListener('message', this.eventer);
	}
};
</script>