import { defineStore } from 'pinia';
//import product from './product';

export const usePosStore = defineStore({
    id: 'pos',
    state: () => ({
        products: [],
        detailsModal: false,
        invoiceId: null
    }),
    getters: {
        subTotal(state) {
            if (state.allPrice.length) {
                return state.allPrice.reduce((sum, item) => sum + item.price, 0);
            } else {
                return 0;
            }
        }
    }
});
