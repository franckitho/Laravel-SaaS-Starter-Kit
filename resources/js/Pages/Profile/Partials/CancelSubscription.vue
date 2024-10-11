<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const confirmingCancelSubscription = ref(false);

const form = useForm({
});

const confirmCancelSubscription = () => {
    confirmingCancelSubscription.value = true;
};

const cancelSubscription = () => {
    form.delete(route("subscription.cancel"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingCancelSubscription.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                Cancel Subscription
            </h2>

            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                Cancel your subscription. You will still have access to your account
                until your current subscription period ends.
            </p>
        </header>

        <DangerButton @click="confirmCancelSubscription">Cancel Subscription</DangerButton>

        <Modal :show="confirmingCancelSubscription" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-slate-900 dark:text-slate-100"
                >
                    Are you sure you want to cancel your subscription?
                </h2>

                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Your subscription will be canceled and you will still have access to
                    your account until your current subscription period ends.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="cancelSubscription"
                    >
                        Cancel Subscription
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
