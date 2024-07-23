<template>
    <Head title="Daftar Grup" />

    <AuthenticatedLayout>
        <template #header>
            <Header />
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border rounded-xl bg-white p-8">
                <DataTable
                    v-model:selection="selectedGroups"
                    v-model:filters="filters"
                    dataKey="id"
                    :value="groups"
                    paginator
                    paginatorTemplate="FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink RowsPerPageDropdown"
                    currentPageReportTemplate="Menampilkan {first} - {last} dari {totalRecords}"
                    :rows="10"
                    :rowsPerPageOptions="[10, 20, 30, 40, 50, 60]"
                    :globalFilterFields="['name']"
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
                                    placeholder="Cari grup"
                                />
                            </IconField>

                            <button
                                @click="remove()"
                                :disabled="selectedGroups.length < 1"
                                class="flex items-center gap-3 border rounded-lg px-4 py-2 disabled:opacity-50 disabled:bg-gray-100 hover:bg-gray-50"
                            >
                                <i class="pi pi-trash"></i> Hapus
                            </button>
                        </div>
                    </template>
                    <template #empty> Data tidak ditemukan. </template>

                    <Column
                        selectionMode="multiple"
                        headerStyle="width: 3rem"
                    ></Column>

                    <Column field="name" header="Nama" style="min-width: 15rem">
                        <template #body="{ data }">
                            <Link
                                :href="route('groups.edit', data)"
                                class="hover:text-primary-500 hover:underline"
                            >
                                {{ data.name }}
                            </Link>
                        </template>
                    </Column>

                    <Column field="users_count" header="Anggota"> </Column>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Header from "@/Components/Header/Member.vue";
import { ref } from "vue";
import InputText from "primevue/inputtext";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import { FilterMatchMode } from "primevue/api";
import Button from "primevue/button";
import { router, useForm } from "@inertiajs/vue3";
import { useConfirm } from "primevue/useconfirm";

defineProps(["groups"]);

const selectedGroups = ref([]);
const filters = ref();

function initFilters() {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    };
}

initFilters();

function edit() {
    router.get(route("groups.edit", selectedGroups.value[0]));
}

const confirm = useConfirm();

function remove() {
    confirm.require({
        message:
            "Apakah Anda yakin ingin menghapus " +
            selectedGroups.value.length +
            " grup?",
        header: "Konfirmasi",
        rejectClass:
            "border-0 bg-transparent text-slate-900 hover:bg-surface-200 focus:ring-0",
        rejectLabel: "Batal",
        acceptLabel: "Hapus",
        accept: () => {
            const form = useForm({
                groups: selectedGroups.value,
            });

            form.delete(route("groups.bulk-destroy"), {
                preserveState: false,
            });
        },
        reject: () => {},
    });
}
</script>

<style lang="scss" scoped></style>
