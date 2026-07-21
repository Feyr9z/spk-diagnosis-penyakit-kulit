<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { History, Eye, Trash2, Calendar, User, Activity } from 'lucide-vue-next';

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
            <h2 class="text-2xl font-bold leading-tight text-white flex items-center gap-2">
                <History class="w-6 h-6 text-indigo-400" />
                Riwayat Diagnosis
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-end">
                <Link
                    :href="route('diagnosis.create')"
                    class="flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                >
                    <Activity class="w-4 h-4" /> Diagnosis Baru
                </Link>
            </div>

            <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 shadow-sm backdrop-blur-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700/50">
                        <thead class="bg-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Pasien</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Hasil Diagnosis</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Nilai SPK</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-700/50 bg-transparent">
                            <tr v-for="(item, index) in riwayat" :key="item.id" class="hover:bg-slate-700/20 transition-colors group">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-400">
                                    {{ index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-bold text-white mb-0.5">{{ item.pasien?.nama ?? 'Pasien Dihapus' }}</div>
                                    <div v-if="item.pasien" class="text-xs text-slate-400 flex items-center gap-1">
                                        <User class="w-3 h-3" /> {{ item.pasien.usia }} thn &bull; {{ jenisKelaminLabel(item.pasien.jenis_kelamin) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="font-bold text-indigo-400">{{ item.penyakit?.kode_penyakit ?? '-' }}</span>
                                    <div class="text-slate-300 font-medium">{{ item.penyakit?.nama_penyakit ?? 'Penyakit Dihapus' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-amber-400">
                                    {{ item.nilai_preferensi ? Number(item.nilai_preferensi).toFixed(4) : '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-400">
                                    <div class="flex items-center gap-1.5">
                                        <Calendar class="w-4 h-4 text-slate-500" /> {{ tanggal(item.created_at) }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm">
                                    <template v-if="confirmingDelete === item.id">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-slate-400 text-xs">Yakin?</span>
                                            <button @click="hapus(item.id)" class="text-rose-500 hover:text-rose-400 text-xs font-bold transition-colors">Ya</button>
                                            <button @click="cancelDelete" class="text-slate-400 hover:text-slate-300 text-xs transition-colors">Batal</button>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex items-center justify-center gap-4">
                                            <Link :href="route('riwayat.show', item.id)" class="text-indigo-400 hover:text-indigo-300 transition-colors" title="Lihat Detail">
                                                <Eye class="w-4 h-4" />
                                            </Link>
                                            <button @click="confirmDelete(item.id)" class="text-rose-500 hover:text-rose-400 transition-colors" title="Hapus Riwayat">
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </template>
                                </td>
                            </tr>

                            <tr v-if="riwayat.length === 0">
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <History class="w-8 h-8 opacity-20" />
                                        <p>Belum ada riwayat diagnosis tersimpan.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
