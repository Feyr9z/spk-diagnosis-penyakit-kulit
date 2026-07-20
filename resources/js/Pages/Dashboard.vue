<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    stats: {
        type: Object,
        required: true,
    },
    diagnosis_terbaru: {
        type: Array,
        required: true,
    },
    penyakit_terbanyak: {
        type: Array,
        required: true,
    },
});

const tanggal = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};

const jenisKelaminLabel = (jk) => jk === 'L' ? 'L' : 'P';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                <!-- Statistik -->
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

                    <div class="rounded-lg bg-indigo-600 p-5 text-white shadow-sm">
                        <p class="text-sm text-indigo-200">Total Diagnosis</p>
                        <p class="mt-1 text-3xl font-bold">{{ stats.total_diagnosis }}</p>
                    </div>

                    <div class="rounded-lg bg-white p-5 shadow-sm">
                        <p class="text-sm text-gray-500">Total Penyakit</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ stats.total_penyakit }}</p>
                    </div>

                    <div class="rounded-lg bg-white p-5 shadow-sm">
                        <p class="text-sm text-gray-500">Total Gejala</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ stats.total_gejala }}</p>
                    </div>

                    <div class="rounded-lg bg-white p-5 shadow-sm">
                        <p class="text-sm text-gray-500">Total Pengguna</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">{{ stats.total_user }}</p>
                    </div>

                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                    <!-- Diagnosis Terbaru -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="mb-4 flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                    Diagnosis Terbaru
                                </h3>
                                <Link
                                    :href="route('riwayat.index')"
                                    class="text-xs text-indigo-600 hover:underline"
                                >
                                    Lihat semua →
                                </Link>
                            </div>

                            <div v-if="diagnosis_terbaru.length > 0" class="space-y-3">
                                <div
                                    v-for="item in diagnosis_terbaru"
                                    :key="item.id"
                                    class="flex items-center justify-between rounded-md border px-4 py-3"
                                >
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ item.nama_pasien }}</p>
                                        <p class="text-xs text-gray-500">{{ item.penyakit.nama }}</p>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ tanggal(item.created_at) }}</span>
                                </div>
                            </div>

                            <p v-else class="text-sm text-gray-400 text-center py-4">
                                Belum ada data diagnosis.
                            </p>

                            <div class="mt-4">
                                <Link
                                    :href="route('diagnosis.create')"
                                    class="block w-full rounded-md bg-indigo-600 py-2 text-center text-sm text-white hover:bg-indigo-700"
                                >
                                    + Diagnosis Baru
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Penyakit Terbanyak Terdiagnosis -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="mb-4 text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Penyakit Terbanyak Terdiagnosis
                            </h3>

                            <div v-if="penyakit_terbanyak.length > 0" class="space-y-3">
                                <div
                                    v-for="item in penyakit_terbanyak"
                                    :key="item.penyakit_id"
                                    class="flex items-center justify-between rounded-md border px-4 py-3"
                                >
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ item.penyakit.nama }}</p>
                                        <p class="text-xs text-gray-500">{{ item.penyakit.kode }}</p>
                                    </div>
                                    <span class="rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-medium text-indigo-800">
                                        {{ item.total }}×
                                    </span>
                                </div>
                            </div>

                            <p v-else class="text-sm text-gray-400 text-center py-4">
                                Belum ada data diagnosis.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Shortcut Menu -->
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                    <Link
                        :href="route('gejala.index')"
                        class="rounded-lg border bg-white p-4 text-center text-sm text-gray-700 shadow-sm hover:border-indigo-500 hover:text-indigo-600 transition"
                    >
                        Master Gejala
                    </Link>
                    <Link
                        :href="route('penyakit.index')"
                        class="rounded-lg border bg-white p-4 text-center text-sm text-gray-700 shadow-sm hover:border-indigo-500 hover:text-indigo-600 transition"
                    >
                        Master Penyakit
                    </Link>
                    <Link
                        :href="route('nilai-kecocokan.index')"
                        class="rounded-lg border bg-white p-4 text-center text-sm text-gray-700 shadow-sm hover:border-indigo-500 hover:text-indigo-600 transition"
                    >
                        Nilai Kecocokan
                    </Link>
                    <Link
                        :href="route('diagnosis.create')"
                        class="rounded-lg border bg-white p-4 text-center text-sm text-gray-700 shadow-sm hover:border-indigo-500 hover:text-indigo-600 transition"
                    >
                        Diagnosis
                    </Link>
                    <Link
                        :href="route('riwayat.index')"
                        class="rounded-lg border bg-white p-4 text-center text-sm text-gray-700 shadow-sm hover:border-indigo-500 hover:text-indigo-600 transition"
                    >
                        Riwayat
                    </Link>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
