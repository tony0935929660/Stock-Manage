<template>
    <v-row class="d-flex justify-space-between">
        <v-card class="px-4 py-5" style="width: 30%; height: 40%">
            <v-card-title>Transaction Record</v-card-title>
            <v-autocomplete label="Stock" v-model="form.stock" :items="options.stock" item-title="title" return-object/>
            <v-date-input label="Date" v-model="form.date" prepend-icon="" />
            <v-divider class="mb-5" />
            <v-radio-group v-model="isBuy" inline>
                <v-label class="mr-5">Action:</v-label>
                <v-radio label="Buy" :value="true" />
                <v-radio label="Sell" :value="false" />
            </v-radio-group>
            <v-radio-group v-model="isBoardLot" inline>
                <v-label class="mr-5">Type:</v-label>
                <v-radio label="Board Lot" :value="true" />
                <v-radio label="Odd Lot" :value="false" />
            </v-radio-group>
            <v-number-input v-if="isBoardLot" label="Price (Per Unit)" v-model="form.price" />
            <v-number-input v-else label="Price (Per Share)" v-model="form.price" />
            <v-number-input label="Quantity" v-model="form.quantity_of_unit" />
            <v-card-actions class="d-flex justify-space-between">
                <v-label>Total: {{ total }}</v-label>
                <v-btn size="large" variant="tonal" @click="submit">Submit</v-btn>
            </v-card-actions>
        </v-card>
        <v-card v-if="data.length" class="px-4 py-5" style="width: 68%">
            <v-card-title>{{ form.stock?.name }}</v-card-title>
            <v-card-subtitle>{{ form.stock?.code }}  {{ form.stock?.industry_category }}</v-card-subtitle>
            <v-data-table class="mt-10" :headers="columns" :items="data" />
        </v-card>
        <v-snackbar v-model="snackbarMessage" timeout="3000" color="red">
            {{ snackbarMessage }}
        </v-snackbar>
    </v-row>
</template>

<script setup>
    import { computed, onMounted, ref, watch } from 'vue'
    import { API } from '@/utils/api'
    import { useRouter } from "vue-router"
    import moment from 'moment'

    onMounted(() => {
        getStockList()
    })

    const router = useRouter()
    const form = ref({
        quantity_of_unit: 0,
        price: 0
    })
    const isBuy = ref(true)
    const isBoardLot = ref(true)
    const data = ref([])
    const snackbarMessage = ref(null)
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

    const total = computed (() => {
        if (!form.value.price || !form.value.quantity) {
            return 0;
        }

        return (form.value.price * form.value.quantity).toLocaleString()
    })

    watch(() => form.value.quantity_of_unit, (newValue) => {
        if (isBoardLot.value) {
            form.value.quantity = newValue * 1000
        } else {
            form.value.quantity = newValue
        }
    })

    watch(() => form.value.stock, (newValue) => {
        if (!newValue) {
            return
        }
        form.value.stock_id = newValue.id
        data.value = []
        getInfo()
    })

    watch(() => form.value.date, (newValue) => {
        if (!newValue) {
            return
        }
        getInfo()
    })

    async function getInfo() {
        try {
            const date = form.value.date ? moment(form.value.date).format('YYYY-MM-DD') : moment().subtract(1, 'month').format('YYYY-MM-DD')
            const response = await API('get', `/stock/${form.value.stock.id}/info`, {'start_date': date})
            data.value = response
        } catch (error) {
            console.log(error)
        }
    }

    async function getStockList() {
        try {
            const stocks = await API('get', '/stock')
            for (var stock of stocks) {
                stock.title = `${stock.name} (${stock.code})`
                options.value.stock.push(stock)
            }
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
            snackbarMessage.value = error?.response?.data?.reason
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