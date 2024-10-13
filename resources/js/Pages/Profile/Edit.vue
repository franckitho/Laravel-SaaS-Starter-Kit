<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import AccountInformation from "./Partials/BillingInformation.vue";
import CancelSubscription from "./Partials/CancelSubscription.vue";
import ResumeSubscription from "./Partials/ResumeSubscription.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    invoices: {
        type: Array,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight"
            >
                Profile
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div
                    v-if="invoices"
                    class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg"
                >
                    <AccountInformation :invoices="invoices" />
                </div>
                <div
                    class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div
                    class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg"
                >
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div
                    class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>
                <div v-if="$page.props.auth.subscription">
                    <div
                        v-if="$page.props.auth.subscription.ends_at"
                        class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg"
                    >
                        <ResumeSubscription class="max-w-xl" />
                    </div>

                    <div
                        v-else
                        class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg"
                    >
                        <CancelSubscription class="max-w-xl" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
