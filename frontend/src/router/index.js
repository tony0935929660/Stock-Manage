import { createRouter, createWebHistory } from 'vue-router'
import store from '@/utils/store'
import Home from '@/pages/DashBoard'
import Login from '@/pages/UserLogin'

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/login', name: 'login', component: Login },
    { path: '/record', name: 'record', component: () => import('@/pages/InvestRecord') },
    { path: '/history', name: 'history', component: () => import('@/pages/InvestHistory') },
    { path: '/system-setup', name:'system-setup', component: () => import('@/pages/SystemSetup/list') },
    { path: '/system-setup/:id', name:'system-setup-detail', component: () => import('@/pages/SystemSetup/detail') }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

router.beforeEach((to, from, next) => {
    const isAuthenticated = store.getters.token; // 假设你的 token 存储在 Vuex store 中的 getters 中

    if (!isAuthenticated && to.path !== '/login') {
        next('/login');
        return; // 在这里返回，以确保不会执行下面的代码
    }

    next();
});

export default router
