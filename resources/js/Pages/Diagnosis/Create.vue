<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Activity, User, Calendar, CheckSquare, Stethoscope } from 'lucide-vue-next';

defineProps({
    gejala: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    nama: '',
    usia: '',
    jenis_kelamin: '',
    gejala_ids: [],
});

const toggleGejala = (id) => {
    const index = form.gejala_ids.indexOf(id);
    if (index === -1) {
        form.gejala_ids.push(id);
    } else {
        form.gejala_ids.splice(index, 1);
    }
};

const submit = () => {
    form.post(route('diagnosis.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Diagnosis SPK" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-white flex items-center gap-2">
                <Stethoscope class="w-6 h-6 text-indigo-400" />
                Diagnosis SPK SAW
            </h2>
        </template>

        <div class="space-y-6 max-w-5xl mx-auto">
            
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Data Pasien -->
                <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 md:p-8">
                    <div class="flex items-center gap-2 mb-6">
                        <User class="w-5 h-5 text-indigo-400" />
                        <h3 class="text-lg font-bold text-white">Data Pasien</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Pasien -->
                        <div class="space-y-2 md:col-span-2">
                            <label for="nama" class="block text-sm font-semibold text-slate-300">Nama Lengkap</label>
                            <input
                                id="nama"
                                v-model="form.nama"
                                type="text"
                                maxlength="100"
                                placeholder="Masukkan nama pasien"
                                class="block w-full rounded-xl border border-slate-600 bg-slate-900/50 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500/50 transition-colors"
                                :class="{ 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/50': form.errors.nama }"
                            />
                            <p v-if="form.errors.nama" class="text-sm font-medium text-rose-500">{{ form.errors.nama }}</p>
                        </div>

                        <!-- Usia -->
                        <div class="space-y-2">
                            <label for="usia" class="block text-sm font-semibold text-slate-300">Usia (Tahun)</label>
                            <div class="relative">
                                <input
                                    id="usia"
                                    v-model="form.usia"
                                    type="number"
                                    min="1"
                                    max="255"
                                    placeholder="Contoh: 25"
                                    class="block w-full rounded-xl border border-slate-600 bg-slate-900/50 px-4 py-3 pl-11 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500/50 transition-colors"
                                    :class="{ 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/50': form.errors.usia }"
                                />
                                <Calendar class="w-5 h-5 text-slate-500 absolute left-3 top-3.5" />
                            </div>
                            <p v-if="form.errors.usia" class="text-sm font-medium text-rose-500">{{ form.errors.usia }}</p>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="space-y-2">
                            <label for="jenis_kelamin" class="block text-sm font-semibold text-slate-300">Jenis Kelamin</label>
                            <select
                                id="jenis_kelamin"
                                v-model="form.jenis_kelamin"
                                class="block w-full rounded-xl border border-slate-600 bg-slate-900/50 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500/50 transition-colors"
                                :class="{ 'border-rose-500 focus:border-rose-500 focus:ring-rose-500/50': form.errors.jenis_kelamin }"
                            >
                                <option value="" disabled class="text-slate-500 bg-slate-800">-- Pilih Jenis Kelamin --</option>
                                <option value="L" class="bg-slate-800">Laki-laki</option>
                                <option value="P" class="bg-slate-800">Perempuan</option>
                            </select>
                            <p v-if="form.errors.jenis_kelamin" class="text-sm font-medium text-rose-500">{{ form.errors.jenis_kelamin }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pilih Gejala -->
                <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 md:p-8">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <Activity class="w-5 h-5 text-indigo-400" />
                            <h3 class="text-lg font-bold text-white">Observasi Gejala (Kriteria)</h3>
                        </div>
                        <span class="text-xs font-semibold text-slate-400 bg-slate-900/50 px-3 py-1 rounded-full border border-slate-700">
                            Terpilih: {{ form.gejala_ids.length }}
                        </span>
                    </div>
                    
                    <p class="mb-6 text-sm text-slate-400">
                        Pilih gejala yang dialami oleh pasien. Minimal satu gejala harus dipilih untuk diproses oleh mesin SAW.
                    </p>

                    <p v-if="form.errors.gejala_ids" class="mb-4 rounded-xl bg-rose-500/10 border border-rose-500/20 px-4 py-3 text-sm font-medium text-rose-400">
                        {{ form.errors.gejala_ids }}
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        <label
                            v-for="item in gejala"
                            :key="item.id"
                            class="relative flex cursor-pointer items-start gap-4 rounded-xl border p-4 transition-all duration-200"
                            :class="form.gejala_ids.includes(item.id) ? 'border-indigo-500 bg-indigo-500/10 shadow-[0_0_15px_rgba(99,102,241,0.15)]' : 'border-slate-700/50 bg-slate-900/30 hover:bg-slate-800 hover:border-slate-600'"
                        >
                            <div class="flex items-center h-5">
                                <input
                                    type="checkbox"
                                    :value="item.id"
                                    :checked="form.gejala_ids.includes(item.id)"
                                    @change="toggleGejala(item.id)"
                                    class="h-5 w-5 rounded border-slate-600 bg-slate-900/50 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-slate-900"
                                />
                            </div>
                            <div class="flex flex-col flex-1">
                                <span class="text-sm font-semibold transition-colors" :class="form.gejala_ids.includes(item.id) ? 'text-indigo-300' : 'text-slate-300'">
                                    {{ item.kode_gejala }}
                                </span>
                                <span class="text-sm mt-0.5 leading-snug transition-colors" :class="form.gejala_ids.includes(item.id) ? 'text-white' : 'text-slate-400'">
                                    {{ item.nama_gejala }}
                                </span>
                            </div>
                        </label>
                    </div>

                    <div v-if="gejala.length === 0" class="py-12 text-center border-2 border-dashed border-slate-700 rounded-xl">
                        <CheckSquare class="w-12 h-12 text-slate-600 mx-auto mb-4" />
                        <p class="text-slate-400">Belum ada data gejala/kriteria di dalam sistem.</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button
                        type="submit"
                        :disabled="form.processing || form.gejala_ids.length === 0"
                        class="flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-8 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50 transition-all"
                    >
                        <span v-if="form.processing" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Menganalisis Data...
                        </span>
                        <span v-else class="flex items-center gap-2">
                            <Stethoscope class="w-5 h-5" />
                            Proses Diagnosis SAW
                        </span>
                    </button>
                </div>
            </form>

        </div>
    </AuthenticatedLayout>
</template>
