<template>
    <v-data-table :headers="columns" :items="data">
        <template v-slot:item.current_price="{ item }">
            {{ item.quantity * item.stock_current_price }}
        </template>
        <template v-slot:item.total="{ item }">
            {{ item.total }}
        </template>
        <template v-slot:item.profit="{ item }">
            <p :style="{color: getColor(item.quantity * item.stock_current_price - item.total)}">
                {{ (item.quantity * item.stock_current_price - item.total).toLocaleString() }}
            </p>
        </template>
        <template v-slot:item.roi="{ item }">
            <p :style="{color: getColor(item.quantity * item.stock_current_price - item.total)}">
                {{ ((item.quantity * item.stock_current_price - item.total) / item.total).toFixed(2) }}%
            </p>
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
        },
        {
            "value": "profit",
            "title": "Profit"
        },
        {
            "value": "roi",
            "title": "ROI"
        }
    ]);

    function getColor(total) {
        if (total > 0) {
            return 'red'
        } else if (total < 0) {
            return 'green'
        } else {
            return 'white'
        }
    }

    async function getList() {
        data.value = await API('get', '/transaction/holding');
    }
</script>
