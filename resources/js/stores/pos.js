import { defineStore } from 'pinia';
//import product from './product';

export const usePosStore = defineStore({
    id: 'pos',
    state: () => ({
        products: [],
        detailsModal: false,
        invoice: {
            id: null,
            subtotal: null,
            discount_percent: null,
            discount: null,
            vat_percent: null,
            vat: null,
            total: null,
            due: null,
            paid: null,
            payment_type: null
        }
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
