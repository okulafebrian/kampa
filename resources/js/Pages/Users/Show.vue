<template>
    <Head :title="user.full_name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="font-semibold text-2xl">
                    {{ user.full_name }}
                </div>
                <SplitButton label="Edit" @click="edit" :model="items" />
            </div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white min-h-96">
                <div class="relative px-8 pt-4">
                    <TabMenu :model="menus" />
                    <hr class="absolute inset-x-0 bottom-0" />
                </div>

                <div v-if="selectedMenu === 'biodata'" class="space-y-6 p-8">
                    <div>
                        <div class="font-medium mb-1">Email</div>
                        <div class="text-gray-600">
                            {{ user.email }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Nomor HP</div>
                        <div class="text-gray-600">
                            {{ user.phone }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Akses</div>
                        <div class="text-gray-600">
                            {{ user.role.name }}
                        </div>
                    </div>
                </div>

                <div
                    v-if="selectedMenu === 'interaction'"
                    class="space-y-6 px-8 py-4"
                >
                    <div v-if="interactions?.length > 0" class="divide-y">
                        <div
                            v-for="interaction in interactions"
                            class="py-4 space-y-3"
                        >
                            <div>
                                <span class="font-medium">
                                    {{ interaction.user?.full_name }}
                                </span>
                                melakukan interaksi dengan
                                <span class="font-medium">
                                    {{ interaction.contact.full_name }}
                                </span>
                            </div>
                            <div
                                :class="[
                                    'border-s-4 px-4 font-medium',
                                    statusColor(interaction.status),
                                ]"
                            >
                                {{ statusLabel(interaction.status) }}
                            </div>
                            <Rating
                                v-model="interaction.support_level"
                                readonly
                                :cancel="false"
                            />
                            <div
                                v-if="interaction.notes"
                                class="w-fit bg-slate-100 px-3 py-2 rounded-lg"
                            >
                                {{ interaction.notes }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ interaction.created_at }}
                            </div>
                        </div>
                    </div>
                    <div v-else class="text-gray-600">Belum ada interaksi</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import TabMenu from "primevue/tabmenu";
import { ref } from "vue";
import { useConfirm } from "primevue/useconfirm";
import Rating from "primevue/rating";
import SplitButton from "primevue/splitbutton";

const props = defineProps(["user", "interactions"]);

function statusLabel(status) {
    switch (status) {
        case "answered":
            return "Terjawab";
        case "call back":
            return "Telepon Kembali";
        case "not interested":
            return "Tidak Tertarik";
        case "not home":
            return "Tidak di Rumah";
        case "inaccessible":
            return "Tidak Terjangkau";
    }
}

function statusColor(status) {
    switch (status) {
        case "answered":
            return "border-green-600";
        case "call back":
            return "border-blue-600";
        case "not interested":
            return "border-red-600";
        case "not home":
            return "border-blue-600";
        case "inaccessible":
            return "border-blue-600";
    }
}

const selectedMenu = ref("biodata");

const menus = ref([
    {
        label: "Biodata",
        command: () => {
            selectedMenu.value = "biodata";
        },
    },
    {
        label: "Interaksi Terakhir",
        command: () => {
            selectedMenu.value = "interaction";
            router.reload({ only: ["interactions"] });
        },
    },
]);

function edit() {
    router.get(route("users.edit", props.user));
}

const confirm = useConfirm();

const items = [
    {
        label: "Hapus",
        command: () => {
            confirm.require({
                message:
                    "Apakah Anda yakin ingin menghapus anggota ini? Pengguna akun yang telah dihapus tidak dapat mengakses Kampa lagi",
                header: "Konfirmasi",
                rejectClass:
                    "border-0 bg-transparent text-slate-900 hover:bg-surface-200 focus:ring-0",
                rejectLabel: "Batal",
                acceptLabel: "Hapus",
                accept: () => {
                    router.delete(route("users.destroy", props.user), {
                        preserveState: false,
                    });
                },
                reject: () => {},
            });
        },
    },
];
</script>

<style lang="scss" scoped></style>
