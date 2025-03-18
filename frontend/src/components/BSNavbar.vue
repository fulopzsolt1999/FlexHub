<template>
  <nav class="navbar navbar-expand-md bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Logo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link to="/" class="nav-link">Főoldal</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/gym-search" class="nav-link">Edzőterem kereső</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/about" class="nav-link">Rólam</router-link>
          </li>
          <li class="nav-item" v-if="!isLoggedIn">
            <router-link class="nav-link" to="/register">Regisztráció</router-link>
          </li>
          <li class="nav-item" v-if="!isLoggedIn">
            <router-link class="nav-link" to="/login">Bejelentkezés</router-link>
          </li>
          <li class="nav-item" v-if="isLoggedIn">
            <router-link class="nav-link" to="/workout-plan">Edzésterv készítő</router-link>
          </li>
          <li class="nav-item" v-if="superUser">
            <router-link class="nav-link" to="/admin">Admin felület</router-link>
          </li>
          <li class="nav-item" v-if="isLoggedIn">
            <router-link class="nav-link" to="/" @click="logout">Kijelentkezés</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const isLoggedIn = ref(false);
const router = useRouter();
const superUser = ref(false);

const checkLoginStatus = () => {
  const userId = sessionStorage.getItem('userId');
  if (userId === import.meta.env.VITE_ADMIN_USER_ID) {
    superUser.value = true;
  }
  isLoggedIn.value = !!userId;
};

const logout = () => {
  sessionStorage.removeItem('userId');
  isLoggedIn.value = false;
  superUser.value = false;
  router.push('/');
};

onMounted(() => {
  checkLoginStatus();
});
</script>

