<template>
    <app-layout title="Cards">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cards
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-4">
                    <h1 class="text-xl p-2">Adventures in the Forgotten Realm</h1>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-4">
                    <h1 class="text-xl p-2">Filters</h1>
                </div>
                <div class="grid grid-cols-4 gap-5">
                    <div v-if="cards && cards.data.length > 0" class="grid grid-cols-3 gap-5 col-span-3">
                        <div v-for="card in cards.data" class="mb-6">
                            <div class="mb-2">
                                <img :src="card.image_uris.normal" />
                            </div>
                            <div class="flex justify-center">
                                <button class="flex-1 bg-blue-400 text-white rounded-md" @click="removeCard(card)">-</button>
                                <div class="flex-1 text-center">[COUNT]</div>
                                <button class="flex-1 bg-blue-400 text-white rounded-md"  @click="addCard(card)">+</button>
                            </div> 
                        </div>
                    </div>
                    <div class="bg-white overflow-y shadow-xl sm:rounded p-2 sticky top-0 self-start">
                        <h1 class="text-xl">Deck</h1>
                        <div v-for="card in deck" class="grid grid-cols-3 gap-2">
                            <div class="col-span-2">
                                ({{deckCardCount[card.arena_id].count}}) {{card.name}}
                            </div>
                            <div>
                                {{card.mana_cost}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import cardJson from '../scryfall_json/afr.json';

    export default {
        components: {
            AppLayout,
            Welcome,
        },

        data() {
            return {
                cards: cardJson,
                deck: [],
                deckSet: new Set(),
                deckCardCount: {}
            }
        },

        mounted() {
            this.getCards();
            console.log(cardJson);
        },

        methods: {
            getCards() {
                // axios.get('https://api.scryfall.com/cards/search?order=set&q=e%3Aafr&unique=prints')
                //     .then(res => {
                //         this.cards = res.data;
                //     })
                // console.log(cardJson);
            },

            addCard(card) {
                if (!this.deckSet.has(card.arena_id)) {
                    this.deckSet.add(card.arena_id);
                    this.deck.push(card);
                    this.deckCardCount[card.arena_id] = {};
                    this.deckCardCount[card.arena_id].count = 1;
                } else {
                    if (this.deckCardCount[card.arena_id].count < 4) this.deckCardCount[card.arena_id].count++;
                }
                
                this.deck = _.orderBy(this.deck, ['cmc'], 'asc');
            }
            
        }
    }
</script>
