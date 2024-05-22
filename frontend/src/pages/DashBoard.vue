<template>
    <v-row>
        <v-card>
            <v-card-title>大盤指數</v-card-title>
            <div
                class="d-flex justify-center mx-5" 
                style="font-size: 30px;"
                :style="{ color: parseInt(taiexIndex?.spread) > 0 ? 'red' : 'green' }">
                {{ taiexIndex?.close }}
            </div>
            <v-card-actions
                class="d-flex justify-space-between"
                :style="{ color: parseInt(taiexIndex?.spread) > 0 ? 'red' : 'green' }">
                <div>
                    {{ taiexIndex?.spread }}
                    <v-icon v-if="parseInt(tpexIndex?.spread) > 0">mdi-trending-up</v-icon>
                    <v-icon v-else>mdi-trending-down</v-icon>
                </div>
                <div>
                    {{ taiexIndex ? (taiexIndex?.spread / taiexIndex?.open).toFixed(2) : 0 }}%
                </div>
            </v-card-actions>
        </v-card>
        <v-card>
            <v-card-title>櫃買指數</v-card-title>
            <div
                class="d-flex justify-center mx-5" 
                style="font-size: 30px;"
                :style="{ color: parseInt(tpexIndex?.spread) > 0 ? 'red' : 'green' }">
                {{ tpexIndex?.close }}
            </div>
            <v-card-actions
                class="d-flex justify-space-between"
                :style="{ color: parseInt(tpexIndex?.spread) > 0 ? 'red' : 'green' }">
                <div>
                    {{ tpexIndex?.spread }}
                    <v-icon v-if="parseInt(tpexIndex?.spread) > 0">mdi-trending-up</v-icon>
                    <v-icon v-else>mdi-trending-down</v-icon>
                </div>
                <div>
                    {{ tpexIndex ? (tpexIndex?.spread / tpexIndex?.open).toFixed(2) : 0 }}%
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