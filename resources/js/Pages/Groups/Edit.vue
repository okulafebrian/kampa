<template>
    <Head title="Edit Grup" />

    <AuthenticatedLayout>
        <template #header>
            <div class="font-semibold text-2xl">Edit Grup</div>
        </template>

        <div class="p-24 pt-0 pb-16">
            <div class="border rounded-xl bg-white p-10 space-y-8">
                <div>
                    <div class="font-medium mb-2">
                        Nama Grup <span class="text-red-600">*</span>
                    </div>
                    <InputText type="text" v-model="form.name" class="w-1/3" />
                </div>

                <div class="space-y-2">
                    <div class="text-xl font-medium">
                        Daftar Anggota (pilih anggota untuk menambahkan mereka
                        ke grup ini)
                    </div>

                    <DataTable
                        v-model:selection="form.users"
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
                            <div class="flex gap-4 font-medium">
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
                    </DataTable>
                </div>

                <div class="flex gap-4">
                    <Button
                        label="Batal"
                        severity="secondary"
                        @click="cancel"
                    />
                    <Button label="Simpan" @click="submit" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router, useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import IconField from "primevue/iconfield";
import InputIcon from "primevue/inputicon";
import Dropdown from "primevue/dropdown";
import { ref } from "vue";
import { FilterMatchMode } from "primevue/api";
import Column from "primevue/column";

const props = defineProps(["group", "users", "roles"]);

const form = useForm({
    name: props.group.name,
    users: props.group.users,
});

const filters = ref();

function initFilters() {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
        "role.name": {
            value: null,
            matchMode: FilterMatchMode.EQUALS,
        },
    };
}

initFilters();

function cancel() {
    router.get(route("groups.index"));
}

function submit() {
    form.put(route("groups.update", props.group));
}
</script>

<style lang="scss" scoped></style>
