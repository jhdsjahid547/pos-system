<script setup>
import { DetailsIcon } from 'vue-tabler-icons';
import { usePosStore } from '@/stores/pos';

const pos = usePosStore();

const cancel = () => {
    pos.products = [];
    pos.detailsModal = false;
}
</script>

<template>
    <v-card :prepend-icon="DetailsIcon" title="Invoice Product Details">
        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <v-table>
                        <thead>
                            <tr>
                                <th class="font-weight-bold">Product Name</th>
                                <th class="font-weight-bold">Price</th>
                                <th class="font-weight-bold">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in pos.products">
                                <td>{{ item.product.name }}</td>
                                <td>{{ item.product.sell_price }}</td>
                                <td>{{ item.quantity }}</td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-col>
            </v-row>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text="Close" variant="plain" @click="cancel"></v-btn>
        </v-card-actions>
    </v-card>
</template>