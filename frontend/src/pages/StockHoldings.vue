<template>
    <v-data-table :headers="columns" :items="data">
        <template v-slot:item.current_price="{ item }">
            ${{ item.quantity * item.stock_current_price }}
        </template>
        <template v-slot:item.total="{ item }">
            ${{ item.total }}
        </template>
    </v-data-table>
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
            "title": "Cost"
        },
        {
            "value": "current_price",
            "title": "Current Price"
        }
    ]);

    async function getList() {
        data.value = await API('get', '/transaction/holding');
    }
</script>
