<template>
    <Head title="Jalan" />

    <AuthenticatedLayout>
        <template #header>
            <Header>
                <SplitButton
                    label="Tambah Jalan"
                    @click="create"
                    :model="menus"
                />
            </Header>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white p-8">
                <DataTable
                    v-model:selection="selectedStreets"
                    v-model:filters="filters"
                    dataKey="id"
                    filterDisplay="menu"
                    :value="streets"
                    paginator
                    paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
                    currentPageReportTemplate="Menampilkan {first} - {last} dari {totalRecords}"
                    :rows="10"
                    :rowsPerPageOptions="[10, 20, 30, 40, 50]"
                    scrollable
                    removableSort
                >
                    <template #header>
                        <div
                            class="flex justify-between items-center font-medium"
                        >
                            <IconField iconPosition="left">
                                <InputIcon>
                                    <i class="pi pi-search" />
                                </InputIcon>
                                <InputText
                                    v-model="filters['global'].value"
                                    placeholder="Cari jalan"
                                />
                            </IconField>

                            <div class="flex gap-4">
                                <button
                                    @click="clearFilter"
                                    class="flex items-center gap-3 border rounded-lg px-4 py-2 text-primary-500 hover:bg-gray-50"
                                >
                                    <i class="pi pi-filter-slash"></i>
                                    Hapus Filter
                                </button>
                                <button
                                    @click="remove"
                                    :disabled="selectedStreets.length < 1"
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
                        field="name"
                        header="Nama"
                        style="min-width: 20rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #body="{ data }">
                            <Link
                                :href="route('streets.show', data)"
                                class="hover:text-primary-500 hover:underline"
                            >
                                {{ data.name }}
                            </Link>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis nama"
                            />
                        </template>
                    </Column>

                    <Column
                        field="village.name"
                        header="Kelurahan"
                        style="min-width: 15rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis nama kelurahan"
                            />
                        </template>
                    </Column>

                    <Column
                        field="district.name"
                        header="Kecamatan"
                        style="min-width: 15rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis nama kecamatan"
                            />
                        </template>
                    </Column>

                    <Column
                        field="regency.name"
                        header="Kabupaten/Kota"
                        style="min-width: 15rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis nama kabupaten/kota"
                            />
                        </template>
                    </Column>

                    <Column
                        field="province.name"
                        header="Provinsi"
                        style="min-width: 15rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis nama provinsi"
                            />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Header from "@/Components/Header/Voter.vue";
import { ref } from "vue";
import { FilterMatchMode } from "primevue/api";
import InputText from "primevue/inputtext";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import Dropdown from "primevue/dropdown";
import SplitButton from "primevue/splitbutton";
import { router, useForm } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";

const props = defineProps(["streets"]);

const selectedStreets = ref([]);
const filters = ref();

function initFilters() {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        name: {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        "village.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        "district.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },

        "regency.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        "province.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
    };
}

initFilters();

function clearFilter() {
    initFilters();
}

const confirm = useConfirm();

function remove() {
    confirm.require({
        message:
            "Apakah Anda yakin ingin menghapus " +
            selectedStreets.value.length +
            " jalan?",
        header: "Konfirmasi",
        rejectClass:
            "border-0 bg-transparent text-slate-900 hover:bg-surface-200 focus:ring-0",
        rejectLabel: "Batal",
        acceptLabel: "Hapus",
        accept: () => {
            const form = useForm({
                streets: selectedStreets.value,
            });

            form.delete(route("streets.bulk-destroy"), {
                preserveState: false,
            });
        },
        reject: () => {},
    });
}

function create() {
    router.get(route("streets.create"));
}

const menus = [
    {
        label: "Tambah sekaligus",
    },
];
</script>

<style lang="scss" scoped></style>
