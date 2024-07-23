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
                <div class="grid grid-cols-3">
                    <div class="font-medium">Nama Organisasi</div>
                    <div class="text-gray-600">{{ organization.name }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-medium">Jenis Pemilihan</div>
                    <div class="text-gray-600">{{ electionType }}</div>
                </div>
                <div class="grid grid-cols-3">
                    <div class="font-medium">Wilayah Pemilihan</div>
                    <div class="text-gray-600">{{ organization.region }}</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import SelectButton from "primevue/selectbutton";
import { computed, ref, watch } from "vue";

const props = defineProps(["organization"]);

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

const selectedOption = ref(menus.value[0]);

watch(
    () => selectedOption.value,
    (newValue) => {
        router.get(route(newValue.route));
    }
);

const electionType = computed(() => {
    switch (props.organization.election_type) {
        case "presidential":
            return "Presiden";
        case "governor":
            return "Gubernur";
        case "regent":
            return "Bupati";
        case "regent":
            return "Wali Kota";
        case "dpr":
            return "Dewan Perwakilan Rakyat (DPR)";
        case "dpd":
            return "Dewan Perwakilan Daerah (DPD)";
        case "dprd-1":
            return "Dewan Perwakilan Rakyat Daerah Provinsi";
        case "dprd-2":
            return "Dewan Perwakilan Rakyat Daerah Kabupaten/Kota";
    }
});
</script>

<style lang="scss" scoped></style>
