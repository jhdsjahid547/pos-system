<script setup>
import iconCard from '@/assets/images/icons/icon-card.svg';
import { CircleArrowUpRightIcon } from 'vue-tabler-icons';
</script>

<template>
    <v-row>
        <v-col cols="6" md="4">
            <v-card elevation="0" class="bg-secondary overflow-hidden bubble-shape bubble-secondary-shape">
                <v-card-text>
                    <div class="d-flex align-start mb-6">
                        <v-btn icon rounded="sm" color="darksecondary" variant="flat">
                            <img :src="iconCard" width="25" />
                        </v-btn>
                    </div>
                    <h2 class="text-h1 font-weight-medium">
                        $500.00 <a href="#"><CircleArrowUpRightIcon stroke-width="1.5" width="28" class="text-white" /> </a>
                    </h2>
                    <span class="text-subtitle-1 text-medium-emphasis text-white">Total Earning</span>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="6" md="4">
            <v-card elevation="0" class="bg-primary overflow-hidden bubble-shape bubble-primary-shape">
                <v-card-text>
                    <div class="d-flex align-start mb-6">
                        <v-btn icon rounded="sm" color="darkprimary" variant="flat">
                            <img :src="iconCard" width="25" />
                        </v-btn>
                    </div>
                    <h2 class="text-h1 font-weight-medium">
                        $400.00 <a href="#"><CircleArrowUpRightIcon stroke-width="1.5" width="28" class="text-white" /> </a>
                    </h2>
                    <span class="text-subtitle-1 text-medium-emphasis text-white">Total Sell</span>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="6" md="4">
            <v-card elevation="0" class="bg-success overflow-hidden bubble-shape bubble-primary-shape">
                <v-card-text>
                    <div class="d-flex align-start mb-6">
                        <v-btn icon rounded="sm" color="darkprimary" variant="flat">
                            <img :src="iconCard" width="25" />
                        </v-btn>
                    </div>
                    <h2 class="text-h1 font-weight-medium">
                        $600.00 <a href="#"><CircleArrowUpRightIcon stroke-width="1.5" width="28" class="text-white" /> </a>
                    </h2>
                    <span class="text-subtitle-1 text-medium-emphasis text-white">Total Cost</span>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

