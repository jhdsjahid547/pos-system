<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { EyeIcon, EyeOffIcon } from 'vue-tabler-icons';

const valid = ref(false)
const show = ref(false)
const isLoading = ref(false)

const form = useForm({
    email: null,
    password: null
})
const login = () => {
    isLoading.value = true;
    form.post(route('login.store'))
    isLoading.value = false;
}

</script>

<template>
    <v-row class="h-screen" no-gutters>
        <v-col cols="12" class="d-flex align-center bg-lightprimary">
            <v-container>
                <div class="pa-7 pa-sm-12">
                    <v-row justify="center">
                        <v-col cols="12" lg="10" xl="6" md="7">
                            <v-card elevation="16" class="loginBox">
                                <v-card-text class="pa-9">
                                    <!---Left Part Logo -->
                                    <v-row>
                                        <v-col cols="12" class="text-center">
                                            <v-img
                                                class="mx-auto my-6"
                                                max-width="200"
                                                src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
                                            ></v-img>
                                        </v-col>
                                    </v-row>
                                    <!---Left Part Logo -->
                                    <!---Left Part Form-->
                                    <h5 class="text-h5 text-center my-4 mb-8">Sign in with Email address</h5>
                                    <form @submit.prevent="login" class="mt-7 loginForm">
                                        <v-text-field
                                            label="Email Address / Username"
                                            class="mt-4 mb-8"
                                            required
                                            density="comfortable"
                                            hide-details="auto"
                                            type="email"
                                            variant="outlined"
                                            color="primary"
                                            v-model="form.email"
                                            :error="!!form.errors.email"
                                            :error-messages="form.errors.email"
                                            @input="form.clearErrors('email')"
                                        ></v-text-field>
                                        <v-text-field
                                            label="Password"
                                            required
                                            density="comfortable"
                                            variant="outlined"
                                            color="primary"
                                            hide-details="auto"
                                            :append-inner-icon="show ? EyeIcon : EyeOffIcon"
                                            :type="show ? 'text' : 'password'"
                                            @click:append-inner="show = !show"
                                            class="pwdInput"
                                            v-model="form.password"
                                            :error="!!form.errors.password"
                                            :error-messages="form.errors.password"
                                            @input="form.clearErrors('password')"
                                        ></v-text-field>
                                        <v-btn color="secondary" :loading="isLoading" block class="mt-4" variant="flat" size="large" :disabled="valid" type="submit">Sign In</v-btn>
                                    </form>
                                    <!---Left Part Form-->
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </div>
            </v-container>
        </v-col>
    </v-row>
</template>

<style scoped lang="scss">
.loginBox {
    max-width: 475px;
    margin: 0 auto;
}
.outlinedInput .v-field {
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: none;
}
.pwdInput {
    position: relative;
    .v-input__append {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }
}
.loginForm {
    .v-text-field .v-field--active input {
        font-weight: 500;
    }
}
</style>
