<template>
    <Head title="Daftar" />

    <AuthenticatedLayout>
        <template #header>
            <Header />
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white p-8">
                <DataTable
                    v-model:selection="selectedWalkLists"
                    v-model:filters="filters"
                    filterDisplay="menu"
                    dataKey="id"
                    :value="walkLists"
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
                            <div class="flex gap-4">
                                <IconField iconPosition="left">
                                    <InputIcon>
                                        <i class="pi pi-search" />
                                    </InputIcon>
                                    <InputText
                                        v-model="filters['global'].value"
                                        placeholder="Cari daftar"
                                    />
                                </IconField>
                            </div>

                            <div class="flex gap-4">
                                <button
                                    @click="clearFilter()"
                                    class="flex items-center gap-3 border rounded-lg px-4 py-2 text-primary-500 hover:bg-gray-50"
                                >
                                    <i class="pi pi-filter-slash"></i>
                                    Hapus Filter
                                </button>
                                <button
                                    @click="remove()"
                                    :disabled="selectedWalkLists.length < 1"
                                    class="flex items-center gap-3 border rounded-lg px-4 py-2 disabled:opacity-50 disabled:bg-gray-100 hover:bg-gray-50"
                                >
                                    <i class="pi pi-file-export"></i> Ekspor
                                </button>
                                <button
                                    @click="remove()"
                                    :disabled="selectedWalkLists.length < 1"
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
                        style="min-width: 25rem"
                        sortable
                    >
                        <template #body="{ data }">
                            <Link
                                :href="route('walk-lists.show', data)"
                                class="hover:text-primary-500 hover:underline"
                            >
                                {{ data.name }}
                            </Link>
                        </template>
                    </Column>

                    <Column
                        field="assignee.label"
                        header="Yang memiliki akses"
                        style="min-width: 15rem"
                        sortable
                    >
                    </Column>

                    <Column
                        field="status"
                        header="Status"
                        style="min-width: 15rem"
                        sortable
                    >
                        <template #body="{ data }">
                            <div>{{ formatStatus(data.status) }}</div>
                        </template>
                        <template #filter="{ filterModel, filterCallback }">
                            <Dropdown
                                v-model="filterModel.value"
                                @change="filterCallback()"
                                :options="statuses"
                                class="p-column-filter"
                                :showClear="true"
                            />
                        </template>
                    </Column>

                    <Column column="totals" style="min-width: 15rem" sortable>
                        <template #header>
                            <i
                                class="pi pi-circle-fill me-2 text-green-600"
                            ></i>
                            Terjawab
                        </template>
                        <template #body="{ data }">
                            {{ data.totals["answered"] }}
                        </template>
                    </Column>

                    <Column column="totals" style="min-width: 15rem" sortable>
                        <template #header>
                            <i class="pi pi-circle-fill me-2 text-blue-600"></i>
                            Telepon Kembali
                        </template>
                        <template #body="{ data }">
                            {{ data.totals["call back"] }}
                        </template>
                    </Column>

                    <Column column="totals" style="min-width: 15rem" sortable>
                        <template #header>
                            <i class="pi pi-circle-fill me-2 text-red-600"></i>
                            Tidak Tertarik
                        </template>
                        <template #body="{ data }">
                            {{ data.totals[["inaccessible"]] }}
                        </template>
                    </Column>

                    <Column column="totals" style="min-width: 15rem" sortable>
                        <template #header>
                            <i class="pi pi-circle-fill me-2 text-blue-600"></i>
                            Tidak di Rumah
                        </template>
                        <template #body="{ data }">
                            {{ data.totals["not home"] }}
                        </template>
                    </Column>

                    <Column column="totals" style="min-width: 15rem" sortable>
                        <template #header>
                            <i class="pi pi-circle-fill me-2 text-blue-600"></i>
                            Tidak Terjangkau
                        </template>
                        <template #body="{ data }">
                            {{ data.totals["not interested"] }}
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
import { FilterMatchMode, FilterOperator } from "primevue/api";
import Dropdown from "primevue/dropdown";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import InputText from "primevue/inputtext";

const props = defineProps(["walkLists"]);

const statuses = [
    {
        name: "Berlangsung",
        value: "in progress",
    },
    {
        name: "Selesai",
        value: "completed",
    },
];

function formatStatus(status) {
    switch (status) {
        case "in progress":
            return "Berlangsung";
        case "completed":
            return "Selesai";
    }
}

const selectedWalkLists = ref([]);
const filters = ref();

function initFilters() {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        name: {
            operator: FilterOperator.AND,
            constraints: [
                { value: null, matchMode: FilterMatchMode.STARTS_WITH },
            ],
        },
        assignee: {
            operator: FilterOperator.AND,
            constraints: [
                { value: null, matchMode: FilterMatchMode.STARTS_WITH },
            ],
        },
        status: {
            operator: FilterOperator.AND,
            constraints: [
                { value: null, matchMode: FilterMatchMode.STARTS_WITH },
            ],
        },
    };
}

initFilters();

function clearFilter() {
    initFilters();
}
</script>

<style lang="scss" scoped></style>
