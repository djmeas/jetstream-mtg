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
                <div class="grid grid-cols-7 gap-5">
                    <div v-if="cards && cards.data.length > 0" class="grid grid-cols-4 gap-5 col-span-5">
                        <div v-for="card in cards.data" class="mb-2">
                            <div class="mb-2">
                                <card-display :card="card" :card-count="(deckCardCount[card.arena_id] && deckCardCount[card.arena_id].count) ? deckCardCount[card.arena_id].count : 0" @addCard="addCard" />
                            </div>
                        </div>
                    </div>
                    <div class="bg-white shadow-xl sm:rounded p-2 sticky top-2 self-start col-span-2">
                        <h1 class="text-xl">Deck ({{deckTotalCards}}/60) --- <span @click="saveDeck">[SAVE]</span></h1>
                        <div class="deck-list-container overflow-y-auto">
                            <div v-for="card in deck" class="card-list-item grid grid-cols-5 gap-2">
                                <div class="col-span-3">
                                    <span class="count-badge" :class="'bg-rarity-' + card.rarity">{{deckCardCount[card.arena_id].count}}</span> {{card.name}}
                                </div>
                                <div class="flex justify-end">
                                    <span v-for="mana in parseManaCost(card.mana_cost)" class="flex-1 mana-symbol ml-1">
                                        <img :src="'/img/' + mana + '.svg'" alt="" />
                                    </span>
                                </div>
                                <div class="deck-list-actions text-right">
                                    <span class="draw-percentage">{{parseFloat((deckCardCount[card.arena_id].count/deckTotalCards) * 100).toFixed(1)}}%</span>
                                    <div class="actions flex">
                                        <button class="flex-1 bg-blue-400 text-white rounded-md mr-1" @click="removeCard(card)">-</button>
                                        <button class="flex-1 bg-blue-400 text-white rounded-md"  @click="addCard(card)">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import CardDisplay from '../Components/CardDisplay.vue'
    import cardJson from '../scryfall_json/afr.json';

    export default {
        components: {
            AppLayout,
            Welcome,
            CardDisplay
        },

        props: {
            deckId: {
                type: Number,
                required: false,
                default: null
            }
        },

        data() {
            return {
                cards: cardJson,
                deck: [],
                deckSet: new Set(),
                deckCardCount: {}
            }
        },

        computed: {
            deckTotalCards() {
                let count = 0;
                Object.keys(this.deckCardCount).forEach(card => {
                    count += this.deckCardCount[card].count;
                })
                return count;
            }
        },

        mounted() {
            this.getCards();
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
                    if (this.deckCardCount[card.arena_id].count < 4 || this.isBasicLand(card)) this.deckCardCount[card.arena_id].count++;
                }
                
                this.deck = _.orderBy(this.deck, ['cmc'], 'asc');
            },

            removeCard(card) {
                this.deckCardCount[card.arena_id].count--;
                if (this.deckCardCount[card.arena_id].count === 0) {
                     this.deckSet.delete(card.arena_id);
                     this.deck = this.deck.filter(deckItem => deckItem.arena_id !== card.arena_id);
                }
            },

            parseManaCost(cost) {
                let manaList = cost.replaceAll('{','').replaceAll('}', '|').split('|');
                manaList.pop();
                return manaList;
            },

            isBasicLand(card) {
                return card.type_line.search('Basic Land') !== -1;
            },

            saveDeck() {
                const form = {
                    deckId: this.deckId,
                    deck: this.deck,
                    deckCardCount: this.deckCardCount
                }

                Inertia.post('/my-decks/save', form);
            }
            
        }
    }
</script>

<style scoped>
    .deck-list-container {
        max-height: 95vh;
    }

    .mana-symbol {
        max-width: 20px;
    }

    .card-list-item {
        background-color: #f3f4f6;
        padding: 8px;
        border-radius: 6px;
        margin-bottom: 8px;
        border: 0px solid black;
        border-top: 2px solid black;
        border-bottom: 2px solid black;
    }

    .deck-list-actions .actions {
        display: none;
    }

    .card-list-item:hover .actions {
        display: flex;
    }

    .card-list-item:hover .draw-percentage {
        display: none;
    }

    .count-badge {
        padding: 1px 8px;
        border-radius: 4px;
    }
</style>
