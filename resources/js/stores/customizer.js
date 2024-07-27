import { defineStore } from 'pinia'

export const useCustomizerStore = defineStore({
  id: 'customizer',
  state: () => ({
    Sidebar_drawer: true,
    mini_sidebar: false,
  }),

  getters: {},
  actions: {
    SET_SIDEBAR_DRAWER() {
      this.Sidebar_drawer = !this.Sidebar_drawer
    },
    SET_MINI_SIDEBAR(payload) {
      this.mini_sidebar = payload
    },
  }
});
