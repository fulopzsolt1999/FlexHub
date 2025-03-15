<template>
  <div class="container">
    <h1>Bejelentkezés</h1>
    <form @submit.prevent="handleLogin">
      <div>
        <label for="userName">Felhasználónév:</label>
        <input type="text" id="userName" v-model="userName" required />
      </div>
      <div>
        <label for="password">Jelszó:</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <button type="submit">Bejelentkezés</button>
    </form>
    <p v-if="message">{{ message }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import api from '../services/api';

const userName = ref('');
const password = ref('');
const message = ref('');

const handleLogin = async () => {
  try {
    const response = await api.login({ user_name: userName.value, password: password.value });
    message.value = response.data.message;
  } catch (error) {
    message.value = 'Hiba történt a bejelentkezés során.';
    console.error(error);
  }
};
</script>