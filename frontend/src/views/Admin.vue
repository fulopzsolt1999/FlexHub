<template>
  <div class="container my-5 p-4">
    <h1>Admin Felület</h1>
    <hr>
    <div class="row">
      <div class="col-md-4">
        <h3>Regisztrált felhasználók</h3>
        <p class="display-4">{{ totalUsers }}</p>
      </div>
      <div class="col-md-4">
        <h3>Edzéstervet készítők</h3>
        <p class="display-4">{{ usersWithWorkoutPlans }}</p>
      </div>
      <div class="col-md-4">
        <h3>Edzéstervet készítők aránya</h3>
        <p class="display-4">{{ percentageWithWorkoutPlans.toFixed(1) }}%</p>
      </div>
    </div>
    <div class="mt-5">
      <h3>{{ currentYear }}-ös regisztrációk és edzéstervek</h3>
      <hr>
      <canvas id="monthlyRegistrationsChart"></canvas>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import Chart from 'chart.js/auto';
import api from '../services/api';

const totalUsers = ref(0);
const usersWithWorkoutPlans = ref(0);
const percentageWithWorkoutPlans = ref(0);
const monthlyStats = ref<{ month: string; total_users: number; users_with_workout_plans: number }[]>([]);

const monthNames = [
  'Január', 'Február', 'Március', 'Április', 'Május', 'Június',
  'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December',
];

const currentYear = new Date().getFullYear();

const fetchAdminData = async () => {
  const usersResponse = await api.getTotalUsers();
  totalUsers.value = usersResponse.data.total_users;

  const workoutPlanStatsResponse = await api.getWorkoutPlanStats();
  usersWithWorkoutPlans.value = workoutPlanStatsResponse.data.users_with_workout_plans;
  percentageWithWorkoutPlans.value = workoutPlanStatsResponse.data.percentage_with_workout_plans;

  const monthlyStatsResponse = await api.getMonthlyStats();
  const monthlyUsers = monthlyStatsResponse.data.monthly_users;
  const monthlyWorkoutPlans = monthlyStatsResponse.data.monthly_workout_plans;

  monthlyStats.value = monthNames.map((_, index) => {
    const month = `${currentYear}-${String(index + 1).padStart(2, '0')}`;
    const userStat = monthlyUsers.find((user) => user.month === month) || { total_users: 0 };
    const workoutPlanStat = monthlyWorkoutPlans.find((plan) => plan.month === month) || { users_with_workout_plans: 0 };

    return {
      month,
      total_users: userStat.total_users || 0,
      users_with_workout_plans: workoutPlanStat.users_with_workout_plans || 0,
    };
  });

  renderChart();
};

const renderChart = () => {
  const ctx = document.getElementById('monthlyRegistrationsChart') as HTMLCanvasElement;
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: monthNames,
      datasets: [
        {
          label: 'Regisztrált felhasználók',
          data: monthlyStats.value.map((item) => item.total_users),
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
        },
        {
          label: 'Edzéstervet készítők',
          data: monthlyStats.value.map((item) => item.users_with_workout_plans),
          backgroundColor: 'rgba(153, 102, 255, 0.2)',
          borderColor: 'rgba(153, 102, 255, 1)',
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          ticks: {
            stepSize: 1,
          },
        },
      },
      plugins: {
        legend: {
          position: 'top',
        },
      },
    },
  });
};

onMounted(fetchAdminData);
</script>