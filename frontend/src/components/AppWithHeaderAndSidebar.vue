<template>
    <v-app>
        <v-app-bar>
            <v-toolbar-title>Stock Manage</v-toolbar-title>
        </v-app-bar>
        <v-navigation-drawer
        floating
        permanent
        >
            <v-list nav class="my-3">
                <v-list-item prepend-icon="mdi-home" title="Home" to="/" />
                <!-- <v-list-item prepend-icon="mdi-currency-usd" title="Holdings" to="/holdings" /> -->
                <v-list-item prepend-icon="mdi-pencil" title="Record" to="/record" />
                <v-list-item prepend-icon="mdi-history" title="History" to="/history" />
                <v-list-item prepend-icon="mdi-cog" title="System Setup" to="/system-setup" />
            </v-list>
        </v-navigation-drawer>
        <v-main class="mx-8 my-10">
            <router-view />
        </v-main>
    </v-app>
</template>