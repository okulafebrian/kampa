<template>
    <Head :title="'Jl. ' + house.street.name + ' No. ' + house.number" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="font-semibold text-2xl">
                    Jl. {{ house.street.name }} No. {{ house.number }}
                </div>
                <div class="flex gap-4">
                    <SplitButton label="Edit" @click="edit" :model="items" />
                    <Button label="Tambah Kontak" @click="visible = true" />
                </div>
            </div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white min-h-96">
                <div class="relative px-8 pt-4">
                    <TabMenu :model="menus" />
                    <hr class="absolute inset-x-0 bottom-0" />
                </div>

                <div v-if="selectedMenu === 'house'" class="space-y-6 p-8">
                    <div>
                        <div class="font-medium mb-1">Alamat</div>
                        <div class="text-gray-600">
                            {{ house.name }}
                            <span v-if="house.unit"> , {{ house.unit }} </span>
                        </div>
                        <div class="text-gray-600">
                            Jl. {{ house.street.name }} No. {{ house.number }}
                            <span v-if="house.neighborhood_rt">
                                , RT {{ house.neighborhood_rt }}
                            </span>
                            <span v-if="house.neighborhood_rw">
                                RW {{ house.neighborhood_rw }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Kelurahan</div>
                        <div class="text-gray-600">
                            {{ house.street.village.name }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Kecamatan</div>
                        <div class="text-gray-600">
                            {{ house.street.district.name }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Kabupaten/kota</div>
                        <div class="text-gray-600">
                            {{ house.street.regency.name }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Provinsi</div>
                        <div class="text-gray-600">
                            {{ house.street.province.name }}
                        </div>
                    </div>
                </div>

                <div v-if="selectedMenu === 'contact'" class="space-y-6 p-8">
                    <div
                        v-if="contacts?.length > 0"
                        class="grid grid-cols-2 gap-4"
                    >
                        <Link
                            v-for="contact in contacts"
                            :href="route('contacts.show', contact)"
                            class="block bg-gray-50 hover:bg-gray-100 rounded-lg px-4 py-3"
                        >
                            <div class="font-medium">
                                {{ contact.full_name }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ formatGender(contact.gender) }} -
                                {{ contact.age }} tahun
                            </div>
                        </Link>
                    </div>
                    <div v-else class="text-gray-600">Belum ada kontak</div>
                </div>
            </div>

            <div class="border rounded-xl bg-white p-8 space-y-2">
                <div class="flex gap-10">
                    <div class="w-36">Dibuat</div>
                    <div>:</div>
                    <div>
                        {{ house.created_at.date }}
                        {{ house.created_at.time }} oleh
                        {{ house.creator.full_name }}
                    </div>
                </div>
                <div class="flex gap-10">
                    <div class="w-36">Diperbaharui</div>
                    <div>:</div>
                    <div v-if="house.updater">
                        {{ house.updated_at.date }}
                        {{ house.updated_at.time }} oleh
                        {{ house.updater.full_name ?? "-" }}
                    </div>
                    <div v-else>-</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Sidebar
        v-model:visible="visible"
        header="Tambah Kontak"
        position="right"
        class="w-[35rem]"
    >
        <AddContact />
    </Sidebar>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import Button from "primevue/button";
import Sidebar from "primevue/sidebar";
import SplitButton from "primevue/splitbutton";
import TabMenu from "primevue/tabmenu";
import { useConfirm } from "primevue/useconfirm";
import { defineAsyncComponent, ref } from "vue";

const props = defineProps(["house", "contacts"]);

const visible = ref(false);

const AddContact = defineAsyncComponent(() => import("../Contacts/Create.vue"));

const selectedMenu = ref("house");

const menus = ref([
    {
        label: "Informasi Rumah",
        command: () => {
            selectedMenu.value = "house";
        },
    },
    {
        label: "Kontak",
        command: () => {
            selectedMenu.value = "contact";
            router.reload({ only: ["contacts"] });
        },
    },
]);

function formatGender(gender) {
    switch (gender) {
        case "male":
            return "Laki-laki";
        case "female":
            return "Perempuan";
    }
}

const confirm = useConfirm();

const items = [
    {
        label: "Hapus",
        command: () => {
            confirm.require({
                message:
                    "Apakah Anda yakin ingin menghapus rumah ini? Semua kontak yang terkait dengan rumah ini akan ikut terhapus.",
                header: "Konfirmasi",
                rejectClass:
                    "border-0 bg-transparent text-slate-900 hover:bg-surface-200 focus:ring-0",
                rejectLabel: "Batal",
                acceptLabel: "Hapus",
                accept: () => {
                    router.delete(route("houses.destroy", props.house), {
                        preserveState: false,
                    });
                },
                reject: () => {},
            });
        },
    },
];

function edit() {
    router.get(route("houses.edit", props.house));
}
</script>

<style lang="scss" scoped></style>
