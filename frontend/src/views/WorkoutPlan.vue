<template>
  <div class="container mt-5">
    <h1 class="mb-4">Edzésterv</h1>
    <div v-if="loading" class="text-center">Betöltés...</div>
    <div v-else>
      <div
        class="row"
        v-for="day in days"
        :key="day.id"
      >
        <div class="col-12 mb-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{ day.name }}</h5>
              <div class="d-flex align-items-center mb-3">
                <div class="form-check form-switch me-3">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    :id="'restDaySwitch-' + day.id"
                    :checked="restDays.includes(day.id)"
                    @change="toggleRestDay(day.id, ($event.target as HTMLInputElement)?.checked)"
                  />
                  <label class="form-check-label" :for="'restDaySwitch-' + day.id">Pihenőnap</label>
                </div>
              </div>
              <div v-if="!restDays[day.id]">
                <button class="btn btn-primary ms-auto">
                  Gyakorlatok módosítása/hozzáadása
                </button>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Gyakorlat neve</th>
                      <th>Szettek</th>
                      <th>Ismétlések</th>
                      <th>Megjegyzés</th>
                      <th>Kép</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td colspan="5" class="text-center">Nincs megadott gyakorlat</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import api from '../services/api';

interface Day {
  id: number;
  name: string;
}

const days = ref<Day[]>([]);
const restDays = ref<number[]>([]);
const loading = ref(true);
const userId = sessionStorage.getItem('userId');

const fetchDays = async () => {
  try {
    const response = await api.getDays();
    days.value = response.data;
  } catch (error) {
    console.error('Hiba történt a napok betöltésekor:', error);
  } finally {
    loading.value = false;
  }
};

const fetchRestDays = async () => {
  try {
    if (!userId) {
      throw new Error('A felhasználói azonosító nem érhető el a munkamenet tárolójában.');
    }
    const response = await api.getRestDays(userId);
    const restDayList = Array.isArray(response.data) ? response.data : [];
    restDays.value = restDayList.map((restDay: { day_id: number }) => restDay.day_id);
  } catch (error) {
    console.error('Hiba történt a pihenőnapok betöltésekor:', error);
  }
};

const toggleRestDay = async (dayId: number, isRestDay: boolean) => {
  try {    
    if (!userId) {
      throw new Error('A felhasználói azonosító nem érhető el a munkamenet tárolójában.');
    }
    
    if (isRestDay) {
      restDays.value.push(dayId);
      await api.createRestDay(userId, dayId.toString());
    } else {
      restDays.value = restDays.value.filter(id => id !== dayId);
      await api.deleteRestDay(userId, dayId.toString());
    }
  } catch (error) {
    console.error('Hiba történt a pihenőnap állapotának frissítésekor:', error);
  }
};

onMounted(async () => {
  await fetchDays();
  await fetchRestDays();
});
</script>