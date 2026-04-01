<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;
use App\Models\UserWordResult;
use App\Models\Wordbook;
use App\Models\Goal;
use App\Notifications\GoalCompletedNotification;

class FlashcardController extends Controller
{
    public function index()
    {
        return redirect()->route('flashcards.select');
    }

    // フォルダ選択画面
    public function select()
    {
        $userId = auth()->id();

        $wordbooks = Wordbook::where('user_id', $userId)
                    ->orWhere('user_id', 0)
                    ->get();

        return view('flashcards.select', compact('wordbooks'));
    }

    // セッションを開始してランダム10問をセット
    public function startSession(Request $request)
    {
        $userId = auth()->id();
        $request->validate([
            'wordbooks' => 'required|array',
        ]);

        $wordbookIds = Wordbook::whereIn('id', $request->wordbooks)
                ->where(function($q) use ($userId) {
                    $q->where('user_id', $userId)
                      ->orWhere('user_id', 0);
                })
                ->pluck('id')
                ->toArray();

        $wordIds = Word::whereIn('wordbook_id', $wordbookIds)
                    ->inRandomOrder()
                    ->limit(10)
                    ->pluck('id')
                    ->toArray();

        if (empty($wordIds)) {
            return back()->with('error', '選択した単語帳に単語がありません');
        }

        session([
            'flashcards' => $wordIds,
            'current_index' => 0,
            'correct_count' => 0,
            'wrong_words' => [],
        ]);

        return redirect()->route('flashcards.next');
    }

    // 次の単語を表示
    public function next(Request $request)
    {
        $wordIds = $request->session()->get('flashcards', []);
        $index = $request->session()->get('current_index', 0);

        if ($index >= count($wordIds)) {
            return redirect()->route('flashcards.result');
        }

        $word = Word::findOrFail($wordIds[$index]);

        $choices = Word::where('id', '!=', $word->id)
                        ->inRandomOrder()
                        ->limit(3)
                        ->pluck('meaning')
                        ->toArray();
        $choices[] = $word->meaning;
        shuffle($choices);

        $progress = [
            'current' => $index + 1,
            'total' => count($wordIds),
            'correct' => $request->session()->get('correct_count', 0)
        ];
        $request->session()->put('progress', $progress);

        return view('flashcards.index', compact('word', 'choices', 'progress'));
    }

    // 回答処理
    public function answer(Request $request)
    {
        $word = Word::findOrFail($request->word_id);
        $selected = $request->selected;
        $isCorrect = $selected === $word->meaning;

        if (Auth::check()) {
            $userWord = UserWordResult::firstOrCreate([
                'user_id' => Auth::id(),
                'word_id' => $word->id
            ]);

            if ($isCorrect) {
                $userWord->rank = max(0, $userWord->rank - 1);
            } else {
                $userWord->rank = min(3, $userWord->rank + 1);
                $userWord->mistake_count = ($userWord->mistake_count ?? 0) + 1;
            }
            $userWord->save();
        }

        $request->session()->increment('current_index');
        if ($isCorrect) {
            $request->session()->increment('correct_count');
        } else {
            $wrongWords = $request->session()->get('wrong_words', []);
            $wrongWords[] = $word->id;
            $request->session()->put('wrong_words', $wrongWords);
        }

        return redirect()->route('flashcards.next')->with([
            'result' => $isCorrect ? 'correct' : 'wrong',
            'answer' => $word->meaning,
            'selected' => $selected
        ]);
    }

    // 結果表示
    public function result(Request $request)
    {
        $user = auth()->user();
        $correctCount = session('correct_count', 0);
        $wordIds = session('flashcards', []);
        $wrongWords = session('wrong_words', []);
        $total = count($wordIds);
        $achievedGoals = [];

        $goals = Goal::where('user_id', $user->id)
            ->where('is_completed', false)
            ->get();

        foreach ($goals as $goal) {
            $goal->current_value = min(
                $goal->current_value + $correctCount,
                $goal->target_value
            );

            if ($goal->current_value >= $goal->target_value) {
                $goal->is_completed = true;
                $goal->save();
                $user->notify(new GoalCompletedNotification($goal));
                $achievedGoals[] = $goal->title;

                $mutualUsers = $user->mutualFollows();
                foreach ($mutualUsers as $mutualUser) {
                    $mutualUser->notify(
                        new \App\Notifications\MutualGoalCompletedNotification($goal)
                    );
                }
            } else {
                $goal->save();
            }
        }

        return view('flashcards.result', compact(
            'correctCount',
            'wrongWords',
            'achievedGoals',
            'total'
        ));
    }
}
