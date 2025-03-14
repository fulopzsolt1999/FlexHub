<script setup lang="ts">
import { ref, onMounted } from 'vue';
import api from '../services/api.ts';

interface Gym {
  id: string;
  name: string;
  address_id: string;
  url: string;
  price_group: string;
}

const gyms = ref<Gym[]>([]);

onMounted(async () => {
  try {
    const response = await api.getGyms();
    gyms.value = response.data;
  } catch (error) {
    console.error('Error fetching gyms:', error);
  }
});
</script>

<template>
   <header>
     <h1>Edzőterem kereső</h1>
   </header>

   <main>
     <nav>
       <router-link to="/">Főoldal</router-link>
       <router-link to="/gym-search">Edzőterem kereső</router-link>
     </nav>
     <div class="gym-cards">
       <div class="gym-card" v-for="gym in gyms" :key="gym.id">
         <h2>{{ gym.name }}</h2>
         <hr>
         <p><strong>Cím:</strong> {{ gym.address_id }}</p>
         <p><strong>URL:</strong> <a :href="gym.url" target="_blank">Weboldal/Facebook oldal</a></p>
         <p><strong>Árkategória:</strong> {{ gym.price_group }}</p>
       </div>
     </div>
   </main>
 </template>

<style scoped>
.gym-cards {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  justify-content: center;
  padding: 16px;
}

.gym-card {
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 16px;
  width: 300px;
  text-align: center;
}

.gym-card h2 {
  margin-top: 0;
}

.gym-card hr {
  margin: 16px 0;
}

.gym-card p {
  margin: 8px 0;
}
</style>