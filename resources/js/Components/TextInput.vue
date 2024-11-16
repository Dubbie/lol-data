<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
    pill: {
        type: Boolean,
        default: false,
    },
});

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

const roundingClass = computed(() => {
    return props.pill ? 'rounded-full' : 'rounded-2xl';
});

const paddingClass = computed(() => {
    return props.pill ? 'px-6 py-2.5' : 'px-3.5 py-2.5';
});

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="border-none bg-white/5 text-white ring-inset ring-white/15 focus:ring-2 focus:ring-inset"
        :class="[roundingClass, paddingClass]"
        v-model="model"
        ref="input"
    />
</template>
