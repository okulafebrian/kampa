<template>
    <Head title="Edit Kontak" />

    <AuthenticatedLayout>
        <template #header>
            <div class="font-semibold text-2xl">Edit Kontak</div>
        </template>

        <div class="p-24 pt-0 pb-16">
            <div class="border rounded-xl bg-white p-10 space-y-8">
                <div class="grid grid-cols-3 gap-8">
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">Nama Depan</div>
                        <InputText v-model="form.first_name" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">Nama Belakang</div>
                        <InputText v-model="form.last_name" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">Jenis Kelamin</div>
                        <Dropdown
                            v-model="form.gender"
                            :options="genders"
                            optionLabel="name"
                            optionValue="value"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">Tanggal Lahir</div>
                        <Calendar v-model="form.dob" dateFormat="dd M yy" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium mb-1">Email</div>
                        <InputText v-model="form.email" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">Nomor HP</div>
                        <InputText v-model="form.phone" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium mb-1">TPS</div>
                        <Dropdown
                            v-model="form.polling_station_id"
                            :options="pollingStations"
                            optionLabel="id"
                            optionValue="id"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">Pekerjaan</div>
                        <Dropdown
                            v-model="form.employment_id"
                            :options="employments"
                            optionLabel="name"
                            optionValue="id"
                        />
                    </div>
                    <div>
                        <div class="font-medium mb-2">Relawan</div>
                        <SelectButton
                            v-model="form.is_volunteer"
                            :options="booleans"
                            optionLabel="name"
                            optionValue="value"
                        />
                    </div>
                    <div>
                        <div class="font-medium mb-2">Saksi</div>
                        <SelectButton
                            v-model="form.is_witness"
                            :options="booleans"
                            optionLabel="name"
                            optionValue="value"
                        />
                    </div>
                    <div>
                        <div class="font-medium mb-2">Telah Meninggal</div>
                        <SelectButton
                            v-model="form.is_deceased"
                            :options="booleans"
                            optionLabel="name"
                            optionValue="value"
                        />
                    </div>
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
import Calendar from "primevue/calendar";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import SelectButton from "primevue/selectbutton";

const props = defineProps(["contact", "employments", "pollingStations"]);

const form = useForm({
    first_name: props.contact.first_name,
    last_name: props.contact.last_name,
    gender: props.contact.gender,
    dob: new Date(props.contact.dob),
    email: props.contact.email,
    phone: props.contact.phone,
    polling_station_id: props.contact.pollingStation?.id,
    employment_id: props.contact.employment.id,
    is_volunteer: props.contact.is_volunteer,
    is_witness: props.contact.is_witness,
    is_deceased: props.contact.is_deceased,
});

const genders = [
    {
        name: "Laki-laki",
        value: "male",
    },
    {
        name: "Perempuan",
        value: "female",
    },
];

const booleans = [
    {
        name: "Iya",
        value: 1,
    },
    {
        name: "Tidak",
        value: 0,
    },
];

function cancel() {
    router.get(route("contacts.show", props.contact));
}

function submit() {
    router.put(route("contacts.update", props.contact));
}
</script>

<style lang="scss" scoped></style>
