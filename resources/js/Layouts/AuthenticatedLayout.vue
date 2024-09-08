<script setup>
import Navbar from "@/Components/Navbar/Authenticated.vue";
import { usePage } from "@inertiajs/vue3";
import ConfirmDialog from "primevue/confirmdialog";
import Toast from "primevue/toast";
import { useToast } from "primevue/usetoast";
import { onMounted } from "vue";

const toast = useToast();

onMounted(() => {
    if (usePage().props.flash.success) {
        toast.add({
            severity: "success",
            summary: "Berhasil",
            detail: usePage().props.flash?.success,
            life: 3000,
        });
    } else if (usePage().props.flash.failed) {
        toast.add({
            severity: "error",
            summary: "Gagal",
            detail: usePage().props.flash?.failed,
            life: 3000,
        });
    }
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-slate-50">
            <Navbar />
            <!-- Page Heading -->
            <header v-if="$slots.header" class="px-24 py-6">
                <slot name="header" />
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>

    <Toast class="z-50" />

    <ConfirmDialog style="width: 30rem"></ConfirmDialog>
</template>
