<script setup>
import { BarcodeIcon } from 'vue-tabler-icons';
import { useProductFormStore } from '@/stores/ProductForm';
const props = defineProps({
    rules: Object
});
const productForm = useProductFormStore();
</script>

<template>
        <v-card :prepend-icon="BarcodeIcon" title="Generate Barcode Sticker">
        <v-card-text>
            <v-row dense>
                <v-col cols="12" md="7">
                    <v-text-field
                        label="Product Name"
                        variant="outlined"
                        :model-value="productForm.productDetails.name"
                        readonly
                    ></v-text-field>
                    <v-text-field
                        label="Product Bardcode"
                        variant="outlined"
                        :model-value="productForm.productDetails.barcode"
                        readonly
                    ></v-text-field>
                    <v-text-field
                        label="Product Rate"
                        variant="outlined"
                        :model-value="productForm.productDetails.sell_price"
                        readonly
                    ></v-text-field>
                    <v-text-field
                        label="Stock Quantity"
                        variant="outlined"
                        :model-value="productForm.productDetails.stock ?? 'Not set yet!'"
                        readonly
                    ></v-text-field>
                    <v-text-field
                        v-model="productForm.barcodeQty"
                        label="Barcode Quantity"
                        type="number"
                        variant="outlined"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" md="5">
                    <v-img
                        v-if="productForm.productDetails.image"
                        height="150"
                        width="150"
                        alt="fatal error"
                        :src="'storage/'+productForm.productDetails.image"
                    ></v-img>
                </v-col>
            </v-row>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text="Close" variant="plain" @click="productForm.stickerDailog = false"></v-btn>
            <v-btn color="primary" text="Print" variant="tonal" @click="productForm.printDailog = true" v-print="rules"></v-btn>
        </v-card-actions>
    </v-card>
</template>
