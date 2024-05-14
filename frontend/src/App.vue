<template>
	<div>
		<AppWithHeaderAndSidebar v-if="currentRouteName != 'login'" />
		<v-app>
			<v-main>
				<router-view />
			</v-main>
		</v-app>
	</div>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from "vue-router"
import AppWithHeaderAndSidebar from '@/components/AppWithHeaderAndSidebar.vue'

const router = useRouter();
const currentRouteName = computed(() => router.currentRoute.value.name)

</script>