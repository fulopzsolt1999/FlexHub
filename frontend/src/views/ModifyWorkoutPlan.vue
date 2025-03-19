<template>
  <div class="container mt-5">
    <div class="row">
      <!-- Bal oszlop -->
      <div class="col-md-6">
        <h3>Gyakorlat hozzáadása</h3>
        <button class="btn btn-secondary mb-3" @click="goBack">Vissza az edzéstervekre</button>
        <div class="mb-3">
          <div class="alert alert-info text-center h4"><strong>{{ dayName }}</strong></div>
        </div>
        <form @submit.prevent="addExercise">
          <div class="mb-3">
            <label for="muscleGroup" class="form-label">Izomcsoport</label>
            <select
              id="muscleGroup"
              class="form-select"
              v-model="selectedMuscleGroup"
              @change="fetchExercises"
              required
            >
              <option value="" disabled>Válassz izomcsoportot</option>
              <option v-for="group in muscleGroups" :key="group.id" :value="group.id">
                {{ group.name }}
              </option>
            </select>
          </div>
          <div class="mb-3" v-if="selectedMuscleGroup">
            <label for="exercise" class="form-label">Gyakorlat</label>
            <select id="exercise" class="form-select" v-model="selectedExercise" required>
              <option value="" disabled>Válassz gyakorlatot</option>
              <option
                v-for="exercise in filteredExercises"
                :key="exercise.id"
                :value="exercise.id"
              >
                {{ exercise.name }}
              </option>
            </select>
          </div>
          <div class="mb-3">
            <label for="sets" class="form-label">Szettek</label>
            <input type="number" id="sets" class="form-control" v-model="sets" required />
          </div>
          <div class="mb-3">
            <label for="reps" class="form-label">Ismétlések</label>
            <input type="number" id="reps" class="form-control" v-model="reps" required />
          </div>
          <div class="mb-3">
            <label for="comment" class="form-label">Megjegyzés</label>
            <textarea id="comment" class="form-control" v-model="comment"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Hozzáadás</button>
        </form>

        <!-- Gyakorlat kép és videó link -->
        <div v-if="selectedExerciseDetails" class="mt-4 text-center">
          <a :href="selectedExerciseDetails.video" target="_blank">
            <img
              :src="`/src/assets/images/Exercises/${selectedExerciseDetails.image}`"
              alt="Gyakorlat képe"
              class="img-thumbnail"
              style="max-width: 300px; cursor: pointer;"
              @click="navigateToVideo"
            />
          </a>
        </div>
      </div>

      <!-- Jobb oszlop -->
      <div class="col-md-6">
        <h3>{{ dayName }} naphoz tartozó gyakorlatok</h3>
        <div
          v-for="(exercise, index) in addedExercises"
          :key="index"
          class="card mb-3"
          draggable="true"
          @dragstart="dragStart(index)"
          @dragover.prevent
          @drop="drop(index)"
        >
          <div class="card-body">
            <h5 class="card-title">{{ exercise.exerciseName }}</h5>
            <p class="card-text">
              <strong>Izomcsoport:</strong> {{ exercise.muscleGroupName }}<br />
              <strong>Szettek:</strong> {{ exercise.sets }}<br />
              <strong>Ismétlések:</strong> {{ exercise.reps }}<br />
              <strong>Megjegyzés:</strong> {{ exercise.comment || 'Nincs' }}
            </p>
            <button class="btn btn-danger" @click="removeExercise(index)">Törlés</button>
          </div>
        </div>
        <button class="btn btn-success mt-3" @click="saveExercises">Módosítás mentése</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../services/api';

const route = useRoute();
const router = useRouter();
const dayName = route.params.dayName as string;
const dayId = Number(route.params.dayId);

const muscleGroups = ref<Array<{ id: string; name: string }>>([]);
const exercises = ref<Array<{ id: string; name: string; image: string; video: string }>>([]);
const addedExercises = ref<Array<{
   userId: string;
   dayId: number;
   muscleGroupId: string;
   muscleGroupName?: string;
   exerciseId: string;
   exerciseName?: string;
   sets: number;
   reps: number;
   comment: string;
}>>([]);

const selectedMuscleGroup = ref('');
const selectedExercise = ref('');
const sets = ref<number | null>(null);
const reps = ref<number | null>(null);
const comment = ref('');

const selectedExerciseDetails = computed(() => {
  return exercises.value.find(exercise => exercise.id === selectedExercise.value) || null;
});

// Szűrt gyakorlatok, amelyek még nincsenek hozzáadva
const filteredExercises = computed(() => {
  const addedExerciseIds = addedExercises.value.map(exercise => exercise.exerciseId);
  return exercises.value.filter(exercise => !addedExerciseIds.includes(exercise.id));
});

const fetchMuscleGroups = async () => {
  try {
    const response = await api.getMuscleGroups();
    muscleGroups.value = response.data;
  } catch (error) {
    console.error('Hiba történt az izomcsoportok betöltésekor:', error);
  }
};

const fetchExercises = async () => {
  try {
    const response = await api.getExercisesByMuscleGroup(selectedMuscleGroup.value);
    exercises.value = response.data;
  } catch (error) {
    console.error('Hiba történt a gyakorlatok betöltésekor:', error);
  }
};

const fetchAddedExercises = async () => {
  try {
    const userId = sessionStorage.getItem('userId');
    if (!userId) {
      throw new Error('User ID is missing from session storage.');
    }

    const response = await api.getWorkoutPlan(userId, dayId);
    if (Array.isArray(response.data)) {
      addedExercises.value = response.data.map((exercise: any) => ({
        userId,
        dayId,
        muscleGroupId: exercise.muscle_group_id,
        muscleGroupName: exercise.muscle_group_name,
        exerciseId: exercise.exercise_id,
        exerciseName: exercise.exercise_name,
        sets: exercise.series,
        reps: exercise.reps,
        comment: exercise.comment,
      }));
    }
  } catch (error) {
    console.error('Hiba történt a korábban hozzáadott gyakorlatok betöltésekor:', error);
  }
};

const addExercise = () => {
  if (!selectedMuscleGroup.value || !selectedExercise.value || !sets.value || !reps.value) {
    return;
  }

  const muscleGroupName = muscleGroups.value.find(group => group.id === selectedMuscleGroup.value)?.name;
  const exerciseName = exercises.value.find(exercise => exercise.id === selectedExercise.value)?.name;

  addedExercises.value.push({
    userId: sessionStorage.getItem('userId') || '',
    dayId,
    muscleGroupId: selectedMuscleGroup.value,
    muscleGroupName,
    exerciseId: selectedExercise.value,
    exerciseName,
    sets: sets.value,
    reps: reps.value,
    comment: comment.value || 'Nincs',
  });

  // Reset form
  selectedMuscleGroup.value = '';
  selectedExercise.value = '';
  sets.value = null;
  reps.value = null;
  comment.value = '';
};

const removeExercise = (index: number) => {
  addedExercises.value.splice(index, 1);
};

const dragStartIndex = ref<number | null>(null);

const dragStart = (index: number) => {
  dragStartIndex.value = index;
};

const drop = (index: number) => {
  if (dragStartIndex.value !== null) {
    const draggedItem = addedExercises.value.splice(dragStartIndex.value, 1)[0];
    addedExercises.value.splice(index, 0, draggedItem);
    dragStartIndex.value = null;
  }
};

const saveExercises = async () => {
  try {
    const userId = sessionStorage.getItem('userId');
    if (!userId) {
      throw new Error('User ID is missing from session storage.');
    }
    
    
    const exercisesToSave = addedExercises.value.map(exercise => ({
      user_id: userId,
      muscle_group_id: exercise.muscleGroupId,
      exercise_id: exercise.exerciseId,
      day_id: dayId,
      sets: exercise.sets,
      reps: exercise.reps,
      comment: exercise.comment || "Nincs",
    }));
    console.log(addedExercises.value, exercisesToSave);
    await api.deleteWorkoutPlan(userId, dayId);
    await api.saveWorkoutPlan(userId, dayId, exercisesToSave);
    alert('Módosítások mentve!');
    router.push('/workout-plan');
  } catch (error) {
    console.error('Hiba történt a gyakorlatok mentésekor:', error);
  }
};

const goBack = () => {
  router.push('/workout-plan');
};

const navigateToVideo = () => {
  if (selectedExerciseDetails.value?.video) {
    window.open(selectedExerciseDetails.value.video, '_blank');
  }
};

onMounted(async () => {
  await fetchMuscleGroups();
  await fetchAddedExercises();
});
</script>