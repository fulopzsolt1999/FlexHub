<template>
  <div class="container">
    <h1>Regisztráció</h1>
    <form @submit.prevent="handleRegister">
      <div>
        <label for="name">Felhasználónév:</label>
        <input type="text" id="name" v-model="userName" required />
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required />
      </div>
      <div>
        <label for="password">Jelszó:</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <button type="submit">Regisztráció</button>
    </form>
    <p v-if="message">{{ message }}</p>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import api from '../services/api';

const userName = ref('');
const email = ref('');
const password = ref('');
const message = ref('');

const handleRegister = async () => {
  try {
    const response = await api.register({ user_name: userName.value, email: email.value, password: password.value });
    message.value = response.data.message;
  } catch (error) {
    message.value = 'Hiba történt a regisztráció során.';
    console.error(error);
  }
};
</script>