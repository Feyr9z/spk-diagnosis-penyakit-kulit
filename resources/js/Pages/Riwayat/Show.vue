<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { TableProperties, Calculator, Stethoscope, User, Calendar, RefreshCcw, ArrowLeft, Activity, Trash2, FileText, AlertCircle } from 'lucide-vue-next';

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

// Calculate percentage relative to max value for clinical progress bars
const maxNilai = computed(() => {
    if (!props.hasilSAW?.ranking?.length) return 1;
    return props.hasilSAW.ranking[0].nilai_preferensi || 1;
});

const getPercentage = (nilai) => {
    if (!maxNilai.value) return 0;
    return Math.round((nilai / maxNilai.value) * 100);
};

const clinicalLabels = ['Diagnosis Utama', 'Diferensial 1', 'Diferensial 2'];
const clinicalBorderColors = [
    'border-l-emerald-500',
    'border-l-slate-400',
    'border-l-slate-300',
];
const clinicalBadgeStyles = [
    'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30',
    'bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-600/50',
    'bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-500 border border-slate-200 dark:border-slate-700/50',
];
const clinicalProgressColors = [
    'bg-emerald-500',
    'bg-slate-400',
    'bg-slate-300',
];

const severityBadge = (level) => {
    const map = {
        ringan: 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-500/30',
        sedang: 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-500/30',
        parah:  'bg-rose-100 dark:bg-rose-500/20 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-500/30',
    };
    return map[level] || map['sedang'];
};

const severityLabel = (level) => {
    return { ringan: 'Ringan', sedang: 'Sedang', parah: 'Parah' }[level] || 'Sedang';
};

const severityAlert = computed(() => {
    const level = props.hasilSAW?.ranking?.[0]?.penyakit?.tingkat_keparahan;
    if (level === 'parah') return { class: 'bg-rose-50 dark:bg-rose-500/10 border-rose-200 dark:border-rose-500/20 text-rose-700 dark:text-rose-300', msg: 'Penyakit ini termasuk kategori PARAH. Segera rujuk ke dokter spesialis.' };
    if (level === 'sedang') return { class: 'bg-amber-50 dark:bg-amber-500/10 border-amber-200 dark:border-amber-500/20 text-amber-700 dark:text-amber-300', msg: 'Penyakit ini termasuk kategori SEDANG. Disarankan konsultasi dengan dokter.' };
    return { class: 'bg-emerald-50 dark:bg-emerald-500/10 border-emerald-200 dark:border-emerald-500/20 text-emerald-700 dark:text-emerald-300', msg: 'Penyakit ini termasuk kategori RINGAN. Tetap pantau kondisi pasien.' };
});
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
                    <FileText class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    Detail Riwayat Diagnosis
                </h2>
            </div>
        </template>

        <div class="space-y-6 max-w-7xl mx-auto pb-12">
            
            <!-- Profil Singkat Pasien -->
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
                    <Stethoscope class="w-4 h-4" /> Hasil Diagnosis
                </button>
                <button @click="activeTab = 'matriks-x'" :class="activeTab === 'matriks-x' ? 'border-emerald-400 dark:border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="whitespace-nowrap flex items-center gap-2 py-3 px-5 border-b-2 font-bold text-sm transition-all rounded-t-lg">
                    <TableProperties class="w-4 h-4" /> Matriks Keputusan (X)
                </button>
                <button @click="activeTab = 'matriks-r'" :class="activeTab === 'matriks-r' ? 'border-emerald-400 dark:border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="whitespace-nowrap flex items-center gap-2 py-3 px-5 border-b-2 font-bold text-sm transition-all rounded-t-lg">
                    <RefreshCcw class="w-4 h-4" /> Normalisasi (R)
                </button>
                <button @click="activeTab = 'preferensi-v'" :class="activeTab === 'preferensi-v' ? 'border-emerald-400 dark:border-emerald-500 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10' : 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-600'" class="whitespace-nowrap flex items-center gap-2 py-3 px-5 border-b-2 font-bold text-sm transition-all rounded-t-lg">
                    <Calculator class="w-4 h-4" /> Nilai Preferensi (V)
                </button>
            </div>

            <!-- TAB 1: HASIL DIAGNOSIS -->
            <div v-if="activeTab === 'hasil'" class="space-y-6">

                <!-- Clinical Ranking -->
                <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 transition-colors">
                    <div class="flex items-center gap-2 mb-1">
                        <Stethoscope class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Hasil Analisis SPK — Peringkat Penyakit</h3>
                    </div>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mb-6">Diurutkan berdasarkan nilai preferensi SAW tertinggi ke terendah.</p>

                    <div class="space-y-3">
                        <div
                            v-for="(item, index) in hasilSAW.ranking.slice(0, 3)"
                            :key="item.penyakit?.id ?? index"
                            class="rounded-xl border-l-4 border border-slate-200 dark:border-slate-700/50 bg-slate-50/60 dark:bg-slate-900/30 p-4 transition-colors"
                            :class="clinicalBorderColors[index]"
                        >
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <span class="shrink-0 text-xs font-extrabold uppercase tracking-wider px-2.5 py-1 rounded-lg" :class="clinicalBadgeStyles[index]">
                                        {{ clinicalLabels[index] }}
                                    </span>
                                    <div>
                                        <p class="font-bold text-slate-900 dark:text-white text-sm">
                                            {{ item.penyakit?.nama_penyakit ?? 'Penyakit Dihapus' }}
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-0.5">
                                            {{ item.penyakit?.kode_penyakit ?? '—' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 shrink-0">
                                    <span v-if="item.penyakit?.tingkat_keparahan" class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-bold" :class="severityBadge(item.penyakit.tingkat_keparahan)">
                                        {{ severityLabel(item.penyakit.tingkat_keparahan) }}
                                    </span>
                                    <div class="text-right">
                                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-0.5">Nilai Preferensi (V)</p>
                                        <p class="text-xl font-black tabular-nums" :class="index === 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300'">
                                            {{ item.nilai_preferensi.toFixed(4) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Progress Bar -->
                            <div class="mt-3">
                                <div class="flex justify-between text-xs text-slate-400 dark:text-slate-500 font-semibold mb-1">
                                    <span>Tingkat Kesesuaian</span>
                                    <span>{{ getPercentage(item.nilai_preferensi) }}%</span>
                                </div>
                                <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                                    <div
                                        class="h-2 rounded-full transition-all duration-700"
                                        :class="clinicalProgressColors[index]"
                                        :style="{ width: getPercentage(item.nilai_preferensi) + '%' }"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Penjelasan Penyakit -->
                    <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 transition-colors">
                        <div class="flex items-center gap-2 mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                            <Stethoscope class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            <h3 class="font-bold text-slate-900 dark:text-white">Deskripsi Medis — Diagnosis Utama</h3>
                        </div>
                        <!-- Severity Alert -->
                        <div v-if="hasilSAW.ranking?.length" class="mb-4 flex items-start gap-2 rounded-xl border p-3" :class="severityAlert.class">
                            <AlertCircle class="w-4 h-4 shrink-0 mt-0.5" />
                            <p class="text-xs font-semibold leading-relaxed">{{ severityAlert.msg }}</p>
                        </div>
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-300 leading-relaxed text-justify">
                            {{ diagnosis.penyakit.deskripsi }}
                        </p>
                        <div class="mt-6 flex items-start gap-2 rounded-lg bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 p-3">
                            <AlertCircle class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" />
                            <p class="text-xs text-amber-700 dark:text-amber-300 font-semibold leading-relaxed">
                                Hasil ini bersifat pendukung keputusan (SPK) dan tidak menggantikan diagnosis resmi dari dokter spesialis.
                            </p>
                        </div>
                    </div>

                    <!-- Gejala Terpilih -->
                    <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 transition-colors">
                        <div class="flex items-center gap-2 mb-4 pb-4 border-b border-slate-200 dark:border-slate-700">
                            <Activity class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            <h3 class="font-bold text-slate-900 dark:text-white">Gejala yang Dilaporkan</h3>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold mb-3">Total: {{ diagnosis.details.length }} gejala teridentifikasi</p>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="detail in diagnosis.details"
                                :key="detail.id"
                                class="inline-flex items-center rounded-lg bg-slate-100 dark:bg-slate-700/60 border border-slate-200 dark:border-slate-600/50 px-3 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-300"
                            >
                                <span class="font-mono text-emerald-600 dark:text-emerald-400 mr-1.5">{{ detail.gejala.kode_gejala }}</span>
                                {{ detail.gejala.nama_gejala }}
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
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-600 dark:text-emerald-400 border-r border-slate-200 dark:border-slate-700/50">Nilai V (Akhir)</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-400">Detail (R &times; W)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700/50 bg-white dark:bg-slate-900/30">
                            <tr v-for="(rankItem, index) in hasilSAW.ranking" :key="rankItem.penyakit.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50" :class="{'bg-emerald-50/50 dark:bg-emerald-500/5': index === 0}">
                                <td class="px-4 py-3 text-center border-r border-slate-200 dark:border-slate-700/50">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full font-bold text-xs"
                                        :class="index === 0 ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400'">
                                        {{ index + 1 }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-medium border-r border-slate-200 dark:border-slate-700/50" :class="index === 0 ? 'text-emerald-700 dark:text-emerald-400 font-bold' : 'text-slate-700 dark:text-slate-200'">
                                    {{ rankItem.penyakit.kode_penyakit }} - {{ rankItem.penyakit.nama_penyakit }}
                                </td>
                                <td class="px-4 py-3 text-sm font-black border-r border-slate-200 dark:border-slate-700/50" :class="index === 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-300'">
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
