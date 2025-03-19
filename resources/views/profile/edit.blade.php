@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le profil</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmation du mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <<div class="form-group">
            <label>Photo de profil actuelle</label>
            <div>
                @if ($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" class="img-thumbnail" width="150">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Photo de profil par défaut" class="img-thumbnail" width="150">
                @endif
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
