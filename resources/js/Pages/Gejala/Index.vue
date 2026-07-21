<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ListTodo, Plus, Trash2, Edit } from 'lucide-vue-next';

const props = defineProps({
    gejala: {
        type: Array,
        required: true,
    },
    total_bobot: {
        type: Number,
        required: true,
    }
});

const confirmingDelete = ref(null);

const confirmDelete = (id) => {
    confirmingDelete.value = id;
};

const cancelDelete = () => {
    confirmingDelete.value = null;
};

const hapus = (id) => {
    router.delete(route('gejala.destroy', id), {
        preserveScroll: true,
        onFinish: () => {
            confirmingDelete.value = null;
        },
    });
};
</script>

<template>
    <Head title="Master Gejala" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-white flex items-center gap-2">
                <ListTodo class="w-6 h-6 text-indigo-400" />
                Data Kriteria (Gejala)
            </h2>
        </template>

        <div class="space-y-6">
            <!-- Total Bobot Indicator -->
            <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-6 shadow-sm backdrop-blur-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Total Bobot Kriteria</h3>
                    <p class="mt-1 text-3xl font-extrabold" :class="total_bobot > 100 ? 'text-rose-500' : (total_bobot === 100 ? 'text-emerald-400' : 'text-white')">
                        {{ total_bobot }} <span class="text-lg font-medium text-slate-500">/ 100</span>
                    </p>
                    <p v-if="total_bobot > 100" class="text-xs text-rose-500 mt-1">Peringatan: Total bobot melebihi batas 100.</p>
                    <p v-else-if="total_bobot === 100" class="text-xs text-emerald-400 mt-1">Total bobot sudah ideal (100).</p>
                    <p v-else class="text-xs text-slate-400 mt-1">Sisa bobot yang bisa ditambahkan: {{ 100 - total_bobot }}</p>
                </div>
                <div>
                    <Link
                        :href="route('gejala.create')"
                        class="flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        <Plus class="w-4 h-4" /> Tambah Gejala
                    </Link>
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 shadow-sm backdrop-blur-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700/50">
                        <thead class="bg-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">No</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Gejala</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Jenis</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Bobot</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50 bg-transparent">
                            <tr v-for="(item, index) in gejala" :key="item.id" class="hover:bg-slate-700/20 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-400">
                                    {{ index + 1 }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-white">
                                    {{ item.kode_gejala }}
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-300">
                                    {{ item.nama_gejala }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <span v-if="item.jenis === 'benefit'" class="inline-flex items-center rounded-md bg-emerald-400/10 px-2 py-1 text-xs font-medium text-emerald-400 ring-1 ring-inset ring-emerald-400/20">Benefit</span>
                                    <span v-else class="inline-flex items-center rounded-md bg-rose-400/10 px-2 py-1 text-xs font-medium text-rose-400 ring-1 ring-inset ring-rose-400/20">Cost</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-slate-200">
                                    {{ item.bobot }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium">
                                    <!-- Konfirmasi hapus -->
                                    <template v-if="confirmingDelete === item.id">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-slate-400 text-xs">Yakin?</span>
                                            <button @click="hapus(item.id)" class="text-rose-500 hover:text-rose-400 text-xs font-bold transition-colors">Ya</button>
                                            <button @click="cancelDelete" class="text-slate-400 hover:text-slate-300 text-xs transition-colors">Batal</button>
                                        </div>
                                    </template>

                                    <template v-else>
                                        <div class="flex items-center justify-center gap-4">
                                            <Link :href="route('gejala.edit', item.id)" class="text-indigo-400 hover:text-indigo-300 transition-colors" title="Edit">
                                                <Edit class="w-4 h-4" />
                                            </Link>
                                            <button @click="confirmDelete(item.id)" class="text-rose-500 hover:text-rose-400 transition-colors" title="Hapus">
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </template>
                                </td>
                            </tr>

                            <tr v-if="gejala.length === 0">
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <ListTodo class="w-8 h-8 opacity-20" />
                                        <p>Belum ada data kriteria (gejala).</p>
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
