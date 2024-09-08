<template>
    <div class="space-y-8">
        <div class="flex flex-col gap-2">
            <div>Saksi</div>
            <Dropdown
                v-model="form.witness_id"
                :options="$page.props.users"
                filter
                optionLabel="full_name"
                optionValue="id"
            >
                <template #option="slotProps">
                    {{ slotProps.option.full_name }}
                </template>
            </Dropdown>
        </div>
        <div class="flex flex-col gap-2">
            <div>Jumlah suara calon <span class="text-red-600">*</span></div>
            <InputNumber v-model="form.vote_count" />
        </div>
        <div class="flex flex-col gap-2">
            <div>Lampiran Formulir C1 <span class="text-red-600">*</span></div>
            <div v-if="form.attachment">
                <button
                    @click="form.attachment = null"
                    class="bg-surface-100 hover:bg-surface-200 rounded-md px-3 py-2"
                >
                    <div class="flex items-center gap-3">
                        <div class="truncate">{{ form.attachment.name }}</div>
                        <i class="pi pi-times text-sm"></i>
                    </div>
                </button>
            </div>
            <div v-else class="flex">
                <label
                    for="attach"
                    class="border rounded-md px-3 py-2 cursor-pointer"
                >
                    <div
                        class="flex items-center gap-2 text-primary font-medium"
                    >
                        <i class="pi pi-plus"></i>
                        Tambah File
                    </div>
                </label>
                <input
                    id="attach"
                    type="file"
                    @input="form.attachment = $event.target.files[0]"
                    hidden
                />
            </div>
        </div>

        <Button @click="submit" label="Kirim" class="w-full" />
    </div>
</template>

<script setup>
import { router, useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputNumber from "primevue/inputnumber";
import { onMounted } from "vue";

onMounted(() => {
    router.reload({ only: ["users"] });
});

const props = defineProps(["pollingStation"]);

const emit = defineEmits(["close"]);

const form = useForm({
    polling_station_id: props.pollingStation.id,
    witness_id: "",
    vote_count: 0,
    attachment: "",
});

function submit() {
    form.post(route("votes.store"), {
        preserveState: false,
    });
}
</script>

<style lang="scss" scoped></style>
