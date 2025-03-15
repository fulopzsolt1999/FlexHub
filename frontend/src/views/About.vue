<template>
  <div class="about-page">
    <!-- Rólam rész -->
    <div class="container about-me">
      <h2>Rólam</h2>
      <hr />
      <div class="content">
        <img src="" alt="Junior Frontend Fejlesztő" />
        <div class="text">
          <p>
            Kisebb szöveg rólam. Lorem ipsum dolor sit amet, consectetur
            adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante
            dapibus diam.
          </p>
        </div>
      </div>
    </div>

    <!-- A projektről rész -->
    <div class="container about-project">
      <h2>A projektről</h2>
      <hr />
      <p>
        Kevés szöveg a projektről. Lorem ipsum dolor sit amet, consectetur
        adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante
        dapibus diam.
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
// Import statements if needed
</script>

<style scoped>
.about-page {
  padding: 20px;
}

.container {
  margin-bottom: 40px;
}

.about-me .content {
  display: flex;
  align-items: center;
}

.about-me img {
  max-width: 150px;
  margin-right: 20px;
  border-radius: 50%;
}

.about-me .text {
  max-width: 600px;
}

.about-me h2,
.about-project h2 {
  font-size: 24px;
  margin-bottom: 10px;
}

hr {
  border: none;
  border-top: 2px solid #333;
  margin-bottom: 20px;
}

.about-project p {
  max-width: 600px;
}
</style>