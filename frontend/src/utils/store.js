import { createStore } from 'vuex'

export default createStore({
    state: {
        token: null,
        user: null,
        tokenExpiresIn: null,
        systemPreferences: {}
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
        },
        setUser(state, user) {
            state.user = user;
        },
        setTokenExpiresIn(state, time) {
            state.tokenExpiresIn = time;
        },
        setSystemPreference(state, systemPreference) {
            state.systemPreferences[systemPreference['name']] = systemPreference['value'];
        }
    },
    actions: {
        updateToken(store, response) {
            store.commit('setToken', response.access_token);
            store.commit('setUser', response.user);
            store.commit('setTokenExpiresIn', response.expires_in);
        },
        setSystemPreference(store, response) {
            store.commit('setSystemPreference', response);
        }
    },
    getters: {
        token (state) {
            if (!state.token) {
                return null;
            }
            return `Bearer ${state.token}`;
        },
        renewTokenTime (state) {
            if (!state.tokenExpiresIn) {
                return null;
            }
            return (state.tokenExpiresIn - 60) * 1000;
        },
        systemPreferences (state) {
            return state.systemPreferences;
        }
    }
})