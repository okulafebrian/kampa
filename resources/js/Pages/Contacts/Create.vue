<template>
    <div class="space-y-6 mb-10">
        <div class="flex flex-col gap-2">
            <div class="font-medium">Nama Depan</div>
            <InputText v-model="form.first_name" />
        </div>
        <div class="flex flex-col gap-2">
            <div class="font-medium">Nama Belakang</div>
            <InputText v-model="form.last_name" />
        </div>
        <div>
            <div class="font-medium mb-2">Jenis Kelamin</div>
            <Dropdown
                v-model="form.gender"
                :options="genders"
                optionLabel="name"
                optionValue="value"
                class="w-48"
            />
        </div>
        <div>
            <div class="font-medium mb-2">Tanggal Lahir</div>
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
        <div>
            <div class="font-medium mb-2">TPS</div>
            <Dropdown
                v-model="form.polling_station_id"
                :options="pollingStations"
                optionLabel="name"
                optionValue="value"
                class="w-48"
            />
        </div>
        <div class="flex flex-col gap-2">
            <div class="font-medium">Pekerjaan</div>
            <Dropdown v-model="form.employment" :options="employments" />
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

    <Button class="w-full" label="Simpan" />
</template>

<script setup>
import { router, useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import Calendar from "primevue/calendar";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import SelectButton from "primevue/selectbutton";

const props = defineProps(["contact"]);

const form = useForm({
    first_name: "",
    last_name: "",
    gender: "",
    dob: "",
    email: "",
    phone: "",
    polling_station_id: "",
    employment: "",
    is_volunteer: "",
    is_witness: "",
    is_deceased: "",
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

const employments = [
    "Belum/Tidak bekerja",
    "Aparatur/Pejabat negara",
    "Tenaga pengajar",
    "Wiraswasta",
    "Pertanian/Perternakan/Perkebunan",
    "Nelayan/Perikanan",
    "Agama dan kepercayaan",
    "Pelajar/Mahasiswa",
    "Tenaga kesehatan",
    "Pensiunan",
    "Buruh Harian Lepas",
    "Lainnya",
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
