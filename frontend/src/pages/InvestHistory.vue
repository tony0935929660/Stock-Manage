<template>
    <v-table>
        <thead>
            <tr>
                <th v-for="column in columns" v-bind:key="column.key">
                    {{ column.header }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="datum in data" v-bind:key="datum.id">
                <td v-for="column in columns" v-bind:key="column.key">
                    {{ datum[column.key] }}
                </td>
            </tr>
        </tbody>
    </v-table>
</template>

<script>
import { onMounted, ref } from 'vue';
import { API } from '@/utils/api';

export default {
  setup() {
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

    return {
        columns,
        data
    };
  }
}
</script>