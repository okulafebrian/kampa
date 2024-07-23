<template>
    <Head title="Tambah Rumah" />

    <AuthenticatedLayout>
        <template #header>
            <div class="font-semibold text-2xl">Tambah Rumah</div>
        </template>

        <div class="p-24 pt-0 pb-16">
            <div class="border rounded-xl bg-white p-10 space-y-8">
                <div class="grid grid-cols-3 gap-8">
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Provinsi <span class="text-red-600">*</span>
                        </div>
                        <Dropdown
                            v-model="form.province_id"
                            :options="provinces"
                            optionLabel="name"
                            optionValue="id"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Kabupaten/kota <span class="text-red-600">*</span>
                        </div>
                        <Dropdown
                            v-model="form.regency_id"
                            :options="regencies"
                            optionLabel="name"
                            optionValue="id"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Kecamatan <span class="text-red-600">*</span>
                        </div>
                        <Dropdown
                            v-model="form.district_id"
                            :options="districts"
                            optionLabel="name"
                            optionValue="id"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Kelurahan <span class="text-red-600">*</span>
                        </div>
                        <Dropdown
                            v-model="form.village_id"
                            :options="villages"
                            optionLabel="name"
                            optionValue="id"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Nama Jalan <span class="text-red-600">*</span>
                        </div>
                        <AutoComplete
                            v-model="form.street"
                            :suggestions="filteredStreets"
                            @complete="searchStreet"
                            optionLabel="name"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Nomor Rumah <span class="text-red-600">*</span>
                        </div>
                        <InputText v-model="form.house_number" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">RT/RW</div>
                        <InputMask v-model="form.neighborhood" mask="999/999" />
                    </div>
                    <div class="flex-1 flex flex-col gap-2">
                        <div class="font-medium">Nama Rumah</div>
                        <InputText v-model="form.house_name" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">Unit Rumah</div>
                        <InputText v-model="form.house_unit" />
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
import AutoComplete from "primevue/autocomplete";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputMask from "primevue/inputmask";
import InputText from "primevue/inputtext";
import { ref, watch } from "vue";

const props = defineProps(["provinces"]);

const form = useForm({
    province_id: "",
    regency_id: "",
    district_id: "",
    village_id: "",
    street: "",
    house_number: "",
    house_name: "",
    house_unit: "",
    neighborhood: "",
});

const regencies = ref();
const districts = ref();
const villages = ref();
const streets = ref();
const filteredStreets = ref();

watch(
    () => form.province_id,
    (newValue) => {
        axios
            .post(route("geo.regencies", newValue))
            .then((response) => {
                regencies.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching regencies:", error);
            });
    }
);

watch(
    () => form.regency_id,
    (newValue) => {
        axios
            .post(route("geo.districts", newValue))
            .then((response) => {
                districts.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching districts:", error);
            });
    }
);

watch(
    () => form.district_id,
    (newValue) => {
        axios
            .post(route("geo.villages", newValue))
            .then((response) => {
                villages.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching villages:", error);
            });
    }
);

watch(
    () => form.village_id,
    (newValue) => {
        axios
            .post(route("geo.streets", newValue))
            .then((response) => {
                streets.value = response.data;
            })
            .catch((error) => {
                console.error("Error fetching streets:", error);
            });
    }
);

function searchStreet(event) {
    setTimeout(() => {
        if (!event.query.trim().length) {
            filteredStreets.value = [...streets.value];
        } else {
            filteredStreets.value = streets.value.filter((street) => {
                return street.name
                    .toLowerCase()
                    .startsWith(event.query.toLowerCase());
            });
        }
    }, 250);
}

function cancel() {
    router.get(route("houses.index"));
}

function submit() {
    form.post(route("houses.store"));
}
</script>

<style lang="scss" scoped></style>
