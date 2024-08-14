<script setup>
import { CameraPlusIcon, XIcon, CheckIcon } from 'vue-tabler-icons';
import { useProductFormStore } from '@/stores/ProductForm';
//Get value pass through props
const props = defineProps({
    form: Object,
    categories: Array,
    lastId: Number,
    isEdit: Boolean,
})
const productForm = useProductFormStore();
//Generate static barcode
const generate = () => {
    if (props.form.errors.barcode) {
        props.form.clearErrors('barcode');
    }
    const position = 10000 + props.lastId;
    const today = (new Date().toISOString().replace(/-/g, "").split("T")[0]);
    props.form.barcode = position + today;
}
//Emits custom events
const emit = defineEmits(['formCancel', 'formReset', 'formSave']);
const formCancel = () => emit('formCancel');
const formReset = () => emit('formReset');
const formSave = () => emit('formSave');
//fetch input image or data base image to image input field 
const onFileChange = event => {
const file = event.target.files[0];
    if (file) {
        props.form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            productForm.hasImage = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
//Clear image input when click cross icon
const clearImage = () => {
    if (props.isEdit) {
        productForm.hasImage = productForm.editImage;
    } else {
        productForm.hasImage = null;
    }
    props.form.reset('image');
}
</script>

<template>
    <v-card :prepend-icon="CheckIcon" :title="isEdit ? 'Update Product' : 'Create Product'">
        <v-card-text>
            <v-row dense>
                <v-col cols="12" md="6" sm="6">
                    <v-text-field 
                        v-model="form.name" 
                        label="Product Name*" 
                        variant="outlined"
                        :error="!!form.errors.name || !!productForm.errors.name"
                        :error-messages="form.errors.name || productForm.errors.name"
                        @input="() => {form.clearErrors('name'); productForm.errors.name = null;}">
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6">
                    <v-select
                        v-model.number="form.category_id"
                        label="Select Category*"
                        variant="outlined"
                        :items="categories"
                        item-title="name"
                        item-value="id"
                        :error="!!form.errors.category_id || !!productForm.errors.category_id"
                        :error-messages="form.errors.category_id || !!productForm.errors.category_id"
                        @focus="() => {form.clearErrors('category_id'); productForm.errors.category_id = null;}"
                    ></v-select>
                </v-col>

                <v-col cols="12" md="6" sm="6">
                    <v-text-field 
                        v-model.number="form.barcode" 
                        type="number" 
                        label="Barcode*" 
                        variant="outlined"
                        :error="!!form.errors.barcode || !!productForm.errors.barcode"
                        :error-messages="form.errors.barcode || productForm.errors.barcode"
                        @input="() => {form.clearErrors('barcode'); productForm.errors.barcode = null;}">
                        <template v-slot:append-inner>
                            <v-btn 
                                color="lightsecondary" 
                                variant="flat" 
                                class="text-secondary" 
                                @click="generate"
                            >Generate</v-btn>
                        </template>
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6">
                    <v-text-field 
                        v-model.number="form.stock" 
                        type="number" 
                        label="In Stock" 
                        variant="outlined">
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6">
                    <v-text-field 
                        v-model.number="form.purchase_price" 
                        type="number" 
                        label="Purchase Price" 
                        variant="outlined">
                    </v-text-field>
                </v-col>
                <v-col cols="12" md="6" sm="6">
                    <v-text-field 
                        v-model.number="form.sell_price" 
                        type="number" label="Selling Price*" 
                        variant="outlined"
                        :error="!!form.errors.sell_price || !!productForm.errors.sell_price"
                        :error-messages="form.errors.sell_price || productForm.errors.sell_price"
                        @input="() => {form.clearErrors('sell_price'); productForm.errors.sell_price = null;}"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" md="5" sm="6">
                    <v-textarea 
                        v-model="form.description" 
                        label="Description" 
                        variant="outlined" 
                        rows="3">
                    </v-textarea>
                </v-col>
                <v-col cols="12" md="4" sm="6">                
                    <v-file-input
                        @change="onFileChange"
                        accept="image/png, image/jpeg"
                        class="border-md border-success pt-6"
                        label="Image*"
                        :prepend-icon="CameraPlusIcon"
                        variant="outlined"
                        :clear-icon="XIcon"
                        @click:clear="clearImage"
                        show-size
                        :error="!!form.errors.image || !!productForm.errors.image"
                        :error-messages="form.errors.image || productForm.errors.image"
                        @focus="() => {form.clearErrors('image'); productForm.errors.image = null;}"
                    ></v-file-input>
                </v-col>
                <v-col cols="12" md="3" sm="6">
                    <v-img
                        v-if="productForm.hasImage || form.image"
                        height="100"
                        width="100"
                        cover
                        alt="fatal error"
                        :src="productForm.hasImage ?? 'storage/'+form.image"
                    ></v-img>
                </v-col>
            </v-row>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn text="Close" variant="plain" @click="formCancel"></v-btn>
            <v-btn color="secondary" text="Reset" variant="plain" @click="formReset"></v-btn>
            <v-btn color="primary" text="Save" variant="tonal" @click="formSave"
            ></v-btn>
        </v-card-actions>
    </v-card>
</template>
