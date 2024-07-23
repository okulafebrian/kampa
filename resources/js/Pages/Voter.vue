<template>
    <Head title="Statistik Pemilih" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="font-semibold text-2xl">Statistik Pemilih</div>
                <button class="bg-white px-4 py-3 rounde-lg border rounded-lg">
                    <span class="font-semibold">30 hari terakhir</span> (11 Mei
                    - 10 Jun 2024)
                    <i class="pi pi-angle-down ms-2"></i>
                </button>
            </div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6"></div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePage } from "@inertiajs/vue3";
import Chart from "primevue/chart";
import { onMounted, ref } from "vue";
</script>

<style lang="scss" scoped></style>
