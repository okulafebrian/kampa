<template>
    <Head title="Rumah" />

    <AuthenticatedLayout>
        <template #header>
            <Header>
                <SplitButton
                    label="Tambah Rumah"
                    @click="create"
                    :model="menus"
                />
            </Header>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white p-8">
                <DataTable
                    v-model:selection="selectedHouses"
                    v-model:filters="filters"
                    filterDisplay="menu"
                    dataKey="id"
                    :value="houses"
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
                                    placeholder="Cari rumah"
                                />
                            </IconField>

                            <div class="flex gap-4">
                                <button
                                    @click="clearFilter()"
                                    class="flex items-center gap-3 border rounded-lg px-4 py-2 text-primary-500 hover:bg-gray-50"
                                >
                                    <i class="pi pi-filter-slash"></i>
                                    Hapus Filter
                                </button>
                                <button
                                    @click="addToList()"
                                    :disabled="selectedHouses.length < 1"
                                    class="flex items-center gap-3 border rounded-lg px-4 py-2 disabled:opacity-50 disabled:bg-gray-100 hover:bg-gray-50"
                                >
                                    <i class="pi pi-list"></i> Tambah ke Daftar
                                </button>
                                <button
                                    @click="remove()"
                                    :disabled="selectedHouses.length < 1"
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
                        header="Nomor"
                        field="number"
                        style="min-width: 10rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #body="{ data }">
                            <Link
                                :href="route('houses.show', data)"
                                class="hover:text-primary-500 hover:underline"
                            >
                                {{ data.number }}
                            </Link>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis no. rumah"
                            />
                        </template>
                    </Column>

                    <Column
                        field="street.name"
                        header="Jalan"
                        style="min-width: 20rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis nama jalan"
                            />
                        </template>
                    </Column>

                    <Column
                        field="neighborhood_rt"
                        header="RT"
                        style="min-width: 8rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis nama rt"
                            />
                        </template>
                    </Column>

                    <Column
                        field="neighborhood_rw"
                        header="RW"
                        style="min-width: 8rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis nama rw"
                            />
                        </template>
                    </Column>

                    <Column
                        field="street.village.name"
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
                        field="street.district.name"
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
                        field="street.regency.name"
                        header="Kabupaten/Kota"
                        style="min-width: 16rem"
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
                        field="unit"
                        header="Unit"
                        style="min-width: 10rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis unit rumah"
                            />
                        </template>
                    </Column>

                    <Column
                        field="name"
                        header="Nama"
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
                                placeholder="Tulis nama rumah"
                            />
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>

    <Dialog
        v-model:visible="visible"
        modal
        header="Tambah ke dalam Daftar"
        :style="{ width: '32rem' }"
    >
        <Form :contacts="selectedHouses" />
    </Dialog>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Header from "@/Components/Header/Voter.vue";
import { ref } from "vue";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import InputText from "primevue/inputtext";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import { useConfirm } from "primevue/useconfirm";
import Dropdown from "primevue/dropdown";
import Dialog from "primevue/dialog";
import Form from "../WalkLists/Form.vue";
import SplitButton from "primevue/splitbutton";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps(["houses"]);

const visible = ref(false);
const selectedHouses = ref([]);
const filters = ref();

function initFilters() {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        number: {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        "street.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        neighborhood_rt: {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        neighborhood_rw: {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        "street.village.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        "street.district.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },

        "street.regency.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        unit: {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        name: {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
    };
}

initFilters();

function clearFilter() {
    initFilters();
}

function create() {
    router.get(route("houses.create"));
}

function addToList() {
    visible.value = true;
}

const confirm = useConfirm();

function remove() {
    confirm.require({
        message:
            "Apakah Anda yakin ingin menghapus " +
            selectedHouses.value.length +
            " rumah?",
        header: "Konfirmasi",
        rejectClass:
            "border-0 bg-transparent text-slate-900 hover:bg-surface-200 focus:ring-0",
        rejectLabel: "Batal",
        acceptLabel: "Hapus",
        accept: () => {
            const form = useForm({
                houses: selectedHouses.value,
            });

            form.delete(route("houses.bulk-destroy"), {
                preserveState: false,
            });
        },
        reject: () => {},
    });
}

const menus = [
    {
        label: "Tambah sekaligus",
    },
];
</script>

<style lang="scss" scoped></style>
