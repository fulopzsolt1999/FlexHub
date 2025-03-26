<script setup lang="ts">
import { RouterView } from 'vue-router';
import BSNavbar from "@/components/BSNavbar.vue";
import BSFooter from './components/BSFooter.vue';
</script>

<template>
  <div id="wrapper">
    <BSNavbar />
    <div class="d-flex justify-content-center align-items-center flex-grow-1" id="content">
      <router-view />
    </div>
    <BSFooter />
  </div>
</template>