<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useActivityStore } from '@/stores/activity.js'
import NavItem from '../NavItem/NavItem.vue'
import Icon from '../IconSet.vue'

const props = defineProps({ item: Object, level: Number })
const activityStore = useActivityStore()

const active = computed(() => activityStore.current.includes(props.item.name))
const setActive = (routeName) => {
    activityStore.setRouteName({ active: routeName })
}
</script>

<template>
  <!-- ---------------------------------------------- -->
  <!---Item Childern -->
  <!-- ---------------------------------------------- -->
    <v-list>
        <v-list-item
            @click="setActive(item.name)"
            :title="item.title" :class="{ 'bg-purple-lighten-4 text-secondary': active }"
            rounded
        >
            <template v-slot:prepend>
                <Icon :item="item.icon" :level="level" />
            </template>
        </v-list-item>
        <div class="pl-6">
            <Link
                v-if="active"
                v-for="(subitem, i) in item.children" :key="i"
                href="#"
                class="text-decoration-none"
            > <!--:href="route(item.name)"-->
                <NavCollapse :item="subitem" v-if="subitem.children" :level="props.level + 1" />
                <NavItem :item="subitem" :level="props.level + 1" v-else></NavItem>
            </Link>
        </div>
    </v-list>
</template>
