<!-- filepath: d:\FlexHub\frontend\src\views\ForgotPassword.vue -->
<template>
  <div class="container mt-5">
    <h1 class="mb-4">Elfelejtett jelszó</h1>
    <form @submit.prevent="handleForgotPassword">
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
      <button type="submit" class="btn btn-primary">Jelszó visszaállítás</button>
    </form>
    <p v-if="message" class="alert alert-info mt-3">{{ message }}</p>
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