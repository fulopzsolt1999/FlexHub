<template>
  <div class="container mt-5 p-4 w-50">
    <h1>Elfelejtett jelszó</h1>
    <hr>
    <p v-if="message" class="alert alert-info mt-3">{{ message }}</p>
    <form @submit.prevent="handleForgotPassword" class="needs-validation mx-5">
      <div class="mb-3">
        <label for="email" class="form-label">E-mail cím:</label>
        <input
          type="email"
          id="email"
          v-model="email"
          class="form-control"
          required
        />
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn w-50 mt-2">Jelszó visszaállítás</button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import api from '../services/api';

const email = ref('');
const message = ref('');

const handleForgotPassword = async () => {
  try {
    const response = await api.forgotPassword({ email: email.value });
    message.value = response.data.message;
  } catch (error) {
    message.value = 'Hiba történt a jelszó visszaállítási link küldése során.';
    console.error(error);
  }
};
</script>