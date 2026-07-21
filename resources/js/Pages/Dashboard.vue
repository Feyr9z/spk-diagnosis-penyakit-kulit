<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { LayoutDashboard, Users, Activity, ListTodo, ClipboardList, Database, History, ArrowRight, User } from 'lucide-vue-next';

defineProps({
    stats: {
        type: Object,
        required: true,
    },
    diagnosis_terbaru: {
        type: Array,
        default: () => [],
    },
    penyakit_terbanyak: {
        type: Array,
        default: () => [],
    },
});

const tanggal = (dateStr) => {
    return new Date(dateStr).toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-slate-900 dark:text-white flex items-center gap-2">
                <LayoutDashboard class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                Dashboard SPK SAW
            </h2>
        </template>

        <div class="space-y-6">
            <!-- Stats Row -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="relative overflow-hidden rounded-2xl border border-indigo-200 dark:border-indigo-500/30 bg-indigo-50/50 dark:bg-indigo-500/10 p-6 shadow-sm backdrop-blur-xl group transition-all hover:-translate-y-1 hover:shadow-md">
                    <div class="absolute -right-4 -top-4 text-indigo-600/10 dark:text-indigo-500/10 group-hover:scale-110 transition-transform duration-500">
                        <Activity class="w-32 h-32" />
                    </div>
                    <p class="text-sm font-medium text-indigo-600/80 dark:text-indigo-300 relative z-10">Total Diagnosis</p>
                    <p class="mt-2 text-4xl font-extrabold text-indigo-700 dark:text-white relative z-10">{{ stats.total_diagnosis }}</p>
                </div>

                <div class="relative overflow-hidden rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 p-6 shadow-sm backdrop-blur-xl group transition-all hover:-translate-y-1 hover:shadow-md">
                    <div class="absolute -right-4 -top-4 text-slate-100 dark:text-slate-700/50 group-hover:scale-110 transition-transform duration-500">
                        <ListTodo class="w-32 h-32" />
                    </div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 relative z-10">Total Kriteria (Gejala)</p>
                    <p class="mt-2 text-4xl font-extrabold text-slate-800 dark:text-white relative z-10">{{ stats.total_gejala }}</p>
                </div>

                <div class="relative overflow-hidden rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 p-6 shadow-sm backdrop-blur-xl group transition-all hover:-translate-y-1 hover:shadow-md">
                    <div class="absolute -right-4 -top-4 text-slate-100 dark:text-slate-700/50 group-hover:scale-110 transition-transform duration-500">
                        <Database class="w-32 h-32" />
                    </div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 relative z-10">Total Alternatif (Penyakit)</p>
                    <p class="mt-2 text-4xl font-extrabold text-slate-800 dark:text-white relative z-10">{{ stats.total_penyakit }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Diagnosis Terbaru -->
                <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl flex flex-col transition-colors">
                    <div class="p-6 border-b border-slate-200/60 dark:border-slate-700/50 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider flex items-center gap-2">
                            <Activity class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                            Diagnosis Terbaru
                        </h3>
                        <Link :href="route('riwayat.index')" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 flex items-center gap-1 transition-colors">
                            Lihat semua <ArrowRight class="w-3 h-3" />
                        </Link>
                    </div>

                    <div class="p-6 flex-1">
                        <div v-if="diagnosis_terbaru.length > 0" class="space-y-4">
                            <div v-for="item in diagnosis_terbaru" :key="item.id" class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ item.pasien?.nama || item.nama_pasien || 'Pasien Dihapus' }}</p>
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-500">{{ item.penyakit?.nama_penyakit || item.penyakit?.nama || 'Penyakit Dihapus' }}</p>
                                </div>
                                <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-700/30 border border-slate-200 dark:border-slate-600/30 px-2 py-1 rounded-md">
                                    {{ tanggal(item.created_at) }}
                                </span>
                            </div>
                        </div>
                        <div v-else class="h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 py-8">
                            <Activity class="w-12 h-12 mb-3 opacity-20" />
                            <p class="text-sm font-medium">Belum ada data diagnosis.</p>
                        </div>
                    </div>

                    <div class="p-4 border-t border-slate-200/60 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/30 rounded-b-2xl">
                        <Link :href="route('diagnosis.create')" class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-50 dark:bg-indigo-600/10 px-4 py-2.5 text-sm font-bold text-indigo-600 dark:text-indigo-400 transition-colors hover:bg-indigo-100 dark:hover:bg-indigo-600/20">
                            + Mulai Diagnosis SAW
                        </Link>
                    </div>
                </div>

                <!-- Penyakit Terbanyak Terdiagnosis -->
                <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl flex flex-col transition-colors">
                    <div class="p-6 border-b border-slate-200/60 dark:border-slate-700/50">
                        <h3 class="text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider flex items-center gap-2">
                            <Database class="w-4 h-4 text-cyan-600 dark:text-cyan-400" />
                            Leaderboard Penyakit Dominan
                        </h3>
                    </div>

                    <div class="p-6 flex-1">
                        <div v-if="penyakit_terbanyak.length > 0" class="space-y-4">
                            <div v-for="(item, index) in penyakit_terbanyak" :key="item.penyakit_id" class="flex items-center justify-between p-3 rounded-xl bg-slate-50/80 dark:bg-slate-800/50 border border-slate-200/80 dark:border-slate-700/30 hover:border-slate-300 dark:hover:border-slate-600/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-600 dark:text-slate-300">
                                        #{{ index + 1 }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ item.penyakit?.nama_penyakit || item.penyakit?.nama || 'Penyakit Dihapus' }}</p>
                                        <p class="text-xs font-medium text-slate-500">{{ item.penyakit?.kode_penyakit || item.penyakit?.kode || '-' }}</p>
                                    </div>
                                </div>
                                <span class="rounded-lg bg-cyan-50 dark:bg-cyan-500/10 border border-cyan-200 dark:border-cyan-500/20 px-3 py-1 text-xs font-extrabold text-cyan-700 dark:text-cyan-400 shadow-sm">
                                    {{ item.total }} Kasus
                                </span>
                            </div>
                        </div>
                        <div v-else class="h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 py-8">
                            <Database class="w-12 h-12 mb-3 opacity-20" />
                            <p class="text-sm font-medium">Data leaderboard belum tersedia.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shortcut Menu -->
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5 pt-2">
                <Link :href="route('gejala.index')" class="flex flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/60 dark:bg-slate-800/30 p-6 transition-all hover:bg-white dark:hover:bg-slate-800 hover:border-indigo-300 dark:hover:border-indigo-500/50 group shadow-sm hover:shadow-md">
                    <ListTodo class="w-8 h-8 text-slate-400 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors" />
                    <span class="text-sm font-bold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Data Kriteria</span>
                </Link>
                <Link :href="route('penyakit.index')" class="flex flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/60 dark:bg-slate-800/30 p-6 transition-all hover:bg-white dark:hover:bg-slate-800 hover:border-cyan-300 dark:hover:border-cyan-500/50 group shadow-sm hover:shadow-md">
                    <Database class="w-8 h-8 text-slate-400 dark:text-slate-400 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors" />
                    <span class="text-sm font-bold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Data Alternatif</span>
                </Link>
                <Link :href="route('nilai-kecocokan.index')" class="flex flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/60 dark:bg-slate-800/30 p-6 transition-all hover:bg-white dark:hover:bg-slate-800 hover:border-emerald-300 dark:hover:border-emerald-500/50 group shadow-sm hover:shadow-md">
                    <ClipboardList class="w-8 h-8 text-slate-400 dark:text-slate-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors" />
                    <span class="text-sm font-bold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Nilai Kecocokan</span>
                </Link>
                <Link :href="route('diagnosis.create')" class="flex flex-col items-center justify-center gap-3 rounded-2xl border border-indigo-200 dark:border-indigo-500/30 bg-indigo-50/80 dark:bg-indigo-500/10 p-6 transition-all hover:bg-indigo-100 dark:hover:bg-indigo-500/20 hover:border-indigo-400 dark:hover:border-indigo-500/60 group shadow-sm hover:shadow-md">
                    <Activity class="w-8 h-8 text-indigo-600 dark:text-indigo-400 group-hover:text-indigo-700 dark:group-hover:text-indigo-300 transition-colors" />
                    <span class="text-sm font-bold text-indigo-700 dark:text-indigo-300 group-hover:text-indigo-900 dark:group-hover:text-white transition-colors">Hitung SAW</span>
                </Link>
                <Link :href="route('riwayat.index')" class="flex flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/60 dark:bg-slate-800/30 p-6 transition-all hover:bg-white dark:hover:bg-slate-800 hover:border-rose-300 dark:hover:border-rose-500/50 group shadow-sm hover:shadow-md">
                    <History class="w-8 h-8 text-slate-400 dark:text-slate-400 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors" />
                    <span class="text-sm font-bold text-slate-600 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Riwayat Hasil</span>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
