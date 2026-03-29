<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Wordbook;

class Eiken2WordsSeeder extends Seeder
{
    public function run(): void
    {
        // 既存の英検2級単語帳（user_idはNULL＝共通単語帳）
        $wordbook = Wordbook::create([
            'name' => '英検2級',
            'user_id' => null, // NULL禁止なら 0 にして共通扱い
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
            Word::create([
                'word' => $w['word'],
                'meaning' => $w['meaning'],
                'wordbook_id' => $wordbook->id,
            ]);
        }
    }
}
