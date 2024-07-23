<template>
    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between h-16">
                <div class="shrink-0 flex items-center">
                    <Link :href="route('home')">
                        <ApplicationLogo
                            class="block h-10 w-auto fill-current text-gray-800"
                        />
                    </Link>
                </div>
                <Button label="Donate" />
            </div>
        </div>
    </nav>
</template>

<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import Button from "primevue/button";
import Menu from "primevue/menu";
</script>

<style lang="scss" scoped></style>
