@extends('layouts.app')

@section('content')
<style>

* { box-sizing: border-box; }


/* ─── ページ全体 ─── */
.container {
    max-width: 480px;
    margin: 0 auto;
    min-height: 50vh;
    display: flex;
    flex-direction: column;
    background: #fff;
    border-left: 1px solid #dbdbdb;
    border-right: 1px solid #dbdbdb;
}

/* ─── ヘッダー ─── */
.dm-header {
    display: flex;
    align-items: center;
    padding: 14px 16px;
    border-bottom: 1px solid #efefef;
    background: #fff;
    position: sticky;
    top: 0;
    z-index: 10;
}

.dm-user {
    display: flex;
    align-items: center;
    gap: 12px;
}

.avatar-bubble {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    flex-shrink: 0;
}

.dm-user span {
    font-size: 15px;
    font-weight: 600;
    color: #262626;
}

/* ─── メッセージ一覧 ─── */
.chat-container {
    flex: 1;
    padding: 16px 12px 12px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    overflow-y: auto;
}

.no-message {
    text-align: center;
    color: #a8a8a8;
    font-size: 13px;
    margin-top: 40px;
}

/* メッセージ行 */
.message-wrapper {
    display: flex;
    flex-direction: column;
}

.message-wrapper.me {
    align-items: flex-end;
}

.message-wrapper.other {
    align-items: flex-start;
}

/* バブル本体 */
.message {
    max-width: 72%;
    padding: 10px 14px;
    border-radius: 20px;
    font-size: 14px;
    line-height: 1.55;
    word-break: break-word;
    position: relative;
    animation: popIn 0.18s ease;
}

@keyframes popIn {
    from { opacity: 0; transform: scale(0.95) translateY(4px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}

.message.me {
    background: #0095f6;
    color: #fff;
    border-bottom-right-radius: 5px;
}

.message.other {
    background: #efefef;
    color: #262626;
    border-bottom-left-radius: 5px;
}

/* タイムスタンプ */
.timestamp {
    font-size: 10px;
    margin-top: 4px;
    opacity: 0.6;
    text-align: right;
}

.message.other .timestamp {
    text-align: left;
}

/* 編集・削除ボタン */
.message-actions {
    display: flex;
    gap: 4px;
    margin-top: 5px;
    justify-content: flex-end;
}

.message-actions button {
    background: rgba(255, 255, 255, 0.18);
    border: none;
    border-radius: 8px;
    padding: 2px 6px;
    cursor: pointer;
    font-size: 13px;
    transition: background 0.15s;
}

.message-actions button:hover {
    background: rgba(255, 255, 255, 0.35);
}

/* 編集フォーム */
.edit-form {
    margin-top: 6px;
    display: flex;
    gap: 6px;
}

.edit-form input[type="text"] {
    flex: 1;
    border: 1.5px solid #dbdbdb;
    border-radius: 16px;
    padding: 6px 12px;
    font-size: 13px;
    font-family: inherit;
    outline: none;
    min-width: 0;

    background: #fff;
    color: #262626; /* ← これ追加 */
}
.edit-form input[type="text"]:focus {
    border-color: #0095f6;
}

.edit-form button {
    background: #0095f6;
    color: #fff;
    border: none;
    border-radius: 16px;
    padding: 6px 14px;
    font-size: 13px;
    font-family: inherit;
    font-weight: 600;
    cursor: pointer;
}

/* ─── 入力フォーム ─── */
.chat-input {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px 20px;
    border-top: 1px solid #efefef;
    background: #fff;
}

.chat-input input[type="text"] {
    flex: 1;
    border: 1.5px solid #dbdbdb;
    border-radius: 24px;
    padding: 10px 16px;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    background: transparent;
    color: #262626;
    min-width: 0;
    transition: border-color 0.2s;
}

.chat-input input[type="text"]::placeholder { color: #a8a8a8; }
.chat-input input[type="text"]:focus { border-color: #a8a8a8; }

.chat-input button[type="submit"] {
    background: none;
    border: none;
    font-size: 14px;
    font-weight: 600;
    color: #0095f6;
    cursor: pointer;
    padding: 4px 8px;
    flex-shrink: 0;
    font-family: inherit;
    transition: opacity 0.15s;
}

.chat-input button[type="submit"]:hover { opacity: 0.75; }
</style>

<div class="container">

    {{-- 🔝 上部ヘッダー --}}
    <div class="dm-header">
        <div class="dm-user">
            <div class="avatar-bubble">
                {{ mb_substr($user->name, 0, 1) }}
            </div>
            <span>{{ $user->name }}</span>
        </div>
    </div>

    {{-- 💬 メッセージ一覧 --}}
    <div class="chat-container" id="chat-container">
        @forelse($messages as $message)
            <div class="message-wrapper 
                {{ $message->sender_id === auth()->id() ? 'me' : 'other' }}">

                <div class="message 
                    {{ $message->sender_id === auth()->id() ? 'me' : 'other' }}">

                    {{ $message->message }}

                    <div class="timestamp">
                        {{ $message->created_at->format('H:i') }}
                    </div>

                    {{-- 自分のメッセージだけ編集・削除 --}}
                    @if($message->sender_id === auth()->id())
                        <div class="message-actions">
                            <button onclick="toggleEdit({{ $message->id }})">✏️</button>

                            <form action="{{ route('dm.destroy', $message->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">🗑</button>
                            </form>
                        </div>

                        <form id="edit-form-{{ $message->id }}"
                              action="{{ route('dm.update', $message->id) }}"
                              method="POST"
                              class="edit-form"
                              style="display:none;">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="message" value="{{ $message->message }}">
                            <button type="submit">保存</button>
                        </form>
                    @endif

                </div>
            </div>
        @empty
            <p class="no-message">まだメッセージはありません</p>
        @endforelse
    </div>

    {{-- ✍️ 入力フォーム --}}
    <form method="POST" class="chat-input">
        @csrf
        <input type="text" name="message" placeholder="メッセージを入力..." required>
        <button type="submit">送信</button>
    </form>

</div>

<script>
function toggleEdit(id) {
    let form = document.getElementById('edit-form-' + id);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// 最新メッセージまで自動スクロール
const chat = document.getElementById('chat-container');
chat.scrollTop = chat.scrollHeight;
</script>

@endsection