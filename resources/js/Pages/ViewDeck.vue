<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New Deck
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-4">
                    <h1 class="text-xl p-2">Filters</h1>
                </div>

                <div class="grid grid-cols-4 gap-5">
                    <Link :href="route('new-deck')">
                        <div class="deck-box p-3">
                            [NEW DECK]
                        </div>
                    </Link>
                    <div class="deck-box p-3" v-for="deck in 10">[DECK HERE]</div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import { Link } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            AppLayout,
            Welcome,
            Link,
        },
    }
</script>

<style lang="scss" scoped>
    .deck-box {
        background-color: rosybrown;
        height: 250px;
        border: 1px solid brown;
    }
</style>
