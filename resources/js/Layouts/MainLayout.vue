<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import VerticalSidebarVue from '@/Layouts/vertical-sidebar/VerticalSidebar.vue'
import VerticalHeaderVue from '@/Layouts/vertical-header/VerticalHeader.vue'
import FooterPanel from '@/Layouts/footer/FooterPanel.vue'
import { useCustomizerStore } from '@/stores/customizer.js'
import { useFlashStore } from "@/stores/flash.js";

const customizer = useCustomizerStore()
const flash = useFlashStore()
const user = computed(() => usePage().props.user)
</script>
<template>

<!--For authenticated user show dashboard or something-->
	<section v-if="user">
	  <v-locale-provider>
		<v-app
		  theme="PurpleTheme"
		  :class="[customizer.mini_sidebar ? 'mini-sidebar' : '']"
		>
		  <VerticalSidebarVue />
		  <VerticalHeaderVue />

		  <v-main>
			<v-container fluid class="page-wrapper">
            <div>
                <slot></slot>
            </div>
			</v-container>
			<v-container fluid class="pt-0">
			  <div>
				<FooterPanel />
			  </div>
			</v-container>
		  </v-main>
		</v-app>
	  </v-locale-provider>
	</section>
<!--if user not authenticated show login or other-->
    <section v-else>
        <div>
            <slot></slot>
        </div>
    </section>
<!--show flash message section-->
    <section>
        <v-snackbar v-if="!!flash.flashSuccess" v-model="flash.snackbar" :timeout="3000" color="green-lighten-1">
            {{ flash.flashSuccess }}
            <template v-slot:actions>
                <v-btn color="red" variant="text" @click="flash.clearFlash">X</v-btn>
            </template>
        </v-snackbar>
    </section>
</template>
