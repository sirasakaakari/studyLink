<form method="POST" action="/guest-login">
    @csrf

    <h2>ゲストで学習する</h2>

    <input type="text" name="name" placeholder="ユーザ名" required>

    <button type="submit">始める</button>
</form>