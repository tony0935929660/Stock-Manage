<template>
    <v-row>
        <v-card class="px-4 py-5" style="width: 40%;">
            <v-card-title>Record</v-card-title>
            <v-date-input label="Date" v-model="form.buy_date" prepend-icon="" />
            <v-select label="Stock ID" v-model="form.stock_id" :items="options.stock" item-title="name" item-value="id" filled/>
            <v-text-field label="Price" v-model="form.buy_price" />
            <v-text-field label="Amount" v-model="form.amount" />
            <v-card-actions>
                <v-btn size="large" variant="tonal" @click="submit">Submit</v-btn>
            </v-card-actions>
        </v-card>
        <v-card>

        </v-card>
    </v-row>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { API } from '@/utils/api';
import { useRouter } from "vue-router";

onMounted(() => {
    getStockList()
})

const router = useRouter();
const form = ref({})
const options = ref({
    'stock': []
});

const getStockList = async () => {
    const response = await API('get', '/stock');
    options.value.stock = response;
}
const submit = async () => {
    try {
        await API('post', '/user-stock', form.value);
        router.push('/');
    } catch (error) {
        console.log(error);
    }
}
</script>