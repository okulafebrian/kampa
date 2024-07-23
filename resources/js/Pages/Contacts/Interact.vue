<template>
    <div class="space-y-8">
        <div class="flex flex-col gap-2">
            <div class="font-medium">
                Status <span class="text-red-600">*</span>
            </div>
            <Dropdown
                v-model="form.status"
                :options="statuses"
                optionLabel="name"
                optionValue="value"
                lev
            />
        </div>
        <template v-if="form.status === 'answered'">
            <div class="flex flex-col gap-2">
                <div class="font-medium">
                    Level dukungan <span class="text-red-600">*</span>
                </div>
                <Rating v-model="form.support_level" :cancel="false" />
                <div class="text-gray-600">"{{ supportLabel }}""</div>
            </div>
            <div class="flex flex-col gap-2">
                <div class="font-medium">Catatan</div>
                <Textarea v-model="form.notes" rows="5" />
            </div>
        </template>
        <Button @click="submit" class="w-full">Kirim</Button>
    </div>
</template>

<script setup>
import Button from "primevue/button";
import Textarea from "primevue/textarea";
import Rating from "primevue/rating";
import Dropdown from "primevue/dropdown";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref } from "vue";

const emit = defineEmits(["close"]);

onMounted(() => {
    router.reload({ only: ["contacts"] });
});

const form = useForm({
    status: "answered",
    contact_id: usePage().props.contact.id,
    support_level: 5,
    notes: "",
});

const statuses = ref([
    {
        name: "Terjawab",
        value: "answered",
    },
    {
        name: "Telpon Kembali",
        value: "call back",
    },
    {
        name: "Tidak Tertarik",
        value: "not interested",
    },
    {
        name: "Tidak di Rumah",
        value: "not home",
    },
    {
        name: "Tidak Terjangkau",
        value: "inaccessible",
    },
]);

function submit() {
    form.post(route("interactions.store"), {
        onSuccess: () => {
            emit("close");
        },
    });
}

const supportLabel = computed(() => {
    switch (form.support_level) {
        case 1:
            return "Menolak mendukung";
        case 2:
            return "Kurang mendukung";
        case 3:
            return "Pendukung yang masih ragu";
        case 4:
            return "Siap untuk mendukung";
        case 5:
            return "Sangat mendukung";
    }
});
</script>

<style lang="scss" scoped></style>
