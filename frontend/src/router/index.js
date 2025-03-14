import {createRouter, createWebHistory} from "vue-router";
import HomeView from "../views/Home.vue";
import GymSearchView from "../views/GymSearch.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
        path: "/",
        name: "Home",
        component: HomeView
        },
        {
            path: "/gym-search",
            name: "GymSearch",
            component: GymSearchView
        }
    ]
})

export default router;