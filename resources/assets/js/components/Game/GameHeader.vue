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
            <div class= "btn-group d-flex" role="group">
					<button v-if="gameExecutingCode" type="button" id="stop_execution_button" class="btn btn-danger mr-3 w-100" 
						v-on:click="stopExecution($event)"><i class="fas fa-times"></i> Zastaviť vykonávanie</button>
					<button v-else type="button" id="send_code_button" class="btn btn-success mr-3 w-100" 
						v-on:click="runCode()" :disabled="locked"><i class="fas fa-play"></i> Spustiť bloky</button>
					<button type="button" id="show_task_button" class="btn btn-success mr-3 w-100" v-on:click="showTaskButton()" :disabled="locked"><i class="fas fa-tasks"></i> Zadanie úlohy</button>
					<button type="button" id="delete_blocks_button" class="btn btn-success mr-3 w-100" v-on:click="deleteAllBlocksButton()" :disabled="locked"><i class="fas fa-trash"></i> Vymazať všetky bloky</button>       
					<button type="button" id="report_bug_button" class="btn btn-success mr-3 w-100" v-on:click="reportBugButton()" :disabled="locked"><i class="fas fa-bug"></i> Nahlásiť chybu</button>                 
            </div>
            </div>
        </div>
    </div>
</div>
</div>
<div id="blocklyDiv" ref="blocklyDiv" style="position: absolute;"></div>
<Modal 
		v-for="(modal, index) in modalsArray"
		:heading="modal.heading"
		:text="modal.text"
		:image-url="modal.imageUrl"
		:buttons="modal.buttons"
		:reportBug="modal.reportBug || undefined"
		:id="modal.id"
		:key="index"
/>
</header>                
</template>

<script>
import * as $ from 'jquery';
import BlocklyManager from '../Managers/BlocklyManager';
import { convertDateToTime, sendRequest, rateMainTaskCompletion } from '../Managers/Common';
import ModalManager from '../Managers/ModalManager';
import Modal from './Modal';
import HistoryManager from '../Managers/HistoryManager';

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
			workspacePlayground: undefined,
			modalsArray: [],
			gameExecutingCode: false,
			LOGGING_ENABLED: true,
			SAVING_ENABLED: false,
			UPDATING_PROGRESS_ENABLED: false
		};
	},
	components: {
		Modal
	},
	props: {
		category: String,
		level: String,
		gameData: Object
	},
	created(){
		BlocklyManager.createBlocklyBlocks(this.$global.Url());
	},        
	mounted() {
		console.log('GameHeader mounted:');   
		console.log(this.$data);	
		
		this.workspacePlayground = BlocklyManager.createWorkspacePlayground(
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
			BlocklyManager.changeFacingDirectionImage(this.savedGameParsed.character.facingDirection);
		}
		
		ModalManager.enableModals(this.modalsArray, this.$global.Url('game'), this.modals['ajaxerror'].modal, this.reportBug);
		window.addEventListener('message', this.eventer);      
		// this.$on('EVENT', (obj) => {
		// });
	},
	methods: {
		eventer(e)
		{
			if(!e.data.action)
			{
				return;
			}
			console.log('Web-side script has received message from game:  ', e.data);
			switch(e.data.action)
			{
			case 'unlock':
			{
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
					ModalManager.showDynamicModal('levelIntroduced', { 
						data: this.tasks.level.welcome_modal, 
						imageLocation: this.levelString,
						onclick: this.mainTaskIntroduced.bind(null, e.data.content)
					});
					break;
				}
				this.mainTaskIntroduced(e.data.content);							
				break;     
			}

			case 'highlightProgress':
			{
				this.workspacePlayground.highlightBlock(e.data.content);
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
				this.gameExecutingCode = false;
                    
				this.task_end = Date.now();
                    
				this.mainTaskCompleted(e.data.content);
				break;     
			}
			case 'commandFailed': 
			{
				this.workspacePlayground.highlightBlock(null);
				this.gameExecutingCode = false;

				this.commandFailed(e.data.content);                    
				break;     
			}
			case 'mainTaskFailed': 
			{
				this.workspacePlayground.highlightBlock(null);
				this.gameExecutingCode = false;

				this.mainTaskFailed(e.data.content);                    
				break;     
			}
			case 'stoppedExecution': 
			{
				this.workspacePlayground.highlightBlock(null);
				this.gameExecutingCode = false;

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
		async createLogOfGameplay(type, object)
		{
			if(!this.isUserLoggedIn || !this.LOGGING_ENABLED)
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
				await sendRequest({method:'POST', url: this.$global.Url('game/createlogofgameplay'), data});           
			}
			catch (e) {
				ModalManager.setAjaxError();                    
			}
		},
		sendMessage(message)
		{        
			this.$refs.iframe.contentWindow.postMessage(
				{ message },    
				//"https://playcanv.as/p/62c28f63/"
				this.$global.Url()
			);
		},
		mainTaskIntroduced(task)
		{
			this.task_start = Date.now();
			this.main_task = 'mainTask' + task;

			ModalManager.showDynamicModal('mainTaskIntroduced', { 
				data: this.tasks[this.main_task].introduction_modal, 
				imageLocation: this.levelString,
				onclick: this.sendMessage.bind(null, 'continue\n')
			});
		},
		mainTaskFailed(object)
		{		
			this.gameExecutingCode = false;
			this.createLogOfGameplay('mainTaskFailed', object);		

			ModalManager.showDynamicModal('mainTaskFailed', { 
				data: this.modals['maintaskfailed'].modal, 
				imageLocation: 'common',
				onclick: this.sendMessage.bind(null, `load\n${this.saveObjectToString}`)
			});
		},
		showTaskButton() 
		{
			ModalManager.showDynamicModal('mainTaskShowed', { 
				data: this.tasks[this.main_task].introduction_modal, 
				imageLocation: this.levelString,
				onclick: () => {}
			});
		},
		reportBugButton()
		{
			ModalManager.showReportBugModal();
		},
		reportBug(report)
		{
			if(!this.isUserLoggedIn)
			{
				ModalManager.setAjaxError();
				return;
			}

			const data = {'username' : this.userName, 'category': this.category, 'level': this.level, 'report': report };

			try {
				sendRequest({method:'POST', url: this.$global.Url('game/reportbug'), data});           
			}
			catch (e) {
				ModalManager.setAjaxError();                    
			}
		},		
		deleteAllBlocksButton()
		{
			BlocklyManager.deleteAllBlocks();
		},
		runCode()
		{			
			this.gameExecutingCode = true; 
			this.locked = true;	

			BlocklyManager.clearFailedBlocks(this.failedBlock);			

			this.code = BlocklyManager.getWorkspaceCode();
			this.sendMessage(this.code);
		},		
		stopExecution(event)
		{
			event.target.disabled = true;
			this.sendMessage('stopExecution\n');
		},
		stoppedExecution(object)
		{
			this.createLogOfGameplay('stoppedExecution', object);

			ModalManager.showDynamicModal('mainTaskFailed', { 
				data: this.modals['stoppedexecution'].modal, 
				imageLocation: 'common',
				onclick: this.sendMessage.bind(null, `load\n${this.saveObjectToString}`)
			});
			
		},
		commandFailed(object)
		{ 		
			let text = '';

			if(object.commandNumber==1)
				text = 'Váš prvý Blockly blok je chybný: <br>'; 
			else if(object.commandNumber==2)
				text = 'Váš prvý Blockly blok fungoval, ale v nasledujúcom nastala chyba: <br>';
			else 
				text = 'Niekoľko vašich Blockly blokov fungovalo, ale potom nastala chyba: <br>';

			let title = this.modals[object.failureType].modal.title;
			text += this.modals[object.failureType].modal.text; 
			let image = this.modals[object.failureType].modal.image;
			text += '<br> Chybný blok je zafarbený na červeno.';

			this.createLogOfGameplay('commandFailed', object);			
			
			ModalManager.showDynamicModal('mainTaskFailed', { 
				data: {title, text, image}, 
				imageLocation: 'common',
				onclick: this.sendMessage.bind(null, `load\n${this.saveObjectToString}`) 
			});
		},
		async saveObjectToJson(object){
			this.saveObjectToString = JSON.stringify(object);  
			this.gameData.savedGame.json = this.saveObjectToString;
			this.gameData.savedGame.progress = this.progress;
			this.$emit('UPDATE_PROGRESS', {category: this.category, level: this.level, progress: this.progress});
			HistoryManager.changeView('game', this.gameData, '', ''); 

			if(this.SAVING_ENABLED && this.isUserLoggedIn)
			{									
				const data = {'save' : this.saveObjectToString, 'user' : this.userName, 'category': this.category, 'level': this.level, 'progress': this.progress };				           
				try {
					await sendRequest({method:'POST', url: this.$global.Url('game/savegame'), data});           
				}
				catch (e) {
					ModalManager.setAjaxError();                    
				}  
			}			
		},
		mainTaskCompleted(object)
		{   
			const task = 'mainTask' + object.currentMainTask;
			this.code = String(object.commandArray).split(',').slice();
			this.rating = rateMainTaskCompletion(object, this.ratings);

			if(this.rating)
			{
				this.progress = this.tasks[task].progress;

				this.updateIngameProgress(task);		

				this.createLogOfGameplay('mainTaskCompleted', object);     
				
				ModalManager.showDynamicModal('mainTaskCompleted', { 
					data: this.tasks[task].success_modal, 
					imageLocation: 'common',
					onclick: this.sendMessage.bind(null, 'continue\n'),
					task_elapsed_time: this.task_end - this.task_start,
					code: this.code,
					rating: this.rating
				});
			}
			else
			{
				this.mainTaskFailedRule(object);
			}
		},
		async updateIngameProgress(task)
		{
			if(!this.isUserLoggedIn || !this.UPDATING_PROGRESS_ENABLED)
			{
				return; 
			}

			var progress = this.tasks[task].progress;
			const data = {'progress' : progress, 'user' : this.userName, 'category': this.category, 'level': this.level }; 
			try {
				await sendRequest({method:'POST', url: this.$global.Url('game/savegame'), data});           
			}
			catch (e) {
				ModalManager.setAjaxError();                    
			}  			
		},
		allMainTasksFinished()
		{	 
			ModalManager.showDynamicModal('allMainTasksFinished', { 
				data: this.tasks.level.finish_modal, 
				imageLocation: 'common',
				onclick: this.loadNextLevel
			});
		},
		async loadNextLevel()
		{			
			try {
				const result = await sendRequest({method: 'GET', headers: {'Accept': 'application/json'}, url: this.$global.Url(`start/${this.category}/${this.level+1}`)});           
				this.$global.GameData.push(result);
				HistoryManager.changeView('game', result, '', `/game/${this.category}/${this.level}`, true);
			}
			catch (e) {
				// modal error window?
				console.log('AJAX loadNextLevel:', e);
			}
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