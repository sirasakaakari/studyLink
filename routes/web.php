<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\WordbookController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;
use App\Models\User;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckGuest;

Route::get('/', function () {
    return view('welcome');
});
//
// 確認後必ず削除！
Route::get('/run-seeder', function () {
    // user_id=0で共通単語帳を作成
    $wordbook = App\Models\Wordbook::create([
        'name' => '英検2級',
        'user_id' => 0,
    ]);

    $words = [
        ['word' => 'achievement', 'meaning' => '達成'],
        ['word' => 'behavior', 'meaning' => '行動'],
        ['word' => 'candidate', 'meaning' => '候補者'],
        ['word' => 'disaster', 'meaning' => '災害'],
        ['word' => 'environment', 'meaning' => '環境'],
        ['word' => 'familiar', 'meaning' => 'よく知っている'],
        ['word' => 'generate', 'meaning' => '生み出す'],
        ['word' => 'honest', 'meaning' => '正直な'],
        ['word' => 'improve', 'meaning' => '改善する'],
        ['word' => 'journey', 'meaning' => '旅'],
        ['word' => 'knowledge', 'meaning' => '知識'],
        ['word' => 'language', 'meaning' => '言語'],
        ['word' => 'manage', 'meaning' => '管理する'],
        ['word' => 'necessary', 'meaning' => '必要な'],
        ['word' => 'opinion', 'meaning' => '意見'],
        ['word' => 'practice', 'meaning' => '練習'],
        ['word' => 'quality', 'meaning' => '品質'],
        ['word' => 'responsible', 'meaning' => '責任がある'],
        ['word' => 'situation', 'meaning' => '状況'],
        ['word' => 'tradition', 'meaning' => '伝統'],
        ['word' => 'unique', 'meaning' => '独特の'],
        ['word' => 'volunteer', 'meaning' => 'ボランティア'],
        ['word' => 'wealth', 'meaning' => '富'],
        ['word' => 'youth', 'meaning' => '若者'],
        ['word' => 'zeal', 'meaning' => '熱心さ'],
    ];

    foreach ($words as $w) {
        App\Models\Word::create([
            'word' => $w['word'],
            'meaning' => $w['meaning'],
            'wordbook_id' => $wordbook->id,
        ]);
    }

    return 'Done! wordbook_id: ' . $wordbook->id . ', words: ' . count($words);
});
//
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/guest', function () {
    return view('auth.guest');
});
Route::get('/guest-register', [AuthController::class, 'guestToRegister'])
    ->name('guest.register');
Route::get('/guest-login', [AuthController::class, 'guestLogin'])
    ->name('guest.login');

Route::middleware('auth')->group(function () {

    // プロフィール
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // フラッシュカード
    Route::get('/flashcards', [FlashcardController::class, 'index'])
        ->name('flashcards.index');

    Route::get('/flashcards/select', [FlashcardController::class, 'select'])
        ->name('flashcards.select');

    Route::post('/flashcards/start', [FlashcardController::class, 'startSession'])
        ->name('flashcards.start');

    Route::get('/flashcards/next', [FlashcardController::class, 'next'])
        ->name('flashcards.next');

    Route::post('/flashcards/answer', [FlashcardController::class, 'answer'])
        ->name('flashcards.answer');

    Route::get('/flashcards/result', [FlashcardController::class, 'result'])
        ->name('flashcards.result');

    Route::get('/flashcards/finish', [FlashcardController::class, 'finish'])
        ->name('flashcards.finish');

    // 単語帳
    Route::resource('wordbooks', WordbookController::class);

    // 単語追加
    Route::post('/wordbooks/{wordbook}/words', [WordController::class, 'store'])
        ->name('wordbooks.words.store');

    // 目標
    Route::get('/goals/create', [GoalController::class, 'create'])->name('goals.create');
    Route::post('/goals', [GoalController::class, 'store'])->name('goals.store');

    // ユーザー一覧・プロフィール
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/{user}', [UserController::class, 'show'])
        ->name('users.show');

    // フォロー
    Route::post('/users/{user}/follow', [FollowController::class, 'store'])
    ->middleware(['auth', CheckGuest::class])
    ->name('follow.store');

Route::delete('/users/{user}/unfollow', [FollowController::class, 'destroy'])
    ->middleware(['auth', CheckGuest::class])
    ->name('follow.destroy');
});


Route::middleware('auth')->group(function () {
    // 自分がフォローしている人一覧ページ
    Route::get('/followings', [FollowController::class, 'followings'])
        ->name('followings.index');
});
Route::post('/goals/{goal}/complete', [GoalController::class, 'complete'])
    ->middleware('auth')
    ->name('goals.complete');
    Route::patch('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back();
    })->name('notifications.read')->middleware('auth');
    
    Route::post('/celebrate', [GoalController::class, 'celebrate'])
    ->name('celebrate')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dm/{user}', [MessageController::class, 'show'])->name('dm.show');
    Route::post('/dm/{user}', [MessageController::class, 'store']);
});

Route::patch('/dm/message/{message}', [MessageController::class, 'update'])->name('dm.update');
Route::delete('/dm/message/{message}', [MessageController::class, 'destroy'])->name('dm.destroy');
require __DIR__.'/auth.php';
