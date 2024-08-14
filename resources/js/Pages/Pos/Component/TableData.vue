<script setup>
import { ref, computed } from 'vue';
import { usePosStore } from '@/stores/pos.js';

const props = defineProps({
    product: Object
});
const pos = usePosStore();
const quantity = ref(props.product.quantity);
const subTotal = computed(() => props.product.sell_price * quantity.value);
const addPrice = () => {
    console.log(quantity.value);
    if (quantity.value > props.product.stock) {
        quantity.value -= 1; 
        alert('Out of stock!');
    }
    if (quantity.value === 0) {
        quantity.value = 1;
    }
    const item = pos.products.find(item => item.id === props.product.id);
    if (item) {
        item.sub_total = subTotal.value;
        item.quantity = quantity.value;
    }
}
// const quantity = ref(1);
// const subTotal = computed(() => props.product.sell_price * quantity.value);
// const addPrice = () => {
//     if (quantity.value > props.product.stock) {
//         quantity.value -= 1; 
//         alert('Out of stock!');
//     }
//     if (quantity.value === 0) {
//         quantity.value = 1;
//     }
//     const item = pos.products.find(item => item.id === props.product.id);
//     if (item) {
//         item.sub_total = subTotal.value;
//         item.quantity = quantity.value;
//     }
// }
</script>

<template>
    <td>{{ product.name }}</td>
    <td>{{ product.stock }}</td>
    <td>{{ product.sell_price }}</td>
    <td>
        <v-text-field
            v-model.number="quantity"
            @input="addPrice"
            type="number"
            density="compact" 
            variant="outlined"
            max-width="70"
            hide-details
        ></v-text-field>
    </td>
    <td>{{ subTotal }}</td>
</template>