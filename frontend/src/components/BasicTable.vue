<template>
    <v-table>
        <thead>
            <tr>
                <th v-for="column in props.columns" v-bind:key="column.key">
                    {{ column.header }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="datum in data" v-bind:key="datum.id">
                <td v-for="column in props.columns" v-bind:key="column.key">
                    {{ datum[column.key] }}
                </td>
            </tr>
        </tbody>
    </v-table>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  columns: {
    type: Array,
    default: () => []
  },
  data: {
    type: Array,
    default: () => []
  }
})

</script>