<template>
    <nav class="sticky top-0 z-50 bg-white border-b">
        <div class="px-8 sm:px-16 mx-auto">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('dashboard')">
                            <ApplicationLogo
                                class="block h-10 w-auto fill-current text-gray-800"
                            />
                        </Link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <NavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dasbor
                        </NavLink>
                        <NavButton
                            :href="route('statistic')"
                            :active="route().current('statistic')"
                        >
                            Statistik
                        </NavButton>
                        <Menu ref="item" :model="items" :popup="true" />
                        <NavLink
                            v-if="
                                $page.props.auth.user.role.code === 'owner' ||
                                $page.props.auth.user.role.code === 'volunteer'
                            "
                            :href="route('contacts.index')"
                            :active="
                                $page.component === 'Contacts/Index' ||
                                $page.component === 'Houses/Index' ||
                                $page.component === 'Streets/Index' ||
                                $page.component === 'WalkLists/Index'
                            "
                        >
                            Data Pemilih
                        </NavLink>
                        <NavLink
                            v-if="$page.props.auth.user.role.code === 'owner'"
                            :href="route('users.index')"
                            :active="
                                $page.component === 'Users/Index' ||
                                $page.component === 'Groups/Index'
                            "
                        >
                            Anggota & Grup
                        </NavLink>
                        <NavLink
                            v-if="
                                $page.props.auth.user.role.code === 'owner' ||
                                $page.props.auth.user.role.code === 'witness'
                            "
                            :href="route('votes.index')"
                            :active="route().current('votes.index')"
                        >
                            Arsip Suara
                        </NavLink>
                        <NavLink
                            v-if="$page.props.auth.user.role.code === 'owner'"
                            :href="route('settings.general')"
                            :active="$page.url.startsWith('/settings')"
                        >
                            Pengaturan
                        </NavLink>
                    </div>
                </div>
                <button @click="toggleMenu" class="p-1">
                    <Avatar
                        :label="initials"
                        size="large"
                        shape="circle"
                        class="text-primary-500 font-medium"
                        style="background-color: rgb(253, 230, 230)"
                    />
                </button>
                <Menu ref="menu" :model="menus" :popup="true" />
            </div>
        </div>
    </nav>
</template>

<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { router, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import NavLink from "@/Components/NavLink.vue";
import Button from "primevue/button";
import Menu from "primevue/menu";
import Avatar from "primevue/avatar";
import NavButton from "../NavButton.vue";

const menu = ref();
const menus = ref([
    {
        label: "Profil",
        command: () => {
            router.get(route("profile.show"));
        },
    },
    {
        label: "Keluar",
        command: () => {
            router.post("logout");
        },
    },
]);

function toggleMenu() {
    menu.value.toggle(event);
}

const user = ref(usePage().props.auth.user);

const initials = computed(() => {
    return (
        user.value.first_name.charAt(0) + user.value.last_name.charAt(0)
    ).toUpperCase();
});
</script>

<style lang="scss" scoped></style>
