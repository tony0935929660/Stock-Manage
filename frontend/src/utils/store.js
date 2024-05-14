import { createStore } from 'vuex'

export default createStore({
    state: {
        token: null,
        user: null,
        tokenExpiresIn: null
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
        }
    },
    actions: {
        updateToken(store, response) {
            store.commit('setToken', response.access_token);
            store.commit('setUser', response.user);
            store.commit('setTokenExpiresIn', response.expires_in);
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
        }
    }
})