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
              <div v-if="!restDays.includes(day.id)">
                <button
                  class="btn btn-primary ms-auto"
                  type="button"
                  @click="goToModifyWorkoutPlan(day.name)"
                >
                  Gyakorlatok módosítása/hozzáadása
                </button>
                <table class="table table-bordered mt-3">
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
                    <tr v-for="exercise in exercisesByDay[day.id] || []" :key="exercise.id">
                      <td>{{ exercise.exercise_name }}</td>
                      <td>{{ exercise.sets }}</td>
                      <td>{{ exercise.reps }}</td>
                      <td>{{ exercise.comment || 'Nincs megjegyzés' }}</td>
                      <td>
                        <img :src="exercise.image" alt="Gyakorlat képe" class="img-thumbnail" style="max-width: 100px;" />
                      </td>
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
import { useRouter } from 'vue-router';
import api from '../services/api';

interface Day {
  id: number;
  name: string;
}

interface Workout {
  id: number;
  user_id: number;
  day_id: number;
  muscle_group_id: number;
  exercise_id: string;
  sets: number;
  reps: number;
  comment: string;
  exercise_name: string;
  image: string;
}

const days = ref<Day[]>([]);
const restDays = ref<number[]>([]);
const exercisesByDay = ref<{ [key: number]: Workout[] }>({});
const loading = ref(true);
const userId = sessionStorage.getItem('userId');
const router = useRouter();

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

const fetchExercisesForDay = async (dayId: number) => {
  try {
    if (!userId) {
      throw new Error('A felhasználói azonosító nem érhető el a munkamenet tárolójában.');
    }
    const response = await api.getWorkoutPlan(userId, dayId);    
    if (Array.isArray(response.data)) {
      exercisesByDay.value[dayId] = response.data.map((exercise: any) => ({
        id: exercise.id,
        user_id: exercise.user_id,
        day_id: exercise.day_id,
        muscle_group_id: exercise.muscle_group_id,
        exercise_id: exercise.exercise_id,
        sets: exercise.series,
        reps: exercise.reps,
        comment: exercise.comment,
        exercise_name: exercise.name,
        image: exercise.image,
      }));
    } else {
      console.error('Unexpected response format for exercises:', response.data);
      exercisesByDay.value[dayId] = [];
    }    
  } catch (error) {
    console.error(`Hiba történt a gyakorlatok betöltésekor a(z) ${dayId} naphoz:`, error);
  }
};

const fetchAllExercises = async () => {
  for (const day of days.value) {
    await fetchExercisesForDay(day.id);
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

const goToModifyWorkoutPlan = (dayName: string) => {
  const day = days.value.find(d => d.name === dayName);
  if (day) {
    router.push({ name: 'ModifyWorkoutPlan', params: { dayName, dayId: day.id } });
  } else {
    console.error('Nem található a nap az adott névvel:', dayName);
  }
};

onMounted(async () => {
  await fetchDays();
  await fetchRestDays();
  await fetchAllExercises();
});
</script>