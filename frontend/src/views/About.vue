<template>
  <div class="container p-3 d-flex justify-content-center align-items-center flex-column">
    <div class="about-me mt-5">
      <h2>Rólam</h2>
      <hr />
      <div class="d-flex justify-content-center align-items-center flex-row row gap-3">
        <img class="col-md-6 col-12" src="../assets/images/Zsolt.jpg" alt="Junior Frontend Fejlesztő" />
        <div class="col-md-6 col-12">
          <p>
            2023-ban kezdtem meg tanulmányaimat a Ruander Oktatási Központ, Junior Frontend Fejlesztő tanfolyamon.
            Miután ezt elvégeztem kezdhettem a Webfejlesztés tanfolyamot, amire készítettem ezt a vizsgaremeket.
          </p>
        </div>
      </div>
    </div>
    <div class="about-project mt-5">
      <h2>A projektemről</h2>
      <hr />
      <div class="d-flex justify-content-center align-items-center flex-row">
        <p>
          Ez a projekt egy interaktív weboldal létrehozását tűzte ki célul, amely megkönnyíti a felhasználók számára
          az edzőtermek keresését és saját edzésterveik létrehozását. A felhasználók különböző szűrési lehetőségekkel
          böngészhetnek az adatbázisban található edzőtermek között, majd bejelentkezés után személyre szabott
          edzésterveket hozhatnak létre. A regisztráció és a bejelentkezés folyamata egyszerű és biztonságos, így a
          felhasználók könnyen hozzáférhetnek a weboldal nyújtotta összes funkcióhoz. A projekt célja egy átlátható
          és felhasználóbarát rendszer kialakítása, amely segíti a sportolni vágyókat céljaik elérésében.
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .container {
    width: 80%;
  }
  .about-me,
  .about-project {
    width: 80%;
  }
  img {
    max-width: 12rem;
    border-radius: 50%;
  }
  p {
    max-width: 40rem;
    text-indent: 1rem;
  }
</style>