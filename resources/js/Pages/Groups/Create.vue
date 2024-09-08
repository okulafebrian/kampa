<template>
    <div v-if="newGroup" class="space-y-8">
        <div class="flex flex-col gap-2">
            <div class="font-medium">
                Nama Grup <span class="text-red-600">*</span>
            </div>
            <InputText v-model="newForm.name" />
        </div>

        <Button label="Simpan" class="w-full" @click="create" />
    </div>

    <div v-else class="space-y-8">
        <div class="flex flex-col gap-2">
            <Dropdown
                v-model="form.group_id"
                :options="$page.props.groups"
                optionLabel="name"
                optionValue="id"
                placeholder="Pilih grup"
            />
            <div>
                Tidak menemukan?
                <button
                    @click="newGroup = true"
                    class="font-medium text-primary-500 hover:underline"
                >
                    Buat Grup baru
                </button>
            </div>
        </div>

        <Button label="Simpan" class="w-full" @click="assign" />
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import { ref } from "vue";

const props = defineProps(["users"]);

const newForm = useForm({
    name: "",
    users: props.users,
});

const form = useForm({
    group_id: "",
    users: props.users,
});

const newGroup = ref(false);

function create() {
    newForm.post(route("groups.store"), {
        preserveState: false,
    });
}

function assign() {
    form.put(route("groups.assign", form.group_id), {
        preserveState: false,
    });
}
</script>

<style lang="scss" scoped></style>
