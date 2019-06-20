@extends('layouts.app')

@section('content')

    <h1>Posts</h1>
    @forelse($posts as $post)
        <p>
            {{ $post->title }}
            <a href="{{ route('posts.edit', $post->id) }}">Editar</a>
        </p>
        <hr>
    @empty
        <p>Nenhum post.</p>
    @endforelse

@endsection
