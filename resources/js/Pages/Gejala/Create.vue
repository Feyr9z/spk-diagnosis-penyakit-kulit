<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ListTodo, ArrowLeft } from 'lucide-vue-next';

const props = defineProps({
    total_bobot: {
        type: Number,
        required: true,
    }
});

const form = useForm({
    kode_gejala: '',
    nama_gejala: '',
    jenis: 'benefit',
    bobot: '',
});

const submit = () => {
    form.post(route('gejala.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Tambah Gejala" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('gejala.index')" class="text-slate-400 hover:text-white transition-colors">
                    <ArrowLeft class="w-6 h-6" />
                </Link>
                <h2 class="text-2xl font-bold leading-tight text-white flex items-center gap-2">
                    <ListTodo class="w-6 h-6 text-indigo-400" />
                    Tambah Kriteria Gejala
                </h2>
            </div>
        </template>

        <div class="max-w-3xl space-y-6">
            <!-- Warning total bobot -->
            <div v-if="total_bobot >= 100" class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4">
                <p class="text-sm font-medium text-rose-400">
                    Peringatan: Total bobot saat ini sudah mencapai atau melebihi 100 ({{ total_bobot }}). Anda tidak dapat menambah kriteria baru dengan bobot lebih dari sisa yang diizinkan.
                </p>
            </div>
            
            <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-6 shadow-sm backdrop-blur-xl sm:p-8">
                <form @submit.prevent="submit" class="space-y-6">

                    <!-- Kode -->
                    <div>
                        <label for="kode_gejala" class="block text-sm font-semibold text-slate-300 mb-2">
                            Kode Gejala
                        </label>
                        <input
                            id="kode_gejala"
                            v-model="form.kode_gejala"
                            type="text"
                            maxlength="20"
                            placeholder="Contoh: G01"
                            class="w-full rounded-xl border border-slate-600 bg-slate-900/50 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
                            :class="{ 'border-rose-500 focus:border-rose-500 focus:ring-rose-500': form.errors.kode_gejala }"
                        />
                        <p v-if="form.errors.kode_gejala" class="mt-2 text-xs text-rose-400">
                            {{ form.errors.kode_gejala }}
                        </p>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label for="nama_gejala" class="block text-sm font-semibold text-slate-300 mb-2">
                            Nama Gejala
                        </label>
                        <input
                            id="nama_gejala"
                            v-model="form.nama_gejala"
                            type="text"
                            placeholder="Contoh: Gatal pada kulit"
                            class="w-full rounded-xl border border-slate-600 bg-slate-900/50 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
                            :class="{ 'border-rose-500 focus:border-rose-500 focus:ring-rose-500': form.errors.nama_gejala }"
                        />
                        <p v-if="form.errors.nama_gejala" class="mt-2 text-xs text-rose-400">
                            {{ form.errors.nama_gejala }}
                        </p>
                    </div>

                    <!-- Jenis -->
                    <div>
                        <label for="jenis" class="block text-sm font-semibold text-slate-300 mb-2">
                            Jenis Kriteria
                        </label>
                        <select
                            id="jenis"
                            v-model="form.jenis"
                            class="w-full rounded-xl border border-slate-600 bg-slate-900/50 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
                            :class="{ 'border-rose-500 focus:border-rose-500 focus:ring-rose-500': form.errors.jenis }"
                        >
                            <option value="benefit" class="bg-slate-800 text-white">Benefit (Semakin tinggi semakin baik)</option>
                            <option value="cost" class="bg-slate-800 text-white">Cost (Semakin rendah semakin baik)</option>
                        </select>
                        <p v-if="form.errors.jenis" class="mt-2 text-xs text-rose-400">
                            {{ form.errors.jenis }}
                        </p>
                    </div>

                    <!-- Bobot -->
                    <div>
                        <label for="bobot" class="block text-sm font-semibold text-slate-300 mb-2">
                            Bobot <span class="text-slate-500 font-normal">(Sisa maksimal: {{ Math.max(0, 100 - total_bobot) }})</span>
                        </label>
                        <input
                            id="bobot"
                            v-model="form.bobot"
                            type="number"
                            min="1"
                            max="100"
                            placeholder="Contoh: 10"
                            class="w-full rounded-xl border border-slate-600 bg-slate-900/50 px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-colors"
                            :class="{ 'border-rose-500 focus:border-rose-500 focus:ring-rose-500': form.errors.bobot }"
                        />
                        <p v-if="form.errors.bobot" class="mt-2 text-xs text-rose-400">
                            {{ form.errors.bobot }}
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-700/50">
                        <Link
                            :href="route('gejala.index')"
                            class="text-sm font-medium text-slate-400 hover:text-white transition-colors"
                        >
                            Batal
                        </Link>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="flex justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50 transition-colors"
                        >
                            {{ form.processing ? 'Menyimpan...' : 'Simpan Gejala' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
