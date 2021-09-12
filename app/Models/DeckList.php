<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeckList extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'deck_id', 'card_id', 'arena_card_id', 'count'];
}
