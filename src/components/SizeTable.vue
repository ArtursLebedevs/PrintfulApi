<template>
  <div class="main-container">
    <section class="size-table-section">
      <h2>Size Table</h2>
    </section>
    <!-- Button to API Data -->
    <section class="api-fetch-button">
      <button @click="fetchApiData" :disabled="loading">
        {{ loading ? 'Loading...' : 'Load Product Data' }}
      </button>
    </section>

    <!-- Error Message -->
    <section style="margin-top: 10px;" v-if="error">
      <p>{{ error }}</p>
    </section>

    <!-- All Sizes -->
    <section v-if="allSizes.length">
      <h2 style="margin-top: 15px; margin-bottom: 15px;">All Available Sizes</h2>
      <ul>
        <li v-for="size in allSizes" :key="size">{{ size }}</li>
      </ul>
    </section>

    <!-- Size Table -->
    <section class="api-data-table" v-if="sizeTableDetails.length">
      <h2 style="margin-top: 15px;">Size Table</h2>
      <table v-for="(table, index) in sizeTableDetails" :key="index">
        <thead>
          <tr>
            <th colspan="2">{{ table.type }} ({{ table.unit }})</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(measurement, mIndex) in table.measurements" :key="mIndex">
            <td>{{ measurement.type_label }}</td>
            <td>
              <ul>
                <li v-for="(value, vIndex) in measurement.values" :key="vIndex">
                  {{ value.size }}: {{ value.value }}
                </li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
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
    }
  },
  data() {
    return {
      productDetails: null,
      sizeTableDetails: [],
      allSizes: [],
      loading: false,
      error: null
    };
  },
  methods: {
    fetchApiData() {
      this.loading = false;
      this.error = null; 


    if (!this.productId) {
      this.loading = false;
      this.error = 'No product ID specified. Please provide a product ID.';
      return; 
    }

    if (!this.size) {
      this.loading = false;
      this.error = 'No size specified. Please provide a size.';
      return; 
    }

      axios.get('http://localhost/Printful_v2/printful_v2/src/components/api/ApiHandler.php', {
        params: { productID: this.productId, size: this.size }
      })
      .then(response => {
        if (response.data && response.data.sizeTableData && response.data.sizeTableData.size_table) {
          this.extractAllAvailableSizes(response.data.sizeTableData.size_table);
          this.sizeTableDetails = this.filterSizeTableData(response.data.sizeTableData.size_table);
          if (this.sizeTableDetails.length === 0) {
            this.error = `No details found for size ${this.size}.`;
          }
        } else {
          console.error(response.data);
          this.error = 'Invalid Product ID or item doesnt have a size table';
          this.sizeTableDetails = [];
          this.allSizes = [];
        }
      })
      .catch(error => {
        console.error('Error fetching API data:', error);
        this.error = 'Failed to load API data';
      })
      .finally(() => {
        this.loading = false;
      });
    },

    extractAllAvailableSizes(sizeTableData) {
      const allSizes = new Set();
      sizeTableData.forEach(table => {
        table.measurements.forEach(measurement => {
          measurement.values.forEach(value => {
            allSizes.add(value.size);
          });
        });
      });
      this.allSizes = Array.from(allSizes);
    },

    filterSizeTableData(sizeTableData) {
      if (!Array.isArray(sizeTableData)) {
        console.error('sizeTableData is not an array:', sizeTableData);
        return [];
      }
      const filteredData = sizeTableData.map(table => {
        if (!table.measurements || !Array.isArray(table.measurements)) {
          console.error('Invalid or missing measurements:', table);
          return null;
        }
        return {
          ...table,
          measurements: table.measurements.map(measurement => ({
            ...measurement,
            values: (measurement.values || []).filter(value => value.size === this.size)
          })).filter(measurement => measurement && measurement.values.length > 0)
        };
      }).filter(table => table && table.measurements.length > 0);

      if (filteredData.length === 0) {
        this.error = `Size '${this.size}' not available for this product.`;
      }
      return filteredData;
    }
  },
}
</script>

<style lang="scss">

.main-container {
  width: 60%; 
  max-width: 800px; 
  margin: 20px auto;
  background-color: rgba(0, 0, 0, 0.5); 
  color: #fff; 
  padding: 20px;
  border-radius: 10px; 
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); 
  border: 1px solid #ccc; 
}

/* Size Table Section */
.size-table-section {
  text-align: center;

  h2 {
    margin-bottom: 1rem;
  }
}

/* Button */
.api-fetch-button button {
  background-color: #28a745;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  transition: background-color 0.3s ease;

  &:disabled {
    background-color: #6c757d;
    cursor: default;
  }

  &:hover:not(:disabled) {
    background-color: #218838;
  }
}

/* Error */
section {
  margin-bottom: 20px;
  text-align: center;

  h2 {
    margin-bottom: 1rem;
  }

  ul {
    list-style-type: none;
    padding: 0;

    li {
      display: inline-block;
      margin: 0.5rem;
      padding: 0.5rem;
      border: 1px solid #ddd;
      border-radius: 4px;
      background-color: #368f8a;
      color: white;
    }
  }
}
  /* Data Table */
  .api-data-table table {
    width: 100%;
    margin: 1rem auto;
    border-collapse: collapse;

    th, td {  // table header, table data
      border: 1px solid #ddd;
      background-color: #f4f4f4;
      padding: 4px;
      text-align: left;
      font-size: 0.8rem;
      color: #000; 
      min-width: 100px;
      max-width: 150px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    th {
      background-color: #f4f4f4;
      min-width: 120px;
      max-width: 200px;
    }
  }
</style>
