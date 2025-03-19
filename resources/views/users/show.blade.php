@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de l'utilisateur</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->name }}</h5>
            <p class="card-text">{{ $user->email }}</p>
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Modifier</a>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection