<script setup>
const props = defineProps({
    form: Object,
    categories: Array,
    isEdit: Boolean,
})
const emit = defineEmits(['formCancel', 'formSave']);
const formCancel = () => emit('formCancel');
const formSave = () => emit('formSave');
</script>

<template>
    <v-card :prepend-icon="CheckIcon" :title="isEdit ? 'Update Product' : 'Create Product'">
        <v-card-text>
            <v-row dense>
                <v-col cols="12" md="6" sm="6">
                    <v-text-field v-model="form.name" label="Product Name*" variant="outlined" required></v-text-field>
                </v-col>

                <v-col cols="12" md="6" sm="6">
                    <v-select
                        v-model.number="form.category_id"
                        label="Select Category"
                        variant="outlined"
                        :items="categories"
                        item-title="name"
                        item-value="id"
                    ></v-select>
                </v-col>

                <v-col cols="12" md="6" sm="6">
                    <v-text-field v-model.number="form.barcode" type="number" label="Barcode" variant="outlined">
                        <template v-slot:append-inner>
                            <v-btn color="lightsecondary" variant="flat" class="text-secondary">Generaten</v-btn>
                        </template>
                    </v-text-field>
<!--                    <v-text-field v-model.number="form.barcode" type="number" label="Barcode" variant="outlined" required></v-text-field>-->
                </v-col>

                <v-col cols="12" md="6" sm="6">
                    <v-text-field v-model.number="form.stock" type="number" label="In Stock" variant="outlined" required></v-text-field>
                </v-col>

                <v-col cols="12" md="6" sm="6">
                    <v-text-field v-model.number="form.purchase_price" type="number" label="Purchase Price" variant="outlined" required></v-text-field>
                </v-col>

                <v-col cols="12" md="6" sm="6">
                    <v-text-field v-model.number="form.sell_price" type="number" label="Selling Price" variant="outlined" required></v-text-field>
                </v-col>

                <v-textarea v-model="form.description" label="Description" variant="outlined" rows="3"></v-textarea>

            </v-row>

        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text="Close" variant="plain" @click="formCancel"></v-btn>
            <v-btn color="primary" text="Save" variant="tonal" @click="formSave"
            ></v-btn>
        </v-card-actions>
    </v-card>
</template>
