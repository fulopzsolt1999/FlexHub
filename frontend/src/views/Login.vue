<template>
  <div class="container mt-5 p-4 w-50">
    <h1>Bejelentkezés</h1>
    <hr>
    <p v-if="message" class="alert alert-danger mt-3">{{ message }}</p>
    <form @submit.prevent="handleLogin" class="needs-validation mx-5" novalidate>
      <div class="mb-3">
        <label for="userName" class="form-label">Felhasználónév:</label>
        <input
          type="text"
          id="userName"
          v-model="userName"
          class="form-control"
          :class="{ 'is-invalid': errors.userName }"
          autocomplete="off"
          required
        />
        <div class="invalid-feedback">{{ errors.userName }}</div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Jelszó:</label>
        <input
          type="password"
          id="password"
          v-model="password"
          class="form-control"
          :class="{ 'is-invalid': errors.password }"
          autocomplete="off"
          required
        />
        <div class="invalid-feedback">{{ errors.password }}</div>
      </div>
      <div class="d-flex justify-content-center my-4">
        <button type="submit" class="btn w-50 mt-2">Bejelentkezés</button>
      </div>
      <div class="d-flex justify-content-center">
        <a href="/forgot-password">Elfelejtett jelszó?</a>
      </div>
    </form>

  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import api from '../services/api';

const userName = ref('');
const password = ref('');
const message = ref('');
const errors = ref({
  userName: '',
  password: '',
});

const handleLogin = async () => {
  // Reset errors
  errors.value = {
    userName: '',
    password: '',
  };

  let hasError = false;

  if (!userName.value) {
    errors.value.userName = 'A felhasználónév megadása kötelező.';
    hasError = true;
  }

  if (!password.value) {
    errors.value.password = 'A jelszó megadása kötelező.';
    hasError = true;
  }

  if (hasError) {
    return;
  }

  try {
    const response = await api.login({ user_name: userName.value, password: password.value });
    const userId = response.data?.user?.id;
    if (userId) {
      sessionStorage.setItem('userId', userId);
      sessionStorage.setItem('isAdmin', response.data?.user?.is_admin ? 'true' : 'false');
      alert('Sikeres bejelentkezés!');
      window.location.href = '/';
    }
  } catch (error) {
    message.value = 'Hiba történt a bejelentkezés során.';
    console.error(error);
  }
};
</script>