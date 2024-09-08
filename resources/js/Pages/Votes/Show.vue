<template>
    <Head :title="district.name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="font-semibold text-2xl">
                {{ district.name }}
            </div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="flex gap-4">
                <SelectButton
                    v-model="selectedVillage"
                    :options="district.villages"
                    optionLabel="name"
                />
            </div>

            <div class="border rounded-xl bg-white p-8">
                <DataTable :value="pollingStations" dataKey="id">
                    <Column field="name" header="TPS"></Column>
                    <Column
                        field="vote.witness.full_name"
                        header="Saksi"
                    ></Column>
                    <Column field="vote.vote_count" header="Jumlah suara calon">
                        <template #body="{ data }">
                            {{ formattedNumber(data.vote?.vote_count) }}
                        </template>
                    </Column>
                    <Column header="Formulir C1">
                        <template #body="{ data }">
                            <button
                                v-if="data.vote"
                                @click="download(data.vote.attachment)"
                                class="hover:underline"
                            >
                                {{ data.vote.attachment }}
                            </button>
                        </template>
                    </Column>
                    <Column headerStyle="width: 8rem">
                        <template #body="{ data }">
                            <button
                                v-if="data.vote"
                                @click="edit(data)"
                                class="flex p-2 hover:bg-gray-100 hover:text-black rounded-md"
                            >
                                <i class="pi pi-pencil"></i>
                            </button>
                            <button
                                v-else
                                @click="create(data)"
                                class="flex p-2 hover:bg-gray-100 hover:text-black rounded-md"
                            >
                                <i class="pi pi-plus"></i>
                            </button>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>

    <Dialog
        v-model:visible="visible1"
        modal
        :header="selectedPollingStation?.name + ' - Hasil Pemungutan Suara'"
        :style="{ width: '35rem' }"
    >
        <Create
            :pollingStation="selectedPollingStation"
            @close="visible1 = false"
        />
    </Dialog>

    <Dialog
        v-model:visible="visible2"
        modal
        :header="selectedPollingStation?.name + ' - Hasil Pemungutan Suara'"
        :style="{ width: '35rem' }"
    >
        <Edit
            :pollingStation="selectedPollingStation"
            @close="visible2 = false"
        />
    </Dialog>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Dialog from "primevue/dialog";
import SelectButton from "primevue/selectbutton";
import { defineAsyncComponent, onMounted, ref, watch } from "vue";

const props = defineProps(["district"]);

const selectedVillage = ref();
const selectedPollingStation = ref();
const pollingStations = ref();

onMounted(() => {
    selectedVillage.value = props.district.villages[0];
    fetchPollingStations(selectedVillage.value);
});

watch(
    () => selectedVillage.value,
    (newValue) => {
        fetchPollingStations(newValue);
    }
);

function fetchPollingStations(village) {
    axios
        .post(route("geo.polling-stations", village))
        .then((response) => {
            pollingStations.value = response.data;
        })
        .catch((error) => {
            console.error("Error fetching polling stations:", error);
        });
}

function formattedNumber(number) {
    return number ? number.toLocaleString() : null;
}

const visible1 = ref(false);
const visible2 = ref(false);

const Create = defineAsyncComponent(() => import("./Create.vue"));
const Edit = defineAsyncComponent(() => import("./Edit.vue"));

function create(pollingStation) {
    selectedPollingStation.value = pollingStation;
    visible1.value = true;
}

function edit(pollingStation) {
    selectedPollingStation.value = pollingStation;
    visible2.value = true;
}

function download(attachment) {
    axios
        .get(route("attachments.download", { attachment: attachment }), {
            responseType: "blob",
        })
        .then((response) => {
            const blob = new Blob([response.data]);

            const link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = attachment;
            link.click();

            window.URL.revokeObjectURL(link.href);
        })
        .catch((error) => {
            console.error("Download failed:", error);
        });
}
</script>

<style lang="scss" scoped></style>
