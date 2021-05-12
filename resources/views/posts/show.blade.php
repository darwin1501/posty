@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            {{-- if there is a post --}}
            @if ($posts->count())
                <div>
                    <a href="{{ route('users.post', $posts->user) }}" class="font-bold">{{ $posts->user->username}}</a>
                    {{-- use carbon library to manipulate date --}}
                    <span class="text-gray-600 text-sm">{{ $posts->created_at->diffForHumans() }}</span>
                </div>
                <p class="mb-4">{{ $posts->body }}</p>
                @auth
                         @can('delete', $posts)
                    {{-- @if ($post->ownedBy(auth()->user())) --}}
                            <div>
                                <form action="{{ route('post.destroy', $posts)}}" method="POST">
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
                   @if(!$posts->likeBy(auth()->user()))
                    {{-- pass the post data at route('post.like') --}}
                        <form action="{{ route('post.like', $posts) }}" method="POST" class="mr-1">
                            @csrf
                            <button type="submit" class="text-blue-500">Like</button>
                        </form>
                    @else
                        <form action="{{ route('post.like', $posts) }}" method="POST" class="mr-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-500">Unlike</button>
                        </form>
                    @endif
                    @endauth
                    {{-- Laravel String Helper helps to pluralize automatically the word like
                        when like is greater than 1 --}}
                    <span>{{ $posts->likes->count() }} {{ Str::plural('like', $posts->likes->count()) }}</span>
                </div>
                {{-- generate pagination links automatically --}}
                {{-- {{ $posts->links() }} --}}
            @else
                <p>No post to show</p>
            @endif
        </div>
    </div>
@endsection