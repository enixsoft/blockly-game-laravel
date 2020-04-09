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
                    ></GameLevelItem>
                  <div class="col-md-6 mx-auto">
                     <!-- <button onclick="window.location=window.location.href + 'play';" :class="['btn', 'btn-lg', 'btn-success', inGameProgress[9] && inGameProgress[9] === 100 ? 'disabled' : '']"> -->
                     <button v-on:click="runGame()" :class="['btn', 'btn-lg', 'btn-success', inGameProgress[9] && inGameProgress[9] === 100 ? 'disabled' : '']">
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
			// levelsPerCategory: 5			
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
		async runGame(category = 1, level = 1){			
			const dataExists = this.$global.GameData.find((data) => data.category === category && data.level === level);
			if(dataExists)
			{
				HistoryManager.changeView('game', dataExists, '', `game/${category}/${level}`);
				return;
			}
			try {
				const result = await sendRequest({method: 'GET', headers: {'Accept': 'application/json'}, url: this.$global.Url(`game/${category}/${level}`)});           
				this.$global.GameData.push(result);
				HistoryManager.changeView('game', result, `Kategória ${category} Úroveň ${level}`, `game/${category}/${level}`);
			}
			catch (e) {
				// modal error window?
				console.log("AJAX GET GAMEDATA:", e);
			}
		}
	},
	mounted()
	{
		console.log('GameLevels', this.inGameProgress);
	}        
};
</script>