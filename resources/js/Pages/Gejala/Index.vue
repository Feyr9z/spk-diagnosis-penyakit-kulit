<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ListTodo, Plus, Trash2, Edit, AlertTriangle, SquarePen } from 'lucide-vue-next';

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

const confirmDelete = (item) => {
    confirmingDelete.value = item;
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
            <h2 class="text-2xl font-bold leading-tight text-slate-900 dark:text-white flex items-center gap-2">
                <ListTodo class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                Data Kriteria (Gejala)
            </h2>
        </template>

        <div class="space-y-6">
            <!-- Total Bobot Indicator -->
            <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 p-6 shadow-sm backdrop-blur-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors">
                <div>
                    <h3 class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Bobot Kriteria</h3>
                    <p class="mt-1 text-3xl font-extrabold" :class="total_bobot > 100 ? 'text-rose-600 dark:text-rose-500' : (total_bobot === 100 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-900 dark:text-white')">
                        {{ total_bobot }} <span class="text-lg font-bold text-slate-400 dark:text-slate-500">/ 100</span>
                    </p>
                    <p v-if="total_bobot > 100" class="text-xs font-semibold text-rose-600 dark:text-rose-500 mt-1">Peringatan: Total bobot melebihi batas 100.</p>
                    <p v-else-if="total_bobot === 100" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 mt-1">Total bobot sudah ideal (100).</p>
                    <p v-else class="text-xs font-semibold text-slate-500 dark:text-slate-400 mt-1">Sisa bobot yang bisa ditambahkan: {{ 100 - total_bobot }}</p>
                </div>
                <div>
                    <Link
                        :href="route('gejala.create')"
                        class="flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-emerald-500 transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600"
                    >
                        <Plus class="w-4 h-4" /> Tambah Gejala
                    </Link>
                </div>
            </div>

            <!-- Table -->
            <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl overflow-hidden transition-colors">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/80 dark:divide-slate-700/50">
                        <thead class="bg-slate-100/80 dark:bg-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">No</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Nama Gejala</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Jenis</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Bobot</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/80 dark:divide-slate-700/50 bg-transparent">
                            <tr v-for="(item, index) in gejala" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-slate-500 dark:text-slate-400">
                                    {{ index + 1 }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-extrabold text-slate-900 dark:text-white">
                                    {{ item.kode_gejala }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">
                                    {{ item.nama_gejala }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <span v-if="item.jenis === 'benefit'" class="inline-flex items-center rounded-md bg-emerald-100 dark:bg-emerald-400/10 px-2.5 py-1 text-xs font-bold text-emerald-700 dark:text-emerald-400 ring-1 ring-inset ring-emerald-600/20 dark:ring-emerald-400/20">Benefit</span>
                                    <span v-else class="inline-flex items-center rounded-md bg-rose-100 dark:bg-rose-400/10 px-2.5 py-1 text-xs font-bold text-rose-700 dark:text-rose-400 ring-1 ring-inset ring-rose-600/20 dark:ring-rose-400/20">Cost</span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-extrabold text-slate-800 dark:text-slate-200">
                                    {{ item.bobot }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-sm font-medium">
                                    <div class="flex items-center justify-center gap-2">
                                        <Link
                                            :href="route('gejala.edit', item.id)"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-500 transition-all"
                                        >
                                            <SquarePen class="w-3.5 h-3.5" />
                                            Edit
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

                            <tr v-if="gejala.length === 0">
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <ListTodo class="w-8 h-8 opacity-20" />
                                        <p class="font-medium">Belum ada data kriteria (gejala).</p>
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
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">Hapus Data Gejala</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Tindakan ini tidak dapat dibatalkan. Data berikut akan dihapus permanen:</p>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 p-4">
                        <p class="font-mono font-bold text-slate-500 dark:text-slate-400 text-xs mb-0.5">{{ confirmingDelete.kode_gejala }}</p>
                        <p class="font-bold text-slate-900 dark:text-white">{{ confirmingDelete.nama_gejala }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <span class="text-xs font-bold px-2 py-0.5 rounded"
                                :class="confirmingDelete.jenis === 'benefit' ? 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300' : 'bg-rose-100 dark:bg-rose-500/20 text-rose-700 dark:text-rose-300'">{{ confirmingDelete.jenis }}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">Bobot: {{ confirmingDelete.bobot }}</span>
                        </div>
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
