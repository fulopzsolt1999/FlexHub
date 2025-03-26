<template>
  <footer class="bg-dark text-white text-center py-1">
    <div>
      &copy; {{ currentYear }} - Fülöp Zsolt
    </div>
  </footer>
</template>

<script setup lang="ts">
const currentYear = new Date().getFullYear();
</script>