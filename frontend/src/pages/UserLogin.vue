<template>
    <div class="d-flex justify-center my-10">
        <v-card class="px-5 py-3" style="width: 30%;">
            <v-card-title class="d-flex justify-center my-2">Stock Manage</v-card-title>
            <v-text-field label="Email" v-model="form.email" />
            <v-text-field label="Password" v-model="form.password" />
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

const login = async () => {
    try {
        const response = await API('post', '/auth/login', form.value);
        store.dispatch("login", response);
        router.push('/');
    } catch (error) {
        console.log(error);
    }
}
</script>