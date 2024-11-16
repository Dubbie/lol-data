<script setup>
import useTooltipTranslator from '@/composables/useTooltipTranslator';
import { computed, ref } from 'vue';

const props = defineProps({
    spell: {
        type: Object,
        required: true,
    },
});

const { translateTooltip } = useTooltipTranslator();

const buttonText = computed(() => {
    switch (props.spell.priority) {
        case 0:
            return 'Q';
        case 1:
            return 'W';
        case 2:
            return 'E';
        case 3:
            return 'R';
        default:
            return '?';
    }
});

const cooldownText = computed(() => {
    let same = true;
    let lastCooldown = null;

    for (const cd of props.spell.cooldown) {
        if (!lastCooldown) {
            lastCooldown = cd;
        }

        if (cd !== lastCooldown) {
            same = false;
            break;
        }
    }

    if (same) {
        return `${lastCooldown}`;
    }

    return props.spell.cooldown.join(' / ');
});

const translatedTooltip = ref(
    translateTooltip(props.spell.tooltip, props.spell.effect_burn),
);

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
                :src="spell.image"
                :alt="spell.name"
                class="size-8 rounded-md bg-zinc-700 text-transparent ring-2 ring-white"
            />

            <p
                class="absolute -bottom-2 left-1/2 -translate-x-1/2 rounded-md bg-white px-1 text-center font-poppins text-xs/4 font-bold text-black"
            >
                {{ buttonText }}
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
                class="absolute left-1/2 top-full z-10 mt-4 w-96 -translate-x-1/2 rounded-2xl bg-black/60 p-4 text-sm backdrop-blur"
            >
                <p class="font-semibold text-zinc-400">
                    {{ spell.name }}
                </p>
                <p class="mb-2 text-xs text-zinc-400">
                    <span class="mr-1">Cooldown:</span>
                    <span class="font-semibold text-white">{{
                        cooldownText
                    }}</span>
                </p>

                <p v-html="translatedTooltip"></p>
            </div>
        </transition>
    </div>
</template>
