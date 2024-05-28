<template>
    <div>
        <v-row class="d-flex justify-space-between mb-5">
            <v-card :loading="!taiexIndex" style="width: 24%">
                <v-card-title>Stock Market Index</v-card-title>
                <div
                    class="d-flex justify-center mx-10" 
                    style="font-size: 40px;"
                    :style="{ color: getColor(taiexIndex?.spread) }">
                    {{ taiexIndex?.close }}
                </div>
                <v-card-actions
                    class="d-flex justify-space-between"
                    :style="{ color: getColor(taiexIndex?.spread) }">
                    <div>
                        {{ taiexIndex?.spread }}
                        <v-icon v-if="parseFloat(taiexIndex?.spread) > 0">mdi-trending-up</v-icon>
                        <v-icon v-else-if="parseFloat(taiexIndex?.spread) < 0">mdi-trending-down</v-icon>
                    </div>
                    <div v-if="taiexIndex">
                        {{ (taiexIndex?.spread / taiexIndex?.open).toFixed(2) }}%
                    </div>
                </v-card-actions>
            </v-card>
            <v-card :loading="!tpexIndex" style="width: 24%">
                <v-card-title>OTC Index</v-card-title>
                <div
                    class="d-flex justify-center mx-10" 
                    style="font-size: 40px;"
                    :style="{ color: getColor(tpexIndex?.spread) }">
                    {{ tpexIndex?.close }}
                </div>
                <v-card-actions
                    class="d-flex justify-space-between"
                    :style="{ color: getColor(tpexIndex?.spread) }">
                    <div>
                        {{ tpexIndex?.spread }}
                        <v-icon v-if="parseFloat(tpexIndex?.spread) > 0">mdi-trending-up</v-icon>
                        <v-icon v-else-if="parseFloat(tpexIndex?.spread) < 0">mdi-trending-down</v-icon>
                    </div>
                    <div v-if="tpexIndex">
                        {{ (tpexIndex?.spread / tpexIndex?.open).toFixed(2) }}%
                    </div>
                </v-card-actions>
            </v-card>
            <v-card :loading="!highestProfit" style="width: 24%">
                <v-card-title>
                    Highest Profit
                </v-card-title>
                <div
                    v-if="highestProfit"
                    class="d-flex justify-center mx-10" 
                    style="font-size: 40px;"
                    :style="{ color: getColor(highestProfit?.profit) }">
                    ${{ highestProfit?.profit }}
                </div>
                <v-card-actions :style="{ color: getColor(highestROI?.ROI) }">{{ highestProfit?.stock_name }} {{ highestProfit?.stock_code }}</v-card-actions>
            </v-card>
            <v-card :loading="!highestROI" style="width: 24%">
                <v-card-title>
                    Highest ROI
                </v-card-title>
                <div
                    v-if="highestROI"
                    class="d-flex justify-center mx-10" 
                    style="font-size: 40px;"
                    :style="{ color: getColor(highestROI?.ROI) }">
                    {{ highestROI?.ROI }}%
                </div>
                <v-card-actions :style="{ color: getColor(highestROI?.ROI) }">{{ highestROI?.stock_name }} {{ highestROI?.stock_code }}</v-card-actions>
            </v-card>
        </v-row>
        <v-row class="d-flex justify-space-between">
            <v-card style="width: 30%">
                <v-card-title>Holding Category</v-card-title>
                <holding-category-pie-chart :chartdata="chartData" :options="chartOptions" />
            </v-card>
            <v-card style="width: 68%">
                <v-card-title>Holdings</v-card-title>
                <stock-holdings />
            </v-card>
        </v-row>
    </div>
</template>

<script setup>
    import { onMounted, ref } from 'vue'
    import { API } from '@/utils/api'
    import HoldingCategoryPieChart from '@/components/HoldingCategoryPieChart.vue'
    import StockHoldings from '@/pages/StockHoldings.vue';

    onMounted(() => {
        getTaiexIndex()
        getTpexIndex()
        getHighestProfit()
        getHighestROI()
    })

    const taiexIndex = ref()
    const tpexIndex = ref()
    const highestProfit = ref()
    const highestROI = ref()
    const chartData = ref([''])
    const chartOptions = ref()

    function getColor(number) {
        if (parseFloat(number) > 0) {
            return 'red'
        } else if (parseFloat(number) < 0)  {
            return 'green'
        } else {
            return 'grey'
        }
    }

    async function getTaiexIndex() {
        try {
            const response = await API('get', `/index/taiex`)
            taiexIndex.value = response
        } catch (error) {
            console.log(error)
        }
    }

    async function getTpexIndex() {
        try {
            const response = await API('get', `/index/tpex`)
            tpexIndex.value = response
        } catch (error) {
            console.log(error)
        }
    }

    async function getHighestProfit() {
        try {
            const response = await API('get', `/stock/highest-profit`)
            if (response) {
                highestProfit.value = response
            } else {
                highestProfit.value = {'profit': 0}
            }
        } catch (error) {
            console.log(error)
        }
    }

    async function getHighestROI() {
        try {
            const response = await API('get', `/stock/highest-roi`)
            if (response) {
                highestROI.value = response
            } else {
                highestROI.value = {'ROI': 0}
            }
        } catch (error) {
            console.log(error)
        }
    }
</script>