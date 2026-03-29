<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wordbook;

class WordbookController extends Controller
{
    // 単語帳一覧
    public function index()
    {
        $wordbooks = auth()->user()->wordbooks;
        return view('wordbooks.index', compact('wordbooks'));
    }

    // ⭐ 単語帳作成フォーム表示（← これが無かった！）
    public function create()
    {
        return view('wordbooks.create');
    }

    // 単語帳作成処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        auth()->user()->wordbooks()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('wordbooks.index')
            ->with('success', '単語帳を作成しました！');
    }

    // フラッシュカード開始
    public function wordbook(Request $request, Wordbook $wordbook)
    {
        $wordIds = $wordbook->words()
            ->inRandomOrder()
            ->limit(10)
            ->pluck('id')
            ->toArray();

        $request->session()->put('flashcards', $wordIds);
        $request->session()->put('current_index', 0);
        $request->session()->put('correct_count', 0);

        return redirect()->route('flashcards.next');
    }
    public function show(Wordbook $wordbook)
{
    // 自分の単語帳かチェック（超重要）
    abort_if($wordbook->user_id !== auth()->id(), 403);

    $words = $wordbook->words;

    return view('wordbooks.show', compact('wordbook', 'words'));
}
}
