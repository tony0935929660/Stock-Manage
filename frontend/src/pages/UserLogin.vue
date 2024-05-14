<template>
    <div class="d-flex justify-center my-10">
        <v-card class="px-5 py-3" style="width: 30%;">
            <v-card-title class="d-flex justify-center my-2">Stock Manage</v-card-title>
            <v-text-field label="Email" v-model="form.email" />
            <v-text-field label="Password" v-model="form.password" @keyup.enter="login"/>
            <v-card-actions class="d-flex justify-end">
                <v-btn size="large" @click="login">Login</v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script setup>
import { API } from '@/utils/api.js'
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'

const store = useStore();
const router = useRouter();
const form = ref({});

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
        console.log('logging...')
        const response = await API('post', '/auth/login', form.value)
        store.dispatch("updateToken", response)
        router.push('/')
        
        if (store.getters.renewTokenTime) {
            setTimeout(refreshToken, store.getters.renewTokenTime)
        }
    } catch (error) {
        console.log(error)
    }
}
</script>