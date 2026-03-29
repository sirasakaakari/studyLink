@if(!empty($achievedGoals))
<script>
alert("🎉 目標達成！\n\n{!! implode('\n', $achievedGoals) !!}");
</script>
@endif
@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto text-center">

    <h2 class="text-2xl font-bold mb-4">
        StudyLink Vocabulary - 結果
    </h2>

    <h1 class="text-xl mb-6">
        {{ $total }}問中 {{ $correctCount }} 問正解！
    </h1>

    @if(count($wrongWords) > 0)
        <h2 class="text-lg font-semibold mb-2">
            復習すべき単語
        </h2>

        <ul class="mb-6">
            @foreach($wrongWords as $id)
                @php $word = \App\Models\Word::find($id); @endphp
                @if($word)
                    <li>{{ $word->word }} = {{ $word->meaning }}</li>
                @endif
            @endforeach
        </ul>
    @endif

    <a href="{{ route('flashcards.index') }}"
       class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        もう一度挑戦 ▶
    </a>

</div>
@endsection

<!-- @section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(!empty($achievedGoals))
<script>
Swal.fire({
    icon: 'success',
    title: '🎉 目標達成！',
    html: `{!! implode('<br>', $achievedGoals) !!}`,
    timer: 3000,
    showConfirmButton: false
});
</script>
@endif
@endsection -->
