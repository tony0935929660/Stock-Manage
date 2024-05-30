<template>
    <v-card style="width: 50%">
        <v-card-title>System Preference</v-card-title>
        <v-text-field label="Name" v-model="form.name" disabled />
        <v-autocomplete label="Value" v-model="form.value" :items="form.options"/>
        <v-card-actions class="d-flex justify-end">
            <v-btn size="large" variant="tonal" @click="router.back">Back</v-btn>
            <v-btn size="large" variant="tonal" @click="submit">Submit</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup>
    import { onMounted, ref } from 'vue'
    import { API } from '@/utils/api'
    import { useStore } from 'vuex'
    import { useRoute, useRouter } from 'vue-router';

    onMounted(() => {
        getData()
    })

    const route = useRoute()
    const router = useRouter()
    const store = useStore()
    const form = ref({})

    async function getData() {
        form.value = await API('get', `/system-preference/${route.params.id}`)
    }

    async function submit() {
        try {
            await API('put', `/system-preference/${route.params.id}`, form.value)
            store.dispatch("setSystemPreference", form.value)
            router.push('/system-setup');
        } catch (error) {
            console.log(error)
        }
    }
</script>