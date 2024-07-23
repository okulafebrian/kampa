<template>
    <Head title="Profil" />

    <AuthenticatedLayout>
        <template #header>
            <div class="font-semibold text-2xl">Profil</div>
        </template>

        <div class="p-24 pt-0 pb-16">
            <div class="border rounded-xl bg-white px-96 py-14 space-y-6">
                <div class="flex flex-col gap-2">
                    <div class="font-medium">Nama Lengkap</div>
                    <InputText :value="auth.user.full_name" readonly />
                </div>
                <div class="flex flex-col gap-2">
                    <div class="font-medium">Email</div>
                    <InputText :value="auth.user.email" readonly />
                </div>
                <div class="flex flex-col gap-2">
                    <div class="font-medium">Nomor HP</div>
                    <InputText :value="auth.user.phone" readonly />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import InputText from "primevue/inputtext";

defineProps(["auth"]);
</script>

<style lang="scss" scoped></style>
