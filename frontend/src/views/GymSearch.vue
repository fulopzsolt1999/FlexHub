<template>
  <div class="container my-5">
    <h1 class="m-auto my-3">Edzőterem kereső</h1>
    <div class="search-sort form-group mt-4 m-auto">
      <input
          type="text"
          class="form-control mb-3"
          v-model="searchQuery"
          placeholder="Keresés név vagy város alapján..."
          autocomplete="off">
      <select v-model="sortOrder" class="form-control">
        <option value="">Rendezés ár szerint</option>
        <option value="asc">Ár (növekvő)</option>
        <option value="desc">Ár (csökkenő)</option>
      </select>
    </div>
    <div class="gym-cards mt-5 d-flex justify-content-center flex-wrap gap-3">
     <div class="gym-card p-3" v-for="gym in filteredAndSortedGyms" :key="gym.id">
       <h3 class="text-center">{{ gym.name }}</h3>
       <hr>
       <p v-if="addresses[gym.address_id] && cities[addresses[gym.address_id].city_id]">
         <strong>Cím:</strong>
         {{ cities[addresses[gym.address_id].city_id].name }},
         {{ addresses[gym.address_id].street }}
         {{ addresses[gym.address_id].street_number }}
       </p>
       <p><strong>Árkategória:</strong> {{ gym.price_group }}</p>
       <p class="mt-4" id="info">Bővebb információért<br><a :href="gym.url" target="_blank">Kattints ide</a></p>
     </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue';
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
const searchQuery = ref('');
const sortOrder = ref('');

// Fetch gyms, addresses, and cities
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


// Computed property to filter and sort gyms
const filteredAndSortedGyms = computed(() => {
  let filteredGyms = gyms.value.filter(gym => {
    const address = addresses.value[gym.address_id];
    const city = address && cities.value[address.city_id];
    const matchesSearch = gym.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        (city && city.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
    return matchesSearch;
  });

  if (sortOrder.value === 'asc') {
    filteredGyms.sort((a, b) => a.price_group.length - b.price_group.length);
  } else if (sortOrder.value === 'desc') {
    filteredGyms.sort((a, b) => b.price_group.length - a.price_group.length);
  }

  return filteredGyms;
});
</script>

<style scoped>
  .container {
    background-color: unset;
  }
  .search-sort {
    width: 25rem;
  }
  h1 {
    width: fit-content;
    background-color: rgba(0, 0, 0, 0.3);
    color: var(--primary-text);
    border-radius: 20%;
  }
  .gym-card {
    width: 25rem;
    background-color: var(--primary-bg);
    color: var(--primary-text);
    border: 1px solid var(--highlight);
    border-radius: 15px;
  }
  p {
    margin: 0.5rem 0;
    text-align: center;
  }
  #info {
    color: var(--secondary-text);
  }
</style>