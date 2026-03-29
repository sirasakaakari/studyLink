<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wordbook;

class WordController extends Controller
{
    public function store(Request $request, Wordbook $wordbook)
    {
        // 自分の単語帳かチェック
        abort_if($wordbook->user_id !== auth()->id(), 403);

        $request->validate([
            'word' => 'required|string|max:255',
            'meaning' => 'required|string|max:255',
        ]);

        $wordbook->words()->create([
            'word' => $request->word,
            'meaning' => $request->meaning,
        ]);

        return back();
    }
}
