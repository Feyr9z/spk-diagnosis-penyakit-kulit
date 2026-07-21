<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    kode_gejala: '',
    nama_gejala: '',
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
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah Gejala
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <form @submit.prevent="submit" class="space-y-5">

                            <!-- Kode -->
                            <div>
                                <label for="kode_gejala" class="block text-sm font-medium text-gray-700">
                                    Kode Gejala
                                </label>
                                <input
                                    id="kode_gejala"
                                    v-model="form.kode_gejala"
                                    type="text"
                                    maxlength="20"
                                    placeholder="Contoh: G01"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.kode_gejala }"
                                />
                                <p v-if="form.errors.kode_gejala" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.kode_gejala }}
                                </p>
                            </div>

                            <!-- Nama -->
                            <div>
                                <label for="nama_gejala" class="block text-sm font-medium text-gray-700">
                                    Nama Gejala
                                </label>
                                <input
                                    id="nama_gejala"
                                    v-model="form.nama_gejala"
                                    type="text"
                                    placeholder="Contoh: Gatal pada kulit"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.nama_gejala }"
                                />
                                <p v-if="form.errors.nama_gejala" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.nama_gejala }}
                                </p>
                            </div>

                            <!-- Bobot -->
                            <div>
                                <label for="bobot" class="block text-sm font-medium text-gray-700">
                                    Bobot
                                </label>
                                <input
                                    id="bobot"
                                    v-model="form.bobot"
                                    type="number"
                                    min="1"
                                    max="255"
                                    placeholder="Contoh: 3"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    :class="{ 'border-red-500': form.errors.bobot }"
                                />
                                <p v-if="form.errors.bobot" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.bobot }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-3 pt-2">
                                <Link
                                    :href="route('gejala.index')"
                                    class="rounded-md border px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                >
                                    Batal
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700 disabled:opacity-50"
                                >
                                    {{ form.processing ? 'Menyimpan...' : 'Simpan' }}
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
