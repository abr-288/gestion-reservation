<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de {{ $user->name }}</title>
</head>
<body>
    <div class="container mt-4">
        <h1>Bienvenue, {{ $user->name }}</h1>
        <p>Email: {{ $user->email }}</p>
        <p>Inscrit depuis: {{ $user->created_at->format('d/m/Y') }}</p>
        <div>
            <h4>Photo de Profil:</h4>
            <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.png') }}" alt="Photo de profil" class="profile-img">
        </div>
    </div>
</body>
</html>