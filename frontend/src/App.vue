<script setup lang="ts">
import { RouterView, RouterLink } from 'vue-router';
</script>

<template>
  <nav>
    <router-link to="/">Főoldal</router-link>
    <router-link to="/gym-search">Edzőterem kereső</router-link>
  </nav>
  <router-view></router-view>
</template>