<template>
    <Head :title="walklist.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="font-semibold text-2xl">{{ walklist.name }}</div>
                <SplitButton label="Edit" @click="edit" :model="items" />
            </div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white min-h-96">
                <div class="relative px-8 pt-4">
                    <TabMenu :model="menus" />
                    <hr class="absolute inset-x-0 bottom-0" />
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
