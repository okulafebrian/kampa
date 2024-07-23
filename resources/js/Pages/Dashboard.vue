<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="p-6 sm:p-24 sm:py-16 space-y-6">
            <div class="flex gap-8 mb-16">
                <div class="flex-1 border rounded-xl bg-white p-8 space-y-8">
                    <div class="space-y-1">
                        <div class="text-2xl font-semibold">
                            Hi {{ auth.user.full_name }}
                        </div>
                        <div class="text-gray-600">
                            Interaksi yang kamu lakukan selama 30 hari terakhir
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-8 gap-8">
                        <div>
                            <div class="mb-2">Percobaan</div>
                            <div class="font-medium text-2xl">
                                {{ interactionsCount }}
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">Terjawab</div>
                            <div class="font-medium text-2xl">
                                {{ answeredCount }}
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">Telepon Kembali</div>
                            <div class="font-medium text-2xl">
                                {{ callBackCount }}
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">Tidak Tertarik</div>
                            <div class="font-medium text-2xl">
                                {{ notInterestedCount }}
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">Tidak di Rumah</div>
                            <div class="font-medium text-2xl">
                                {{ notHomeCount }}
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">Tidak Terjangkau</div>
                            <div class="font-medium text-2xl">
                                {{ inaccessibleCount }}
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">Level Dukungan</div>
                            <div
                                class="font-medium text-2xl flex items-center gap-2"
                            >
                                {{ avgRating }}
                                <i class="pi pi-star-fill text-lg"></i>
                            </div>
                        </div>
                        <div>
                            <div class="mb-2">Tingkat Konversi</div>
                            <div class="font-medium text-2xl">
                                {{ conversionRate }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps([
    "auth",
    "interactionsCount",
    "answeredCount",
    "callBackCount",
    "notInterestedCount",
    "notHomeCount",
    "inaccessibleCount",
    "avgRating",
    "conversionRate",
]);
</script>
