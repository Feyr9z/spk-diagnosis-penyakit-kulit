<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    riwayat: {
        type: Array,
        required: true,
    },
});

const confirmingDelete = ref(null);

const confirmDelete = (id) => {
    confirmingDelete.value = id;
};

const cancelDelete = () => {
    confirmingDelete.value = null;
};

const hapus = (id) => {
    router.delete(route('riwayat.destroy', id), {
        preserveScroll: true,
        onFinish: () => {
            confirmingDelete.value = null;
        },
    });
};

const tanggal = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};

const jenisKelaminLabel = (jk) => jk === 'L' ? 'Laki-laki' : 'Perempuan';
</script>

<template>
    <Head title="Riwayat Diagnosis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Riwayat Diagnosis
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <div class="mb-6 flex justify-end">
                            <Link
                                :href="route('diagnosis.create')"
                                class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700"
                            >
                                Diagnosis Baru
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama Pasien</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Usia / JK</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Hasil Diagnosis</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nilai Akhir</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tanggal</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="(item, index) in riwayat" :key="item.id">
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ item.pasien.nama }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                            {{ item.pasien.usia }} thn / {{ jenisKelaminLabel(item.pasien.jenis_kelamin) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <span class="font-medium text-gray-900">{{ item.penyakit.kode_penyakit }}</span>
                                            — {{ item.penyakit.nama_penyakit }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                            {{ Number(item.nilai_preferensi).toFixed(4) }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                            {{ tanggal(item.created_at) }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-center text-sm">

                                            <template v-if="confirmingDelete === item.id">
                                                <span class="mr-2 text-gray-600 text-xs">Yakin hapus?</span>
                                                <button
                                                    @click="hapus(item.id)"
                                                    class="mr-2 text-red-600 hover:underline text-xs font-semibold"
                                                >
                                                    Ya
                                                </button>
                                                <button
                                                    @click="cancelDelete"
                                                    class="text-gray-500 hover:underline text-xs"
                                                >
                                                    Batal
                                                </button>
                                            </template>

                                            <template v-else>
                                                <Link
                                                    :href="route('riwayat.show', item.id)"
                                                    class="mr-3 text-indigo-600 hover:underline text-sm"
                                                >
                                                    Detail
                                                </Link>
                                                <button
                                                    @click="confirmDelete(item.id)"
                                                    class="text-red-600 hover:underline text-sm"
                                                >
                                                    Hapus
                                                </button>
                                            </template>

                                        </td>
                                    </tr>

                                    <tr v-if="riwayat.length === 0">
                                        <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                            Belum ada riwayat diagnosis.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
