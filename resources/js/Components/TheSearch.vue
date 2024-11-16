<script setup>
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import ChampionMini from './ChampionMini.vue';

const loading = ref(false);
const champions = ref([]);
const form = useForm({
    query: '',
});

let abortController = null;
const focused = ref(false);
const debounceTimeout = ref(null);

const fetchChampions = async (query) => {
    if (query.length < 2) {
        champions.value = [];
        return;
    }

    // Abort any ongoing request
    if (abortController) {
        abortController.abort();
    }

    abortController = new AbortController();

    loading.value = true;
    try {
        const response = await axios.get(route('api.champion.index'), {
            params: { query },
            signal: abortController.signal,
        });
        champions.value = response.data;
    } catch (err) {
        if (axios.isCancel(err)) {
            console.log('Request canceled');
        } else {
            console.log('Error while loading champions!');
            console.log(err);
        }
    } finally {
        loading.value = false;
    }
};

// Watch for changes in the search query and debounce the fetch
watch(
    () => form.query,
    (newQuery) => {
        clearTimeout(debounceTimeout.value);
        debounceTimeout.value = setTimeout(() => {
            fetchChampions(newQuery);
        }, 300); // 300ms debounce
    },
);
</script>

<template>
    <div class="relative">
        <TextInput
            class="w-full"
            v-model="form.query"
            placeholder="Search..."
            @focus="focused = true"
            @blur="focused = false"
        />

        <transition
            enter-active-class="transition-all ease-out duration-300"
            enter-from-class="opacity-0 translate-y-2"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition-all ease-out duration-100"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                class="absolute left-1/2 top-full mt-2 min-w-full -translate-x-1/2 rounded-2xl bg-white/10 p-2 text-white"
                v-show="focused && (loading || champions.length > 0)"
            >
                <div v-if="loading">
                    <p>Loading...</p>
                </div>
                <div v-else>
                    <ChampionMini
                        v-for="champion in champions"
                        :key="champion.id"
                        :champion="champion"
                    />
                </div>
            </div>
        </transition>
    </div>
</template>
