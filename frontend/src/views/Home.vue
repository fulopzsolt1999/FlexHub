<template>
  <div class="container w-75 my-5 p-4">
    <div class="welcome m-auto p-3 d-flex justify-content-center align-items-center text-center">
      <h1 class="w-75">Üdvözlöm a FlexHub-on! </h1>
      <hr>
    </div>
  </div>
</template>

<style scoped>
  .welcome {
    height: 10rem;
    background-color: var(--primary-bg);
    border-radius: 1rem;
  }
  h1 {
    border-bottom: 3px solid var(--highlight);
  }
  .container {
    background-color: unset;
    height: 25rem;
  }
  @media (max-width: 900px) {
    .welcome {
      height: 7rem;
    }
  }
  @media (max-width: 500px) {
    h1 {
      font-size: 1.5rem;
    }
  }
</style>