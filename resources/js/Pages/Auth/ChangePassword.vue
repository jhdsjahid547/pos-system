<script setup>
import { ref } from 'vue'
import { useForm } from "@inertiajs/vue3";
import { useFlashStore } from "@/stores/flash.js";
import { EyeIcon, EyeOffIcon } from "vue-tabler-icons";

const flash = useFlashStore();
const show1 = ref(false);
const show2 = ref(false);
const show3 = ref(false);
const isLoading = ref(false)
const form = useForm({
    current_password: null,
    password: null,
    password_confirmation: null,
});
const data = () => {
    isLoading.value = true;
    form.patch(route('update.password'), {
        onSuccess: () => flash.snackbar = true
    });
    isLoading.value = false;
};
</script>
<template>
    <v-row justify="center" class="bg-white rounded-md ma-1">
        <v-col cols="12" lg="10" xl="6" md="7">
                <div class="pa-9">
                    <!---Left Part Logo -->
                    <!---Left Part Form-->
                        <form @submit.prevent="data" class="mt-7 loginForm">
                            <v-text-field
                                label="Old Password"
                                required
                                density="comfortable"
                                variant="outlined"
                                color="primary"
                                hide-details="auto"
                                class="pwdInput pb-4"
                                v-model="form.current_password"
                                :append-inner-icon="show1 ? EyeIcon : EyeOffIcon"
                                :type="show1 ? 'text' : 'password'"
                                @click:append-inner="show1 = !show1"
                                :error="!!form.errors.current_password"
                                :error-messages="form.errors.current_password"
                                @input="form.clearErrors('current_password')"
                            ></v-text-field>
                            <v-text-field
                                label="New Password"
                                required
                                density="comfortable"
                                variant="outlined"
                                color="primary"
                                hide-details="auto"
                                class="pwdInput pb-4"
                                v-model="form.password"
                                :append-inner-icon="show2 ? EyeIcon : EyeOffIcon"
                                :type="show2 ? 'text' : 'password'"
                                @click:append-inner="show2 = !show2"
                                :error="!!form.errors.password"
                                :error-messages="form.errors.password"
                                @input="form.clearErrors('password')"
                            ></v-text-field>
                            <v-text-field
                                label="Confirm Password"
                                required
                                density="comfortable"
                                variant="outlined"
                                color="primary"
                                hide-details="auto"
                                class="pwdInput pb-2"
                                v-model="form.password_confirmation"
                                :append-inner-icon="show3 ? EyeIcon : EyeOffIcon"
                                :type="show3 ? 'text' : 'password'"
                                @click:append-inner="show3 = !show3"
                                :error="!!form.errors.password_confirmation"
                                :error-messages="form.errors.password_confirmation"
                                @input="form.clearErrors('password_confirmation')"
                            ></v-text-field>
                        <v-btn color="secondary" :loading="isLoading" block class="mt-4" variant="flat" size="large" type="submit">Update</v-btn>
                    </form>
                    <!---Left Part Form-->
                </div>
        </v-col>
    </v-row>
</template>
