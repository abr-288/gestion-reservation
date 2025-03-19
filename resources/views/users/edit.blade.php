@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Profil</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Champ pour le nom -->
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Champ pour l'email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Champ pour la photo de profil -->
        <div class="form-group">
            <label for="photo">Photo de profil</label>
            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
            @error('photo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Afficher la photo de profil actuelle -->
        <div class="form-group">
            <label>Photo de profil actuelle</label>
            <div>
                @if ($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" class="img-thumbnail" width="150">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Photo de profil par défaut" class="img-thumbnail" width="150">
                @endif
            </div>
        </div>

        <!-- Bouton de soumission -->
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection