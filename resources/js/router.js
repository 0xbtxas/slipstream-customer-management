import { createRouter, createWebHistory } from "vue-router";
import Home from "./components/home/Home.vue"; // or lazy load if needed
import Customers from "./components/customers/Customers.vue"; // or lazy load if needed

const routes = [
    { path: "/", component: Home },
    { path: "/customers", component: Customers },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
