@extends('layouts.app')

@section('content')

    <h1>Cadastrar post</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('posts.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label>
                <input type="text" name="title" placeholder="Título" class="form-control">
            </label>
        </div>
        <div class="form-group">
            <label>
                <textarea cols="30" name="body" placeholder="Conteúdo" rows="5" class="form-control"></textarea>
            </label>
        </div>
        <div class="form-group">
            <button class="btn btn-success" type="submit">Enviar</button>
        </div>
    </form>

@endsection
