<template>
    <v-data-table :headers="columns" :items="data" />
</template>

<script setup>
    import { onMounted, ref } from 'vue';
    import { API } from '@/utils/api';

    onMounted(() => {
        getList()
    })

    const data = ref();
    const columns = ref([
        {
            "value": "stock_name",
            "title": "Stock"
        },
        {
            "value": "quantity",
            "title": "Quantity"
        },
        {
            "value": "total",
            "title": "Total"
        }
    ]);

    async function getList() {
        data.value = await API('get', '/transaction/holding');
    }
</script>
