<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
    invoices: {
        type: Array,
    },
});

const user = usePage().props.auth.user;

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-slate-900">
                Invoices
            </h2>

            <p class="mt-1 text-sm text-slate-600">
                See all your invoices here.
            </p>
        </header>
        <table class="w-full text-sm mt-4 text-left rtl:text-right">
            <thead class="text-xs text-slate-700 uppercase bg-slate-200">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Subscription
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Payment Method
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr 
                    class="bg-slate-50 border-b border-slate-200" 
                    v-for="invoice in invoices" v-bind:key="invoice.id"
                >
                    <td
                        class="px-6 py-4"
                    >
                        {{ invoice.plan }}
                    </td>
                    <td
                        class="px-6 py-4 font-bold"
                    >
                        {{ invoice.pm }}
                    </td>
                    <td
                        class="px-6 py-4"
                    >
                        {{ invoice.date }}
                    </td>
                    <td
                        class="px-6 py-4"
                    >
                        {{ invoice.total }}
                    </td>
                    <td
                        class="px-6 py-4"
                    >
                        <a
                            :href="route('invoices.download', invoice.id)"
                            class="underline text-sm text-slate-600 hover:text-slate-900 rounded-md focus:outline-none"
                        >
                           Download
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </section>
</template>
