
/**
 * router/index.ts
 *
 * Automatic routes for `./src/pages/*.vue`
 */

// Composables
import { createRouter, createWebHistory } from 'vue-router/auto'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', component: () => import('@/pages/InvestmentHome.vue') },
    { path: '/home', component: () => import('@/pages/InvestmentHome.vue') },
    // { path: '/record', component: Record },
    // { path: '/holdings', component: Holdings },
    // { path: '/history', component: History },
    // { path: '/system-setup', component: SystemSetup },
    { path: "/:pathMatch(.*)*", redirect: "/404", name: "NotFound" }
  ]
})

export default router
