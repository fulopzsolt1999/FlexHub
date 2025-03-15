<script setup lang="ts">
import { RouterView } from 'vue-router';
import BSNavbar from "@/components/BSNavbar.vue";
</script>

<template>
  <div id="wrapper">
    <BSNavbar />
  </div>
  <router-view></router-view>
</template>