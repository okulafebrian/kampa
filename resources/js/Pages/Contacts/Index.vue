<template>
    <Head title="Kontak" />

    <AuthenticatedLayout>
        <template #header>
            <Header />
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white p-8">
                <DataTable
                    v-model:selection="selectedContacts"
                    v-model:filters="filters"
                    dataKey="id"
                    filterDisplay="menu"
                    :value="contacts"
                    paginator
                    paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
                    currentPageReportTemplate="Menampilkan {first} - {last} dari {totalRecords}"
                    :rows="10"
                    :rowsPerPageOptions="[10, 20, 30, 40, 50]"
                    :globalFilterFields="[
                        'full_name',
                        'house.address',
                        'email',
                        'phone',
                    ]"
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
                                        placeholder="Cari kontak"
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
                                    @click="addToList()"
                                    :disabled="selectedContacts.length < 1"
                                    class="flex items-center gap-3 border rounded-lg px-4 py-2 disabled:opacity-50 disabled:bg-gray-100 hover:bg-gray-50"
                                >
                                    <i class="pi pi-list"></i> Tambah ke Daftar
                                </button>
                                <button
                                    @click="remove()"
                                    :disabled="selectedContacts.length < 1"
                                    class="flex items-center gap-3 border rounded-lg px-4 py-2 disabled:opacity-50 disabled:bg-gray-100 hover:bg-gray-50"
                                >
                                    <i class="pi pi-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </template>
                    <template #empty> Data tidak ditemukan. </template>

                    <Column selectionMode="multiple" headerStyle="width: 3rem">
                    </Column>

                    <Column
                        field="full_name"
                        header="Nama"
                        style="min-width: 15rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #body="{ data }">
                            <Link
                                :href="route('contacts.show', data)"
                                class="hover:text-primary-500 hover:underline"
                            >
                                {{ data.full_name }}
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
                        field="house.address"
                        header="Alamat"
                        style="min-width: 24rem"
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
                        field="house.street.village.name"
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
                        field="house.street.district.name"
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
                        field="email"
                        header="Email"
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
                                placeholder="Tulis email"
                            />
                        </template>
                    </Column>

                    <Column
                        field="phone"
                        header="Nomor HP"
                        style="min-width: 12rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <InputText
                                v-model="filterModel.value"
                                type="text"
                                placeholder="Tulis no hp"
                            />
                        </template>
                    </Column>

                    <Column
                        field="gender"
                        header="Jenis Kelamin"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        style="min-width: 15rem"
                        sortable
                    >
                        <template #body="{ data }">
                            {{ formatGender(data.gender) }}
                        </template>
                        <template #filter="{ filterModel }">
                            <Dropdown
                                v-model="filterModel.value"
                                :options="genders"
                                optionLabel="name"
                                optionValue="value"
                                class="w-48"
                                placeholder="Pilih jenis kelamin"
                                :showClear="true"
                            />
                        </template>
                    </Column>

                    <Column
                        field="age"
                        header="Umur"
                        style="min-width: 8rem"
                        :showFilterMatchModes="false"
                        sortable
                    >
                        <template #filter="{ filterModel }">
                            <Slider
                                v-model="filterModel.value"
                                range
                                class="m-4"
                            ></Slider>
                            <div class="flex items-center justify-between px-2">
                                <span>
                                    {{
                                        filterModel.value
                                            ? filterModel.value[0]
                                            : 0
                                    }}
                                </span>
                                <span>
                                    {{
                                        filterModel.value
                                            ? filterModel.value[1]
                                            : 100
                                    }}
                                </span>
                            </div>
                        </template>
                    </Column>

                    <Column
                        field="employment"
                        header="Pekerjaan"
                        style="min-width: 22rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #body="{ data }">
                            {{ data.employment?.name }}
                        </template>
                        <template #filter="{ filterModel }">
                            <MultiSelect
                                v-model="filterModel.value"
                                :options="employments"
                                optionLabel="name"
                                placeholder="Pilih pekerjaan"
                                class="w-48"
                            />
                        </template>
                    </Column>

                    <Column
                        field="is_volunteer"
                        header="Relawan"
                        style="min-width: 10rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #body="{ data }">
                            <div v-if="data.is_volunteer">Iya</div>
                            <div v-else>Tidak</div>
                        </template>
                        <template #filter="{ filterModel }">
                            <label class="font-bold me-2"> Relawan </label>
                            <Checkbox v-model="filterModel.value" binary />
                        </template>
                    </Column>

                    <Column
                        field="is_witness"
                        header="Saksi"
                        style="min-width: 8rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #body="{ data }">
                            <div v-if="data.is_volunteer">Iya</div>
                            <div v-else>Tidak</div>
                        </template>
                        <template #filter="{ filterModel }">
                            <label class="font-bold me-2"> Saksi </label>
                            <Checkbox v-model="filterModel.value" binary />
                        </template>
                    </Column>

                    <Column
                        field="is_deceased"
                        header="Telah Meninggal"
                        style="min-width: 15rem"
                        :showFilterMatchModes="false"
                        :showAddButton="false"
                        :showFilterOperator="false"
                        sortable
                    >
                        <template #body="{ data }">
                            <div v-if="data.is_volunteer">Iya</div>
                            <div v-else>Tidak</div>
                        </template>
                        <template #filter="{ filterModel }">
                            <label class="font-bold me-2">
                                Telah meninggal
                            </label>
                            <Checkbox v-model="filterModel.value" binary />
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
        <Form :contacts="selectedContacts" />
    </Dialog>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { FilterMatchMode } from "primevue/api";
import Button from "primevue/button";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import { defineAsyncComponent, ref } from "vue";
import Header from "@/Components/Header/Voter.vue";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import { useConfirm } from "primevue/useconfirm";
import Dropdown from "primevue/dropdown";
import Dialog from "primevue/dialog";
import MultiSelect from "primevue/multiselect";
import Checkbox from "primevue/checkbox";
import Slider from "primevue/slider";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["contacts", "employments"]);

const Form = defineAsyncComponent(() => import("../WalkLists/Form.vue"));

const visible = ref(false);
const selectedContacts = ref([]);
const filters = ref();

function initFilters() {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        full_name: {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        "house.address": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        "house.street.village.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        "house.street.district.name": {
            value: null,
            matchMode: FilterMatchMode.CONTAINS,
        },
        email: { value: null, matchMode: FilterMatchMode.CONTAINS },
        gender: { value: null, matchMode: FilterMatchMode.EQUALS },
        age: { value: [0, 100], matchMode: FilterMatchMode.BETWEEN },
        phone: { value: null, matchMode: FilterMatchMode.CONTAINS },
        employment: { value: null, matchMode: FilterMatchMode.IN },
        is_volunteer: { value: null, matchMode: FilterMatchMode.EQUALS },
        is_witness: { value: null, matchMode: FilterMatchMode.EQUALS },
        is_deceased: { value: null, matchMode: FilterMatchMode.EQUALS },
    };
}

initFilters();

function clearFilter() {
    initFilters();
}

const genders = [
    { name: "Laki-laki", value: "male" },
    { name: "Perempuan", value: "female" },
];

function formatGender(gender) {
    switch (gender) {
        case "male":
            return "Laki-laki";
        case "female":
            return "Perempuan";
    }
}

function addToList() {
    visible.value = true;
}

const confirm = useConfirm();

function remove() {
    confirm.require({
        message:
            "Apakah Anda yakin ingin menghapus " +
            selectedContacts.value.length +
            " kontak?",
        header: "Konfirmasi",
        rejectClass:
            "border-0 bg-transparent text-slate-900 hover:bg-surface-200 focus:ring-0",
        rejectLabel: "Batal",
        acceptLabel: "Hapus",
        accept: () => {
            const form = useForm({
                contacts: selectedContacts.value,
            });

            form.delete(route("contacts.bulk-destroy"), {
                preserveState: false,
            });
        },
        reject: () => {},
    });
}
</script>

<style lang="scss" scoped></style>
