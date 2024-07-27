import { defineStore } from 'pinia';

export const useActivityStore = defineStore({
    id: 'activity',
    state: () => ({
        current: route().current(),
    }),

    getters: {},
    actions: {
        setRouteName(payload) {
            this.current = payload.active;
        },
    }
});
