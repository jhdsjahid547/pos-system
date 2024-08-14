<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { EditIcon, CircleCheckFilledIcon, SquareRoundedXIcon } from 'vue-tabler-icons';
import { useFlashStore } from '@/stores/flash';

const flash = useFlashStore();
const props = defineProps({
    taxDiscount: Object
});
const editable = ref(false);
const enableDisable = computed(() => editable.value = !editable.value);
const edit = () => enableDisable.value;
const form = useForm({
    vat: props.taxDiscount.vat,
    discount: props.taxDiscount.discount
});
const cancel = () => {
    if (form.hasErrors) {
        form.clearErrors('vat');
        form.clearErrors('discount');
    }
    enableDisable.value;
};
const clearError = (trigger) => {
    if (trigger === 'vat') {
        form.clearErrors('vat');
    } else if (trigger === 'discount') {
        form.clearErrors('discount');
    }
}
const handleInput = (event, trigger) => {
    if (trigger === 'vat') {
        form.vat = event.target.innerText;
    } else if (trigger === 'discount') {
        form.discount = event.target.innerText;
    }
};
const update = () => {
    form.patch(route('tax-or-discounts.update', { tax_or_discount: props.taxDiscount.id }), {
        preserveScroll: true,
        onSuccess: () => {
            flash.snackbar = true;
            enableDisable.value;
        },
    });
};
</script>

<template>
    <td v-if="!editable" class="set-width-vat">{{ taxDiscount.vat }}</td>
    <td v-else
        :contenteditable="editable"
        @focus="clearError('vat')"
        @input="handleInput($event,'vat')"
        :class="{ 'border-md border-info': editable }">
        {{ taxDiscount.vat }}
        <div class="text-sm-caption text-red" v-if="!!form.errors.vat">{{ form.errors.vat }}</div>
    </td>
    <td v-if="!editable" class="set-width-discount">{{ taxDiscount.discount }}</td>
    <td v-else
        :contenteditable="editable"
        @focus="clearError('discount')"
        @input="handleInput($event,'discount')"
        :class="{ 'border-md border-info': editable }">
        {{ taxDiscount.discount }}
        <div class="text-sm-caption text-red" v-if="!!form.errors.discount">{{ form.errors.discount }}</div>
    </td>
    <td class="action-edit">
        <v-btn v-if="!editable" color="secondary" variant="outlined" @click="edit">
            <EditIcon stroke-width="1.5" size="22" />
        </v-btn>
        <div v-else>
            <v-btn color="warning" variant="outlined" class="me-1" @click="update">
                <CircleCheckFilledIcon stroke-width="1.5" size="22" />
            </v-btn>
            <v-btn variant="outlined" @click="cancel">
                <SquareRoundedXIcon stroke-width="1.5" size="22" />
            </v-btn>
        </div>
    </td>
</template>

<style lang="css" scoped>
[contenteditable] {
    outline: 0 solid transparent;
}
.action-edit {
    width: 170px;
}
</style>