@component('mail::message')
# Introduction

{{ $liker->name }} liked your post

{{-- this is a buttton --}}
@component('mail::button', ['url' => route('post.show', $post)])
View Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
