<script setup>
import { ref, watch } from "vue";
import FakeAPI from "@/stores/product.js";
import {useForm} from "@inertiajs/vue3";
import ProductForm from "@/Pages/Product/Component/ProductForm.vue";

const props = defineProps({
    products: Array,
    categories: Array
})
const itemsPerPage = ref(10);
const headers = [
    { title: 'Product Name', key: 'name', sortable: false, class: 'my-header-style' },
    { title: 'Category', key: 'category.name', sortable: false },
    { title: 'Barcode', key: 'barcode', sortable: false },
    { title: 'Stock', key: 'stock', sortable: false },
    { title: 'Purchase Price', key: 'purchase_price', sortable: false },
    { title: 'Selling Price', key: 'sell_price', sortable: false },
    { title: 'Status', key: 'status', sortable: false },
    { title: 'Actions', key: 'actions' },
];
const serverItems = ref([]);
const loading = ref(true);
const totalItems = ref(0);
const name = ref('');
const search = ref('');
watch(name, () => {
    search.value = String(Date.now())
});
const loadItems = ({ page, itemsPerPage }) => {
    loading.value = true;
    FakeAPI(props.products).fetch({
        page,
        itemsPerPage,
        search: { name: name.value }
    }).then(({ items, total }) => {
        serverItems.value = items;
        totalItems.value = total;
        loading.value = false;
    });
};
const dialog = ref(false);
const isEdit = ref(false);
const form = useForm({
    name: null,
    category_id: null,
    barcode: null,
    stock: null,
    purchase_price: null,
    sell_price: null,
    description: null
});
const formCancel = () => dialog.value = false;
const formSave = () => {
    if (isEdit.value) {
        alert('update route');
    } else {
        alert('store route');
    }
    dialog.value = false;
    form.reset();
}
const createItem = () => {
    if (isEdit.value) {
        form.reset();
        isEdit.value = false;
    }
    dialog.value = true;
};
const editItem = (item) => {
    form.name = item.name;
    form.category_id = item.category_id;
    form.barcode = item.barcode;
    form.stock = item.stock;
    form.purchase_price = item.purchase_price;
    form.sell_price = item.sell_price;
    form.description = item.description;
    isEdit.value = true;
    dialog.value = true;
};
</script>

<template>
    <v-btn @click="createItem" class="mb-4">Create Product</v-btn>
    <v-data-table-server
        class="rounded-md"
        v-model:items-per-page="itemsPerPage"
        :headers="headers"
        :items="serverItems"
        :items-length="totalItems"
        :loading="loading"
        :search="search"
        item-value="name"
        @update:options="loadItems"
        disable-sort
    >
        <template v-slot:headers="{ columns }">
            <tr>
                <template v-for="column in columns" :key="column.key">
                    <th class="font-weight-bold">{{ column.title }}</th>
                </template>
            </tr>
        </template>
        <template v-slot:item.status="{ item }">
            <v-chip
                :color="item.status ? 'green' : 'red'"
                :text="item.status ? 'Active' : 'Not Active'"
                class="text-uppercase"
                size="small"
                label
            ></v-chip>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-btn @click="editItem(item)">Edit</v-btn>
        </template>
        <template v-slot:tfoot>
            <tr>
                <td>
                    <v-text-field v-model="name" variant="outlined" class="ma-2" density="compact" placeholder="Search name..." hide-details></v-text-field>
                </td>
            </tr>
        </template>
    </v-data-table-server>
    <div class="pa-4 text-center">
        <v-dialog v-model="dialog" max-width="800"> <!--@click:outside="backdrop"-->
            <product-form
                :form="form"
                :categories="categories"
                :is-edit="isEdit"
                @form-cancel="formCancel"
                @form-save="formSave"
            ></product-form>
        </v-dialog>
    </div>
</template>

