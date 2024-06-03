<template>
    <div class="d-flex justify-center my-10">
        <v-card class="px-5 py-3" style="width: 30%;">
            <v-card-title class="d-flex justify-center my-2">Stock Manage</v-card-title>
            <v-text-field label="Email" v-model="form.email" />
            <v-text-field label="Password" v-model="form.password" 
                :type="showPassword ? 'text' : 'password'"
                :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                @click:append-inner="showPassword = !showPassword" @keyup.enter="login"/>
            <v-btn :loading="isLoading" size="x-small" variant="text" @click="loginAsGuest">Login in as guest</v-btn>
            <v-card-actions class="d-flex justify-end">
                <v-btn :loading="isLoading" size="large" @click="login">Login</v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script setup>
    import { API } from '@/utils/api.js'
    import { ref } from 'vue'
    import { useRouter } from 'vue-router'
    import { useStore } from 'vuex'

    const store = useStore()
    const router = useRouter()
    const form = ref({})
    const showPassword = ref(false)
    const isLoading = ref(false)

    async function getSystemPreferences() {
        try {
            console.log('fetch system preference...')
            const systemPreferences = await API('get', '/system-preference')
            for (const preference of systemPreferences) {
                store.dispatch("setSystemPreference", preference)
            }
        } catch (error) {
            console.log(error)
        }
    }

    async function refreshToken() {
        try {
            console.log('refreshing token...')
            const response = await API('post', '/auth/refresh')
            store.dispatch("updateToken", response)
            setTimeout(refreshToken, store.getters.renewTokenTime)
        } catch (error) {
            console.log(error)
        }
    }

    async function login() {
        try {
            isLoading.value = true
            console.log('logging...')
            const response = await API('post', '/auth/login', form.value)
            store.dispatch("updateToken", response)
            await getSystemPreferences()
            router.push('/')
            if (store.getters.renewTokenTime) {
                setTimeout(refreshToken, store.getters.renewTokenTime)
            }
        } catch (error) {
            console.log(error)
        } finally {
            isLoading.value = false
        }
    }

    function loginAsGuest() {
        form.value.email = 'guest@gmail.com'
        form.value.password = '000000'
        login()
    }
</script>