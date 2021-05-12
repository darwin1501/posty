@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            @auth
                <form action="{{ route('post') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="body" class="sr-only">Body</label>
                        <textarea name="body" id="body" cols="30" rows="4" class="bg-gray-100 
                        border-2 w-full p-4 rounded-lg mb-2 @error('body') border-red-500 @enderror"
                        placeholder="Post something Amazing!"></textarea>

                        @error('body')
                            <div class="text-red-500 mb-2 text-center mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                        <div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2
                            rounded font-medium">Post</button>
                        </div>
                    </div>
                </form>
            @endauth
            {{-- if there is a post --}}
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
                <p>No post to show</p>
            @endif
        </div>
    </div>
@endsection