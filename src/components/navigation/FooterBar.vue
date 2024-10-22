<!-- FooterBar.vue -->
<template>
    <footer class="footer">
      <div>2024 Printful Task V2</div>
      <ul>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </footer>
  </template>
  
  <script>
  export default {
    name: 'FooterBar',
  };
  </script>
  
  <style>
    .footer {
    margin-top: auto;
    margin-left: 0; 
    margin-right: 0; 
    margin-bottom: 0; 
    background-color: #2c3e50; 
    color: #ddd; 
    text-align: center;
    padding: 1.5rem; 
    font-size: 0.9rem; 

    ul {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: center; 

        li {
        margin: 0 10px;

        a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s; 

            &:hover {
            color: #fff; 
            }
        }
        }
    }
    }
  </style>
  