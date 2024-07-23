<template>
    <div v-if="newGroup" class="space-y-8">
        <div class="flex flex-col gap-2">
            <div class="font-medium">
                Nama Grup <span class="text-red-600">*</span>
            </div>
            <InputText v-model="form.newGroup.name" />
        </div>

        <Button label="Simpan" class="w-full" @click="create" />
    </div>

    <div v-else class="space-y-8">
        <div class="flex flex-col gap-2">
            <Dropdown
                v-model="form.group"
                :options="$page.props.groups"
                optionLabel="name"
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

        <Button label="Simpan" class="w-full" @click="update" />
    </div>
</template>

<script setup>
import { router, useForm } from "@inertiajs/vue3";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import { onMounted, ref } from "vue";

const props = defineProps(["users"]);

onMounted(() => {
    router.reload({ only: ["walkLists"] });
});

const form = useForm({
    group: "",
    newGroup: {
        name: "",
    },
    users: props.users,
});

const newGroup = ref(false);

function create() {
    form.post(route("groups.store"));
}

function update() {
    form.put(route("groups.update", form.group));
}
</script>

<style lang="scss" scoped></style>
