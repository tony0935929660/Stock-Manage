<template>
    <v-row>
        <v-card :loading="!taiexIndex">
            <v-card-title>大盤指數</v-card-title>
            <div
                class="d-flex justify-center mx-5" 
                style="font-size: 30px;"
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
        <v-card :loading="!tpexIndex">
            <v-card-title>櫃買指數</v-card-title>
            <div
                class="d-flex justify-center mx-5" 
                style="font-size: 30px;"
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
    </v-row>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { API } from '@/utils/api'

onMounted(() => {
    getTaiexIndex()
    getTpexIndex()
})

const taiexIndex = ref()
const tpexIndex = ref()

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
</script>

<style scoped>
.v-card {
    margin: 10px 10px;
}
</style>