<template>
    <v-row>
        <v-card class="px-4 py-5" style="width: 40%;">
            <v-select filled label="Stock ID" :items="options.stock" item-title="name" item-value="id"/>
            <v-text-field label="Amount" />
            <v-text-field label="Price" />
            <div class="d-flex justify-end">
                <v-btn size="large" variant="tonal">Submit</v-btn>
            </div>
        </v-card>
        <v-card>

        </v-card>
    </v-row>
</template>

<script>
import { onMounted, ref } from 'vue';
import { API } from '@/utils/api';

export default {
  setup() {
    onMounted(() => {
        getStockList()
    })

    const options = ref({
        'stock': []
    });
    
    const getStockList = async () => {
        const response = await API('get', '/stock');
        options.value.stock = response;
    }

    console.log(options.value);

    return {
        options
    };
  }
}
</script>