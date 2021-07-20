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
                  {{ inGameProgress[0] === 0 || !inGameProgress.length ? locales.bigBtnStart : locales.bigBtnContinue }}
                     </button>             
                  </div>                 
                  <br>
                  <div v-if="$global.User.role==='admin'" class="form-group">
                     <h2 class="section-heading">{{ locales.register }} (Admin)</h2>
                        <div class="form-group col-md-6 mx-auto">
                           <input ref="username" class="form-control" :placeholder="locales.userName" id="username" type="username" name="username">          
                        </div>
                        <div class="form-group col-md-6 mx-auto">
                           <input ref="password" class="form-control" id="password" :placeholder="locales.password" type="password" name="password">              
                        </div>
                        <br>
                        <div class="col-md-6 mx-auto">
                           <button class="btn btn-lg btn-success" v-on:click="registerByAdmin()">
                           {{ locales.registerBtn }}
                           </button>                           
                        </div>         
                  </div> 
                </div> 
            </div>
         </div>
      </section>
</template>
<script>
import GameLevelItem from './GameLevelItem';
import { sendRequest } from '../Managers/Common';
import HistoryManager from '../Managers/HistoryManager';
import { gameLevels as locales } from '../Managers/LocaleManager';
export default {
	data(){
		return {
			locales: this.$global.getLocalizedStrings(locales),			
			categories: [
				{ text: this.$global.getLocalizedString(locales.category1) },
				{ text: this.$global.getLocalizedString(locales.category2) }
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
				HistoryManager.changeView(result.viewName, result.viewData, `Kategória ${result.viewData.category} Úroveň ${result.viewData.level}`, `game/${result.viewData.category}/${result.viewData.level}`);
			}
			catch (e) {
				// modal error window?
			}
		},
		gameLevelClick(obj)
		{
			this.runGame(obj.type, obj.category, obj.level);
			this.disabled = true;
		},
		async registerByAdmin()
		{
			const url = this.$global.Url('registeruserbyadmin');
			const data = {username: this.$refs.username.value, password: this.$refs.password.value};
			try { 
				await sendRequest({method: 'POST', url, data});
			}
			finally {
				this.$refs.username.value = '';
				this.$refs.password.value = '';
			}
		}
	}        
};
</script>