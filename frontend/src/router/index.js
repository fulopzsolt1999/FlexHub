import {createRouter, createWebHistory} from "vue-router";
import HomeView from "../views/Home.vue";
import GymSearchView from "../views/GymSearch.vue";
import AboutView from "../views/About.vue";
import RegisterView from '../views/Register.vue';
import LoginView from '../views/Login.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "Home",
            component: HomeView
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
        }
    ]
})

export default router;