<script setup>
import PassiveIcon from '@/Components/PassiveIcon.vue';
import SpellIcon from '@/Components/SpellIcon.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    champion: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <div class="flex items-center gap-x-6">
            <div
                class="relative size-24 overflow-hidden rounded-2xl bg-zinc-500"
            >
                <img
                    :src="champion.square_image"
                    :alt="champion.name"
                    class="absolute left-1/2 top-1/2 block min-h-32 min-w-32 -translate-x-1/2 -translate-y-1/2"
                />
            </div>

            <div>
                <div class="flex items-baseline gap-x-3">
                    <h1 class="font-poppins text-3xl font-bold">
                        {{ champion.name }}
                    </h1>
                    <p class="font-semibold text-zinc-500">
                        {{ champion.title }}
                    </p>
                </div>

                <div class="mt-3 flex gap-x-3">
                    <PassiveIcon :passive="champion.passive" />

                    <SpellIcon
                        v-for="spell in champion.spells"
                        :key="spell.id"
                        :spell="spell"
                    />
                </div>
            </div>
        </div>

        <!-- Details go here -->
        <div class="mt-12">
            <p>Detailed statistics go here.</p>
        </div>
    </AppLayout>
</template>
