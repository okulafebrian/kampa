<template>
    <Head title="Pengaturan" />

    <AuthenticatedLayout>
        <template #header>
            <div class="font-semibold text-2xl">Pengaturan</div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <SelectButton
                v-model="selectedOption"
                :options="menus"
                optionLabel="name"
            />

            <div class="border rounded-2xl bg-white p-8 space-y-4">
                <div v-for="role in roles">
                    <div class="text-lg font-medium">{{ role.name }}</div>
                    <div class="text-gray-600">{{ role.description }}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import SelectButton from "primevue/selectbutton";
import { ref, watch } from "vue";

const props = defineProps(["roles"]);

const menus = ref([
    {
        name: "Umum",
        route: "settings.general",
    },
    {
        name: "Peran",
        route: "settings.role",
    },
]);

const selectedOption = ref(menus.value[1]);

watch(
    () => selectedOption.value,
    (newValue) => {
        router.get(route(newValue.route));
    }
);
</script>
