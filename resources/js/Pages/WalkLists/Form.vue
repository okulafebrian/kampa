<template>
    <div v-if="newList" class="space-y-8">
        <div class="flex flex-col gap-2">
            <div class="font-medium">
                Nama Daftar <span class="text-red-600">*</span>
            </div>
            <InputText v-model="form.newWalkList.name" />
        </div>

        <div class="flex flex-col gap-2">
            <div class="font-medium">
                Berikan akses kepada <span class="text-red-600">*</span>
            </div>
            <AutoComplete
                v-model="form.assignee"
                :suggestions="$page.props.walklists"
                placeholder="Ketik nama"
            />
        </div>

        <Button label="Simpan" class="w-full" @click="create" />
    </div>

    <div v-else class="space-y-8">
        <div class="flex flex-col gap-2">
            <Dropdown
                v-model="form.walkList"
                :options="$page.props.walkLists"
                optionLabel="name"
                placeholder="Pilih daftar"
            />
            <div>
                Tidak menemukan?
                <button
                    @click="newList = true"
                    class="font-medium text-primary-500 hover:underline"
                >
                    Buat Daftar baru
                </button>
            </div>
        </div>

        <Button label="Simpan" class="w-full" @click="update" />
    </div>
</template>

<script setup>
import { router, useForm } from "@inertiajs/vue3";
import AutoComplete from "primevue/autocomplete";
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import { onMounted, ref } from "vue";

const props = defineProps(["contacts"]);

onMounted(() => {
    router.reload({ only: ["walkLists"] });
});

const form = useForm({
    walkList: "",
    newWalkList: {
        name: "",
        assignee: "",
    },
    contacts: props.contacts,
});

const newList = ref(false);

function create() {
    form.post(route("walk-lists.store"));
}

function update() {
    form.put(route("walk-lists.update", form.walkList));
}
</script>

<style lang="scss" scoped></style>
