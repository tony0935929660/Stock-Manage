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
      login(store, response) {
        store.commit('setToken', response.access_token);
        store.commit('setUser', response.user);
        store.commit('setTokenExpiresIn', response.expires_in);
      }
    },
    getters: {
      token (state) {
        return `Bearer ${state.token}`;
      }
    }
})