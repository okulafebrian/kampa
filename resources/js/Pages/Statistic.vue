<template>
    <Head title="Statistik Interaksi" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="font-semibold text-2xl">Statistik</div>
                <button class="bg-white px-4 py-3 rounde-lg border rounded-lg">
                    <span class="font-semibold">30 hari terakhir</span> (11 Mei
                    - 10 Jun 2024)
                    <i class="pi pi-angle-down ms-2"></i>
                </button>
            </div>
        </template>

        <div class="p-24 pt-0 pb-16 space-y-6">
            <div class="border bg-white rounded-lg p-8">
                <div class="grid grid-cols-2 sm:grid-cols-8 gap-8">
                    <div>
                        <div class="mb-2">Percobaan</div>
                        <div class="font-medium text-2xl">
                            {{ interactionsCount }}
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">Terjawab</div>
                        <div class="font-medium text-2xl">
                            {{ answeredCount }}
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">Telepon kembali</div>
                        <div class="font-medium text-2xl">
                            {{ callBackCount }}
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">Tidak tertarik</div>
                        <div class="font-medium text-2xl">
                            {{ notInterestedCount }}
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">Tidak di rumah</div>
                        <div class="font-medium text-2xl">
                            {{ notHomeCount }}
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">Tidak terjangkau</div>
                        <div class="font-medium text-2xl">
                            {{ inaccessibleCount }}
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">Level dukungan</div>
                        <div
                            class="font-medium text-2xl flex items-center gap-2"
                        >
                            {{ avgRating }}
                            <i class="pi pi-star-fill text-lg"></i>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2">Tingkat konversi</div>
                        <div class="font-medium text-2xl">
                            {{ conversionRate }}%
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-8">
                <div class="border bg-white rounded-lg p-8 space-y-6">
                    <div class="text-lg font-medium">
                        Anggota dengan interaksi terbanyak
                    </div>
                    <div class="space-y-3">
                        <div
                            v-for="bestUser in bestUsers"
                            class="flex items-center justify-between"
                        >
                            <div class="text-gray-600">
                                {{ bestUser.full_name }}
                            </div>
                            <div class="text-gray-600 font-medium">
                                {{ bestUser.interactions_count }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border bg-white rounded-lg p-8">
                    <div class="text-lg font-medium mb-6">
                        Daerah dengan level dukungan tertinggi
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">Jatinegara</div>
                            <div class="text-gray-600 font-medium">2.71</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">
                                Kepuluan Seribu Selatan
                            </div>
                            <div class="text-gray-600 font-medium">2.55</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">Tanah Abang</div>
                            <div class="text-gray-600 font-medium">2.09</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">Senen</div>
                            <div class="text-gray-600 font-medium">1.92</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">Tanjung Priok</div>
                            <div class="text-gray-600 font-medium">1.88</div>
                        </div>
                    </div>
                </div>
                <div class="border bg-white rounded-lg p-8">
                    <div class="text-lg font-medium mb-6">
                        Anggota dengan tingkat konversi tertinggi
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">Dian Permata</div>
                            <div class="text-gray-600 font-medium">17.07%</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">Rizky Santoso</div>
                            <div class="text-gray-600 font-medium">0</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">Andi Pratama</div>
                            <div class="text-gray-600 font-medium">0</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">Iriana Palastri</div>
                            <div class="text-gray-600 font-medium">0</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-gray-600">Eka Setiawan</div>
                            <div class="text-gray-600 font-medium">0</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-8">
                <div
                    class="w-[40%] border rounded-xl bg-white px-10 py-8 space-y-8"
                >
                    <div class="text-lg font-medium">Jenis kelamin pemilih</div>
                    <div class="flex gap-10">
                        <Chart
                            type="pie"
                            :data="genderData"
                            :options="genderOptions"
                            class="w-80"
                        />
                        <div class="space-y-6">
                            <div>
                                <div class="font-medium">Laki-Laki</div>
                                <div>24 orang</div>
                            </div>
                            <div>
                                <div class="font-medium">Perempuan</div>
                                <div>17 orang</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="w-[60%] border rounded-xl bg-white px-10 py-8 space-y-8"
                >
                    <div class="text-lg font-medium">Usia pemilih</div>
                    <div class="flex gap-10">
                        <Chart
                            type="bar"
                            :data="ageData"
                            :options="ageOptions"
                            width="700"
                            height="300"
                        />
                        <div class="space-y-6">
                            <div>
                                <div class="font-medium">Umur 17-23</div>
                                <div>2 orang</div>
                            </div>
                            <div>
                                <div class="font-medium">Umur 24-34</div>
                                <div>8 orang</div>
                            </div>
                            <div>
                                <div class="font-medium">Umur 35-44</div>
                                <div>8 orang</div>
                            </div>
                            <div>
                                <div class="font-medium">Umur >45</div>
                                <div>26 orang</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-8">
                <div
                    class="w-[60%] border rounded-xl bg-white px-10 py-8 space-y-8"
                >
                    <div class="text-lg font-medium">
                        5 teratas pekerjaan pemilih
                    </div>
                    <div class="flex gap-10">
                        <Chart
                            type="bar"
                            :data="employmentData"
                            :options="employmentOptions"
                            height="300"
                            width="500"
                        />
                        <div class="space-y-6">
                            <div>
                                <div class="font-medium">Tenaga kesehatan</div>
                                <div>6 orang</div>
                            </div>
                            <div>
                                <div class="font-medium">
                                    Pertanian/Perternakan/Perkebunan
                                </div>
                                <div>5 orang</div>
                            </div>
                            <div>
                                <div class="font-medium">
                                    Agama dan kepercayaan
                                </div>
                                <div>5 orang</div>
                            </div>
                            <div>
                                <div class="font-medium">Pelajar/Mahasiswa</div>
                                <div>4 orang</div>
                            </div>
                            <div>
                                <div class="font-medium">
                                    Aparatur/Pejabat negara
                                </div>
                                <div>3 orang</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="w-[40%] border rounded-xl bg-white px-10 py-8 space-y-8"
                >
                    <div class="text-lg font-medium">Partisipasi pemilih</div>
                    <div class="flex gap-10">
                        <Chart
                            type="pie"
                            :data="volunteeringData"
                            :options="volunteeringOptions"
                            class="w-80"
                        />
                        <div class="space-y-6">
                            <div>
                                <div class="font-medium">Relawan</div>
                                <div>1 orang</div>
                            </div>
                            <div>
                                <div class="font-medium">Saksi</div>
                                <div>0 orang</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { onMounted, ref } from "vue";
import Chart from "primevue/chart";
import { usePage } from "@inertiajs/vue3";

defineProps([
    "auth",
    "interactionsCount",
    "answeredCount",
    "callBackCount",
    "notInterestedCount",
    "notHomeCount",
    "inaccessibleCount",
    "avgRating",
    "conversionRate",
    "bestUsers",
]);

onMounted(() => {
    genderData.value = setGenderData();
    genderOptions.value = setGenderOptions();
    ageData.value = setAgeData();
    ageOptions.value = setAgeOptions();
    employmentData.value = setEmploymentData();
    employmentOptions.value = setEmploymentOptions();
    volunteeringData.value = setVolunteeringData();
    volunteeringOptions.value = setVolunteeringOptions();
});

const genderData = ref();
const genderOptions = ref();

const setGenderData = () => {
    return {
        labels: ["Laki-laki", "Perempuan"],
        datasets: [
            {
                data: [
                    usePage().props.genders["male"],
                    usePage().props.genders["female"],
                ],
                backgroundColor: ["rgb(198 16 16)", "rgb(229 231 235)"],
                hoverBackgroundColor: ["rgb(160 12 12)", "rgb(209 213 219)"],
            },
        ],
    };
};

const setGenderOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue("--text-color");

    return {
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    color: textColor,
                },
            },
        },
    };
};

const ageData = ref();
const ageOptions = ref();

const setAgeData = () => {
    return {
        labels: ["17-23", "24-34", "35-44", ">45"],
        datasets: [
            {
                label: "Usia",
                data: [
                    usePage().props.ages["17-23"],
                    usePage().props.ages["24-34"],
                    usePage().props.ages["35-44"],
                    usePage().props.ages[">45"],
                ],
                backgroundColor: [
                    "rgb(198 16 16)",
                    "rgb(198 16 16)",
                    "rgb(198 16 16)",
                    "rgb(198 16 16)",
                ],
                borderWidth: 0,
            },
        ],
    };
};

const setAgeOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue("--text-color");
    const textColorSecondary = documentStyle.getPropertyValue(
        "--text-color-secondary"
    );
    const surfaceBorder = documentStyle.getPropertyValue("--surface-border");

    return {
        plugins: {
            legend: {
                labels: {
                    color: textColor,
                },
            },
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary,
                },
                grid: {
                    color: surfaceBorder,
                },
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: textColorSecondary,
                },
                grid: {
                    color: surfaceBorder,
                },
            },
        },
    };
};

const employmentData = ref();
const employmentOptions = ref();

const setEmploymentData = () => {
    return {
        labels: [
            usePage().props.employments[0].name,
            usePage().props.employments[1].name,
            usePage().props.employments[2].name,
            usePage().props.employments[3].name,
            usePage().props.employments[4].name,
        ],
        datasets: [
            {
                label: "Pekerjaan",
                data: [
                    usePage().props.employments[0].count,
                    usePage().props.employments[1].count,
                    usePage().props.employments[2].count,
                    usePage().props.employments[3].count,
                    usePage().props.employments[4].count,
                ],
                backgroundColor: [
                    "rgb(229 231 235)",
                    "rgb(229 231 235)",
                    "rgb(229 231 235)",
                    "rgb(229 231 235)",
                ],
                borderWidth: 0,
            },
        ],
    };
};

const setEmploymentOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue("--text-color");

    return {
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    color: textColor,
                },
            },
        },
    };
};

const volunteeringData = ref();
const volunteeringOptions = ref();

const setVolunteeringData = () => {
    return {
        labels: ["Relawan", "Saksi"],
        datasets: [
            {
                data: [1, 0],
                backgroundColor: ["rgb(198 16 16)", "rgb(229 231 235)"],
                hoverBackgroundColor: ["rgb(160 12 12)", "rgb(209 213 219)"],
            },
        ],
    };
};

const setVolunteeringOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue("--text-color");

    return {
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    color: textColor,
                },
            },
        },
    };
};
</script>

<style lang="scss" scoped></style>
