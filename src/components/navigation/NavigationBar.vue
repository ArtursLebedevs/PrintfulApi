<template>
    <nav class="navbar">
      <div class="logo">Printful V2</div>
      <ul class="nav-links">
        <li><router-link to="/" class="nav-link">Home</router-link></li>
        <li><router-link to="/about" class="nav-link">About</router-link></li>
        <li><a href="#">Contact</a></li> 
      </ul>
    </nav>
  </template>
  
  <script>
  export default {
    name: 'NavigationBar',
  };
  </script>
  
  <style>
    .navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%; 
    box-sizing: border-box; 
    display: flex;
    justify-content: space-between;
    background-color: #2c3e50; 
    padding: 1rem 2rem; 
    box-shadow: 0 2px 5px rgba(0,0,0,0.2); 
    z-index: 1000;

    .logo {
        font-weight: bold;
        color: #fff; 
        font-size: 1.5rem; 
    }

    .nav-links {
        list-style: none;
        display: flex;
        align-items: center; 

        li {
        margin-left: 20px;

        a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem; 
            transition: background-color 0.3s; 

            &:hover {
            background-color: #4a6572; 
            border-radius: 5px; 
            }
        }
        }
    }
    }
  </style>
  