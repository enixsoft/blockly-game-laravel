<template>
<div>
    <Navbar brand="BLOCKLY HRA"/>
    <Carousel-Header/>
</div>
</template>

<script>
import CarouselHeader from './Headers/CarouselHeader';
import Navbar from './Navbar';

export default { 
  components: {
    CarouselHeader,
    Navbar
  },
  mounted () {
    // this.axios  //<--- use this.axios instead of `axios`
    //   .get('https://api.coindesk.com/v1/bpi/currentprice.json')
    //   .then(response => (this.info = response.data))
  }
}

</script>