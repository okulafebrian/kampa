<template>
    <Head title="Edit Anggota" />

    <AuthenticatedLayout>
        <template #header>
            <div class="font-semibold text-2xl">Edit Anggota</div>
        </template>

        <div class="p-24 pt-0 pb-16">
            <div class="border rounded-xl bg-white p-10 space-y-8">
                <div class="grid grid-cols-3 gap-8">
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Nama Depan <span class="text-red-600">*</span>
                        </div>
                        <InputText type="text" v-model="form.first_name" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Nama Belakang <span class="text-red-600">*</span>
                        </div>
                        <InputText type="text" v-model="form.last_name" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Email <span class="text-red-600">*</span>
                        </div>
                        <InputText type="email" v-model="form.email" />
                        <div class="text-gray-600 text-sm">
                            Undangan akan dikirimkan ke email ini
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">Nomor HP</div>
                        <InputText type="text" v-model="form.phone" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">
                            Akses <span class="text-red-600">*</span>
                        </div>
                        <Dropdown
                            v-model="form.role_id"
                            :options="roles"
                            optionLabel="name"
                            optionValue="id"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="font-medium">Grup</div>
                        <Dropdown
                            v-model="form.group_id"
                            :options="groups"
                            optionLabel="name"
                            optionValue="id"
                        />
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
import Button from "primevue/button";
import Dropdown from "primevue/dropdown";
import InputText from "primevue/inputtext";

const props = defineProps(["user", "roles", "groups"]);

const form = useForm({
    first_name: props.user.first_name,
    last_name: props.user.last_name,
    email: props.user.email,
    phone: props.user.phone,
    role_id: props.user.role.id,
    group_id: props.user.group.id,
});

function cancel() {
    router.get(route("users.show", props.user));
}

function submit() {
    form.put(route("users.update", props.user));
}
</script>

<style lang="scss" scoped></style>
