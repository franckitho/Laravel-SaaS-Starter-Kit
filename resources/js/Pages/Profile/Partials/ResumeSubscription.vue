<script setup>
import SuccessButton from "@/Components/SuccessButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const confirmingResumeSubscription = ref(false);

const form = useForm({
});

const confirmResumeSubscription = () => {
    confirmingResumeSubscription.value = true;
};

const resumeSubscription = () => {
    form.post(route("subscription.resume"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingResumeSubscription.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                Resume Subscription
            </h2>

            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                Resume your subscription. You will still have access to your account
                until your current subscription period ends.
            </p>
        </header>

        <SuccessButton @click="confirmResumeSubscription">Resume Subscription</SuccessButton>

        <Modal :show="confirmingResumeSubscription" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-slate-900 dark:text-slate-100"
                >
                    Are you sure you want to resume your subscription?
                </h2>

                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Your subscription will be resumed and you will have access to subscription features.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <SuccessButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="resumeSubscription"
                    >
                        Resume Subscription
                    </SuccessButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
