<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
    isActive: {
        type: Boolean,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="p-2 text-sm font-semibold"
        :class="{
            'text-white': isActive,
            'text-white/50 hover:text-white': !isActive,
        }"
    >
        <slot />
    </Link>
</template>
