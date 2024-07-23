<template>
    <Head title="Daftar Anggota" />

    <AuthenticatedLayout>
        <template #header>
            <Header />
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white p-8">
                <DataTable
                    v-model:selection="selectedUsers"
                    v-model:filters="filters"
                    dataKey="id"
                    :value="users"
                    paginator
                    paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
                    currentPageReportTemplate="Menampilkan {first} - {last} dari {totalRecords}"
                    :rows="10"
                    :rowsPerPageOptions="[10, 20, 30, 40, 50]"
                    :globalFilterFields="[
                        'full_name',
                        'email',
                        'phone',
                        'group.name',
                    ]"
                    scrollable
                >
                    <template #header>
                        <div
                            class="flex justify-between items-center font-medium"
                        >
                            <div class="flex gap-4">
                                <IconField iconPosition="left">
                                    <InputIcon>
                                        <i class="pi pi-search" />
                                    </InputIcon>
                                    <InputText
                                        v-model="filters['global'].value"
                                        placeholder="Cari anggota"
                                    />
                                </IconField>
                                <Dropdown
                                    v-model="filters['role.name'].value"
                                    :options="roles"
                                    optionLabel="name"
                                    optionValue="name"
                                    placeholder="Akses"
                                    showClear
                                    class="w-48"
                                />
                                <Dropdown
                                    v-model="filters['status'].value"
                                    :options="statuses"
                                    placeholder="Status"
                                    optionLabel="name"
                                    optionValue="value"
                                    showClear
                                    class="w-44"
                                />
                            </div>

                            <div class="flex gap-4">
                                <button
                                    @click="addToGroup()"
                                    :disabled="selectedUsers.length < 1"
                                    class="flex items-center gap-3 border rounded-lg px-4 py-2 disabled:opacity-50 disabled:bg-gray-100 hover:bg-gray-50"
                                >
                                    <i class="pi pi-users"></i> Tambah ke Grup
                                </button>
                                <button
                                    @click="remove()"
                                    :disabled="selectedUsers.length < 1"
                                    class="flex items-center gap-3 border rounded-lg px-4 py-2 disabled:opacity-50 disabled:bg-gray-100 hover:bg-gray-50"
                                >
                                    <i class="pi pi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </template>
                    <template #empty> Data tidak ditemukan. </template>

                    <Column
                        selectionMode="multiple"
                        headerStyle="width: 3rem"
                    ></Column>

                    <Column
                        field="full_name"
                        header="Nama"
                        style="min-width: 15rem"
                    >
                        <template #body="{ data }">
                            <Link
                                :href="route('users.show', data)"
                                class="hover:text-primary-500 hover:underline"
                            >
                                {{ data.full_name }}
                            </Link>
                        </template>
                    </Column>

                    <Column
                        field="phone"
                        header="Nomor HP"
                        style="min-width: 12rem"
                    >
                    </Column>

                    <Column
                        field="email"
                        header="Email"
                        style="min-width: 20rem"
                    >
                    </Column>

                    <Column
                        field="role.name"
                        header="Akses"
                        style="min-width: 10rem"
                    >
                    </Column>

                    <Column
                        field="group.name"
                        header="Grup"
                        style="min-width: 15rem"
                    >
                    </Column>

                    <Column
                        field="status"
                        header="Status Akun"
                        style="min-width: 15rem"
                    >
                        <template #body="{ data }">
                            <div
                                :class="[
                                    data.status === 'active'
                                        ? 'bg-green-50 text-green-600'
                                        : 'bg-amber-100 text-amber-600',
                                    'w-fit px-3 py-1 rounded-lg',
                                ]"
                            >
                                {{ formatStatus(data.status) }}
                            </div>
                        </template>
                    </Column>

                    <Column
                        field="joined_at.date"
                        header="Bergabung"
                        style="min-width: 8rem"
                    >
                    </Column>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>

    <Dialog
        v-model:visible="visible"
        modal
        header="Tambah ke dalam Grup"
        :style="{ width: '32rem' }"
    >
        <Create :users="selectedUsers" />
    </Dialog>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import { defineAsyncComponent, ref } from "vue";
import Header from "@/Components/Header/Member.vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import Dropdown from "primevue/dropdown";
import { router } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";
import Dialog from "primevue/dialog";

const props = defineProps(["filters", "users", "roles"]);

const Create = defineAsyncComponent(() => import("../Groups/Create.vue"));

const statuses = [
    { name: "Aktif", value: "active" },
    { name: "Diundang", value: "invited" },
];

const selectedUsers = ref([]);
const filters = ref();

function initFilters() {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        "role.name": {
            value: null,
            matchMode: FilterMatchMode.EQUALS,
        },
        status: {
            value: null,
            matchMode: FilterMatchMode.EQUALS,
        },
    };
}

initFilters();

const visible = ref(false);

function addToGroup() {
    visible.value = true;
}

function formatStatus(status) {
    switch (status) {
        case "active":
            return "Aktif";
        case "invited":
            return "Diundang";
    }
}

function edit() {
    router.get(route("users.edit", selectedUsers.value[0]));
}

const confirm = useConfirm();

function remove() {
    confirm.require({
        message:
            " Apakah Anda yakin ingin menghapus " +
            selectedUsers.value.length +
            " akun? Pengguna akun yang telah dihapus tidak dapat mengakses Kampa lagi.",
        header: "Konfirmasi",
        rejectClass:
            "border-0 bg-transparent text-slate-900 hover:bg-surface-200 focus:ring-0",
        rejectLabel: "Batal",
        acceptLabel: "Hapus",
        accept: () => {
            const form = useForm({
                users: selectedUsers.value,
            });

            form.delete(route("users.bulk-destroy"), {
                preserveState: false,
            });
        },
        reject: () => {},
    });
}
</script>

<style lang="scss" scoped></style>
