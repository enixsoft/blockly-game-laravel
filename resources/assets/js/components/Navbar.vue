<template>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
         <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top"> {{ brand }}</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="#features">O hre</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link js-scroll-trigger" href="#game">Spustiť hru</a>
                  </li>                             
                  <li v-if="isUserLoggedIn" class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fa fa-user-circle"></i> {{ userName }}
                     </a>        
                     <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Odhlásiť sa</a>
                     </div>
                  </li>   
               </ul>
            </div>
        </div>
    </nav> 
</template>

<script>   
    export default {
        props:{
            brand: String
        },
        mounted() {
            console.log('Navbar mounted.')
        },
        computed: {
            isUserLoggedIn()
            {
                return window.user ? true : false;
            },
            userName()
            {             
                return window.user ? user.username : undefined;
            }
        }
        // components:
        // {
        //     CarouselItem
        // }
    }
</script>
