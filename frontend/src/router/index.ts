import { createRouter, createWebHistory } from 'vue-router'
import NivelView from '@/views/NivelView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: NivelView,
    },
    {
      path: '/nivel',
      name: 'nivel',
      component: NivelView,
    },
    {
      path: '/desenvolvedor',
      name: 'desenvolvedor',
      component: () => import('../views/DesenvolvedorView.vue'),
    },
  ],
})

export default router
