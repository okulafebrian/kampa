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

        <SplitButton
            v-if="$page.component === 'Users/Index'"
            label="Tambah"
            @click="create"
            :model="items"
        />
    </div>
</template>

<script setup>
import { router, usePage } from "@inertiajs/vue3";
import Button from "primevue/button";
import Menu from "primevue/menu";
import SplitButton from "primevue/splitbutton";
import { computed, ref } from "vue";

const menu = ref();

const menus = [
    {
        label: "Anggota",
        route: "users.index",
    },
    {
        label: "Grup",
        route: "groups.index",
    },
];

const currentMenu = computed(() => {
    switch (usePage().component) {
        case "Users/Index":
            return "Anggota";
        case "Groups/Index":
            return "Grup";
    }
});

const items = [
    {
        label: "Tambah Sekaligus",
        command: () => {},
    },
];

function toggleMenu() {
    menu.value.toggle(event);
}

function create() {
    if (usePage().component === "Users/Index") {
        router.get(route("users.create"));
    }

    if (usePage().component === "Groups/Index") {
        router.get(route("groups.create"));
    }
}
</script>

<style lang="scss" scoped></style>
