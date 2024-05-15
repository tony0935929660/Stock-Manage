<template>
    <bTable :columns="columns" :data="data" />
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { API } from '@/utils/api';
import bTable from '@/components/BasicTable.vue'

onMounted(() => {
    getList()
})

const data = ref();
const columns = ref([
    {
        "key": "buy_date",
        "header": "Date"
    },
    {
        "key": "stock_id",
        "header": "Stock"
    },
    {
        "key": "buy_price",
        "header": "Price"
    },
    {
        "key": "amount",
        "header": "Amount"
    },
    {
        "key": "total_cost",
        "header": "Total"
    }
]);

const getList = async () => {
    data.value = await API('get', '/user-stock/history');
}
</script>