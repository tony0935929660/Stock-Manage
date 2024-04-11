<template>
  <v-app>
    <v-app-bar>
      <v-toolbar-title>Stock Manage</v-toolbar-title>
      <v-spacer />
      <template v-slot:append>
        <v-list>
          <v-list-item>
            <v-avatar
              class="hover-avatar"
              size="40"
              color="white"
              @mouseenter="showOptions = true"
              @mouseleave="showOptions = false"
            >
              <v-icon>mdi-account</v-icon>
            </v-avatar>
            <v-menu
              v-model="showOptions"
              :close-on-content-click="false"
              :nudge-width="300"
              offsetX
              offsetY
              position-x="end"
              position-y="top"
            >
              <v-list>
                <v-list-item @click="optionSelected('Option 1')">Option 1</v-list-item>
                <v-list-item @click="optionSelected('Option 2')">Option 2</v-list-item>
                <v-list-item @click="optionSelected('Option 3')">Option 3</v-list-item>
              </v-list>
            </v-menu>
          </v-list-item>
        </v-list>
      </template>
    </v-app-bar>
    <v-navigation-drawer
      floating
      permanent
    >
      <v-list nav>
        <v-list-item prepend-icon="mdi-home" title="Home" value="home" to="/home" />
        <v-list-item prepend-icon="mdi-currency-usd" title="Holdings" to="/holdings" />
        <v-list-item prepend-icon="mdi-pencil" title="Record" to="/record" />
        <v-list-item prepend-icon="mdi-history" title="History" to="/history" />
        <v-list-item prepend-icon="mdi-cog" title="System Setup" to="/system_setup" />
      </v-list>
    </v-navigation-drawer>
    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script>
import { ref } from 'vue';

export default {
  setup() {
    const showOptions = ref(false);

    const optionSelected = (option) => {
      // Handle the selected option here
      console.log(option);
    };

    return {
      showOptions,
      optionSelected
    };
  }
}
</script>

<style scoped>
.hover-avatar:hover {
  cursor: pointer;
}
</style>