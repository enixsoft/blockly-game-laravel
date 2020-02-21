<template>
    <div class="d-flex flex-column h-100 align-items-center justify-content-center">
        <h1> {{ title }} <br> {{ subtitle }}  </h1> 
        <a href="#game" class="btn btn-outline btn-xl js-scroll-trigger mb-2">Začnite hrať!</a>                        
        <img class="img-fluid" :src="'img/' + imageFileName">  
    </div>
</template>

<script>
    export default {
        // data () {
        // return { 
        //     folderImagePath: 'img/'
        // }
        // },
        props:{
            title: String,
            subtitle: String,
            imageFileName: String
        },
        // computed()
        // {
        //     fullImagePath()
        //     {
        //         return this.$parent.$props.imageFolderPath + this.imageFileName;
        //     }
        // },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
