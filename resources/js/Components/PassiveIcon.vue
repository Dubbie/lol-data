<script setup>
import { ref } from 'vue';

defineProps({
    passive: {
        type: Object,
        required: true,
    },
});

const showingDescription = ref(false);
</script>

<template>
    <div class="relative">
        <div
            class="size-8 select-none"
            @mouseenter="showingDescription = true"
            @mouseleave="showingDescription = false"
        >
            <img
                :src="passive.image"
                :alt="passive.name"
                class="size-8 rounded-md bg-zinc-700 text-transparent ring-2 ring-white"
            />

            <p
                class="absolute -bottom-2 left-1/2 -translate-x-1/2 rounded-md bg-white px-1 text-center font-poppins text-xs/4 font-bold text-black"
            >
                P
            </p>
        </div>

        <transition
            enter-active-class="transition-all ease-out duration-300"
            enter-from-class="opacity-0 translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition-all ease-out duration-100"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-show="showingDescription"
                class="absolute left-1/2 top-full z-10 mt-4 w-72 -translate-x-1/2 rounded-2xl bg-black/60 p-4 text-sm backdrop-blur"
            >
                <p class="mb-2 font-semibold text-zinc-400">
                    {{ passive.name }}
                </p>
                <p v-html="passive.description"></p>
            </div>
        </transition>
    </div>
</template>
