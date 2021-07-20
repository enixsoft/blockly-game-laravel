<template>
<header class="game-header">
<div class="game-container">
<div class="row h-100 w-100 no-padding">
    <div v-if="isUserLoggedIn" class="col-lg-6 no-padding">
        <iframe id="app-frame" class="game-playcanvas" ref="iframe"  
        :src="this.$global.Url(`game/playcanvas/${levelString}.html?target=${target}`)"></iframe> 
        <!-- src="https://playcanv.as/e/p/62c28f63/"></iframe>-->             
    </div>
    <div v-if="isUserLoggedIn" class="col-lg-6 no-padding">
        <div class="row h-100 w-100 no-padding">
            <div class="col-lg-12 game-blockly" id="blocklyArea" ref="blocklyArea">            
            </div>
            <div class= "col-lg-12 game-buttons mx-auto text-center" id="gameButtons">
            <div class= "btn-group d-flex" role="group">
					<button v-if="gameExecutingCode" type="button" id="stop_execution_button" class="btn btn-danger mr-3 w-100" 
						v-on:click="stopExecution($event)"><i class="fas fa-times"></i> {{ locales.stopExecution }}</button>
					<button v-else type="button" id="send_code_button" class="btn btn-success mr-3 w-100" 
						v-on:click="runCode()" :disabled="locked"><i class="fas fa-play"></i> {{ locales.sendCode }}</button>
					<button type="button" id="show_task_button" class="btn btn-success mr-3 w-100" v-on:click="showTaskButton()" :disabled="locked"><i class="fas fa-tasks"></i> {{ locales.showTask }}</button>
					<button type="button" id="delete_blocks_button" class="btn btn-success mr-3 w-100" v-on:click="deleteAllBlocksButton()" :disabled="locked"><i class="fas fa-trash"></i> {{ locales.deleteBlocks }}</button>       
					<button type="button" id="report_bug_button" class="btn btn-success mr-3 w-100" v-on:click="reportBugButton()" :disabled="locked"><i class="fas fa-bug"></i> {{ locales.reportBug }}</button>                 
            </div>
            </div>
        </div>
    </div>
</div>
</div>
<div v-if="isUserLoggedIn" id="blocklyDiv" ref="blocklyDiv" style="position: absolute;"></div>
<Modal 
		ref="modal"
		:heading="modalData.heading"
		:text="modalData.text"
		:image-url="modalData.imageUrl"
		:buttons="modalData.buttons"
		:reportBug="modalData.reportBug || undefined"	
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
import { game as locales, blocks as blocksLocales } from '../Managers/LocaleManager';

export default {
	data(){
		return {
			category: this.gameData.category,
			level: this.gameData.level,
			locales: this.$global.getLocalizedStrings(locales),
			failedBlock: [],
			toolbox: this.gameData.xmlToolbox,
			startBlocks: this.gameData.xmlStartBlocks,
			savedGame: this.gameData.savedGame,
			tasks: JSON.parse(this.gameData.jsonTasks),
			modals: JSON.parse(this.gameData.jsonModals),			
			ratings: JSON.parse(this.gameData.jsonRatings),
			levelString: `${this.gameData.category}x${this.gameData.level}`,
			locked: true,
			progress: this.gameData.savedGame.progress,
			rating: 0,
			ruleError: 0,
			level_start: new Date(),
			task_start: new Date(),
			task_end: new Date(),
			code: '',
			main_task: '',
			saveObjectToString: this.gameData.savedGame.json,
			savedGameParsed: JSON.parse(this.gameData.savedGame.json),
			workspacePlayground: undefined,
			modalData: { 
				heading: '',
				text: '',
				imageUrl: '',
				buttons:[{
					onclick: () => {},
					text: ''
				}]},
			gameExecutingCode: false,
			LOGGING_ENABLED: true,
			SAVING_ENABLED: true,
			UPDATING_PROGRESS_ENABLED: true
		};
	},
	components: {
		Modal
	},
	props: {
		// category: String,
		// level: String,
		gameData: Object
	},
	created(){
		BlocklyManager.createBlocklyBlocks(this.$global.Url(), this.$global.getLocalizedStrings(blocksLocales));
	},        
	mounted() {
		ModalManager.enableModals(this.$refs.modal.$refs.centeredModal, this.modalData, this.$global.Url('game'), this.locales);

		if(!this.isUserLoggedIn)
		{
			ModalManager.showDynamicModal('ajaxError', { 
				data: {
					title: this.$global.getLocalizedString('modals.ajaxerror.title'),
					text: this.$global.getLocalizedString('modals.ajaxerror.text'),
					image: this.modals.ajaxerror.modal.image, 
				},
				imageLocation: 'common',
				onclick: () => window.location.reload()
			});
		}		
		
		this.workspacePlayground = BlocklyManager.createWorkspacePlayground(
			this.$refs.blocklyDiv, 
			this.$refs.blocklyArea, 			
			this.startBlocks, 
			(this.$global.Mobile ?
				{
					toolbox: this.toolbox, scrollbars:  true, toolboxPosition: 'end', horizontalLayout:true, trashcan: true, zoom: {wheel: true}
				}
				:
				{
					toolbox: this.toolbox, trashcan: true, scrollbars: true
				}),
			{
				player: this.runCode.bind(null, this.$global.User.role==='admin')
			}
		);
		if(this.$global.Mobile)
		{
			this.workspacePlayground.scale = 0.6;
		}
		
		BlocklyManager.changeFacingDirectionImage(this.$global.Url('game'), this.savedGameParsed.character.facingDirection);
		window.addEventListener('message', this.eventer);      
		// this.$on('EVENT', (obj) => {
		// });
	},
	methods: {
		eventer(e)
		{
			if(!e.data.action || e.origin !== window.location.origin)
			{
				return;
			}
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
				if(this.$global.Mobile)
				{
					this.sendMessage('camera+\n');	
					this.sendMessage('camera+\n');
					this.sendMessage('camera+\n');
					this.sendMessage('camera+\n');				
				}
				this.sendMessage(`start\n${this.saveObjectToString}`);
				break;     
			}
			case 'introduction':
			{
				this.level_start = Date.now(); 

				if(this.progress==0)
				{
					ModalManager.showDynamicModal('levelIntroduced', { 
						data: {
							title: `${this.locales.category} ${this.category} ${this.locales.level} ${this.level}`,
							text: this.$global.getLocalizedString(`${this.levelString}.welcome_modal.text`),
							image: this.tasks.level.welcome_modal.image, 
						},
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
				BlocklyManager.changeFacingDirectionImage(this.$global.Url('game'), e.data.content);				
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

			const data = {'category': Number(this.category), 'level': Number(this.level), 'level_start': level_start,
				'task': Number(task), 'task_start': task_start, 'task_end': task_end, 'task_elapsed_time': Math.round(task_elapsed_time), 'rating': Number(rating), 'code': code, 'result': result
			};
            
			try {
				await sendRequest({method:'POST', url: this.$global.Url('game/createlogofgameplay'), data});           
			}
			catch (e) {
				ModalManager.showDynamicModal('ajaxError', { 
					data: {
						title: this.$global.getLocalizedString('modals.ajaxerror.title'),
						text: this.$global.getLocalizedString('modals.ajaxerror.text'),
						image: this.modals.ajaxerror.modal.image, 
					},
					imageLocation: 'common',
					onclick: () => window.location.reload()
				});                   
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
				data: {
					title: this.$global.getLocalizedString(`${this.main_task}.introduction_modal.title`),
					text: this.$global.getLocalizedString(`${this.levelString}.${this.main_task}.introduction_modal.text`),
					image: this.tasks[this.main_task].introduction_modal.image, 
				},
				imageLocation: this.levelString,
				onclick: this.sendMessage.bind(null, 'continue\n')
			});
		},
		mainTaskFailed(object)
		{		
			this.gameExecutingCode = false;
			this.createLogOfGameplay('mainTaskFailed', object);		

			ModalManager.showDynamicModal('mainTaskFailed', { 
				data: {
					title: this.$global.getLocalizedString('modals.maintaskfailed.title'),
					text: this.$global.getLocalizedString('modals.maintaskfailed.text'),
					image: this.modals['maintaskfailed'].modal.image, 
				},
				imageLocation: 'common',
				onclick: this.sendMessage.bind(null, `load\n${this.saveObjectToString}`)
			});
		},
		mainTaskFailedRule(object)
		{
			this.gameExecutingCode = false;
			this.createLogOfGameplay('mainTaskFailedRule', object);

			const rule = this.ratings[this.main_task].rules[this.ruleError];
			let text = this.locales.ruleError;
			text += ' ' + this.locales[rule.block] + '.<br>';
			if(rule.count>1)
			{
				text += this.locales.ruleErrorCount + ' ' + rule.count + ' ' + this.locales.ruleErrorTimes + '.<br>';
			}
			text += this.locales.ruleErrorTryAgain;

			ModalManager.showDynamicModal('mainTaskFailed', { 
				data: { 
					title: this.$global.getLocalizedString('modals.maintaskfailed.title'),
					text,
					image: this.modals['maintaskfailed'].modal.image, 
				}, 
				imageLocation: 'common',
				onclick: this.sendMessage.bind(null, `load\n${this.saveObjectToString}`)
			});
		},
		showTaskButton() 
		{
			ModalManager.showDynamicModal('mainTaskShowed', { 
				data: {
					title: this.$global.getLocalizedString(`${this.main_task}.introduction_modal.title`),
					text: this.$global.getLocalizedString(`${this.levelString}.${this.main_task}.introduction_modal.text`),
					image: this.tasks[this.main_task].introduction_modal.image
				},
				imageLocation: this.levelString,
				onclick: () => {}
			});
		},
		reportBugButton()
		{			
			ModalManager.showDynamicModal('reportBug', {			
				onclick: this.reportBug					
			});
				
		},
		reportBug(report)
		{
			if(!report.length)
			{
				return;
			}
			
			if(!this.isUserLoggedIn)
			{
				ModalManager.showDynamicModal('ajaxError', { 
					data: {
						title: this.$global.getLocalizedString('modals.ajaxerror.title'),
						text: this.$global.getLocalizedString('modals.ajaxerror.text'),
						image: this.modals.ajaxerror.modal.image, 
					},
					imageLocation: 'common',
					onclick: () => window.location.reload()
				});
				return;
			}

			const data = {'category': Number(this.category), 'level': Number(this.level), 'report': report };

			try {
				sendRequest({method:'POST', url: this.$global.Url('game/reportbug'), data});           
			}
			catch (e) {
				ModalManager.showDynamicModal('ajaxError', { 
					data: {
						title: this.$global.getLocalizedString('modals.ajaxerror.title'),
						text: this.$global.getLocalizedString('modals.ajaxerror.text'),
						image: this.modals.ajaxerror.modal.image, 
					},
					imageLocation: 'common',
					onclick: () => window.location.reload()
				});               
			}
		},		
		deleteAllBlocksButton()
		{
			BlocklyManager.deleteAllBlocks();
		},
		runCode(solution = false)		
		{
			if(this.locked)
			{
				return;
			}

			this.gameExecutingCode = true; 
			this.locked = true;	

			BlocklyManager.clearFailedBlocks(this.failedBlock);			

			// this.code = BlocklyManager.getWorkspaceCode();
			// <DEV>
			if(solution)
			{
				this.code = '\'abc\'\nPlayer:\n';
				let arr = this.ratings[this.main_task].solution.split(',');
				let newArr = ['\'abc\''].concat(...arr.map(e => [e, '\'abc\'']));
				this.code += newArr.join('\n');		
			}
			else
			{
				this.code = BlocklyManager.getWorkspaceCode();
			}
			// </DEV>

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
				data: {
					title: this.$global.getLocalizedString('modals.stoppedexecution.title'),
					text: this.$global.getLocalizedString('modals.stoppedexecution.text'),
					image: this.modals['stoppedexecution'].modal.image,
				}, 
				imageLocation: 'common',
				onclick: this.sendMessage.bind(null, `load\n${this.saveObjectToString}`)
			});			
		},
		commandFailed(object)
		{ 		
			let text = '';

			if(object.commandNumber==1)
				text = `${this.locales.commandFailedFirst} <br>`;
			else if(object.commandNumber==2)
				text = `${this.locales.commandFailedSecond} <br>`;
			else 
				text = `${this.locales.commandFailedMore} <br>`;

			let title = this.$global.getLocalizedString(`modals.${object.failureType}.title`);
			text += this.$global.getLocalizedString(`modals.${object.failureType}.text`);
			let image = this.modals[object.failureType].modal.image;
			text += `<br> ${this.locales.commandFailedBlock}`;

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
			HistoryManager.changeView('game', this.gameData, '', ''); 

			if(!this.isUserLoggedIn || !this.SAVING_ENABLED)
			{
				return;
			}		
				
			const data = {'save' : this.saveObjectToString, 'category': Number(this.category), 'level': Number(this.level), 'progress':  Number(this.progress) };				           
			try {
				await sendRequest({method:'POST', url: this.$global.Url('game/savegame'), data});           
			}
			catch (e) {
				ModalManager.showDynamicModal('ajaxError', { 
					data: {
						title: this.$global.getLocalizedString('modals.ajaxerror.title'),
						text: this.$global.getLocalizedString('modals.ajaxerror.text'),
						image: this.modals.ajaxerror.modal.image, 
					},
					imageLocation: 'common',
					onclick: () => window.location.reload()
				});                   
			}  						
		},
		mainTaskCompleted(object)
		{   
			const task = 'mainTask' + object.currentMainTask;
			this.code = String(object.commandArray).split(',').slice();
			
			const rateMainTaskResult = rateMainTaskCompletion(object, this.ratings);
			this.rating = rateMainTaskResult.rating;
			this.ruleError = rateMainTaskResult.ruleError;

			if(this.rating)
			{
				this.progress = this.tasks[task].progress;

				this.updateIngameProgress(task);		

				this.createLogOfGameplay('mainTaskCompleted', object);     
				
				ModalManager.showDynamicModal('mainTaskCompleted', { 
					data: {
						title: this.$global.getLocalizedString(`${task}.success_modal.title`),
						text: this.$global.getLocalizedString(`${this.levelString}.${task}.success_modal.text`),
						image: this.tasks[task].success_modal.image, 
					},
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

			const progress = this.tasks[task].progress;
			this.$emit('UPDATE_PROGRESS', {category: this.category, level: this.level, progress: this.progress});
			const data = {'progress' : Number(progress), 'category': Number(this.category), 'level': Number(this.level) }; 
			try {
				await sendRequest({method:'POST', url: this.$global.Url('game/updateingameprogress'), data});           
			}
			catch (e) {
				ModalManager.showDynamicModal('ajaxError', { 
					data: {
						title: this.$global.getLocalizedString('modals.ajaxerror.title'),
						text: this.$global.getLocalizedString('modals.ajaxerror.text'),
						image: this.modals.ajaxerror.modal.image, 
					},
					imageLocation: 'common',
					onclick: () => window.location.reload()
				});                    
			}  			
		},
		allMainTasksFinished()
		{	 
			ModalManager.showDynamicModal('allMainTasksFinished', {
				data: {
					title: this.$global.getLocalizedString('finish_modal.title'),
					text: this.$global.getLocalizedString(`${this.levelString}.finish_modal.text`),
					image: this.tasks.level.finish_modal.image
				},
				imageLocation: 'common',
				onclick: this.loadNextLevel
			});
		},
		async loadNextLevel()
		{			
			try {
				const result = await sendRequest({method: 'GET', headers: {'Accept': 'application/json'}, url: this.$global.Url(`start/${this.category}/${Number(this.level)+1}`)});           
				await HistoryManager.changeView(result.viewName, result.viewData, '', HistoryManager.getLocationFromUrl(this.$global.Url(`game/${result.viewData.category}/${result.viewData.level}`)), true);
			}
			catch (e) {
				ModalManager.showDynamicModal('ajaxError', { 
					data: {
						title: this.$global.getLocalizedString('modals.ajaxerror.title'),
						text: this.$global.getLocalizedString('modals.ajaxerror.text'),
						image: this.modals.ajaxerror.modal.image, 
					},
					imageLocation: 'common',
					onclick: () => window.location.reload()
				});
			}			
		},
		changeLevelData()
		{
			this.category =  this.gameData.category;
			this.level = this.gameData.level;
			
			this.toolbox = this.gameData.xmlToolbox;
			this.startBlocks = this.gameData.xmlStartBlocks;
			this.savedGame = this.gameData.savedGame;
			this.tasks = JSON.parse(this.gameData.jsonTasks);
			this.modals = JSON.parse(this.gameData.jsonModals);
			this.ratings = JSON.parse(this.gameData.jsonRatings);
			this.locked = true;

			this.progress = this.gameData.savedGame.progress;

			this.level_start = new Date();
			this.saveObjectToString = this.gameData.savedGame.json;
			this.savedGameParsed = JSON.parse(this.gameData.savedGame.json);
			
			BlocklyManager.changeWorkspacePlayground(this.toolbox, this.startBlocks);

			BlocklyManager.changeFacingDirectionImage(this.$global.Url('game'), this.savedGameParsed.character.facingDirection);			
				
			const container = this.$refs.iframe.parentElement;
			this.$refs.iframe.remove();
			this.levelString = `${this.category}x${this.level}`;
			this.$refs.iframe.setAttribute('src', this.$global.Url(`game/playcanvas/${this.levelString}.html`));
			container.append(this.$refs.iframe);
		}	
	},
	computed: {
		isUserLoggedIn()
		{
			return this.$global.User ? true : false;
		},
		target()
		{
			return window.location.origin;
		}
	},
	watch: { 
		gameData: function (newVal, oldVal) {
			this.changeLevelData();
		}
	},
	destroyed(){
		window.removeEventListener('message', this.eventer);
	}
};
</script>