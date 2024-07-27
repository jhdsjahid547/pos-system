<script setup>
import { computed, ref } from 'vue'
import { useForm, router } from "@inertiajs/vue3";
import { useFlashStore } from "@/stores/flash.js";
import {EditIcon, CircleCheckFilledIcon, SquareRoundedXIcon, TrashIcon } from 'vue-tabler-icons';

const flash = useFlashStore();
const props = defineProps({
    category: Object
});
const editable = ref(false);
const enableDisable = computed(() => editable.value = !editable.value);
const edit = () => enableDisable.value;
const form = useForm({
    name: props.category.name,
    code: props.category.code
});
const cancel = () => {
    if (form.hasErrors) {
        form.clearErrors('name');
        form.clearErrors('code');
    }
    enableDisable.value;
};
const clearError = (trigger) => {
    if (trigger === 'name') {
        form.clearErrors('name');
    } else if (trigger === 'code') {
        form.clearErrors('code');
    }
}
const handleInput = (event, trigger) => {
    if (trigger === 'name') {
        form.name = event.target.innerText;
    } else if (trigger === 'code') {
        form.code = event.target.innerText;
    }
};
const update = () => {
    form.patch(route('categories.update', { category: props.category.id }), {
        preserveScroll: true,
        onSuccess: () => {
            flash.snackbar = true;
            enableDisable.value;
        },
    });
};
const remove = () => {
    if (confirm("Are you sure want to delete!")) {
        router.delete(route('categories.destroy', { category: props.category.id }), {
            preserveScroll: true,
            onSuccess: () => {
                flash.snackbar = true;
            }
        })
    }
}
</script>

<template>
    <td v-if="!editable" class="set-width-name">{{ category.name }}</td>
    <td v-else
        :contenteditable="editable"
        @focus="clearError('name')"
        @input="handleInput($event,'name')"
        class="set-width-name"
        :class="{ 'border-md border-info': editable }">
        {{ category.name }}
        <div class="text-sm-caption text-red" v-if="!!form.errors.name">{{ form.errors.name }}</div>
    </td>
    <td v-if="!editable" class="set-width-code">{{ category.code }}</td>
    <td v-else
        :contenteditable="editable"
        @focus="clearError('code')"
        @input="handleInput($event,'code')"
        class="set-width-code"
        :class="{ 'border-md border-info': editable }">
        {{ category.code }}
        <div class="text-sm-caption text-red" v-if="!!form.errors.code">{{ form.errors.code }}</div>
    </td>
    <td class="action-edit">
        <v-btn v-if="!editable" color="secondary" variant="outlined" @click="edit">
            <EditIcon stroke-width="1.5" size="22" />
        </v-btn>
        <div v-else>
            <v-btn color="warning" variant="outlined" @click="update" class="me-1">
                <CircleCheckFilledIcon stroke-width="1.5" size="22" />
            </v-btn>
            <v-btn variant="outlined" @click="cancel">
                <SquareRoundedXIcon stroke-width="1.5" size="22" />
            </v-btn>
        </div>

    </td>
    <td class="action-delete">
        <v-btn color="error" variant="outlined" @click="remove">
            <TrashIcon stroke-width="1.5" size="22" />
        </v-btn>
    </td>
</template>

<style scoped>
[contenteditable] {
    outline: 0px solid transparent;
}
.set-width-name {
    width: 250px;
}
.set-width-code {
    width: 100px;
}
.action-edit {
    width: 140px;
}
.action-delete {
    width: 50px;
}
</style>
