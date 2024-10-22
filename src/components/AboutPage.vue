<template>
  <NavigationBar />
    <div class="about-page">
      <h1>About Printful V2</h1>
      <p>Designed to provide data about products, including their sizes, descriptions, and other details. The aim is to create an upgraded version of the first task that Printful has provided - easy-to-use interface, created by using Vue.js and SCSS technologies, to explore product specifications.</p>
  
      <h2>Key Features</h2>
      <ul>
        <li>Product data retrieval from Printful API using PHP backend.</li>
        <li>Interactive size table display for a better understanding of product data.</li>
        <li>Vue.js frontend for a smooth browsing experience.</li>
        <li>Fetched data from API is cached for 5 minutes.</li>
      </ul>
  
      <h2>Technologies Used</h2>
      <ul>
        <li>Vue.js for the frontend development.</li>
        <li>Axios for handling API requests.</li>
        <li>PHP and GuzzleHttp for server-side processing and API interactions.</li>
        <li>SCSS for styling components.</li>
        <li>XAMPP for local PHP server.</li>
        <li>Vue router for navigation</li>
      </ul>

      <h2>Back-End Explanation</h2>
      <img class="pain-img" src="@/assets/pain.png" />
  
    </div>
    <FooterBar />
  </template>
  
  <script>
  import NavigationBar from './navigation/NavigationBar.vue';
  import FooterBar from './navigation/FooterBar.vue';

  export default {
      name: 'AboutPage',
      components: {
        NavigationBar,
        FooterBar
      },
  }
  </script>
  
  <style lang="scss">
    .about-page {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    max-width: 800px;
    margin: 0 auto;
    margin-top: 50px;
    padding: 40px;
    background: #f4f4f4; 
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    
    @media (max-width: 768px) {
    max-width: 100%;
    padding: 20px;
    margin-top: 50px;
  }

  h1 {
    font-family: 'Helvetica Neue', sans-serif;
    color: #333;
    text-align: center;
    font-size: 2.5rem; 

    @media (max-width: 768px) {
      font-size: 2rem;
    }
  }

  p {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #444; 
    margin-bottom: 20px;

    @media (max-width: 768px) {
      font-size: 0.9rem;
    }
  }

  h2 {
    font-family: 'Arial', sans-serif;
    color: #555;
    margin-top: 30px;
    font-size: 2rem;

    @media (max-width: 768px) {
      font-size: 0.9rem;
    }
  }

  ul {
    list-style-type: disc;
    list-style-position: outside; 
    padding-left: 0; 
    margin-right: 20px; 
    text-align: left; 
    li {
      margin-bottom: 10px;
      font-size: 1rem;
      color: #555;
      padding-left: 20px; 
    }
  }

  a {
    color: #0066cc;
    text-decoration: none;
    &:hover {
      text-decoration: underline;
    }
  }
}
.pain-img {
  height: 600px;
  width: 600px;

  @media (max-width: 768px) {
      height: 300px;
      width: 300px;
    }
}

  </style>
  