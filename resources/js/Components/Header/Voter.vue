<template>
    <div class="flex items-center justify-between">
        <button
            class="font-semibold text-2xl py-2 hover:text-gray-700"
            @click="toggleMenu"
        >
            {{ currentMenu }}
            <i class="pi pi-sort-down-fill text-base ms-2"></i>
        </button>
        <Menu ref="menu" :model="menus" :popup="true">
            <template #item="{ item }">
                <Link :href="route(item.route)" class="block px-3 py-2">
                    {{ item.label }}
                </Link>
            </template>
        </Menu>

        <slot />
    </div>
</template>

<script setup>
import { usePage } from "@inertiajs/vue3";
import Button from "primevue/button";
import Menu from "primevue/menu";
import SplitButton from "primevue/splitbutton";
import { computed, ref } from "vue";

const menu = ref();

const menus = [
    {
        label: "Kontak",
        route: "contacts.index",
    },
    {
        label: "Rumah",
        route: "houses.index",
    },
    {
        label: "Jalan",
        route: "streets.index",
    },
    {
        label: "Daftar",
        route: "walk-lists.index",
    },
];

const currentMenu = computed(() => {
    switch (usePage().component) {
        case "Contacts/Index":
            return "Kontak";
        case "Houses/Index":
            return "Rumah";
        case "Streets/Index":
            return "Jalan";
        case "WalkLists/Index":
            return "Daftar";
    }
});

function toggleMenu() {
    menu.value.toggle(event);
}
</script>

<style lang="scss" scoped></style>
