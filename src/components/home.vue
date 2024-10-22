<template>
  <NavigationBar />
  <div class="home-container">

    <div class="input-container">
      <input type="text" v-model="productId" placeholder="Enter Product ID" />
      <input type="text" v-model="size" placeholder="Enter Size" />
    </div>

    <div class="product-container">
      <ProductInfo :productId="productId" />
      <SizeTable :productId="productId" :size="size" :allSizes="allSizes" />
    </div>

  </div>
  <FooterBar />
</template>

<script>
import ProductInfo from './ProductInfo.vue';
import SizeTable from './SizeTable.vue';
import NavigationBar from './navigation/NavigationBar.vue';
import FooterBar from './navigation/FooterBar.vue';

export default {
  name: 'HomePage',
  components: {
    ProductInfo,
    SizeTable, 
    NavigationBar,
    FooterBar
  },
  data() {
    return {
      productId: '',
      size: '',
    };
  },
  
}

</script>

<style lang="scss">
html, body {
  margin: 0;
  padding: 0;
  height: 100%;
}

.home-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  min-height: 100vh;
  position: relative; 
  background-image: url('@/assets/printful-background.png');
  background-size: cover;
  background-position: center;
  margin-top: 80px;

  /* Mask */
  &::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.5); 
    z-index: 0; 
  }

  * {
    margin: 0;
  }

  > * {
    position: relative;
    z-index: 1;
  }

   .input-container {
    input {
      margin: 1.5rem; 
      padding: 0.8rem; 
      background-color: rgba(0, 0, 0, 0.5); 
      color: #fff; 
      border: none; 
      border-radius: 4px; 

      &::placeholder {
        color: rgba(255, 255, 255, 0.7);
      }
    }
  }
  .product-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 25px;
    margin-bottom: 20px;
    margin-top: 15px;
  }
}
</style>



