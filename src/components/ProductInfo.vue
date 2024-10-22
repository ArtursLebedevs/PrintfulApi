  <template>
    <div class="product-info">
      <h2>Product Information</h2>
      <button @click="fetchProductData" :disabled="loading">
        {{ loading ? 'Loading...' : 'Load Product Info' }}
      </button>
      <div v-if="error">{{ error }}</div>
      <div v-if="productDetails">
        <!-- Displaying the product's title -->
        <h3>{{ productDetails.title }}</h3>
        <p>{{ productDetails.description }}</p>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    props: {
    productId: {
      type: String,
      default: ''
    },
    size: {
      type: String,
      default: ''
    },
  },
  data() {
    return {
      productDetails: null,
      loading: false,
      error: null,
      };
    },
    
    methods: {
    fetchProductData() {
      this.loading = true;
      this.error = null;
      this.productDetails = null;

      if (!this.productId) {
        this.error = 'Please enter the product ID';
        this.loading = false;
        return; 
      }

      axios.get('http://localhost/Printful_v2/printful_v2/src/components/api/ApiHandler.php', {
        params: { productID: this.productId }
      })
      .then(response => {
        if (response.data && response.data.productData) {
          this.productDetails = response.data.productData.product;
        } else {
          console.error(response.data);
          this.error = 'Product not found';
        }
      })
      .catch(error => {
        console.error('Error fetching product data:', error);
        this.error = 'Failed to load product data';
      })
      .finally(() => {
        this.loading = false;
      });
    }
  }
}
  </script>
  
  <style scoped lang="scss">
 .product-info {
  max-width: 300px; 
  margin: 0 auto; 
  padding: 20px; 
  border: 1px solid #ccc; 
  border-radius: 10px; 
  background-color: rgba(0, 0, 0, 0.5); 
  color: #fff; 
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 

  h2, h3, p {
    margin: 10px 0; 
  }

  button {
    background-color: #007bff; 
    color: white; 
    border: none; 
    padding: 10px 20px; 
    border-radius: 5px; 
    margin-bottom: 10px; 
    cursor: pointer; 

    &:hover {
      background-color: #0056b3; 
    }
  }

  .error {
    color: #ff4d4f; 
    font-weight: bold; 
    margin: 10px 0; 
  }

  .loading {
    color: #009688; 
    font-style: italic; 
  }

  // Ensures the JSON data wraps and is readable
  pre {
    white-space: pre-wrap; 
    word-break: break-all; 
  }
  }
  </style>
  