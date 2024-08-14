<template>
    <v-row class="page-breadcrumb mb-1 mt-1">
      <v-col cols="12" md="12">
        <v-card variant="flat" class="px-4 py-3">
          <v-row no-gutters class="align-center">
            <v-col md="5">
              <slot></slot>
            </v-col>
  
            <v-col md="7" sm="12" cols="12">
              <v-breadcrumbs class="text-h5 justify-md-end pa-1">
                <slot name="end"></slot>
              </v-breadcrumbs>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </template>