
import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/components/home.vue';
import AboutPage from '@/components/AboutPage.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/about',
      name: 'AboutPage',
      component: AboutPage
    }
  ]
});

export default router;

