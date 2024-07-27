<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <v-img
        :width="300"
        aspect-ratio="16/9"
        cover
        src="@/assets/images/logos/logo.png"
    ></v-img>
    <div><v-icon icon="mdiAccount"></v-icon>Page rendered!</div>
    <Link :href="route('dashboard.index')">
        <v-btn>Refresh</v-btn>
    </Link>
</template>
