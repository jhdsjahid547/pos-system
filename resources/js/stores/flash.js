import { defineStore } from 'pinia';
import { usePage } from "@inertiajs/vue3";

export const useFlashStore = defineStore({
    id: 'flash',
    state: () => ({
        snackbar: false,
    }),
    getters: {
        flashSuccess(){
            return usePage().props.flash.success
        },
    },
    actions: {
        clearFlash(){
            this.snackbar = false;
        }
    }
});
