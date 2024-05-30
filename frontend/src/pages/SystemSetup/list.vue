<template>
    <v-card :loading="!data">
        <v-card-title>System Preference</v-card-title>
        <v-data-table :headers="columns" :items="data">
            <template v-slot:item.action="{ item }">
                <router-link :to="{ name: 'system-setup-detail', params: { id: item.id }}">detail</router-link>
            </template>
        </v-data-table>
    </v-card>
</template>

<script setup>
    import { onMounted, ref } from 'vue'
    import { API } from '@/utils/api';

    onMounted(() => {
        getList()
    })

    const data = ref();
    const columns = ref([
        {
            "value": "name",
            "title": "Name"
        },
        {
            "value": "value",
            "title": "Value"
        },
        {
            "value": "action",
            "title": "Action"
        }
    ])

    async function getList() {
        data.value = await API('get', '/system-preference');
    }
</script>