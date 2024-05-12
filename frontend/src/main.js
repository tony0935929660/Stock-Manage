/**
 * main.js
 *
 * Bootstraps Vuetify and other plugins then mounts the App`
 */

// Plugins
import vuetify from '@/plugins/vuetify'
import router from '@/router'
import store from '@/utils/store'

// Components
import App from './App.vue'

// Composables
import { createApp } from 'vue'

createApp(App)
    .use(vuetify)
    .use(router)
    .use(store)
    .mount('#app');
