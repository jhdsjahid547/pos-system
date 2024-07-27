<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div><v-icon icon="mdiAccount"></v-icon>Another Page</div>
    <Link :href="route('dashboard.index')">
        <v-btn>Refresh</v-btn>
    </Link>
</template>
