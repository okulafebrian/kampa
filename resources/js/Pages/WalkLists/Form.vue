<template>
    <div v-if="newList" class="space-y-8">
        <div class="flex flex-col gap-2">
            <div class="font-medium">
                Nama Daftar <span class="text-red-600">*</span>
            </div>
            <InputText v-model="newForm.name" />
        </div>

        <div class="flex flex-col gap-2">
            <div class="font-medium">
                Berikan akses kepada <span class="text-red-600">*</span>
            </div>

            <Dropdown
                v-model="newForm.assignee"
                :options="assignees"
                filter
                optionLabel="label"
                optionGroupLabel="label"
                optionGroupChildren="items"
            >
                <template #optiongroup="slotProps">
                    <div>
                        {{ slotProps.option.label }}
                    </div>
                </template>
            </Dropdown>
        </div>

        <Button label="Simpan" class="w-full" @click="create" />
    </div>

    <div v-else class="space-y-8">
        <div class="flex flex-col gap-2">
            <Dropdown
                v-model="form.walkList"
                :options="$page.props.walkLists"
                optionLabel="name"
                optionValue="id"
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
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";
import { onMounted, ref, watch } from "vue";

const props = defineProps(["contacts"]);

const newForm = useForm({
    name: "",
    assignee: "",
    contacts: props.contacts,
});

const form = useForm({
    walkList_id: "",
    contacts: props.contacts,
});

// const form = useForm({
//     walkList: "",
//     newWalkList: {
//         name: "",
//         assignee: "",
//     },
//     contacts: props.contacts,
// });

const newList = ref(false);

const assignees = ref();

watch(
    () => newList.value,
    () => {
        if (newList.value) {
            axios
                .get(route("geo.assignees"))
                .then((response) => {
                    assignees.value = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching assignees:", error);
                });
        }
    }
);

function create() {
    newForm.post(route("walk-lists.store"), {
        preserveState: false,
    });
}

function update() {
    form.put(route("walk-lists.update", form.walkList_id), {
        preserveState: false,
    });
}
</script>

<style lang="scss" scoped></style>
