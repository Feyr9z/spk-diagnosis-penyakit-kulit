<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'admin',
});

const submit = () => {
    form.post(route('users.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>

    <Head title="Tambah User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah User
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-4">
                            <input v-model="form.name" type="text" placeholder="Nama"
                                class="w-full rounded border p-2" />

                            <input v-model="form.email" type="email" placeholder="Email"
                                class="w-full rounded border p-2" />

                            <input v-model="form.password" type="password" placeholder="Password"
                                class="w-full rounded border p-2" />

                            <input v-model="form.password_confirmation" type="password"
                                placeholder="Konfirmasi Password" class="w-full rounded border p-2" />

                            <select v-model="form.role" class="w-full rounded border p-2">
                                <option value="admin">Admin</option>
                                <option value="super_admin">Super Admin</option>
                            </select>

                            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
