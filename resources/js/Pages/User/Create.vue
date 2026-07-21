<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Users, Save, ArrowLeft, Shield } from 'lucide-vue-next';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    nama: '',
    username: '',
    password: '',
    password_confirmation: '',
    role: 'admin',
});

const submit = () => {
    form.post(route('users.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Tambah User" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('users.index')" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors border border-slate-200 dark:border-slate-700/50">
                    <ArrowLeft class="w-5 h-5" />
                </Link>
                <h2 class="text-2xl font-bold leading-tight text-slate-900 dark:text-white flex items-center gap-2">
                    <Users class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                    Tambah User
                </h2>
            </div>
        </template>

        <div class="max-w-3xl space-y-6">
            <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/50 bg-white/80 dark:bg-slate-800/50 shadow-sm backdrop-blur-xl p-6 sm:p-8 transition-colors">
                <form @submit.prevent="submit" class="space-y-6">
                    
                    <div class="space-y-4">
                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap</label>
                            <TextInput
                                v-model="form.nama"
                                type="text"
                                class="w-full"
                                placeholder="Masukkan nama lengkap user"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.nama" />
                        </div>

                        <!-- Username -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Username</label>
                            <TextInput
                                v-model="form.username"
                                type="text"
                                class="w-full"
                                placeholder="Masukkan username unik"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.username" />
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Role Akses</label>
                            <select
                                v-model="form.role"
                                class="w-full rounded-xl border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-4 py-2.5 text-sm font-medium text-slate-900 dark:text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors"
                                required
                            >
                                <option value="admin">Admin</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.role" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                            <TextInput
                                v-model="form.password"
                                type="password"
                                class="w-full"
                                placeholder="Masukkan password (minimal 8 karakter)"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Konfirmasi Password</label>
                            <TextInput
                                v-model="form.password_confirmation"
                                type="password"
                                class="w-full"
                                placeholder="Ulangi password"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-slate-200 dark:border-slate-700/50">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <Save class="w-4 h-4" />
                            <span>{{ form.processing ? 'Menyimpan...' : 'Simpan User' }}</span>
                        </button>

                        <Link
                            :href="route('users.index')"
                            class="rounded-xl border border-slate-300 dark:border-slate-600 bg-transparent px-5 py-2.5 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                        >
                            Batal
                        </Link>
                    </div>

                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
