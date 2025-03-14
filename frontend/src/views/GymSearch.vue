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

interface Address {
  id: string;
  city_id: string;
  street: string;
  street_number: string;
}

interface City {
  id: string;
  name: string;
}

const gyms = ref<Gym[]>([]);
const addresses = ref<Record<string, Address>>({});
const cities = ref<Record<string, City>>({});

onMounted(async () => {
  try {
    const gymResponse = await api.getGyms();
    gyms.value = gymResponse.data;
    for (const gym of gyms.value) {
      if (!addresses.value[gym.address_id]) {
        const addressResponse = await api.getAddressById(gym.address_id);
        addresses.value[gym.address_id] = addressResponse.data;

        if (!cities.value[addresses.value[gym.address_id].city_id]) {
          const cityResponse = await api.getCityById(addresses.value[gym.address_id].city_id);
          cities.value[addresses.value[gym.address_id].city_id] = cityResponse.data;
        }
      }
    }
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
         <p v-if="addresses[gym.address_id] && cities[addresses[gym.address_id].city_id]">
           <strong>Cím:</strong>
           {{ cities[addresses[gym.address_id].city_id].name }},
           {{ addresses[gym.address_id].street }}
           {{ addresses[gym.address_id].street_number }}
         </p>
         <p><strong>URL:</strong> <a :href="gym.url" target="_blank">{{ gym.url }}</a></p>
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