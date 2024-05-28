<template>
    <v-data-table :headers="columns" :items="data">
        <template v-slot:item.is_buy="{ item }">
            <span v-if="item.is_buy === 1">Buy</span>
            <span v-else>Sell</span>
        </template>
        <!-- <template v-slot:item.total="{ item }">
            <span style="color: green" v-if="item.is_buy === 1">-{{ item.total }}</span>
            <span style="color: red" v-else>+{{ item.total }}</span>
        </template> -->
    </v-data-table>
</template>

<script setup>
    import { onMounted, ref } from 'vue'
    import { API } from '@/utils/api'

    onMounted(() => {
        getList()
    })

    const data = ref();
    const columns = ref([
        {
            "value": "date",
            "title": "Date"
        },
        {
            "value": "is_buy",
            "title": "Type"
        },
        {
            "value": "stock.name",
            "title": "Stock"
        },
        {
            "value": "price",
            "title": "Price"
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
        data.value = await API('get', '/transaction/history');
    }
</script>