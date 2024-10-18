<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {
    CheckIcon,
    CreditCardIcon,
    ChartBarSquareIcon,
    LockClosedIcon,
    CodeBracketIcon,
    PencilSquareIcon,
    UserCircleIcon
} from '@heroicons/vue/24/solid';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <Head title="SaaS Starter landing page" />
    <div class="bg-slate-50 text-black/50">
        <div
            class="relative min-h-screen flex flex-col selection:bg-lime-500 selection:text-white"
        >
            <div class="relative w-full px-6">
                <header
                    class="grid grid-cols-3 mx-14 text-sm items-center gap-2 py-10 lg:"
                >
                    <div class="flex items-center space-x-2">
                        <ApplicationLogo class="w-14 h-14 fill-current text-black" />
                        <span class="text-slate-900 text-xl font-medium font-heading leading-6">SaaS Starter</span>
                    </div>
                    <nav v-if="canLogin" class="hidden md:space-x-6 md:flex md:items-center col-span-2">
                        <div class="flex flex-1 justify-center md:space-x-6 md:flex md:items-center">
                            <a 
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white" 
                                href="#product">
                                Product
                            </a>
                            <a 
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white" 
                                href="#features">
                                Features
                            </a>
                            <a 
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white" 
                                href="#pricing">
                                Pricing
                            </a>
                            <a 
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white" 
                                href="#oui">
                                Testimonials
                            </a>
                        </div>
                        <div class="flex flex-1 justify-end md:space-x-6 md:flex md:items-center">
                            <Link
                                v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-lime-600 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Dashboard
                            </Link>

                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Sign in
                                </Link>

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="rounded-md px-3 py-2 border border-black/30 text-black ring-1 ring-transparent transition hover:border-black/50 focus:outline-none focus-visible:ring-lime-600 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Create Account
                                </Link>
                            </template>
                        </div>
                    </nav>
                    <section id="product" class="mt-8 md:mt-12 col-span-3">
                        <div class="px-5 max-w-screen-2xl mx-auto md:pt-16 md:pb-24 lg:pt-24 lg:pb-32">
                            <div class="w-full">
                                <h1 
                                    class="md:w-1/2 md:pr-8 font-heading text-slate-900 font-black text-6xl"
                                >
                                    <span class="text-lime-500	">SaaS</span><br> Starter Kit
                                </h1>
                                <p class="mt-6 md:w-1/2 text-slate-900 text-lg">
                                    A open source starter kit for building SaaS applications with Laravel, Vue 3 and InertiaJS.
                                </p>
                                <div class="flex mt-14 items-center space-x-2">
                                    <a 
                                        type="button" 
                                        href="#" 
                                        target="_blank"
                                        class="focus:outline-none text-white bg-lime-500 hover:bg-lime-600 focus:ring-4 focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                                    >
                                        Documentation
                                    </a>
                                    <a type="button" href="#" target="_blank" class="font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2 text-slate-700 hover:underline">
                                        <svg class="w-5 h-5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
                                        </svg>
                                        Star on GitHub
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </header>

                <main class="mt-6">
                    <section class="grid grid-cols-5 max-w-screen-2xl mx-auto">
                        <div class="flex justify-center items-center">
                            <img class="h-[50px]" src="https://spark.laravel.com/images/laravel.svg" alt="Laravel">
                        </div>
                        <div class="flex justify-center items-center">
                            <img class="h-[50px]" src="https://www.vectorlogo.zone/logos/vuejs/vuejs-ar21.svg" alt="Vue3">
                        </div>
                        <div class="flex justify-center items-center">
                            <img class="h-[50px]" src="https://i.ibb.co/GthBfqf/Sans-titre-2.png" alt="InertiaJs">
                        </div>
                        <div class="flex justify-center items-center">
                            <img class="h-[50px]" src="https://i.ibb.co/5BJdRSH/Sans-titre-1.png" alt="Filament">
                        </div>
                        <div class="flex justify-center items-center">
                            <img class="h-[50px]" src="https://hostbillapp.com/appstore/payment_stripe/images/thumbnails/m_logo.png" alt="Stripe">
                        </div>
                    </section>
                    <section id="features" class="mt-24 w-full max-w-screen-2xl mx-auto">
                        <div class="flex w-full flex-col items-center justify-center">
                            <h2 
                                class="text-lg font-bold text-lime-500"
                            >
                                Features
                            </h2>
                            <p 
                                class="text-4xl text-slate-800 font-black my-4"
                            >
                                All everything you need to build a SaaS application.
                            </p>
                            <p
                                class="text-lg max-w-xl text-center"
                            >
                                Create a robust SaaS application with Seo friendly URLs, subscription plans, user management, and more. 
                            </p>
                        </div>
                        <div class="grid grid-cols-3 gap-16 mt-16">
                            <div class="flex justify-center items-start space-x-4">
                                <div class="bg-lime-500 p-2 rounded-lg">
                                    <CreditCardIcon class="text-white size-6" />
                                </div>
                                <p><span class="font-bold">Subscriptions.</span> Define a monthly/yearly subscription, cancel, resume, upgrade your plan and more...</p>
                            </div>
                            <div class="flex justify-center items-start space-x-4">
                                <div class="bg-lime-500 p-2 rounded-lg">
                                    <PencilSquareIcon class="text-white size-6" />
                                </div>
                                
                                <p><span class="font-bold">Blog System.</span>  SEO-friendly blog system with built-in language translation features, designed to help you promote and grow your future idea.</p>
                            </div>
                            <div class="flex justify-center items-start space-x-4">
                                <div class="bg-lime-500 p-2 rounded-lg">
                                    <LockClosedIcon class="text-white size-6" />
                                </div>
                                <p><span class="font-bold">Authentication.</span> Includes a dual-provider authentication system for both user and back office user, powered by Laravel Breeze.</p>
                            </div>
                            <div class="flex justify-center items-start space-x-4">
                                <div class="bg-lime-500 p-2 rounded-lg">
                                    <ChartBarSquareIcon class="text-white size-6" />
                                </div>
                                <p><span class="font-bold">Analytics.</span> Back-office analytics system to track the financial performance of your SaaS.</p>
                            </div>
                            <div class="flex justify-center items-start space-x-4">
                                <div class="bg-lime-500 p-2 rounded-lg">
                                    <CodeBracketIcon class="text-white size-6" />
                                </div>
                                <p><span class="font-bold">Developer friendly.</span> Staying true to Laravel and easily customizable to align with your vision and workflow.</p>
                            </div>
                            <div class="flex justify-center items-start space-x-4">
                                <div class="bg-lime-500 p-2 rounded-lg">
                                    <UserCircleIcon class="text-white size-6" />
                                </div>
                                <p><span class="font-bold">Open-Source.</span> Allowing the community to continuously improve it, ensuring a stronger foundation for ongoing development.</p>
                            </div>
                        </div>
                    </section>
                    <section id="pricing" class="w-full mt-24 max-w-screen-2xl mx-auto">
                        <div class="flex w-full flex-col items-center justify-center">
                            <h2 
                                class="text-lg font-bold text-lime-500"
                            >
                                Pricing
                            </h2>
                            <p 
                                class="text-4xl text-slate-800 font-black my-4"
                            >
                                Defined subscription with Stripe and Laravel Cashier
                            </p>
                            <p
                                class="text-lg max-w-xl text-center"
                            >
                                Create a subscription on stripe then add the public and secret keys in the environment file add it in filament resource Subscription Plans.  
                            </p>
                        </div>
                        <div class="flex text-lg mt-16 items-center justify-center px-24">
                            <div class="max-w-md border border-r-0 border-black/15 px-8 py-8 rounded-l-3xl my-7">
                                <p class="font-bold text-lime-500">Hobby</p>
                                <p 
                                    class="text-4xl font-black text-slate-800 my-4"
                                >
                                    $19
                                    <span 
                                        class="text-lg text-black/50 font-normal"
                                    >
                                        /month
                                    </span>
                                </p>
                                <p>The perfect plan if you're just getting started with our product.</p>
                                <div class="flex flex-col mt-8">
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        25 Credit
                                    </span>
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        Up to 10,000 subscribers
                                    </span>
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        Advanced analytics
                                    </span>
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        24-hour support response time
                                    </span>
                                </div>
                                <button
                                class="w-full mt-8 border border-lime-500 text-lime-500 hover:text-white hover:bg-lime-500 font-bold py-2 rounded-lg"
                                >
                                    Get started today
                                </button>
                            </div>
                            <div class="max-w-md bg-slate-800 px-8 py-8 rounded-3xl text-white shadow-2xl">
                                <p class="font-bold text-lime-500">Enterprise</p>
                                <p 
                                    class="text-4xl font-black my-4"
                                >
                                    $49
                                    <span 
                                        class="text-lg font-normal"
                                    >
                                        /month
                                    </span>
                                </p>
                                <p>Dedicated support and infrastructure for your company.</p>
                                <div class="flex flex-col mt-8">
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        25 Credit
                                    </span>
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        Up to 10,000 subscribers
                                    </span>
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        Advanced analytics
                                    </span>
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        24-hour support response time
                                    </span>
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        Advanced analytics
                                    </span>
                                    <span class="flex">
                                        <CheckIcon class="text-lime-500 size-6 mr-4" />
                                        24-hour support response time
                                    </span>
                                </div>
                                <button
                                class="w-full mt-8 border border-lime-500 text-lime-500 hover:text-white hover:bg-lime-500 font-bold py-2 rounded-lg"
                                >
                                    Get started today
                                </button>
                            </div>
                        </div>
                    </section>
                </main>

                <footer
                    class="py-16 text-center text-sm text-black dark:text-white/70"
                >
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
