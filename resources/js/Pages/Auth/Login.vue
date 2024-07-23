<script setup>
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import Password from "primevue/password";
import Button from "primevue/button";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Masuk" />

    <div
        class="min-h-screen bg-slate-50 flex flex-col items-center justify-center"
    >
        <div class="w-[30%]">
            <div class="border bg-white rounded-lg px-20 py-14 space-y-8">
                <Link :href="route('home')" class="flex">
                    <ApplicationLogo class="h-16" />
                </Link>

                <form @submit.prevent="submit">
                    <div class="flex flex-col gap-2 mb-8">
                        <div class="font-medium">Email</div>
                        <InputText type="email" v-model="form.email" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="flex flex-col gap-2 mb-14">
                        <div class="font-medium">Kata Sandi</div>
                        <Password v-model="form.password" :feedback="false" />
                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <div class="flex flex-col">
                        <Button type="submit" label="Masuk" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
