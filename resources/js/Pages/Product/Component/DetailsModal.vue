<script setup>
import { DetailsIcon } from 'vue-tabler-icons';
import { useProductFormStore } from '@/stores/ProductForm';
import VueBarcode from '@chenfengyuan/vue-barcode';
const productForm = useProductFormStore();
</script>

<template>
    <v-card :prepend-icon="DetailsIcon" title="Product Details">
        <v-card-text>
            <v-row>
                <v-col cols="12" md="7">
                    <v-table>
                        <tbody>
                        <tr>
                            <th class="font-weight-bold text-h5">Barcode</th>
                            <td class="text-subtitle-1" align="right">
                                <vue-barcode 
                                :value="productForm.productDetails.barcode" 
                                :options="{ height: 40 }"
                                ></vue-barcode> <!-- ean13 format 883456710001 last digit(13 no.) auto generate -->
                            </td>
                        </tr>
                        <tr>
                            <th class="font-weight-bold text-h5">Product Name</th>
                            <td class="text-subtitle-1" align="right">{{ productForm.productDetails.name }}</td>
                        </tr>
                        <tr>
                            <th class="font-weight-bold text-h5">Product Category</th>
                            <td class="text-subtitle-1" align="right">{{ productForm.productDetails.category.name }}</td>
                        </tr>
                        <tr>
                            <th class="font-weight-bold text-h5">In Stock</th>
                            <td class="text-subtitle-1" align="right">{{ productForm.productDetails.stock }}</td>
                        </tr>
                        <tr>
                            <th class="font-weight-bold text-h5">Purchase Price</th>
                            <td class="text-subtitle-1" align="right">{{ productForm.productDetails.purchase_price }}</td>
                        </tr>
                        <tr>
                            <th class="font-weight-bold text-h5">Selling Price</th>
                            <td class="text-subtitle-1" align="right">{{ productForm.productDetails.sell_price }}</td>
                        </tr>
                        </tbody>
                    </v-table>
                </v-col>
                <v-col cols="12" md="5">
                    <v-row>
                        <v-col cols="12" class="my-5">
                            <v-img
                                v-if="productForm.productDetails.image"
                                height="150"
                                width="150"
                                alt="fatal error"
                                :src="'storage/'+productForm.productDetails.image"
                            ></v-img>
                        </v-col>
                        <v-col cols="12">
                            <span class="font-weight-bold text-h5">Description</span>
                            <div>
                                {{ productForm.productDetails.description }}
                            </div>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
            
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text="Close" variant="plain" @click="productForm.detailsDailog = false"></v-btn>
        </v-card-actions>
    </v-card>
</template>