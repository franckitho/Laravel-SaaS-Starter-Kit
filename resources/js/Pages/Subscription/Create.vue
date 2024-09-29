<template>
    <Head title="Plans" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight"
            >
                Pricing
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-slate-900 dark:text-slate-100">
                        <form @submit.prevent="handleSubmit">
                            <h2 for="card-holder-name" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">Choose your plans</h2>
                            <div v-for="plan in plans" v-bind:key="plan.id">
                                <div class="flex items-center mb-4">
                                    <input v-model="selectedPlan" :id="'plan-' + plan.id" :value="plan.id" type="radio" name="plan" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                                    <div class="ml-3 text-sm leading-6">
                                        <label :for="'plan-' + plan.id" class="block text-medium font-medium text-gray-900 dark:text-gray-300">
                                            {{ plan.name }}
                                        </label>
                                        <span class="text-slate-500">{{ plan.price }} €</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4 w-4/5 text-slate-300 mx-auto" />
                            <div>
                                <label for="card-holder-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Card holder name</label>
                                <input id="card-holder-name" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="text">

                                <!-- Stripe Elements Placeholder -->
                                <label for="card-element" class="block my-2 text-sm font-medium text-gray-900 dark:text-white">Payment infos</label>
                                <div class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="card-element"></div>

                                <button class="text-white mt-4 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" id="card-button" data-secret="{{ $intent->client_secret }}">
                                    Process payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import {loadStripe} from '@stripe/stripe-js';

export default {
    props: ['plans', 'intent', 'stripe_public_key'],
    data() {
        return {
            stripe: null,
            cardElement: null,
            selectedPlan: null
        };
    },
    components: {
        AuthenticatedLayout,
        Head,
    },
    async mounted() {
        this.stripe = await loadStripe(this.stripe_public_key);
        const elements = this.stripe.elements();
        this.cardElement = elements.create('card');
        this.cardElement.mount('#card-element');
    },

    methods: {
        async handleSubmit() {
            const { setupIntent, error } = await this.stripe.confirmCardSetup(
                this.intent.client_secret,
                {
                payment_method: {
                    card: this.cardElement,
                    billing_details: {
                        name: 'Cardholder Name'
                    }
                }
                }
            );

            if (error) {
                console.error(error);
            } else {
                router.post(route('subscription.process'), {
                    payment_method: setupIntent.payment_method,
                    plan_id: this.selectedPlan,
                });
            }

        }
    }
};
</script>
