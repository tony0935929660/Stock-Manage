<template>
    <v-row class="d-flex justify-space-between">
        <v-card class="px-4 py-5" style="width: 28%">
            <v-card-title>Record</v-card-title>
            <v-date-input label="Date" v-model="form.buy_date" prepend-icon="" />
            <v-autocomplete label="Stock" v-model="form.stock" :items="options.stock" item-title="name" return-object/>
            <v-text-field label="Price" v-model="form.buy_price" />
            <v-text-field label="Amount" v-model="form.amount" />
            <v-card-actions>
                <v-btn size="large" variant="tonal" @click="submit">Submit</v-btn>
            </v-card-actions>
        </v-card>
        <v-card class="px-4 py-5" style="width: 70%">
            <v-card-title>{{ form.stock?.name }}</v-card-title>
            <v-card-subtitle>{{ form.stock?.code }}  {{ form.stock?.industry_category }}</v-card-subtitle>
            <bTable class="mt-10" :columns="columns" :data="data"/>
        </v-card>
    </v-row>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { API } from '@/utils/api'
import { useRouter } from "vue-router"
import moment from 'moment'
import bTable from '@/components/BasicTable.vue'

onMounted(() => {
    getStockList()
})

const router = useRouter();
const form = ref({})
const data = ref({})
const options = ref({
    'stock': []
});
const columns = ref([
    {
        'key': 'date',
        'header': '日期'
    },
    {
        'key': 'trading_volume',
        'header': '交易量'
    },
    {
        'key': 'trading_money',
        'header': '交易金額'
    },
    {
        'key': 'open',
        'header': '開盤價'
    },
    {
        'key': 'max',
        'header': '最高價'
    },
    {
        'key': 'min',
        'header': '最低價'
    },
    {
        'key': 'close',
        'header': '收盤價'
    },
    {
        'key': 'spread',
        'header': '漲跌幅'
    },
    {
        'key': 'close',
        'header': '交易筆數'
    },
])

watch(() => form.value.stock, (newValue) => {
    if (!newValue) {
        return
    }
    data.value = []
    getTodayInfo(newValue.id)
})

async function getTodayInfo(id) {
    const today = moment().format('YYYY-MM-DD')
    const response = await API('get', `/stock/${id}/recent`, {'date': today})
    data.value = response
}

async function getStockList() {
    const response = await API('get', '/stock')
    options.value.stock = response
}

async function submit() {
    try {
        await API('post', '/user-stock', form.value)
        router.push('/')
    } catch (error) {
        console.log(error)
    }
}
</script>