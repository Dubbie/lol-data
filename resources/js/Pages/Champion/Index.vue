<script setup>
import PageTitle from '@/Components/PageTitle.vue';
import TheDivider from '@/Components/TheDivider.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const loading = ref(true);
const champions = ref([]);

const fetchChampions = async () => {
    loading.value = true;
    try {
        const response = await axios.get(route('api.champion.index'));
        champions.value = response.data;
    } catch (err) {
        console.log('Error while loading champions!');

        // console.log(err);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchChampions();
});
</script>

<template>
    <AppLayout>
        <PageTitle>Champions</PageTitle>
        <TheDivider class="mb-6" />

        <div v-if="loading">
            <p>Loading champions...</p>
        </div>
        <div v-else>
            <div class="grid grid-cols-12 gap-4">
                <Link
                    :href="
                        route('champion.show', {
                            champion: champion.name,
                        })
                    "
                    v-for="champion in champions"
                    :key="champion.inner_name"
                >
                    <img
                        :src="champion.square_image"
                        :alt="champion.name"
                        loading="lazy"
                    />
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
