import { defineStore } from 'pinia';

export const useProductFormStore = defineStore({
    id: 'productForm',
    state: () => ({
        hasImage: null,
        editImage: null,
        errors: {
            name: null,
            category_id: null,
            barcode: null,
            sell_price: null,
            image: null
        },
        detailsDailog: false,
        stickerDailog: false,
        printDailog: false,
        barcodeQty: 6,
        productDetails: {
            id: null,
            name: null,
            description: null,
            category_id: null,
            barcode: null,
            stock: null,
            purchase_price: null,
            sell_price: null,
            image: null
        }
    }),
});
