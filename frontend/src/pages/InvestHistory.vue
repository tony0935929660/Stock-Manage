<template>
    <v-table>
        <thead>
            <tr>
                <th>
                    Date
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    123
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
    const columns = ref(['Date', 'Stock', 'Price', 'Amount', 'Total']);
    
    const getList = async () => {
        data.value = await API('get', '/user-stock');
    }

    return {
        columns,
        data
    };
  }
}
</script>