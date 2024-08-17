<script setup>
import { ref, watch } from 'vue';
import { router } from "@inertiajs/vue3";
import { VDateInput } from 'vuetify/labs/VDateInput';
import { useDate } from 'vuetify';
import {
    DetailsIcon,
    EditIcon,
    TrashIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    ChevronsRightIcon,
    ChevronsLeftIcon,
} from "vue-tabler-icons";
import FakeAPI from "@/stores/invoice.js";
import { useFlashStore } from "@/stores/flash";
import BaseItemBar from "@/Components/BaseItemBar.vue";
import { usePosStore } from '@/stores/pos';
import DetailsModal from '@/Pages/Pos/Component/DetailsModal.vue';
import { useActivityStore } from "@/stores/activity.js";

const props = defineProps({
    invoices: Array
});
const activityStore = useActivityStore()
const flash = useFlashStore();
const date = useDate();
const pos = usePosStore();
//Fetch Invoice
const itemsPerPage = ref(10);
const headers = [
    { title: 'Invoice Number', key: 'id', sortable: false },
    { title: 'Order Date', key: 'created_at', sortable: false },
    { title: 'Total', key: 'total', sortable: false },
    { title: 'Paid', key: 'paid', sortable: false },
    { title: 'Due', key: 'due', sortable: false },
    { title: 'Payment Type', key: 'payment_type', sortable: false },
    { title: 'Actions', key: 'actions' },
];
const serverItems = ref([]);
const loading = ref(true);
const totalItems = ref(0);
const orderId = ref(null);
const dateRange = ref(null);
const search = ref('');
watch([orderId, dateRange], () => {
    search.value = String(Date.now());
});
const triggerFetch = () => {
    search.value = String(Date.now())
};
const loadItems = ({ page, itemsPerPage }) => {
    loading.value = true;
    FakeAPI(props.invoices).fetch({
        page,
        itemsPerPage,
        search: { invoiceId: orderId.value, range: dateRange.value }
    }).then(({ items, total }) => {
        serverItems.value = items;
        totalItems.value = total;
        loading.value = false;
    });
};
//Invoice products
const viewProducts = item => {
    pos.products = item;
    pos.detailsModal = true;
}
//Edit Order
const editOrder = async (invoice, products) => {
    const { id, subtotal, discount_percent, discount, vat_percent, vat, total, due, paid, payment_type } = invoice;
    pos.invoice = { id, subtotal, discount_percent, discount, vat_percent, vat, total, due, paid, payment_type };
    pos.products = await products.map(item => {
        return {
            id: item.product.id,
            name: item.product.name,
            stock: item.product.stock,
            sell_price: item.product.sell_price,
            still_quantity: item.quantity,
            quantity: item.quantity,
            sub_total: item.product.sell_price * item.quantity
        };
    })
    if (pos.products) {
        router.visit(route('orders.create'), {
            onSuccess: () => activityStore.setRouteName({ active: 'orders.create' })
        });
    }
}
//Delete item
const deleteItem = id => {
    if (confirm("Are you sure want to delete!")) {
        router.delete(route('orders.destroy', { order: id }), {
            preserveScroll: true,
            onSuccess: () => {
                triggerFetch();
                flash.snackbar = true;
            }
        });
    }
};
</script>

<template>
    <BaseItemBar>
        <v-date-input
            v-model="dateRange"
            label="Filter by date range"
            max-width="368"
            multiple="range"
            variant="outlined"
            density="compact"
            clearable
            hide-details
        ></v-date-input>
        <template #end>
            <v-text-field
                max-width="200"
                v-model="orderId"
                variant="outlined"
                density="compact"
                placeholder="Invoice Number"
                hide-details
            ></v-text-field>
        </template>
    </BaseItemBar>
        <v-data-table-server
        class="rounded-md"
        item-value="id"
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
        disable-sort>
        <template v-slot:headers="{ columns }">
            <tr>
                <template v-for="column in columns" :key="column.key">
                    <th class="font-weight-bold">{{ column.title }}</th>
                </template>
            </tr>
        </template>
        <template v-slot:item.created_at="{ item }">
            {{ date.format(item.created_at, 'fullDateTime') }}
        </template>
        <template v-slot:item.actions="{ item }">
            <v-tooltip text="Products" location="bottom">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" @click="viewProducts(item.products)" variant="outlined" color="success" density="comfortable">
                        <DetailsIcon stroke-width="1.5" size="22" />
                    </v-btn>
                </template>
            </v-tooltip>
            <v-tooltip text="Edit" location="bottom">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" @click="editOrder(item, item.products)" variant="outlined" color="warning" density="comfortable">
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
    </v-data-table-server>
    <div class="pa-4 text-center">
        <v-dialog v-model="pos.detailsModal" max-width="500"> <!--@click:outside="backdrop"-->
            <details-modal></details-modal>
        </v-dialog>
    </div>
</template>
