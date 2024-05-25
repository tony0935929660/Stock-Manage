<template>
    <v-row class="d-flex justify-space-between">
        <v-card class="px-4 py-5" style="width: 28%; height: 40%">
            <v-card-title>Record</v-card-title>
            <v-date-input label="Date" v-model="form.date" prepend-icon="" />
            <v-autocomplete label="Stock" v-model="form.stock" :items="options.stock" item-title="name" return-object/>
            <v-text-field label="Price" v-model="form.price" />
            <v-text-field label="Quantity" v-model="form.quantity" />
            <v-radio-group v-model="isBuy" inline>
                <v-radio label="Buy" :value="true" />
                <v-radio label="Sell" :value="false" />
            </v-radio-group>
            <v-card-actions>
                <v-btn size="large" variant="tonal" @click="submit">Submit</v-btn>
            </v-card-actions>
        </v-card>
        <v-card v-if="data.length" class="px-4 py-5" style="width: 70%">
            <v-card-title>{{ form.stock?.name }}</v-card-title>
            <v-card-subtitle>{{ form.stock?.code }}  {{ form.stock?.industry_category }}</v-card-subtitle>
            <v-data-table class="mt-10" :headers="columns" :items="data" />
        </v-card>
    </v-row>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue'
import { API } from '@/utils/api'
import { useRouter } from "vue-router"
import moment from 'moment'

onMounted(() => {
    getStockList()
})

const router = useRouter()
const form = ref({})
const isBuy = ref(true)
const data = ref([])
const options = ref({
    'stock': []
});
const columns = ref([
    {
        'value': 'date',
        'title': '日期'
    },
    {
        'value': 'Trading_Volume',
        'title': '交易量'
    },
    {
        'value': 'Trading_money',
        'title': '交易金額'
    },
    {
        'value': 'open',
        'title': '開盤價'
    },
    {
        'value': 'max',
        'title': '最高價'
    },
    {
        'value': 'min',
        'title': '最低價'
    },
    {
        'value': 'close',
        'title': '收盤價'
    },
    {
        'value': 'spread',
        'title': '漲跌幅'
    },
    {
        'value': 'Trading_turnover',
        'title': '交易筆數'
    },
])

watch(() => form.value.stock, (newValue) => {
    if (!newValue) {
        return
    }
    form.value.stock_id = newValue.id
    data.value = []
    getInfo(newValue.id)
})

async function getInfo(id) {
    try {
        const monthAgo = moment().subtract(1, 'month').format('YYYY-MM-DD')
        const response = await API('get', `/stock/${id}/info`, {'start_date': monthAgo})
        data.value = response
    } catch (error) {
        console.log(error)
    }
}

async function getStockList() {
    try {
        const response = await API('get', '/stock')
        options.value.stock = response
    } catch (error) {
        console.log(error)
    }
}

async function buy() {
    try {
        await API('post', '/transaction/buy', form.value)
        router.push('/')
    } catch (error) {
        console.log(error)
    }
}

async function sell() {
    try {
        await API('post', '/transaction/sell', form.value)
        router.push('/')
    } catch (error) {
        console.log(error)
    }
}

function submit() {
    if (isBuy.value) {
        return buy()
    } else {
        return sell()
    }
}
</script>