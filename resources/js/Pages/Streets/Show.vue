<template>
    <Head :title="'Jl. ' + street.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="font-semibold text-2xl">Jl. {{ street.name }}</div>
                <SplitButton label="Edit" @click="edit" :model="items" />
            </div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white min-h-96">
                <div class="relative px-8 pt-4">
                    <TabMenu :model="menus" />
                    <hr class="absolute inset-x-0 bottom-0" />
                </div>

                <div v-if="selectedMenu === 'street'" class="space-y-6 p-8">
                    <div>
                        <div class="font-medium mb-1">Nama</div>
                        <div class="text-gray-600">
                            {{ street.name }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Kelurahan</div>
                        <div class="text-gray-600">
                            {{ street.village.name }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Kecamatan</div>
                        <div class="text-gray-600">
                            {{ street.district.name }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Kabupaten/kota</div>
                        <div class="text-gray-600">
                            {{ street.regency.name }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Provinsi</div>
                        <div class="text-gray-600">
                            {{ street.province.name }}
                        </div>
                    </div>
                </div>

                <div v-if="selectedMenu === 'house'" class="space-y-6 p-8">
                    <div
                        v-if="houses?.length > 0"
                        class="grid grid-cols-2 gap-4"
                    >
                        <Link
                            v-for="house in houses"
                            :href="route('houses.show', house)"
                            class="block bg-gray-50 hover:bg-gray-100 rounded-lg px-4 py-3"
                        >
                            <div class="font-medium">
                                {{ house.street.name }} {{ house.number }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ house.name }}
                            </div>
                        </Link>
                    </div>
                    <div v-else class="text-gray-600">Belum ada rumah</div>
                </div>
            </div>

            <div class="border rounded-xl bg-white p-8 space-y-2">
                <div class="flex gap-10">
                    <div class="w-36">Dibuat</div>
                    <div>:</div>
                    <div>
                        {{ street.created_at.date }}
                        {{ street.created_at.time }} oleh
                        {{ street.creator.full_name }}
                    </div>
                </div>
                <div class="flex gap-10">
                    <div class="w-36">Diperbaharui</div>
                    <div>:</div>
                    <div v-if="street.updater">
                        {{ street.updated_at.date }}
                        {{ street.updated_at.time }} oleh
                        {{ street.updater.full_name ?? "-" }}
                    </div>
                    <div v-else>-</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import SplitButton from "primevue/splitbutton";
import TabMenu from "primevue/tabmenu";
import { useConfirm } from "primevue/useconfirm";
import { ref } from "vue";

const props = defineProps(["street", "houses"]);

const selectedMenu = ref("street");

const menus = ref([
    {
        label: "Informasi Jalan",
        command: () => {
            selectedMenu.value = "street";
        },
    },
    {
        label: "Rumah",
        command: () => {
            selectedMenu.value = "house";
            router.reload({ only: ["houses"] });
        },
    },
]);

const confirm = useConfirm();

const items = [
    {
        label: "Hapus",
        command: () => {
            confirm.require({
                message:
                    "Apakah Anda yakin ingin menghapus jalan ini? Semua rumah dan kontak yang terkait dengan jalan ini akan ikut terhapus.",
                header: "Konfirmasi",
                rejectClass:
                    "border-0 bg-transparent text-slate-900 hover:bg-surface-200 focus:ring-0",
                rejectLabel: "Batal",
                acceptLabel: "Hapus",
                accept: () => {
                    router.delete(route("streets.destroy", props.street), {
                        preserveState: false,
                    });
                },
                reject: () => {},
            });
        },
    },
];

function edit() {
    router.get(route("streets.edit", props.street));
}
</script>

<style lang="scss" scoped></style>
