<template>
    <pie-chart :chartData="data" />
</template>

<script setup>
    import { ref, onMounted } from 'vue'
    import { PieChart } from 'vue-chart-3'
    import { Chart, registerables } from "chart.js"
    import { API } from '@/utils/api'
    
    Chart.register(...registerables);

    onMounted(() => {
        getData()
    })
  
    const data = ref({
        labels: [],
        datasets: [
            {
                data: []
            },
        ],
    });

    async function getData() {
        try {
            const response = await API('get', `/chart/pie/holding-category`)
            for (let datum of response) {
                data.value.labels.push(datum.industry_category)
                data.value.datasets[0].data.push(datum.total)
            }
        } catch (error) {
            console.log(error)
        }
    }
</script>