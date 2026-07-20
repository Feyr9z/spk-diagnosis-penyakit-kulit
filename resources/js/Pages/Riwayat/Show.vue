<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    diagnosis: {
        type: Object,
        required: true,
    },
});

const confirmingDelete = ref(false);

const hapus = () => {
    router.delete(route('riwayat.destroy', props.diagnosis.id), {
        onSuccess: () => {
            confirmingDelete.value = false;
        },
    });
};

const jenisKelaminLabel = (jk) => jk === 'L' ? 'Laki-laki' : 'Perempuan';

const tanggal = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <Head title="Detail Riwayat Diagnosis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Detail Riwayat Diagnosis
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8 space-y-6">

                <!-- Hasil Utama -->
                <div class="bg-indigo-600 text-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-indigo-200 mb-1">Hasil Diagnosis</p>
                        <h3 class="text-2xl font-bold">{{ diagnosis.penyakit.nama }}</h3>
                        <p class="mt-1 text-sm text-indigo-200">
                            Kode: {{ diagnosis.penyakit.kode }}
                            &nbsp;·&nbsp;
                            Nilai Akhir: {{ Number(diagnosis.nilai_akhir).toFixed(4) }}
                        </p>
                    </div>
                </div>

                <!-- Deskripsi & Solusi -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="mb-2 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Deskripsi Penyakit
                            </h4>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                {{ diagnosis.penyakit.deskripsi }}
                            </p>
                        </div>
                    </div>
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="mb-2 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                                Saran Penanganan
                            </h4>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                {{ diagnosis.penyakit.solusi }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Data Pasien -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="mb-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Data Pasien
                        </h4>
                        <dl class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                            <div>
                                <dt class="text-xs text-gray-500">Nama</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-900">{{ diagnosis.nama_pasien }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Usia</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-900">{{ diagnosis.usia }} tahun</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Jenis Kelamin</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-900">{{ jenisKelaminLabel(diagnosis.jenis_kelamin) }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs text-gray-500">Tanggal Diagnosis</dt>
                                <dd class="mt-1 text-sm font-medium text-gray-900">{{ tanggal(diagnosis.created_at) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Gejala yang Dipilih -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="mb-4 text-sm font-semibold text-gray-600 uppercase tracking-wider">
                            Gejala yang Dipilih
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="detail in diagnosis.details"
                                :key="detail.id"
                                class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-xs font-medium text-indigo-800"
                            >
                                {{ detail.gejala.kode }} — {{ detail.gejala.nama }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between">
                    <Link
                        :href="route('riwayat.index')"
                        class="rounded-md border px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                    >
                        ← Kembali ke Riwayat
                    </Link>

                    <div class="flex gap-3">
                        <!-- Konfirmasi hapus -->
                        <template v-if="confirmingDelete">
                            <span class="self-center text-sm text-gray-600">Yakin hapus riwayat ini?</span>
                            <button
                                @click="hapus"
                                class="rounded-md bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700"
                            >
                                Ya, Hapus
                            </button>
                            <button
                                @click="confirmingDelete = false"
                                class="rounded-md border px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                            >
                                Batal
                            </button>
                        </template>

                        <button
                            v-else
                            @click="confirmingDelete = true"
                            class="rounded-md bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700"
                        >
                            Hapus Riwayat
                        </button>
                    </div>
                </div>

                <!-- Disclaimer -->
                <p class="text-center text-xs text-gray-400">
                    Hasil diagnosis ini bersifat pendukung keputusan dan tidak menggantikan keputusan dokter.
                </p>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
