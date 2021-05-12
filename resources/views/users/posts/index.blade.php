@extends('layouts.app')

@section('content')
    <div class="flex justify-center mb-2">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <h1 class="text-2xl font-medium mb-1">{{ $user->name }}</h1>
            <p class="mb-1">Posted: {{$posts->count()}} {{Str::plural('post', $posts->count())}}
            and recieved {{$user->recieveLikes()->count() }} {{Str::plural('like', $user->recieveLikes()->count())}}</p>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            @if ($posts->count())
            @foreach ($posts as $post)
            <div>
                <a href="{{ route('users.post', $post->user) }}" class="font-bold">{{ $post->user->username}}</a>
                {{-- use carbon library to manipulate date --}}
                <span class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <p class="mb-4">{{ $post->body }}</p>
            @auth
                    @can('delete', $post)
                {{-- @if ($post->ownedBy(auth()->user())) --}}
                        <div>
                            <form action="{{ route('post.destroy', $post)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-500">Delete</button>
                            </form>
                        </div>
                    @endcan
                {{-- @endif --}}
            @endauth
            {{-- like and unlike button --}}
            <div class="flex items-center mb-4">
            @auth
            @if(!$post->likeBy(auth()->user()))
                {{-- pass the post data at route('post.like') --}}
                    <form action="{{ route('post.like', $post) }}" method="POST" class="mr-1">
                        @csrf
                        <button type="submit" class="text-blue-500">Like</button>
                    </form>
                @else
                    <form action="{{ route('post.like', $post) }}" method="POST" class="mr-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-blue-500">Unlike</button>
                    </form>
                @endif
                @endauth
                {{-- Laravel String Helper helps to pluralize automatically the word like
                    when like is greater than 1 --}}
                <span>{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</span>
            </div>
            @endforeach
            {{-- generate pagination links automatically --}}
            {{ $posts->links() }}
        @else
            <p>{{ $user->name}} has no post</p>
        @endif
        </div>
    </div>
@endsection