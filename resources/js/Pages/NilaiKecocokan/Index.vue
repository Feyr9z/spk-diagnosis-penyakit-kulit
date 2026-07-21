<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ClipboardList, Save } from 'lucide-vue-next';
import { ref, onMounted } from 'vue';

const props = defineProps({
    penyakit: {
        type: Array,
        required: true,
    },
    gejala: {
        type: Array,
        required: true,
    },
    nilaiKecocokan: {
        type: Array,
        required: true,
    },
});

// Initialize matrix data
const matrixData = ref({});
const isProcessing = ref(false);

onMounted(() => {
    // Populate matrix map from existing data
    props.nilaiKecocokan.forEach(nk => {
        matrixData.value[`${nk.penyakit_id}_${nk.gejala_id}`] = nk.nilai;
    });
});

const getNilai = (penyakitId, gejalaId) => {
    return matrixData.value[`${penyakitId}_${gejalaId}`] || 0;
};

const setNilai = (penyakitId, gejalaId, value) => {
    let val = parseInt(value);
    if (isNaN(val) || val < 0) val = 0;
    if (val > 255) val = 255;
    matrixData.value[`${penyakitId}_${gejalaId}`] = val;
};

const saveMatrix = () => {
    isProcessing.value = true;
    
    // Convert matrixData object back to array
    const payload = [];
    Object.keys(matrixData.value).forEach(key => {
        const parts = key.split('_');
        payload.push({
            penyakit_id: parseInt(parts[0]),
            gejala_id: parseInt(parts[1]),
            nilai: matrixData.value[key]
        });
    });

    router.post(route('nilai-kecocokan.matrix'), { matrix: payload }, {
        preserveScroll: true,
        onFinish: () => {
            isProcessing.value = false;
        }
    });
};
</script>

<template>
    <Head title="Nilai Kecocokan (Matriks)" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-white flex items-center gap-2">
                <ClipboardList class="w-6 h-6 text-emerald-400" />
                Matriks Nilai Kecocokan
            </h2>
        </template>

        <div class="space-y-6">
            <!-- Header Actions -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <p class="text-sm text-slate-400 max-w-2xl">
                    Masukkan nilai kecocokan (<span class="font-bold text-slate-200">X<sub>ij</sub></span>) antara setiap Alternatif (Penyakit) dan Kriteria (Gejala). Perubahan tidak akan tersimpan sebelum Anda menekan tombol Simpan.
                </p>
                <button
                    @click="saveMatrix"
                    :disabled="isProcessing"
                    class="flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 disabled:opacity-50 shrink-0"
                >
                    <span v-if="isProcessing" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Menyimpan...
                    </span>
                    <span v-else class="flex items-center gap-2">
                        <Save class="w-4 h-4" /> Simpan Matriks
                    </span>
                </button>
            </div>

            <!-- Matrix Table -->
            <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 shadow-sm backdrop-blur-xl overflow-hidden relative">
                
                <div v-if="penyakit.length === 0 || gejala.length === 0" class="p-12 text-center">
                    <ClipboardList class="w-12 h-12 text-slate-600 mx-auto mb-4" />
                    <p class="text-slate-400">Data Penyakit atau Gejala belum lengkap.</p>
                </div>

                <div v-else class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700/50">
                        <thead class="bg-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-300 bg-slate-800/90 sticky left-0 z-10 border-r border-slate-700/50 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.3)]">
                                    Alternatif \ Kriteria
                                </th>
                                <th 
                                    v-for="g in gejala" 
                                    :key="g.id" 
                                    class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400 min-w-[120px]"
                                    :title="g.nama_gejala"
                                >
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="text-emerald-400 font-bold">{{ g.kode_gejala }}</span>
                                        <span class="text-[10px] text-slate-500 truncate max-w-[100px]">{{ g.nama_gejala }}</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50 bg-transparent">
                            <tr v-for="p in penyakit" :key="p.id" class="hover:bg-slate-700/20 transition-colors group">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-white bg-slate-800/90 group-hover:bg-slate-700/90 sticky left-0 z-10 border-r border-slate-700/50 shadow-[2px_0_5px_-2px_rgba(0,0,0,0.3)] transition-colors">
                                    <div class="flex flex-col">
                                        <span class="text-cyan-400">{{ p.kode_penyakit }}</span>
                                        <span class="text-xs text-slate-400 font-medium truncate max-w-[180px]" :title="p.nama_penyakit">{{ p.nama_penyakit }}</span>
                                    </div>
                                </td>
                                <td v-for="g in gejala" :key="g.id" class="px-2 py-3 text-center">
                                    <input
                                        type="number"
                                        min="0"
                                        max="255"
                                        :value="getNilai(p.id, g.id)"
                                        @input="(e) => setNilai(p.id, g.id, e.target.value)"
                                        class="w-20 rounded-lg border border-slate-600 bg-slate-900/50 px-2 py-1.5 text-center text-sm text-white placeholder-slate-600 focus:border-emerald-500 focus:ring-emerald-500/50 transition-colors"
                                    />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
