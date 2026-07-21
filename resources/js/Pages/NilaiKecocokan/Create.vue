<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    penyakit: {
        type: Array,
        required: true,
    },
    gejala: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    penyakit_id: '',
    gejala_id: '',
    nilai: '',
});

const submit = () => {
    form.post(route('nilai-kecocokan.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Tambah Nilai Kecocokan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah Nilai Kecocokan
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <form @submit.prevent="submit" class="space-y-5">

                            <!-- Penyakit -->
                            <div>
                                <label for="penyakit_id" class="block text-sm font-medium text-gray-700">
                                    Penyakit
                                </label>
                                <select
                                    id="penyakit_id"
                                    v-model="form.penyakit_id"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    :class="{ 'border-red-500': form.errors.penyakit_id }"
                                >
                                    <option value="" disabled>-- Pilih Penyakit --</option>
                                    <option v-for="item in penyakit" :key="item.id" :value="item.id">
                                        {{ item.kode }} — {{ item.nama }}
                                    </option>
                                </select>
                                <p v-if="form.errors.penyakit_id" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.penyakit_id }}
                                </p>
                            </div>

                            <!-- Gejala -->
                            <div>
                                <label for="gejala_id" class="block text-sm font-medium text-gray-700">
                                    Gejala
                                </label>
                                <select
                                    id="gejala_id"
                                    v-model="form.gejala_id"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    :class="{ 'border-red-500': form.errors.gejala_id }"
                                >
                                    <option value="" disabled>-- Pilih Gejala --</option>
                                    <option v-for="item in gejala" :key="item.id" :value="item.id">
                                        {{ item.kode }} — {{ item.nama }}
                                    </option>
                                </select>
                                <p v-if="form.errors.gejala_id" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.gejala_id }}
                                </p>
                            </div>

                            <!-- Nilai -->
                            <div>
                                <label for="nilai" class="block text-sm font-medium text-gray-700">
                                    Nilai Kecocokan
                                </label>
                                <input
                                    id="nilai"
                                    v-model="form.nilai"
                                    type="number"
                                    min="0"
                                    max="255"
                                    placeholder="Contoh: 5"
                                    class="mt-1 w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    :class="{ 'border-red-500': form.errors.nilai }"
                                />
                                <p v-if="form.errors.nilai" class="mt-1 text-xs text-red-600">
                                    {{ form.errors.nilai }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-3 pt-2">
                                <Link
                                    :href="route('nilai-kecocokan.index')"
                                    class="rounded-md border px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                >
                                    Batal
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="rounded-md bg-emerald-600 px-4 py-2 text-sm text-white hover:bg-emerald-700 disabled:opacity-50"
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
