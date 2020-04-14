 <template>
 <section class="download bg-primary text-center" id="game">
         <div class="container">
            <div class="row">
                 <div class="col-md-12 mx-auto">
                    <GameLevelItem
                        v-for="(category, index) in categories"
                        :category-text="category.text"
                        :category-number="index + 1"
                        :category-progress="categoryProgress(index)"
                        :key="index"
								:disabled="disabled"
								v-on:click="gameLevelClick"
                    ></GameLevelItem>
                  <div class="col-md-6 mx-auto">
                     <button v-on:click="runGame('play')" class="btn btn-lg btn-success" :disabled="(inGameProgress[9] && inGameProgress[9] === 100) || disabled">
                     <i class="fas fa-play"></i>
                  {{ inGameProgress[0] === 0 ? 'Začať novú hru' : 'Pokračovať v hre.' }}
                     </button>             
                  </div>
                  <!-- Admin -->
                  <!-- <br>
                  <br>
                  <div class="form-group">
                     <h2 class="section-heading">Registrácia (admin)</h2>
                     <form class="form-horizontal" method="POST" id="registrationForm" action="{{ route('registeruserbyadmin') }}">
                        {{ csrf_field() }}
                        <div class="form-group col-md-6 mx-auto">
                           <input class="form-control" placeholder="Prihlasovacie meno" id="username" type="username" name="username" required>          
                        </div>
                        <div class="form-group col-md-6 mx-auto">
                           <input class="form-control" id="password" placeholder="Heslo" type="password" name="password" required>              
                        </div>
                        <br>
                        <div class="col-md-6 mx-auto">
                           <button class="btn btn-lg btn-success" type="submit">
                           Registrácia
                           </button>
                           <br>
                        </div>
                     </form>
                  </div> -->
                </div> 
            </div>
         </div>
      </section>
</template>
<script>
import GameLevelItem from './GameLevelItem';
import { sendRequest } from '../Managers/Common';
import HistoryManager from '../Managers/HistoryManager';

export default {
	data(){
		return {
			categories: [
				{ text: 'V prvej kategórii sa naučíme ovládať hrdinu, zadávať mu príkazy pohyb, skok, útok mečom, použitie páky a otvorenie truhlice.' },
				{ text: 'V druhej kategórii sa naučíme ovládať hrdinu podľa nového herného systému a využívať pri tvorbe algoritmov cykly a podmienky.' }
			],
			disabled: false	
		};
		
	},
	components: {
		GameLevelItem
	},    
	props: {
		inGameProgress: Array,
		levelsPerCategory: Number
	},
	methods: {
		categoryProgress(index)
		{
			const startIndex = index  * this.levelsPerCategory;      
			const category = [];
			for(let i = 0; i < this.levelsPerCategory; i++)
			{
				category[i] = this.inGameProgress[startIndex + i] || 0;
			}
			return category;
		},		
		async runGame(type, category, level){			
			try {
				const url = type === 'play' ? this.$global.Url('play') : this.$global.Url(`${type}/${category}/${level}`);
				const result = await sendRequest({method: 'GET', headers: {'Accept': 'application/json'}, url});
				HistoryManager.changeView('game', result, `Kategória ${result.category} Úroveň ${result.level}`, `game/${result.category}/${result.level}`);
			}
			catch (e) {
				// modal error window?
				console.log("AJAX GET GAMEDATA:", e);
			}
		},
		gameLevelClick(obj)
		{
			this.runGame(obj.type, obj.category, obj.level);
			this.disabled = true;
		}
	},
	mounted()
	{
		console.log('GameLevels', this.inGameProgress);		
	}        
};
</script>