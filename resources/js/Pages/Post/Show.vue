<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import MarkdownIt from "markdown-it";

const markdown = new MarkdownIt();

defineProps({
    post: {
        type: Object,
    },
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
                            <Link 
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white" 
                                :href="route('welcome')">
                                Home
                            </Link>
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
                </header>

                <main class="mt-6">
                    <div class="flex flex-col mx-auto max-w-3xl">
                        <img :src="post.banner_url" :alt="post.banner_filename">
                        <div class="flex mt-4">
                            <p class="mr-1">{{ post.created_at }} -</p>
                            <p>{{ post.user_filament.name }}</p>
                        </div>
                        <h1>{{ post.title.en }}</h1>
                        <div v-html="markdown.render(post.content.en)"></div>
                    </div>
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
<style>
    h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }
    h2 {
        font-size: 2rem;
        font-weight: 600;
        line-height: 1.2;
        color: #1e293b;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }
    h3 {
        font-size: 1.75rem;
        font-weight: 600;
        line-height: 1.2;
        color: #1e293b;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }
    li {
        line-height: 1.5;
        list-style-type: disc;
    }
</style>
