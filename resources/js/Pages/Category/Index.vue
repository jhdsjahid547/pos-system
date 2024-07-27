<script setup>
import { useForm } from "@inertiajs/vue3";
import { useFlashStore } from "@/stores/flash.js";
import TableData from "@/Pages/Category/Component/TableData.vue";
const flash = useFlashStore();
const props = defineProps({
   categories: Array
});
const form = useForm({
    name: null,
    code: null
});
const data = () => {
    form.post(route('categories.store'), {
        onSuccess: () => {
            flash.snackbar = true
        }
    });
}
</script>

<template>
    <v-row>
        <v-col cols="12" order-md="1" md="4">
            <form @submit.prevent="data" class="rounded-md bg-white px-6 pt-2 pb-6">
                <v-text-field
                    v-model="form.name"
                    label="Category Name"
                    class="mt-4 mb-8"
                    density="comfortable"
                    hide-details="auto"
                    variant="outlined"
                    color="primary"
                    :error="!!form.errors.name"
                    :error-messages="form.errors.name"
                    @input="form.clearErrors('name')"
                ></v-text-field>
                <v-text-field
                    v-model.number="form.code"
                    type="number"
                    label="Identity Code"
                    class="mt-4 mb-8"
                    density="comfortable"
                    hide-details="auto"
                    variant="outlined"
                    color="primary"
                    :error="!!form.errors.code"
                    :error-messages="form.errors.code"
                    @input="form.clearErrors('code')"
                ></v-text-field>
                <v-btn color="secondary" block variant="flat" size="large" type="submit">Create Category</v-btn>
            </form>
        </v-col>
        <v-col cols="12" md="8" class="pa-3">
            <v-table class="rounded-md">
                <thead>
                <tr>
                    <th class="font-weight-bold text-left">Sl.</th>
                    <th class="font-weight-bold text-left">Category</th>
                    <th class="font-weight-bold text-left">Code</th>
                    <th class="font-weight-bold text-left">Edit</th>
                    <th class="font-weight-bold text-left">Delete</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(category, i) in categories" :key="category.id">
                    <td class="set-width-id">{{ i + 1 }}</td>
                    <table-data :category></table-data>
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
