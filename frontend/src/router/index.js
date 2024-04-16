
/**
 * router/index.ts
 *
 * Automatic routes for `./src/pages/*.vue`
 */

// Composables
import { createRouter, createWebHistory } from 'vue-router/auto'

const routes = [
  // { path: '/home', component: Home },
  // { path: '/record', component: Record },
  // { path: '/holdings', component: Holdings },
  // { path: '/history', component: History },
  // { path: '/system-setup', component: SystemSetup }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

export default router
