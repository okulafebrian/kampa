<template>
    <div class="space-y-6 mb-10">
        <div class="flex flex-col gap-2">
            <div class="font-medium">
                Nama Depan <span class="text-red-600">*</span>
            </div>
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
            <Calendar
                v-model="form.dob"
                dateFormat="dd M yy"
                showIcon
                fluid
                iconDisplay="input"
            />
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
                :options="$page.props.pollingStations"
                optionLabel="name"
                optionValue="id"
                class="w-48"
            />
        </div>
        <div class="flex flex-col gap-2">
            <div class="font-medium">Pekerjaan</div>
            <Dropdown
                v-model="form.employment_id"
                :options="$page.props.employments"
                optionLabel="name"
                optionValue="id"
            />
        </div>
        <div>
            <div class="font-medium mb-2">
                Relawan <span class="text-red-600">*</span>
            </div>
            <SelectButton
                v-model="form.is_volunteer"
                :options="booleans"
                optionLabel="name"
                optionValue="value"
            />
        </div>
        <div>
            <div class="font-medium mb-2">
                Saksi <span class="text-red-600">*</span>
            </div>
            <SelectButton
                v-model="form.is_witness"
                :options="booleans"
                optionLabel="name"
                optionValue="value"
            />
        </div>
        <div>
            <div class="font-medium mb-2">
                Telah Meninggal <span class="text-red-600">*</span>
            </div>
            <SelectButton
                v-model="form.is_deceased"
                :options="booleans"
                optionLabel="name"
                optionValue="value"
            />
        </div>
    </div>

    <Button class="w-full" label="Simpan" @click="submit" />
</template>

<script setup>
import { router, useForm, usePage } from "@inertiajs/vue3";
import Button from "primevue/button";
import Calendar from "primevue/calendar";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import SelectButton from "primevue/selectbutton";
import { onMounted } from "vue";

const props = defineProps(["contact"]);

const emit = defineEmits(["close"]);

onMounted(() => {
    router.reload({ only: ["employments", "pollingStations"] });

    form.house_id = usePage().props.house.id;
});

const form = useForm({
    house_id: "",
    first_name: "",
    last_name: "",
    gender: "",
    dob: "",
    email: "",
    phone: "",
    polling_station_id: "",
    employment_id: "",
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

function submit() {
    form.post(route("contacts.store"), {
        preserveState: false,
    });
}
</script>

<style lang="scss" scoped></style>
