import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/pages/DashBoard'
import Login from '@/pages/UserLogin'

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/login', name: 'login', component: Login },
  { path: '/record', name: 'record', component: () => import('@/pages/InvestRecord') },
  { path: '/holdings', name: 'holdings', component: () => import('@/pages/StockHoldings') },
  { path: '/history', name: 'history', component: () => import('@/pages/InvestHistory') },
  { path: '/system-setup', name:'system-setup', component: () => import('@/pages/SystemSetup') }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
