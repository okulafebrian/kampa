<template>
    <div class="space-y-8">
        <div class="flex flex-col gap-2">
            <div class="font-medium">Status</div>
            <Dropdown
                v-model="form.status"
                :options="statuses"
                optionLabel="name"
                optionValue="value"
            />
        </div>
        <template v-if="form.status === 'answered'">
            <div class="flex flex-col gap-2">
                <div class="font-medium">Kontak</div>
                <Dropdown
                    v-model="form.contact_id"
                    :options="$page.props.contacts"
                    optionLabel="full_name"
                    optionValue="id"
                />
            </div>
            <div class="flex flex-col gap-2">
                <div class="font-medium">Level dukungan</div>
                <Rating v-model="form.support_level" :cancel="false" />
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
import { router, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

const emit = defineEmits(["close"]);

onMounted(() => {
    router.reload({ only: ["contacts"] });
});

const form = useForm({
    status: "answered",
    contact_id: "",
    support_level: 0,
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
</script>

<style lang="scss" scoped></style>
