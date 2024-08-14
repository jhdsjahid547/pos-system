<script setup>
import { useForm } from '@inertiajs/vue3';
import { useFlashStore } from '@/stores/flash';
import TableData from '@/Pages/TaxDiscount/Component/TableData.vue';

const props = defineProps({
    taxDiscounts: Array
});
const flash = useFlashStore();
const form = useForm({
    vat: null,
    discount: null
});
const data = () => {
    form.post(route('tax-or-discounts.store'), {
        onSuccess: () => {
            flash.snackbar = true;
        }
    });
}
</script>

<template>
        <v-row>
        <v-col cols="12" order-md="1" md="4">
            <form @submit.prevent="data" class="rounded-md bg-white px-6 pt-2 pb-6">
                <v-text-field
                    v-model="form.vat"
                    label="Vat"
                    class="mt-4 mb-8"
                    density="comfortable"
                    hide-details="auto"
                    variant="outlined"
                    color="primary"
                    :error="!!form.errors.vat"
                    :error-messages="form.errors.vat"
                    @input="form.clearErrors('vat')"
                ></v-text-field>
                <v-text-field
                    v-model.number="form.discount"
                    label="Discount"
                    class="mt-4 mb-8"
                    density="comfortable"
                    hide-details="auto"
                    variant="outlined"
                    color="primary"
                    :error="!!form.errors.discount"
                    :error-messages="form.errors.discount"
                    @input="form.clearErrors('discount')"
                ></v-text-field>
                <v-btn color="secondary" block variant="flat" size="large" type="submit">Create</v-btn>
            </form>
        </v-col>
        <v-col cols="12" md="8" class="pa-3">
            <v-table class="rounded-md">
                <thead>
                <tr>
                    <th class="font-weight-bold text-left">Sl.</th>
                    <th class="font-weight-bold text-left">Vat</th>
                    <th class="font-weight-bold text-left">Discount</th>
                    <th class="font-weight-bold text-left">Edit</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(taxDiscount, i) in taxDiscounts" :key="taxDiscount.id">
                        <td class="set-width-id">{{ i + 1 }}</td>
                        <table-data :tax-discount="taxDiscount"></table-data>
                    </tr>
                </tbody>
            </v-table>
        </v-col>
    </v-row>
</template>

<style scoped>
.set-width-id {
    width: 50px;
}
</style>
