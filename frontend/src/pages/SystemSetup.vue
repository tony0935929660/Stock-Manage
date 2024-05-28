<template>
    <v-row class="d-flex justify-space-between">
        <v-card class="px-4 py-5" style="width: 28%; height: 40%">
            <v-card-title>Update</v-card-title>
            <v-autocomplete label="System Preference" v-model="form.id" :items="options.stock" item-value="id" item-title="name"/>
            <v-card-actions>
                <v-btn size="large" variant="tonal" @click="submit">Submit</v-btn>
            </v-card-actions>
        </v-card>
        <v-card v-if="data.length" class="px-4 py-5" style="width: 70%">
            <v-card-title>System Preference</v-card-title>
            <v-data-table class="mt-10" :headers="columns" :items="data" />
        </v-card>
    </v-row>
</template>

<script setup>
    import { ref } from 'vue'

    const data = ref([]);
    const columns = ref([
        {
            "value": "name",
            "title": "Name"
        },
        {
            "value": "value",
            "title": "Value"
        }
    ])
</script>