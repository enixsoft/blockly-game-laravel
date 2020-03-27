<template>
<header class="game-header">
<div class="game-container">
<div class="row h-100 w-100 no-padding">
    <div class="col-lg-6 no-padding">
        <iframe id="app-frame" class="game-playcanvas"  
        src="http://localhost/blocklyapp/game/playcanvas/1x1.html"></iframe> 
        <!-- src="https://playcanv.as/e/p/62c28f63/"></iframe>-->             
    </div>
    <div class="col-lg-6 no-padding">
        <div class="row h-100 w-100 no-padding">
            <div class="col-lg-12 game-blockly" id="blocklyArea">            
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
</header>
</template>

<script>   
    export default {
        props: {
            brand: String
        },
        mounted() {
            console.log('GameHeader mounted.')
        },
        computed: {
            isUserLoggedIn()
            {
                return this.$global.User ? true : false;
            },
            userName()
            {             
                return this.$global.User ? this.$global.User.username : undefined;
            }
        }
    }
</script>