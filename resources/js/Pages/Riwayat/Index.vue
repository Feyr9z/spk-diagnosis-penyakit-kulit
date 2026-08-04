<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { History, Eye, Trash2, Calendar, User, Activity, AlertTriangle } from 'lucide-vue-next';

defineProps({
    riwayat: {
        type: Array,
        required: true,
    },
});

const confirmingDelete = ref(null);

const confirmDelete = (item) => {
    confirmingDelete.value = item;
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
            <h2 class="text-2xl font-bold leading-tight text-slate-900 dark:text-white flex items-center gap-2">
                <History class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                Riwayat Diagnosis
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-end">
                <Link
                    :href="route('diagnosis.create')"
                    class="flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-500 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600"
                >
                    <Activity class="w-4 h-4" /> Diagnosis Baru
                </Link>
            </div>

            <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl overflow-hidden transition-colors">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/80 dark:divide-slate-700/50">
                        <thead class="bg-slate-100/80 dark:bg-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Pasien</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Hasil Diagnosis</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Nilai SPK</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Tanggal</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200/80 dark:divide-slate-700/50 bg-transparent">
                            <tr v-for="(item, index) in riwayat" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors group">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-slate-500 dark:text-slate-400">
                                    {{ index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="font-extrabold text-slate-900 dark:text-white mb-0.5">{{ item.pasien?.nama ?? 'Pasien Dihapus' }}</div>
                                    <div v-if="item.pasien" class="text-xs font-medium text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                        <User class="w-3 h-3" /> {{ item.pasien.usia }} thn &bull; {{ jenisKelaminLabel(item.pasien.jenis_kelamin) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="font-extrabold text-emerald-600 dark:text-emerald-400">{{ item.penyakit?.kode_penyakit ?? '-' }}</span>
                                    <div class="text-slate-700 dark:text-slate-300 font-medium">{{ item.penyakit?.nama_penyakit ?? 'Penyakit Dihapus' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-extrabold text-amber-600 dark:text-amber-400">
                                    {{ item.nilai_preferensi ? Number(item.nilai_preferensi).toFixed(4) : '-' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-500 dark:text-slate-400">
                                    <div class="flex items-center gap-1.5">
                                        <Calendar class="w-4 h-4 text-slate-400 dark:text-slate-500" /> {{ tanggal(item.created_at) }}
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <Link
                                            :href="route('riwayat.show', item.id)"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-500 transition-all"
                                        >
                                            <Eye class="w-3.5 h-3.5" />
                                            Detail
                                        </Link>
                                        <button
                                            @click="confirmDelete(item)"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 dark:border-rose-500/30 bg-rose-50 dark:bg-rose-500/10 px-3 py-1.5 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-500/20 hover:border-rose-300 dark:hover:border-rose-500/50 transition-all"
                                        >
                                            <Trash2 class="w-3.5 h-3.5" />
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr v-if="riwayat.length === 0">
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <History class="w-8 h-8 opacity-20" />
                                        <p class="font-medium">Belum ada riwayat diagnosis tersimpan.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div v-if="confirmingDelete" class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="cancelDelete">
                <div class="absolute inset-0 bg-slate-900/50 dark:bg-slate-900/70 backdrop-blur-sm"></div>
                <div class="relative w-full max-w-md rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl p-6 space-y-5">
                    <div class="flex items-start gap-4">
                        <div class="shrink-0 w-11 h-11 rounded-full bg-rose-100 dark:bg-rose-500/20 flex items-center justify-center">
                            <AlertTriangle class="w-5 h-5 text-rose-600 dark:text-rose-400" />
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">Hapus Riwayat Diagnosis</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tindakan ini tidak dapat dibatalkan. Riwayat berikut akan dihapus permanen:</p>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 p-4 space-y-1">
                        <p class="font-bold text-slate-900 dark:text-white">{{ confirmingDelete.pasien?.nama ?? 'Pasien Dihapus' }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                            {{ confirmingDelete.pasien ? `${confirmingDelete.pasien.usia} thn · ${confirmingDelete.pasien.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}` : '—' }}
                        </p>
                        <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 pt-1">
                            Diagnosis: {{ confirmingDelete.penyakit?.nama_penyakit ?? 'Penyakit Dihapus' }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ tanggal(confirmingDelete.created_at) }}</p>
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <button @click="cancelDelete" class="rounded-xl border border-slate-300 dark:border-slate-600 bg-transparent px-5 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Batal</button>
                        <button @click="hapus(confirmingDelete.id)" class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-rose-700 transition-colors">
                            <Trash2 class="w-4 h-4" /> Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </Transition>

    </AuthenticatedLayout>
</template>
