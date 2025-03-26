<template>
  <div class="container mt-5 p-4 w-50">
    <h1>Regisztráció</h1>
    <hr>
    <p v-if="message" class="alert alert-danger mt-3">{{ message }}</p>
    <form @submit.prevent="handleRegister" class="needs-validation mx-5" novalidate>
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
        <label for="email" class="form-label">Email:</label>
        <input
          type="email"
          id="email"
          v-model="email"
          class="form-control"
          :class="{ 'is-invalid': errors.email }"
          autocomplete="off"
          required
        />
        <div class="invalid-feedback">{{ errors.email }}</div>
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
      <div class="mb-3">
        <label for="passwordAgain" class="form-label">Jelszó megerősítése:</label>
        <input
          type="password"
          id="passwordAgain"
          v-model="passwordAgain"
          class="form-control"
          :class="{ 'is-invalid': errors.passwordAgain }"
          autocomplete="off"
          required
        />
        <div class="invalid-feedback">{{ errors.passwordAgain }}</div>
      </div>
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn w-50 mt-2">Regisztráció</button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import api from '../services/api';

const userName = ref('');
const email = ref('');
const password = ref('');
const passwordAgain = ref('');
const message = ref('');
const errors = ref({
  userName: '',
  email: '',
  password: '',
  passwordAgain: '',
});

const handleRegister = async () => {
  // Reset errors
  errors.value = {
    userName: '',
    email: '',
    password: '',
    passwordAgain: '',
  };

  let hasError = false;

  if (password.value !== passwordAgain.value) {
    errors.value.passwordAgain = 'A jelszavak nem egyeznek.';
    hasError = true;
  }

  if (password.value.length < 8) {
    errors.value.password = 'A jelszónak legalább 8 karakter hosszúnak kell lennie.';
    hasError = true;
  }

  if (!/^[a-zA-Z0-9]+$/.test(userName.value)) {
    errors.value.userName = 'A felhasználónév csak betűket és számokat tartalmazhat.';
    hasError = true;
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
    errors.value.email = 'Érvényes email címet kell megadni.';
    hasError = true;
  }

  if (hasError) {
    return;
  }

  try {
    const response = await api.register({
      user_name: userName.value,
      email: email.value,
      password: password.value,
    });
    alert(response.data.message);
    window.location.href = '/login';
  } catch (error) {
    message.value = 'Hiba történt a regisztráció során.';
    console.error(error);
  }
};
</script>