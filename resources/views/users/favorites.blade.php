@extends('layouts.app')

@section('content')
    <div class="sm:grid sm:grid-cols-3 sm:gap-10">
        <aside class="mt-4">
            {{-- ユーザー情報 --}}
            @include('users.card')
        </aside>
        <div class="sm:col-span-2 mt-4">
            {{-- タブ --}}
            @include('users.navtabs')
            <div class="mt-4">
                {{-- ユーザー一覧 --}}
                @if($favorites->count() > 0)
            @foreach ($favorites as $micropost)
                <li class="flex items-start gap-x-2 mb-4">
                    {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                    <div class="avatar">
                        <div class="w-12 rounded">
                            <img src="{{ Gravatar::get($micropost->user->email) }}" alt="" />
                        </div>
                    </div>
                    <div>
                        <div>
                            {{-- 投稿の所有者のユーザー詳細ページへのリンク --}}
                            <a class="link link-hover text-info" href="{{ route('users.show', $micropost->user->id) }}">{{ $micropost->user->name }}</a>
                            <span class="text-muted text-gray-500">posted at {{ $micropost->created_at }}</span>
                        </div>
                        <div>
                            {{-- 投稿内容 --}}
                            <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                        </div>
                        <div>
                            @if (Auth::id() == $micropost->user_id)
                                {{-- 投稿削除ボタンのフォーム --}}
                                <form method="POST" action="{{ route('microposts.destroy', $micropost->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm normal-case" 
                                        onclick="return confirm('Delete id = {{ $micropost->id }} ?')">Delete</button>
                                </form>
                            @endif
                        </div>
                        
                        <div>
                            
                            @if (Auth::id() == $user->id)
                                @if (Auth::user()->is_favorite($micropost->id))
                                    {{-- アンフォローボタンのフォーム --}}
                                    <form method="POST" action="{{ route('favorites.unfavorite', $micropost->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-Success btn-sm normal-case" 
                                            onclick="return confirm('id = {{ $micropost->id }} のお気に入りを外します。よろしいですか？')">Unfavorite</button>
                                    </form>
                                @else
                                    {{-- フォローボタンのフォーム --}}
                                    <form method="POST" action="{{ route('favorites.favorite', $micropost->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm normal-case">favorite</button>
                                    </form>
                                @endif
                            @endif
                            
                        </div>
                        
                        <div>
                            
                            @if (Auth::id() != $user->id)
                                @if (Auth::user()->is_favorite($micropost->id))
                                    {{-- アンフォローボタンのフォーム --}}
                                    <form method="POST" action="{{ route('favorites.unfavorite', $micropost->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-Success btn-sm normal-case" 
                                            onclick="return confirm('id = {{ $micropost->id }} のお気に入りを外します。よろしいですか？')">Unfavorite</button>
                                    </form>
                                @else
                                    {{-- フォローボタンのフォーム --}}
                                    <form method="POST" action="{{ route('favorites.favorite', $micropost->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm normal-case">favorite</button>
                                    </form>
                                @endif
                            @endif
                            
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        {{-- ページネーションのリンク --}}
        {{ $favorites->links() }}
    @endif
            </div>
        </div>
    </div>    
@endsection

