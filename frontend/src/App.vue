<template>
	<div>
		<AppWithHeaderAndSidebar v-if="currentRouteName != 'login'" />
		<v-app v-else>
			<v-main>
				<router-view />
			</v-main>
		</v-app>
	</div>
</template>

<script setup>
	import { computed, watch } from 'vue'
	import { useRouter } from "vue-router"
	import { useStore } from "vuex"
    import { useTheme } from 'vuetify'
	import AppWithHeaderAndSidebar from '@/components/AppWithHeaderAndSidebar.vue'

	const router = useRouter()
	const store = useStore()
	const theme = useTheme()
	const currentRouteName = computed(() => router.currentRoute.value.name)
	

	const systemTheme = computed(() => store.getters.systemPreferences['System.Theme'])

	watch(systemTheme, (newValue) => {
		theme.global.name.value = newValue
	})

</script>