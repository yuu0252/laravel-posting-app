@include('includes.head')
<h1>投稿詳細</h1>

@if (session('flash_message'))
    <p>{{ session('flash_message') }}</p>
@endif

<a href="{{ route('posts.index') }}">&lt; 戻る</a>

<article>
    <h2>{{ $post->title }}</h2>
    <p>{{ $post->content }}</p>

    @if ($post->user_id === Auth::id())
        <a href="{{ route('posts.edit', $post) }}">編集</a>
    @endif
</article>
</main>

<footer>
    <p>&copy; 投稿アプリ All rights reserved.</p>
</footer>
</body>

</html>
