<template>
<header class="masthead">
        <div class="container-fluid h-100">
        <div class="row h-100">
        <div id="carousel"  class="carousel slide h-100 w-100" data-ride="carousel" data-interval="6000" data-pause="hover">
            <ul class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ul>
            <div class="carousel-inner h-100" style="text-align: center;"> 
                <div class="carousel-item h-100 active" >
                <CarouselItem title="Blockly hra." subtitle="Váš úvod do sveta programovania." imageFileName="carousel-1.png" />
                </div>
                <div class="carousel-item h-100" >
                <CarouselItem title="10 úrovní." subtitle="Viac ako 40 úloh na riešenie."  imageFileName="carousel-2.png" />
                </div>
                <div class="carousel-item h-100" >
                <CarouselItem title="Tvorte algoritmy." subtitle="S príkazmi v cykloch a podmienkach."  imageFileName="carousel-3.png" />
                 </div>
            </div>
            <a class="carousel-control-prev" href="#carousel" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#carousel" data-slide="next">
            <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
    </div>
</header>
</template>

<script>
    import CarouselItem from './CarouselItem';
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        components:
        {
            CarouselItem
        }
    }
</script>
