<script setup>
import { ref, computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useActivityStore } from '@/stores/activity.js'
import Icon from '../IconSet.vue'

const props = defineProps({ item: Object, level: Number })
const activityStore = useActivityStore()

const active = ref(props.item.name)
const setActive = (routeName) => {
    activityStore.setRouteName({ active: routeName })
    active.value = routeName;
}
const style = computed(() => activityStore.current === active.value)
</script>

<template>
    <Link
        @click="setActive(item.name)"
        :href="route(item.name)"
        class="text-black text-decoration-none"
    ><!--:class="{ 'text-white': style }" insert in link tagt if problem-->
      <v-list-item rounded class="mb-1" color="secondary" href="#" :class="{ 'bg-lightsecondary text-secondary': style }"> <!--:href="route(item.name)"-->
        <!---If icon-->
        <template v-slot:prepend>
          <Icon :item="props.item.icon" :level="props.level" />
        </template>
          <!---Title-->
        <v-list-item-title>{{ item.title }}</v-list-item-title>
      </v-list-item>
    </Link>
</template>
