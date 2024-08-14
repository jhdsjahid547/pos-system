<script setup>
import { ref, watch } from "vue";
import {
    PlusIcon,
    BarcodeIcon,
    DetailsIcon,
    EditIcon,
    TrashIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    ChevronsRightIcon,
    ChevronsLeftIcon,
} from "vue-tabler-icons";
import FakeAPI from "@/stores/product.js";
import { useForm, router } from "@inertiajs/vue3";
import { useFlashStore } from "@/stores/flash";
import ProductForm from "@/Pages/Product/Component/ProductForm.vue";
import { useProductFormStore } from '@/stores/ProductForm';
import BaseItemBar from "@/Components/BaseItemBar.vue";
import DetailsModal from "./Component/DetailsModal.vue";
import GenerateSticker from "./Component/GenerateSticker.vue";
import VueBarcode from '@chenfengyuan/vue-barcode';

const props = defineProps({
    products: Array,
    categories: Array
})
const productForm = useProductFormStore();
const flash = useFlashStore();
//breadcrumbs setup
// const page = ref({ title: 'Product Management' });
// const breadcrumbs = ref([
//     {
//     title: 'Products',
//     disabled: true,
//     href: '#'
//     }
// ]);
/*Fetch product from database start*/
const itemsPerPage = ref(10);
const headers = [
    { title: 'Product Name', key: 'name', sortable: false }, //class: 'my-header-style'
    { title: 'Category', key: 'category.name', sortable: false },
    { title: 'Barcode', key: 'barcode', sortable: false },
    // { title: 'Stock', key: 'stock', sortable: false },
    // { title: 'Purchase Price', key: 'purchase_price', sortable: false },
    { title: 'Selling Price', key: 'sell_price', sortable: false },
    { title: 'Status', key: 'status', sortable: false },
    { title: 'Actions', key: 'actions' },
];
const serverItems = ref([]);
const loading = ref(true);
const totalItems = ref(0);
const nameOrBarcode = ref('');
const search = ref('');
watch(nameOrBarcode, () => {
    search.value = String(Date.now());
});
const triggerFetch = () => {
    search.value = String(Date.now())
};
const loadItems = ({ page, itemsPerPage }) => {
    loading.value = true;
    FakeAPI(props.products).fetch({
        page,
        itemsPerPage,
        search: { nameOrBarcode: nameOrBarcode.value }
    }).then(({ items, total }) => {
        serverItems.value = items;
        totalItems.value = total;
        loading.value = false;
    });
};
/*Fetch product from database end*/
// const isBase64Image = str => {
//   const base64Pattern = /^data:image\/(png|jpg|jpeg);base64,/;
//   return base64Pattern.test(str);
// }
//for modal open and close
const dialog = ref(false);
//check modal is edit or create mode
const isEdit = ref(false);
//configure form data
const form = useForm({
    name: null,
    category_id: null,
    barcode: null,
    stock: null,
    purchase_price: null,
    sell_price: null,
    description: null,
    image: null,
});
//this value use two times(formReset & editItem) thats why make fuction
const extract = item => {
    form.name = item.name;
    form.category_id = item.category_id;
    form.barcode = item.barcode;
    form.stock = item.stock;
    form.purchase_price = item.purchase_price;
    form.sell_price = item.sell_price;
    form.description = item.description;
    form.image = null;
    productForm.hasImage = 'storage/'+item.image;
}
//modal cancel for custom event
const formCancel = () => dialog.value = false;
//set current selected(when edit button clicked) product data
const previous = ref(null);
//modal reset for custom event
const formReset = () => {
    if (previous.value) {
        extract(previous.value);
    } else {
        form.reset()
        productForm.hasImage = null;
    }
}
//when create product click perfom this action
const createItem = () => {
    if (isEdit.value) {
        form.reset();
        productForm.hasImage = null;
        isEdit.value = false;
    }
    dialog.value = true;
};
//generate sticker
const rules = {
        id: "printMe",
        popTitle: 'barcodes',
        closeCallback () {
            productForm.printDailog = false;
        }
    }
const sticker = (item) => {
    productForm.productDetails = item;
    productForm.stickerDailog = true;
}
//details view
const viewItem = (item) => {
    productForm.productDetails = item;
    productForm.detailsDailog = true;
}
//when edit button click perfom this action
const editItem = item => {
    previous.value = item;
    extract(item);
    productForm.editImage = 'storage/'+item.image;
    isEdit.value = true;
    dialog.value = true;
};
//ferform delete operation
const deleteItem = (id) => {
    if (confirm("Are you sure want to delete!")) {
        router.delete(route('products.destroy', { product: id }), {
            preserveScroll: true,
            onSuccess: () => {
                triggerFetch();
                flash.snackbar = true;
            }
        });
    }
}
//perform save operation to backend
const formSave = () => {
    if (isEdit.value) {
        //put or patch method file upload not support thats why
        router.post(route('products.update', { product: previous.value.id }), {
            _method: 'put',
            ...form,
        }, {
            onSuccess: () => {
                triggerFetch();
                flash.snackbar = true;
                dialog.value = false;
            },
            onError: (e) => {
                productForm.errors = e;
            }
        });
    } else {
        form.post(route('products.store'), {
            onSuccess: () => {
                triggerFetch();
                flash.snackbar = true;
                form.reset();
            }
        });
    }
};
</script>

<template>
    <!-- <BaseBreadcrumb :title="page.title" :breadcrumbs="breadcrumbs"></BaseBreadcrumb> -->
    <BaseItemBar>
        <v-btn @click="createItem" :prepend-icon="PlusIcon" color="secondary" variant="outlined">Create Product</v-btn>
        <template #end>
            <v-text-field
                max-width="200"
                v-model="nameOrBarcode"
                variant="outlined"
                density="compact"
                placeholder="Search name/barcode"
                hide-details
            ></v-text-field>
        </template>
    </BaseItemBar>
    <v-data-table-server
        class="rounded-md"
        item-value="name"
        v-model:items-per-page="itemsPerPage"
        :headers="headers"
        :items="serverItems"
        :items-length="totalItems"
        :loading="loading"
        :search="search"
        @update:options="loadItems"
        :prev-icon="ChevronLeftIcon"
        :first-icon="ChevronsLeftIcon"
        :next-icon="ChevronRightIcon"
        :lastIcon="ChevronsRightIcon"
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
            <v-tooltip text="Sticker" location="bottom">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" @click="sticker(item)" variant="outlined" density="comfortable">
                        <BarcodeIcon stroke-width="1.5" size="22" />
                    </v-btn>
                </template>
            </v-tooltip>
            <v-tooltip text="Details" location="bottom">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" @click="viewItem(item)" variant="outlined" color="success" density="comfortable">
                        <DetailsIcon stroke-width="1.5" size="22" />
                    </v-btn>
                </template>
            </v-tooltip>
            <v-tooltip text="Edit" location="bottom">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" @click="editItem(item)" variant="outlined" color="secondary" density="comfortable">
                        <EditIcon stroke-width="1.5" size="22" />
                    </v-btn>
                </template>
            </v-tooltip>
            <v-tooltip text="Delete" location="bottom">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" @click="deleteItem(item.id)" variant="outlined" color="error" density="comfortable">
                        <TrashIcon stroke-width="1.5" size="22" />
                    </v-btn>
                </template>
            </v-tooltip>
        </template>
        <!-- <template v-slot:bottom>
            <v-data-table-footer :nextIcon="ChevronRightIcon"></v-data-table-footer>
        </template> -->
    </v-data-table-server>
    <div v-if="productForm.printDailog" id="printMe" style="background:red;" class="print-only">
        <v-row>
            <v-col
            cols="2"
            class="mx-5"
            v-for="quantity of Number(productForm.barcodeQty)" :key="quantity">
                <vue-barcode
                :options="{ height: 50, width: 1.2 }"
                :value="productForm.productDetails.barcode"
                ></vue-barcode>
            </v-col>
        </v-row>
    </div>
    <div class="pa-4 text-center">
        <v-dialog v-model="dialog" max-width="800"> <!--@click:outside="backdrop"-->
            <product-form
                :form="form"
                :categories="categories"
                :is-edit="isEdit"
                :last-id="products.length + 1"
                @form-cancel="formCancel"
                @formReset="formReset"
                @form-save="formSave"
            ></product-form>
        </v-dialog>
    </div>
    <div class="pa-4 text-center">
        <v-dialog v-model="productForm.detailsDailog" max-width="800"> <!--@click:outside="backdrop"-->
            <details-modal></details-modal>
        </v-dialog>
    </div>
    <div class="pa-4 text-center">
        <v-dialog v-model="productForm.stickerDailog" max-width="800"> <!--@click:outside="backdrop"-->
            <generate-sticker :rules="rules"></generate-sticker>
        </v-dialog>
    </div>
<!--<vue3-barcode value="1234568" :height="20" :width="2"></vue3-barcode>-->
</template>

<style lang="css" scoped>
.print-only {
  display: none;
}
@media print {
  .print-only {
    display: block;
  }

  body * {
    visibility: hidden;
  }

  .print-only,
  .print-only * {
    visibility: visible;
  }

  .print-only {
    position: absolute;
    right: 0;
    left: 0;
    top: 0;
  }
}
</style>

