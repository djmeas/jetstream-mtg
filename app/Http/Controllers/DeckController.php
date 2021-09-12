<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\Deck;
use App\Models\DeckList;

class DeckController extends Controller
{
    public function index() {
        return Inertia::render('MyDecks');
    }

    public function view(Request $request, $deckId = null) {
        return Inertia::render('Cards', [
            'deckId' => $deckId
        ]);
    }

    public function save(Request $request) {
        // dd($request->deckCardCount);

        $deck = Deck::updateOrCreate(
            ['id' => $request->deckId],
            ['user_id' => Auth::id(), 'name' => 'SOME NAME HERE']
        );

        // dd($deck);

        DeckList::where('deck_id', $deck->id)->delete();

        foreach ($request->deck as $card) {
            // dd($request->deckCardCount[$card['arena_id']]);
            DeckList::create([
                'deck_id' => $deck->id,
                'card_id' => $card['id'],
                'arena_card_id' => $card['arena_id'],
                'count' => $request->deckCardCount[$card['arena_id']]['count']
            ]);
        }

        // DeckList::updateOrCreate(
        //     ['id'=> null],
        //     ['deck_id' => $request->deckId, 'user_id' => Auth::id(), 'name' => 'SOME NAME HERE']
        // );

        return Redirect::route('new-deck');
    }
}
