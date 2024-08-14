<script setup>
import { ref, reactive, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { BarcodeIcon, TrashIcon } from 'vue-tabler-icons';
import { useFlashStore } from "@/stores/flash";
import { usePosStore } from '@/stores/pos';
import TableData from '@/Pages/Pos/Component/TableData.vue';

const props = defineProps({
    product: Array,
    productList: Array,
    taxDiscount: Object
});
//Fetch product using bar code scanner
const flash = useFlashStore();
const pos = usePosStore();
const addCart = (product) => {
    pos.products.push({
        ...product,
        quantity: 1,
        sub_total: product.sell_price
    });
}
watch(() => props.product, (newValue) => {
    if (newValue.length && !pos.products.find(item => item.id === newValue[0].id)) {
        addCart(newValue[0]);
    }
});
const barcode = ref(null);
const getProductByBarcode = () => {
    router.post(route('orders.create'), {
            _method: 'get',
            barcode: barcode.value,
        }, {
            preserveScroll: true,
            onSuccess: () => barcode.value = null
        });

};
//Remove item from cart
const remove = id => pos.products = pos.products.filter(item => item.id !== id);
const searchProduct = ref(null);
watch(searchProduct, debounce(() => {
    if (!(typeof searchProduct.value === 'object') && searchProduct.value !== null) {
        router.post(route('orders.create'), {
            _method: 'get',
            name: searchProduct.value,
        });
    } else if (typeof searchProduct.value === 'object' && searchProduct.value !== null) {
        if (!pos.products.find(item => item.id === searchProduct.value.id)) {
            addCart(searchProduct.value);
        }
    }
}, 1000));
//Set searched product to v-combobox :items
const loadProduct = ref([]);
watch(() => props.productList, (newValue) => {
    if (newValue.length) {
        loadProduct.value = newValue;
    }
});
//Tax and Discount
const subTotal = computed(() => pos.products.reduce((sum, item) => sum + item.sub_total, 0));
const order = reactive({
    subtotal: subTotal,
    vatPercent: props.taxDiscount.vat,
    vat: computed(() => (order.vatPercent / 100 * subTotal.value).toFixed(2)),
    discountPercent: props.taxDiscount.discount,
    discount: computed(() => (order.discountPercent / 100 * subTotal.value).toFixed(2)),
    total: computed(() => (Number(order.subtotal) + Number(order.vat) - order.discount).toFixed(2)),
    paid: null,
    due: computed(() => (order.total - order.paid).toFixed(2)),
    payment_type: 'Cash',
    products: computed(() => pos.products.map(item => ({ product_id: item.id, quantity: item.quantity }))),
    products_stock: computed(() => pos.products.map(item => ({ id: item.id, stock: item.stock - item.quantity }))),
});
//Save Order
const errors = reactive({ paid: null });
const saveOrder = () => {
    if (pos.products.length) {
        router.post(route('orders.store'), order, {
            onSuccess: () => {
                pos.products = [];
                searchProduct.value = null;
                loadProduct.value = [];
                flash.snackbar = true;
            },
            onError: error => errors.paid = error.paid
        });
    } else {
        alert('Atleast one product order!');
    }
}
</script>

<template>
    <v-row>
        <v-col cols="12" md="8">
            <v-card>
                <v-card-item>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field
                                v-model.number="barcode"
                                :prepend-inner-icon="BarcodeIcon"
                                type="number"
                                variant="outlined"
                                placeholder="Scan Barcode"
                                hide-details
                                @change="getProductByBarcode"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-combobox
                                v-model="searchProduct"
                                variant="outlined"
                                auto-select-first="exact"
                                label="Search Product"
                                :items="loadProduct"
                                item-title="name"
                            ></v-combobox>
                        </v-col>
                        <!-- <v-col cols="5">
                            <v-autocomplete
                                label="Category"
                                :items="['Fruit', 'Clothes', 'Others']"
                                variant="outlined"
                            ></v-autocomplete>
                        </v-col> -->
                        <v-col cols="12">
                            <v-table hover fixed-header height="300px">
                                <thead>
                                <tr class="border-md">
                                    <th class="text-left font-weight-bold">Product</th>
                                    <th class="text-left font-weight-bold">Stock</th>
                                    <th class="text-left font-weight-bold">Price</th>
                                    <th class="text-left font-weight-bold">Qty</th>
                                    <th class="text-left font-weight-bold">Total</th>
                                    <th class="text-left font-weight-bold">Del.</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="product in pos.products" :key="product.id">
                                    <table-data
                                        :product="product"
                                    ></table-data>
                                    <td>
                                        <v-btn class="px-0" density="compact" color="error" variant="tonal" @click="remove(product.id)">
                                            <TrashIcon stroke-width="1.2" size="15" />
                                        </v-btn>
                                    </td>
                                </tr>
                                </tbody>
                            </v-table>
                        </v-col>
                    </v-row>
                </v-card-item>
            </v-card>
        </v-col>
        <v-col cols="12" md="4">
            <v-text-field :value="order.subtotal" density="compact" variant="outlined" hide-details readonly>
                <template v-slot:prepend-inner>SUBTOTAL:</template>
                <template v-slot:append-inner>Taka</template>
            </v-text-field>
            <v-text-field v-model.number="order.discountPercent" type="number" density="compact" variant="outlined" hide-details bg-color="white">
                <template v-slot:prepend-inner>DISCOUNT(%):</template>
                <template v-slot:append-inner>%</template>
            </v-text-field>
            <v-text-field :value="order.discount" density="compact" variant="outlined" hide-details readonly>
                <template v-slot:prepend-inner>DISCOUNT:</template>
                <template v-slot:append-inner>Taka</template>
            </v-text-field>
            <v-text-field :value="order.vatPercent" density="compact" variant="outlined" hide-details readonly>
                <template v-slot:prepend-inner>VAT(%):</template>
                <template v-slot:append-inner>%</template>
            </v-text-field>
            <v-text-field :value="order.vat" density="compact" variant="outlined" hide-details readonly>
                <template v-slot:prepend-inner>VAT:</template>
                <template v-slot:append-inner>Taka</template>
            </v-text-field>
            <v-divider :thickness="3" class="bg-grey-darken-1 my-4"></v-divider>
            <v-text-field :value="order.total" density="compact" variant="outlined" hide-details readonly>
                <template v-slot:prepend-inner>TOTAL:</template>
                <template v-slot:append-inner>Taka</template>
            </v-text-field>
            <v-divider :thickness="3" class="bg-grey-darken-1 mt-4"></v-divider>
            <!-- <div class="d-flex flex-row ga-2">
                <v-switch label="CASH" color="secondary" hide-details></v-switch>
                <v-switch label="CARD" color="secondary" hide-details></v-switch>
                <v-switch label="CHECK" color="secondary" hide-details></v-switch>
            </div> -->
            <v-radio-group class="mt-6" inline>
                <label for="cash" class="me-2"><input id="cash" type="radio" v-model="order.payment_type" name="same" value="Cash" checked> CASH</label>
                <label for="card" class="me-2"><input id="card" type="radio" v-model="order.payment_type" name="same" value="Card"> CARD</label>
                <label for="check" class="me-2"><input id="check" type="radio" v-model="order.payment_type" name="same" value="Check"> CHECK</label>
            </v-radio-group>
            <v-divider :thickness="3" class="bg-grey-darken-1 mb-4"></v-divider>
            <v-text-field :value="order.due" density="compact" variant="outlined" hide-details readonly>
                <template v-slot:prepend-inner>DUE:</template>
                <template v-slot:append-inner>Taka</template>
            </v-text-field>
            <v-text-field
                v-model.number="order.paid"
                type="number"
                density="compact"
                variant="outlined"
                bg-color="white"
                :error="!!errors.paid"
                :error-messages="errors.paid"
                @input="errors.paid = null"
                ><template v-slot:prepend-inner>PAID:</template>
                <template v-slot:append-inner>Taka</template>
            </v-text-field>
            <v-btn variant="outlined" color="secondary" class="mt-2 justify-end" @click="saveOrder">Save Order</v-btn>
        </v-col>
    </v-row>
</template>

<style lang="css" scoped>
#cash, #card, #check {
    width: 15px;
    height: 15px;
}
</style>
