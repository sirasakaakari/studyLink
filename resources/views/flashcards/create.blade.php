<h2>新しい単語帳を作成</h2>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('wordbooks.store') }}" method="POST">
    @csrf
    <label for="title">単語帳のタイトル:</label>
    <input type="text" name="title" id="title" required>
    <button type="submit">作成</button>
</form>
