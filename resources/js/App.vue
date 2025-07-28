<template>
    <div class="flex min-h-screen">
        <aside class="p-4 border-r border-gray-100">
            <UNavigationMenu
                :items="items"
                orientation="vertical"
                color="secondary"
            ></UNavigationMenu>
        </aside>
        <main class="w-full container mx-auto p-4">
            <router-view />
        </main>
    </div>
</template>

<script setup>
const items = [
    { label: "Home", icon: "i-lucide-home", to: "/" },
    { label: "Customers", icon: "i-lucide-layout-dashboard", to: "/customers" },
];
</script>
