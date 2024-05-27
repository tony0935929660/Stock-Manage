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
            "value": "stock.name",
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

    const getList = async () => {
        data.value = await API('get', '/transaction/holding');
    }
</script>
