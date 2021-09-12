<template>
    <div class="card-display-container">
        <div class="flex in-deck mb-2">
            <div class="card-count-marker card-marked flex-1" v-for="count in cardCount">
                
            </div>
            <div class="card-count-marker card-unmarked flex-1" v-for="count in (4 - cardCount)">

            </div>
        </div>
        <img class="cursor-pointer" :src="card.image_uris.normal" loading="lazy" @click="$emit('addCard', card)" />
    </div>
</template>

<script>
    export default {
        props: {
            card: {
                type: Object
            },
            cardCount: {
                type: Number
            }
        },
        data() {
            return {
        
            }
        },

        computed: {

        },

        mounted() {
           
        },

        methods: {

        }
    }
</script>

<style scoped>
    .in-deck {
        padding: 0 4rem;
    }

    .card-marked {
        padding: 8px;
        background-color: #ffaf41;
        border: 1px solid #e99e35;
        margin-right: 4px;
        border-radius: 4px;
    }

    .card-unmarked {
        padding: 8px;
        background-color: #fde6c6;
        border: 1px solid #e99e35;
        margin-right: 4px;
        border-radius: 4px;
    }
</style>
