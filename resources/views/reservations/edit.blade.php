@extends('layouts.app')

@section('content')
    <h1>Modifier la Réservation</h1>

    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="client_id">Client :</label>
            <select name="client_id" id="client_id" required>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $reservation->client_id == $client->id ? 'selected' : '' }}>{{ $client->nom }} {{ $client->prenom }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="statut">Statut :</label>
            <input type="text" name="statut" id="statut" value="{{ $reservation->statut }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection