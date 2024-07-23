<script setup>
import Navbar from "@/Components/Navbar/Guest.vue";
</script>

<template>
    <div>
        <div class="min-h-screen bg-slate-50">
            <Navbar />

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
