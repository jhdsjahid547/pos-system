<template>
  <v-footer class="px-0 footer mt-2">
    <v-row justify="center" align="center" no-gutters>
      <v-col cols="12" sm="6">
        <p class="text-body-1 mb-0 text-sm-left text-center">
          Developed by
          <a href="#" class="text-darkText text-decoration-none" target="_blank">Jahid</a>
        </p>
      </v-col>
      <v-col class="text-sm-right text-center" cols="12" sm="6">
        <a class="mx-2 text-body-1 text-darkText text-decoration-none" target="_blank" href="#">Portfolio</a>
      </v-col>
    </v-row>
  </v-footer>
</template>

<style lang="scss" scoped>
.v-footer {
  position: unset;
}
footer {
  a {
    &:hover {
      color: rgb(var(--v-theme-primary)) !important;
    }
  }
}
</style>
