<template>
  <div class="container mt-5 p-4 w-50">
    <h1>Új jelszó megadása</h1>
    <hr>
    <p v-if="message" class="alert alert-info mt-3">{{ message }}</p>
    <form @submit.prevent="handleResetPassword" class="needs-validation mx-5">
      <div class="mb-3">
        <label for="password" class="form-label">Új jelszó:</label>
        <input
          type="password"
          id="password"
          v-model="password"
          class="form-control"
          required
        />
      </div>
      <div class="mb-3">
        <label for="passwordConfirmation" class="form-label">Új jelszó megerősítése:</label>
        <input
          type="password"
          id="passwordConfirmation"
          v-model="passwordConfirmation"
          class="form-control"
          required
        />
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn w-50 mt-2">Jelszó megváltoztatás</button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../services/api';

const route = useRoute();
const router = useRouter();
const password = ref('');
const passwordConfirmation = ref('');
const message = ref('');

const handleResetPassword = async () => {
  try {
    const response = await api.resetPassword({
      token: typeof route.query.token === 'string' ? route.query.token : '',
      password: password.value,
      password_confirmation: passwordConfirmation.value,
    });
    message.value = response.data.message;
    alert('Sikeres jelszóváltoztatás!');
    router.push('/login');
  } catch (error) {
    message.value = 'Hiba történt a jelszó megváltoztatása során.';
    console.error(error);
  }
};
</script>