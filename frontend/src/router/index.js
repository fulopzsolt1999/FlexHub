import {createRouter, createWebHistory} from "vue-router";
import HomeView from "../views/Home.vue";
import GymSearchView from "../views/GymSearch.vue";
import AboutView from "../views/About.vue";
import RegisterView from '../views/Register.vue';
import LoginView from '../views/Login.vue';
import WorkoutPlanView from '../views/WorkoutPlan.vue';
import AdminView from '../views/Admin.vue';
import ModifyWorkoutPlanView from '../views/ModifyWorkoutPlan.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "Home",
            component: HomeView
        },
        {
            path: "/admin",
            name: "Admin",
            component: AdminView
        },
        {
            path: '/register',
            name: 'Register',
            component: RegisterView,
        },
        {
            path: '/login',
            name: 'Login',
            component: LoginView,
        },
        {
            path: "/gym-search",
            name: "GymSearch",
            component: GymSearchView
        },
        {
            path: "/about",
            name: "About",
            component: AboutView
        },
        {
            path: "/workout-plan",
            name: "WorkoutPlan",
            component: WorkoutPlanView
        },
        {
            path: '/modify-workout-plan/:dayName/:dayId',
            name: 'ModifyWorkoutPlan',
            component: ModifyWorkoutPlanView,
            props: true
        },
    ]
})

export default router;