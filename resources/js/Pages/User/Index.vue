<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Users, Plus, Edit, Trash2, Shield, User } from 'lucide-vue-next';

defineProps({
    users: {
        type: Array,
        required: true,
    },
});

const confirmingUserDeletion = ref(null);

const confirmUserDeletion = (id) => {
    confirmingUserDeletion.value = id;
};

const cancelUserDeletion = () => {
    confirmingUserDeletion.value = null;
};

const deleteUser = (id) => {
    router.delete(route('users.destroy', id), {
        preserveScroll: true,
        onSuccess: () => cancelUserDeletion(),
    });
};
</script>

<template>
    <Head title="Manajemen User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-slate-900 dark:text-white flex items-center gap-2">
                <Users class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                Manajemen User
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    Kelola daftar pengguna dan hak akses aplikasi.
                </p>
                
                <Link
                    :href="route('users.create')"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all"
                >
                    <Plus class="w-4 h-4" /> Tambah User
                </Link>
            </div>

            <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl overflow-hidden transition-colors">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/80 dark:divide-slate-700/50">
                        <thead class="bg-slate-100/80 dark:bg-slate-800/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Username / Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Role</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 w-32">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200/80 dark:divide-slate-700/50 bg-transparent">
                            <tr v-for="user in users" :key="user.id" class="hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 dark:text-white">{{ user.nama }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-600 dark:text-slate-400">
                                    {{ user.username }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-xs font-bold"
                                        :class="user.role === 'super_admin' ? 'bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20' : 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20'">
                                        <Shield v-if="user.role === 'super_admin'" class="w-3.5 h-3.5" />
                                        <User v-else class="w-3.5 h-3.5" />
                                        {{ user.role === 'super_admin' ? 'Super Admin' : 'Admin' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <template v-if="confirmingUserDeletion === user.id">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-slate-500 dark:text-slate-400 text-xs font-semibold">Yakin?</span>
                                            <button @click="deleteUser(user.id)" class="text-rose-600 dark:text-rose-500 hover:text-rose-700 dark:hover:text-rose-400 text-xs font-bold transition-colors">Ya</button>
                                            <button @click="cancelUserDeletion" class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-300 text-xs font-bold transition-colors">Batal</button>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button @click="confirmUserDeletion(user.id)" class="p-1.5 text-rose-600 dark:text-rose-400 hover:text-rose-800 dark:hover:text-rose-300 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Hapus User">
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </template>
                                </td>
                            </tr>

                            <tr v-if="users.length === 0">
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <Users class="w-8 h-8 text-slate-300 dark:text-slate-600" />
                                        <p class="font-medium">Belum ada user yang ditambahkan.</p>
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
