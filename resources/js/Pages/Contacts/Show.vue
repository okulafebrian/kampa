<template>
    <Head :title="contact.full_name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="font-semibold text-2xl">
                    {{ contact.full_name }}
                </div>
                <div class="flex gap-4">
                    <SplitButton label="Edit" @click="edit" :model="items" />
                    <Button label="Rekam Interaksi" @click="visible = true" />
                </div>
            </div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white min-h-96">
                <div class="relative px-8 pt-4">
                    <TabMenu :model="menus" />
                    <hr class="absolute inset-x-0 bottom-0" />
                </div>

                <div
                    v-if="selectedMenu === 'biodata'"
                    class="p-8 grid grid-cols-3 gap-8"
                >
                    <div>
                        <div class="font-medium mb-1">Jenis Kelamin</div>
                        <div class="text-gray-600">
                            {{
                                contact.gender === "male"
                                    ? "Laki-laki"
                                    : "Perempuan"
                            }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Tanggal Lahir</div>
                        <div class="text-gray-600">
                            {{ contact.dob }} ({{ contact.age }} tahun)
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Email</div>
                        <div class="text-gray-600">
                            {{ contact.email }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Nomor HP</div>
                        <div class="text-gray-600">
                            {{ contact.phone }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Alamat</div>
                        <div class="text-gray-600">
                            {{ contact.house.name }}
                            <span v-if="contact.house.unit">
                                , {{ contact.house.unit }}
                            </span>
                        </div>
                        <div class="text-gray-600">
                            Jl. {{ contact.house.street.name }} No.
                            {{ contact.house.number }}
                            <span v-if="contact.house.neighborhood_rt">
                                , RT {{ contact.house.neighborhood_rt }}
                            </span>
                            <span v-if="contact.house.neighborhood_rw">
                                RW {{ contact.house.neighborhood_rw }}
                            </span>
                        </div>
                        <div class="text-gray-600">
                            Kel. {{ contact.house.street.village.name }}, Kec.
                            {{ contact.house.street.district.name }},
                            {{ contact.house.street.regency.name }},
                        </div>
                        <div class="text-gray-600">
                            {{ contact.house.street.province.name }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">TPS</div>
                        <div class="text-gray-600">
                            {{ contact.pollingStation?.name ?? "-" }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Pekerjaan</div>
                        <div class="text-gray-600">
                            {{ contact.employment.name ?? "-" }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Relawan</div>
                        <div class="text-gray-600">
                            {{ contact.is_volunteer ? "Iya" : "Tidak" }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Saksi</div>
                        <div class="text-gray-600">
                            {{ contact.is_witness ? "Iya" : "Tidak" }}
                        </div>
                    </div>
                    <div>
                        <div class="font-medium mb-1">Telah Meninggal</div>
                        <div class="text-gray-600">
                            {{ contact.is_deceased ? "Iya" : "Tidak" }}
                        </div>
                    </div>
                </div>

                <div
                    v-if="selectedMenu === 'interaction'"
                    class="space-y-6 p-8"
                >
                    <div v-if="interactions?.length > 0" class="divide-y">
                        <div
                            v-for="interaction in interactions"
                            class="space-y-3"
                        >
                            <div>
                                <span class="font-medium">
                                    {{ interaction.user.full_name }}
                                </span>
                                melakukan interaksi dengan
                                <span class="font-medium">
                                    {{ interactions.contact.full_name }}
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

            <div
                v-if="selectedMenu === 'biodata'"
                class="border rounded-xl bg-white p-8 space-y-2"
            >
                <div class="flex gap-10">
                    <div class="w-36">Dibuat</div>
                    <div>:</div>
                    <div>
                        {{ contact.created_at.date }} oleh
                        {{ contact.creator.full_name }}
                    </div>
                </div>
                <div class="flex gap-10">
                    <div class="w-36">Diperbaharui</div>
                    <div>:</div>
                    <div v-if="contact.updater">
                        {{ contact.created_at.date }} oleh
                        {{ contact.updater.full_name ?? "-" }}
                    </div>
                    <div v-else>-</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <Dialog
        v-model:visible="visible"
        modal
        header="Interaksi"
        :style="{ width: '35rem' }"
    >
        <Interact @close="visible = false" />
    </Dialog>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
import Button from "primevue/button";
import Dialog from "primevue/dialog";
import Rating from "primevue/rating";
import SplitButton from "primevue/splitbutton";
import TabMenu from "primevue/tabmenu";
import { defineAsyncComponent, ref } from "vue";
import { useConfirm } from "primevue/useconfirm";

const props = defineProps(["contact", "interactions"]);

const visible = ref(false);

const Interact = defineAsyncComponent(() => import("./Interact.vue"));

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

const confirm = useConfirm();

const items = [
    {
        label: "Hapus",
        command: () => {
            confirm.require({
                message: "Apakah Anda yakin ingin menghapus kontak ini?",
                header: "Konfirmasi",
                rejectClass:
                    "border-0 bg-transparent text-slate-900 hover:bg-surface-200 focus:ring-0",
                rejectLabel: "Batal",
                acceptLabel: "Hapus",
                accept: () => {
                    router.delete(route("contacts.destroy", props.contact), {
                        preserveState: false,
                    });
                },
                reject: () => {},
            });
        },
    },
];

function edit() {
    router.get(route("contacts.edit", props.contact));
}
</script>

<style lang="scss" scoped></style>
