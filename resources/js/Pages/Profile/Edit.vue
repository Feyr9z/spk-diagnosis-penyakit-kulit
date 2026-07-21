<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profil" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-white">
                Pengaturan Profil
            </h2>
        </template>

        <div class="space-y-6 max-w-4xl">
            <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-6 shadow-sm backdrop-blur-xl sm:p-8">
                <UpdateProfileInformationForm
                    :status="status"
                    class="max-w-xl"
                />
            </div>

            <div class="rounded-2xl border border-slate-700/50 bg-slate-800/50 p-6 shadow-sm backdrop-blur-xl sm:p-8">
                <UpdatePasswordForm class="max-w-xl" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
