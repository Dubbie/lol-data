<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    champion: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="
            route('champion.show', {
                champion: champion.name,
            })
        "
        class="group flex cursor-pointer items-center gap-x-3 rounded-xl p-2 hover:bg-indigo-600"
    >
        <img
            :src="champion.square_image"
            :alt="champion.name"
            class="size-8 rounded-full ring-2 ring-white/15 group-hover:ring-indigo-500"
        />
        <p class="font-semibold">{{ champion.name }}</p>
    </Link>
</template>
