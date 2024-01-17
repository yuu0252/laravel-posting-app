@include('includes.head')

<h1>投稿編集</h1>
@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<a href="{{ route('posts.index') }}">&lt; 戻る</a>

<form action="{{ route('posts.update', $post) }}" method="POST">
    @csrf
    @method('PATCH')
    <div>
        <label for="title">タイトル</label>
        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}">
    </div>
    <div>
        <label for="content">本文</label>
        <textarea name="content" id="content">{{ old('content', $post->content) }}</textarea>
    </div>
    <button type="submit">更新</button>
</form>

@include('includes.foot')
