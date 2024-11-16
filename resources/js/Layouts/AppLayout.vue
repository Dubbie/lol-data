<script setup>
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-zinc-900 text-white antialiased lg:bg-zinc-950">
        <div
            class="relative isolate flex min-h-svh w-full flex-col bg-zinc-900 lg:bg-zinc-950"
        >
            <header class="flex items-center px-4">
                <div class="min-w-0 flex-1 text-white">
                    <nav class="flex flex-1 items-center gap-4 py-2.5">
                        <span class="relative max-lg:hidden">
                            <Link href="/" class="font-poppins p-2">Leles</Link>
                        </span>

                        <div
                            class="h-6 w-px bg-zinc-950/10 max-lg:hidden dark:bg-white/10"
                            aria-hidden="true"
                        ></div>

                        <div class="flex items-center gap-3 max-lg:hidden">
                            <NavLink
                                :href="route('champion.index')"
                                :is-active="route().current('champion.*')"
                                >Champions</NavLink
                            >
                        </div>

                        <div class="-ml-4 flex-1" aria-hidden="true"></div>

                        <!-- <div class="flex items-center gap-3"></div> -->
                    </nav>
                </div>
            </header>

            <main class="flex flex-1 flex-col pb-2 lg:px-2">
                <div
                    class="grow p-6 lg:rounded-lg lg:bg-zinc-900 lg:p-10 lg:shadow-sm lg:ring-1 lg:ring-white/10"
                >
                    <div class="mx-auto max-w-6xl">
                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
