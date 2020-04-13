<template>
<div>
<h2 class="section-heading">Kategória {{ categoryNumber }}</h2>
<p> {{ categoryText }} </p>
 <div class="table-responsive">
    <table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Úroveň</th>
            <th scope="col">Postup</th>
            <th scope="col">Spustiť</th>
            <th scope="col">Pokračovať</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(level, index) in categoryProgress" :key="index">
            <th scope="row">{{ levelValue(index + 1) }}</th>
            <td>
                <div class="progress" style="height: 2rem;">
                <div class="progress-bar bg-success" role="progressbar" 
                    :aria-valuenow="levelProgressValue(index)" aria-valuemin="0" 
                    aria-valuemax="100" :style="{width: `${levelProgressValue(index)}%`}">
                    <span style="text-align: center; font-weight: bold;">{{ `${levelProgressValue(index)}%` }} </span>
                </div>
                </div>
            </td>
            <td><a href="" v-on:click.prevent="btnClick('start', index + 1)" :class="['btn', 'btn-secondary', 'btn-sm', levelProgressValue(categoryProgress.length - 1) !== 100 || disabled ? 'disabled' : '']">
                SPUSTIŤ OD ZAČIATKU</a>
            </td>
            <td><a href="" v-on:click.prevent="btnClick('continue', index + 1)" :class="['btn', 'btn-secondary', 'btn-sm', levelProgressValue(categoryProgress.length - 1) !== 100 || disabled ? 'disabled' : '']">
                POKRAČOVAŤ V ULOŽENEJ HRE</a>
            </td>
        </tr>
    </tbody>
    </table>
    </div>
    <br>
    <p v-if="categoryNumber === 1"><i class="fas fa-exclamation-circle"></i> Tlačidlá Spustiť od začiatku a Pokračovať v uloženej hre sa odomknú po dokončení všetkých úrovní kategórie.<br>
    Na spustenie hry používajte zelené tlačidlo {{ categoryProgress[0] ? 'Začať novú hru' : 'Pokračovať v hre.' }}
    </p>
</div>
</template>
<script>
export default {    
	props: {
		categoryText: String,
		categoryNumber: Number,
		categoryProgress: Array,
		disabled: Boolean
	},
	methods:{
		levelValue(index){
			return ((this.categoryNumber - 1) * this.categoryProgress.length) + index;
		},
		levelProgressValue(index)
		{
			return this.categoryProgress[index] ? this.categoryProgress[index] : 0;
		},
		btnClick(type, level)
		{
			this.$emit('click', {type, category: this.categoryNumber, level});			
		}
	}
};
</script>