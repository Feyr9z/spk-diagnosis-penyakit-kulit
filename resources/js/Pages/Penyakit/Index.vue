<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Database, Plus, Trash2, Edit } from 'lucide-vue-next';

defineProps({
    penyakit: {
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
    router.delete(route('penyakit.destroy', id), {
        preserveScroll: true,
        onFinish: () => {
            confirmingDelete.value = null;
        },
    });
};
</script>

<template>
    <Head title="Master Penyakit" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-slate-900 dark:text-white flex items-center gap-2">
                <Database class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                Data Alternatif (Penyakit)
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-end">
                <Link
                    :href="route('penyakit.create')"
                    class="flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-500 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600"
                >
                    <Plus class="w-4 h-4" /> Tambah Alternatif
                </Link>
            </div>

            <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl overflow-hidden transition-colors">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/80 dark:divide-slate-700/50">
                        <thead class="bg-slate-100/80 dark:bg-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Nama Penyakit</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Deskripsi</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/80 dark:divide-slate-700/50 bg-transparent">
                            <tr v-for="(item, index) in penyakit" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-slate-500 dark:text-slate-400">
                                    {{ index + 1 }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-extrabold text-slate-900 dark:text-white">
                                    {{ item.kode_penyakit }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-200">
                                    {{ item.nama_penyakit }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400 max-w-xs truncate">
                                    {{ item.deskripsi }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium">
                                    <template v-if="confirmingDelete === item.id">
                                        <div class="flex items-center justify-center gap-3">
                                            <span class="text-slate-500 dark:text-slate-400 text-xs font-semibold">Yakin?</span>
                                            <button @click="hapus(item.id)" class="text-rose-600 dark:text-rose-500 hover:text-rose-700 dark:hover:text-rose-400 text-xs font-bold transition-colors">Ya</button>
                                            <button @click="cancelDelete" class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-300 text-xs font-bold transition-colors">Batal</button>
                                        </div>
                                    </template>

                                    <template v-else>
                                        <div class="flex items-center justify-center gap-4">
                                            <Link :href="route('penyakit.edit', item.id)" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 transition-colors" title="Edit">
                                                <Edit class="w-4 h-4" />
                                            </Link>
                                            <button @click="confirmDelete(item.id)" class="text-rose-600 dark:text-rose-500 hover:text-rose-800 dark:hover:text-rose-400 transition-colors" title="Hapus">
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </template>
                                </td>
                            </tr>

                            <tr v-if="penyakit.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <Database class="w-8 h-8 opacity-20" />
                                        <p class="font-medium">Belum ada data alternatif (penyakit).</p>
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
