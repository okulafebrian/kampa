<template>
    <Head title="Arsip Suara" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="font-semibold text-2xl">Arsip Suara</div>
                <div class="flex items-center gap-2 font-medium text-2xl">
                    <i class="pi pi-map"></i> {{ region.name }}
                </div>
            </div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div
                v-if="election_type === 'governor'"
                class="grid grid-cols-4 gap-8"
            >
                <div
                    v-for="(regency, index) in regencies"
                    class="border rounded-xl bg-white p-8"
                >
                    <div class="flex justify-between mb-6">
                        <div class="text-xl font-medium">
                            {{ regency.name }}
                        </div>
                        <div class="text-xl">
                            <i class="pi pi-inbox me-2"></i>
                            {{ formatNumber(regencyVotes[index].total_votes) }}
                        </div>
                    </div>

                    <div class="space-y-4">
                        <Link
                            v-for="district in regency.districts"
                            :href="route('votes.show', district.slug)"
                            class="block text-gray-600 hover:text-primary-500 hover:underline"
                        >
                            {{ district.name }}
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps([
    "region",
    "provinces",
    "regencies",
    "election_type",
    "regencyVotes",
]);

function formatNumber(number) {
    if (number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    } else {
        return 0;
    }
}
</script>

<style lang="scss" scoped></style>
