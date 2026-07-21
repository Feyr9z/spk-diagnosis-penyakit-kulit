<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Award, TableProperties, Calculator, Stethoscope, User, Calendar, RefreshCcw, ArrowLeft, Activity, Trash2 } from 'lucide-vue-next';

const props = defineProps({
    diagnosis: {
        type: Object,
        required: true,
    },
    hasilSAW: {
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

const activeTab = ref('hasil');

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
            <div class="flex items-center gap-4">
                <Link :href="route('riwayat.index')" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors border border-slate-200 dark:border-slate-700/50">
                    <ArrowLeft class="w-5 h-5" />
                </Link>
                <h2 class="text-2xl font-bold leading-tight text-slate-900 dark:text-white flex items-center gap-2">
                    <Award class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    Detail Riwayat Diagnosis
                </h2>
            </div>
        </template>

        <div class="space-y-6 max-w-7xl mx-auto pb-12">
            
            <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full bg-emerald-50 dark:bg-emerald-500/20 flex items-center justify-center border border-emerald-200 dark:border-emerald-500/30">
                        <User class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ diagnosis.pasien?.nama ?? 'Pasien Dihapus' }}</h3>
                        <p v-if="diagnosis.pasien" class="text-sm font-medium text-slate-500 dark:text-slate-400 flex items-center gap-2 mt-1">
                            <span>{{ diagnosis.pasien.usia }} Tahun</span> &bull; 
                            <span>{{ jenisKelaminLabel(diagnosis.pasien.jenis_kelamin) }}</span>
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-start md:items-end">
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 mb-1">
                        <Calendar class="w-4 h-4" />
                        <span class="text-sm font-semibold">Tanggal Diagnosis</span>
                    </div>
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ tanggal(diagnosis.created_at) }}</p>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="flex overflow-x-auto space-x-2 border-b border-slate-200 dark:border-slate-700/50 pb-px">
                <button @click="activeTab = 'hasil'" :class="activeTab === 'hasil' ? 'border-emerald-400 dark:border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="whitespace-nowrap flex items-center gap-2 py-3 px-5 border-b-2 font-bold text-sm transition-all rounded-t-lg">
                    <Award class="w-4 h-4" /> Hasil & Podium
                </button>
                <button @click="activeTab = 'matriks-x'" :class="activeTab === 'matriks-x' ? 'border-emerald-400 dark:border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="whitespace-nowrap flex items-center gap-2 py-3 px-5 border-b-2 font-bold text-sm transition-all rounded-t-lg">
                    <TableProperties class="w-4 h-4" /> Matriks Keputusan (X)
                </button>
                <button @click="activeTab = 'matriks-r'" :class="activeTab === 'matriks-r' ? 'border-emerald-400 dark:border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="whitespace-nowrap flex items-center gap-2 py-3 px-5 border-b-2 font-bold text-sm transition-all rounded-t-lg">
                    <RefreshCcw class="w-4 h-4" /> Normalisasi (R)
                </button>
                <button @click="activeTab = 'preferensi-v'" :class="activeTab === 'preferensi-v' ? 'border-rose-400 dark:border-rose-500 text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-500/10' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="whitespace-nowrap flex items-center gap-2 py-3 px-5 border-b-2 font-bold text-sm transition-all rounded-t-lg">
                    <Calculator class="w-4 h-4" /> Nilai Preferensi (V)
                </button>
            </div>

            <!-- TAB 1: HASIL & PODIUM -->
            <div v-if="activeTab === 'hasil'" class="space-y-6">
                
                <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-8 transition-colors">
                    <h3 class="text-xl font-black text-center text-slate-900 dark:text-white mb-10">Ranking Diagnosis Teratas</h3>
                    
                    <div class="flex flex-col md:flex-row items-end justify-center gap-4 h-auto md:h-64">
                        
                        <!-- Juara 2 -->
                        <div v-if="hasilSAW.ranking[1]" class="order-2 md:order-1 flex flex-col items-center w-full md:w-1/4 transform hover:-translate-y-2 transition-transform duration-300">
                            <div class="mb-3 text-center">
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">JUARA 2</p>
                                <p class="font-extrabold text-slate-900 dark:text-white text-sm px-2">{{ hasilSAW.ranking[1].penyakit?.nama_penyakit ?? 'Penyakit Dihapus' }}</p>
                                <p class="text-xs font-bold text-emerald-600 dark:text-emerald-300">{{ hasilSAW.ranking[1].nilai_preferensi }}</p>
                            </div>
                            <div class="w-full bg-gradient-to-t from-slate-100 to-slate-200 dark:from-slate-900 dark:to-slate-700 border-t-2 border-slate-300 dark:border-slate-500 rounded-t-lg h-24 flex items-center justify-center shadow-lg">
                                <span class="text-4xl font-black text-slate-400 dark:text-slate-500/50">2</span>
                            </div>
                        </div>

                        <!-- Juara 1 -->
                        <div v-if="hasilSAW.ranking[0]" class="order-1 md:order-2 flex flex-col items-center w-full md:w-1/3 z-10 transform hover:-translate-y-2 transition-transform duration-300">
                            <div class="mb-4 text-center">
                                <div class="w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-500/20 text-amber-500 dark:text-amber-400 mx-auto flex items-center justify-center mb-2 shadow-[0_0_15px_rgba(245,158,11,0.2)] dark:shadow-[0_0_15px_rgba(245,158,11,0.5)]">
                                    <Award class="w-6 h-6" />
                                </div>
                                <p class="font-black text-slate-900 dark:text-white text-lg px-2 text-shadow-sm">{{ hasilSAW.ranking[0].penyakit?.nama_penyakit ?? 'Penyakit Dihapus' }}</p>
                                <p class="text-sm font-bold text-amber-600 dark:text-amber-400 mt-1">{{ hasilSAW.ranking[0].nilai_preferensi }}</p>
                            </div>
                            <div class="w-full bg-gradient-to-t from-amber-50 to-amber-200 dark:from-amber-900/50 dark:to-amber-600/50 border-t-4 border-amber-400 rounded-t-lg h-36 flex items-center justify-center shadow-lg relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 dark:bg-white/5 skew-x-12"></div>
                                <span class="text-6xl font-black text-amber-300 dark:text-amber-900/50">1</span>
                            </div>
                        </div>

                        <!-- Juara 3 -->
                        <div v-if="hasilSAW.ranking[2]" class="order-3 md:order-3 flex flex-col items-center w-full md:w-1/4 transform hover:-translate-y-2 transition-transform duration-300">
                            <div class="mb-3 text-center">
                                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">JUARA 3</p>
                                <p class="font-extrabold text-slate-900 dark:text-white text-sm px-2">{{ hasilSAW.ranking[2].penyakit?.nama_penyakit ?? 'Penyakit Dihapus' }}</p>
                                <p class="text-xs font-bold text-emerald-600 dark:text-emerald-300">{{ hasilSAW.ranking[2].nilai_preferensi }}</p>
                            </div>
                            <div class="w-full bg-gradient-to-t from-orange-50 to-orange-100 dark:from-slate-900 dark:to-orange-900/30 border-t-2 border-orange-200 dark:border-orange-700/50 rounded-t-lg h-20 flex items-center justify-center shadow-lg">
                                <span class="text-3xl font-black text-orange-200 dark:text-orange-900/50">3</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 transition-colors">
                        <div class="flex items-center gap-2 mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                            <Stethoscope class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            <h3 class="font-bold text-slate-900 dark:text-white">Deskripsi Medis</h3>
                        </div>
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-300 leading-relaxed text-justify">
                            {{ diagnosis.penyakit.deskripsi }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 transition-colors">
                        <div class="flex items-center gap-2 mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                            <Activity class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            <h3 class="font-bold text-slate-900 dark:text-white">Gejala Pasien</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="detail in diagnosis.details"
                                :key="detail.id"
                                class="inline-flex items-center rounded-lg bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 px-3 py-1.5 text-xs font-bold text-emerald-700 dark:text-emerald-300"
                            >
                                {{ detail.gejala.kode_gejala }} — {{ detail.gejala.nama_gejala }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Hapus Riwayat Actions -->
                <div class="flex items-center justify-between mt-8 p-6 rounded-2xl border border-rose-200 dark:border-rose-900/50 bg-rose-50 dark:bg-rose-500/5 transition-colors">
                    <div>
                        <h4 class="text-rose-600 dark:text-rose-400 font-bold">Hapus Riwayat</h4>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mt-1">Data yang dihapus tidak dapat dikembalikan.</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <template v-if="confirmingDelete">
                            <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Yakin hapus?</span>
                            <button
                                @click="hapus"
                                class="rounded-xl bg-rose-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-rose-700 dark:hover:bg-rose-500 transition-colors"
                            >
                                Ya, Hapus
                            </button>
                            <button
                                @click="confirmingDelete = false"
                                class="rounded-xl border border-slate-300 dark:border-slate-600 bg-transparent px-5 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                            >
                                Batal
                            </button>
                        </template>
                        <button
                            v-else
                            @click="confirmingDelete = true"
                            class="flex items-center gap-2 rounded-xl bg-rose-100 dark:bg-rose-500/10 border border-rose-200 dark:border-rose-500/20 text-rose-600 dark:text-rose-400 px-5 py-2.5 text-sm font-bold hover:bg-rose-200 dark:hover:bg-rose-500/20 transition-colors"
                        >
                            <Trash2 class="w-4 h-4" /> Hapus Riwayat
                        </button>
                    </div>
                </div>
            </div>

            <!-- TAB 2: MATRIKS X -->
            <div v-if="activeTab === 'matriks-x'" class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 transition-colors">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Matriks Keputusan (X)</h3>
                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-6">Matriks bobot kecocokan awal saat perhitungan dilakukan.</p>
                <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700/50">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700/50">
                        <thead class="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 border-r border-slate-200 dark:border-slate-700/50">Alternatif</th>
                                <th v-for="g in hasilSAW.gejala_list" :key="g.id" class="px-4 py-3 text-center text-xs font-bold text-emerald-600 dark:text-emerald-400">{{ g.kode_gejala }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700/50 bg-white dark:bg-slate-900/30">
                            <tr v-for="p in hasilSAW.penyakit_list" :key="p.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="px-4 py-3 text-sm font-bold text-slate-900 dark:text-slate-200 border-r border-slate-200 dark:border-slate-700/50">{{ p.kode_penyakit }}</td>
                                <td v-for="g in hasilSAW.gejala_list" :key="g.id" class="px-4 py-3 text-sm font-medium text-center text-slate-600 dark:text-slate-400">
                                    {{ hasilSAW.decision_matrix[p.id][g.id] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 3: NORMALISASI R -->
            <div v-if="activeTab === 'matriks-r'" class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 transition-colors">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Matriks Normalisasi (R)</h3>
                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-6">Pembagian nilai X dengan nilai max (benefit) atau min (cost).</p>
                <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700/50">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700/50">
                        <thead class="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 border-r border-slate-200 dark:border-slate-700/50">Alternatif</th>
                                <th v-for="g in hasilSAW.gejala_list" :key="g.id" class="px-4 py-3 text-center text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                    {{ g.kode_gejala }} <br>
                                    <span class="text-[10px] text-slate-500 font-bold uppercase">{{ g.jenis }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700/50 bg-white dark:bg-slate-900/30">
                            <tr v-for="p in hasilSAW.penyakit_list" :key="p.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                <td class="px-4 py-3 text-sm font-bold text-slate-900 dark:text-slate-200 border-r border-slate-200 dark:border-slate-700/50">{{ p.kode_penyakit }}</td>
                                <td v-for="g in hasilSAW.gejala_list" :key="g.id" class="px-4 py-3 text-sm font-medium text-center text-slate-600 dark:text-slate-400">
                                    {{ hasilSAW.normalized_matrix[p.id][g.id].toFixed(4) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 4: PREFERENSI V -->
            <div v-if="activeTab === 'preferensi-v'" class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 transition-colors">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Perhitungan Nilai Preferensi (V) & Ranking</h3>
                <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mb-6">Perkalian nilai R dengan bobot W.</p>
                
                <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700/50">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700/50">
                        <thead class="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-center text-xs font-bold text-slate-700 dark:text-slate-300 border-r border-slate-200 dark:border-slate-700/50 w-16">Rank</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 dark:text-slate-300 border-r border-slate-200 dark:border-slate-700/50">Penyakit</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-rose-600 dark:text-rose-400 border-r border-slate-200 dark:border-slate-700/50">Nilai V (Akhir)</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-400">Detail (R &times; W)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700/50 bg-white dark:bg-slate-900/30">
                            <tr v-for="(rankItem, index) in hasilSAW.ranking" :key="rankItem.penyakit.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50" :class="{'bg-rose-50 dark:bg-rose-500/5': index === 0}">
                                <td class="px-4 py-3 text-center border-r border-slate-200 dark:border-slate-700/50">
                                    <span v-if="index === 0" class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-500 text-white font-bold text-xs">1</span>
                                    <span v-else-if="index === 1" class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-400 text-white font-bold text-xs">2</span>
                                    <span v-else-if="index === 2" class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-orange-500 dark:bg-orange-700 text-white font-bold text-xs">3</span>
                                    <span v-else class="text-slate-500 font-bold">{{ index + 1 }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm font-medium border-r border-slate-200 dark:border-slate-700/50" :class="index === 0 ? 'text-rose-600 dark:text-rose-400 font-bold' : 'text-slate-700 dark:text-slate-200'">
                                    {{ rankItem.penyakit.kode_penyakit }} - {{ rankItem.penyakit.nama_penyakit }}
                                </td>
                                <td class="px-4 py-3 text-sm font-black border-r border-slate-200 dark:border-slate-700/50" :class="index === 0 ? 'text-slate-900 dark:text-white' : 'text-slate-700 dark:text-slate-300'">
                                    {{ rankItem.nilai_preferensi.toFixed(4) }}
                                </td>
                                <td class="px-4 py-3 text-xs font-medium text-slate-500 max-w-xs md:max-w-md truncate" :title="hasilSAW.gejala_list.map(g => `${hasilSAW.normalized_matrix[rankItem.penyakit.id][g.id].toFixed(4)}×${g.bobot}`).join(' + ')">
                                    {{ hasilSAW.gejala_list.map(g => `(${hasilSAW.normalized_matrix[rankItem.penyakit.id][g.id].toFixed(4)} × ${g.bobot})`).join(' + ') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
