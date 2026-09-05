<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Database, ArrowLeft } from 'lucide-vue-next';

const form = useForm({
    kode_penyakit: '',
    nama_penyakit: '',
    deskripsi: '',
    tingkat_keparahan: 'sedang',
});

const submit = () => {
    form.post(route('penyakit.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Tambah Alternatif (Penyakit)" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('penyakit.index')" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors border border-slate-200 dark:border-slate-700/50">
                    <ArrowLeft class="w-5 h-5" />
                </Link>
                <h2 class="text-2xl font-bold leading-tight text-slate-900 dark:text-white flex items-center gap-2">
                    <Database class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    Tambah Alternatif (Penyakit)
                </h2>
            </div>
        </template>

        <div class="space-y-6 max-w-3xl">
            <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 md:p-8 transition-colors">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Kode Penyakit -->
                    <div class="space-y-2">
                        <label for="kode_penyakit" class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                            Kode Penyakit
                        </label>
                        <input
                            id="kode_penyakit"
                            v-model="form.kode_penyakit"
                            type="text"
                            placeholder="Contoh: P01"
                            class="block w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900/50 px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500/50 transition-colors"
                            :class="{ 'border-rose-300 dark:border-rose-500 focus:border-rose-500 focus:ring-rose-500/50': form.errors.kode_penyakit }"
                        />
                        <p v-if="form.errors.kode_penyakit" class="text-xs font-semibold text-rose-600 dark:text-rose-500">
                            {{ form.errors.kode_penyakit }}
                        </p>
                    </div>

                    <!-- Nama Penyakit -->
                    <div class="space-y-2">
                        <label for="nama_penyakit" class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                            Nama Penyakit / Alternatif
                        </label>
                        <input
                            id="nama_penyakit"
                            v-model="form.nama_penyakit"
                            type="text"
                            placeholder="Contoh: Jerawat (Acne Vulgaris)"
                            class="block w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900/50 px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500/50 transition-colors"
                            :class="{ 'border-rose-300 dark:border-rose-500 focus:border-rose-500 focus:ring-rose-500/50': form.errors.nama_penyakit }"
                        />
                        <p v-if="form.errors.nama_penyakit" class="text-xs font-semibold text-rose-600 dark:text-rose-500">
                            {{ form.errors.nama_penyakit }}
                        </p>
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-2">
                        <label for="deskripsi" class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                            Deskripsi (Opsional)
                        </label>
                        <textarea
                            id="deskripsi"
                            v-model="form.deskripsi"
                            rows="4"
                            placeholder="Penjelasan singkat..."
                            class="block w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900/50 px-4 py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:border-emerald-500 focus:ring-emerald-500/50 transition-colors"
                            :class="{ 'border-rose-300 dark:border-rose-500 focus:border-rose-500 focus:ring-rose-500/50': form.errors.deskripsi }"
                        ></textarea>
                        <p v-if="form.errors.deskripsi" class="text-xs font-semibold text-rose-600 dark:text-rose-500">
                            {{ form.errors.deskripsi }}
                        </p>
                    </div>

                    <!-- Tingkat Keparahan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300">
                            Tingkat Keparahan
                        </label>
                        <div class="flex gap-3">
                            <label
                                v-for="opt in [
                                    { value: 'ringan', label: 'Ringan', color: 'emerald' },
                                    { value: 'sedang', label: 'Sedang', color: 'amber' },
                                    { value: 'parah', label: 'Parah', color: 'rose' },
                                ]"
                                :key="opt.value"
                                class="flex-1 flex items-center justify-center gap-2 rounded-xl border-2 px-4 py-3 cursor-pointer font-bold text-sm transition-all"
                                :class="form.tingkat_keparahan === opt.value
                                    ? opt.value === 'ringan' ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300'
                                    : opt.value === 'sedang' ? 'border-amber-500 bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-300'
                                    : 'border-rose-500 bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-300'
                                    : 'border-slate-200 dark:border-slate-600 text-slate-500 dark:text-slate-400 hover:border-slate-300 dark:hover:border-slate-500'"
                            >
                                <input type="radio" :value="opt.value" v-model="form.tingkat_keparahan" class="sr-only" />
                                <span>{{ opt.label }}</span>
                            </label>
                        </div>
                        <p v-if="form.errors.tingkat_keparahan" class="text-xs font-semibold text-rose-600 dark:text-rose-500">
                            {{ form.errors.tingkat_keparahan }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <Link
                            :href="route('penyakit.index')"
                            class="rounded-xl border border-slate-300 dark:border-slate-600 bg-transparent px-5 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white transition-colors"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 disabled:opacity-50 transition-all"
                        >
                            <span v-if="form.processing" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Menyimpan...
                            </span>
                            <span v-else>Simpan Alternatif</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
