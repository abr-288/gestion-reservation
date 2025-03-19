@extends('layouts.app')

@section('content')
    <h1>Créer une nouvelle réservation</h1>

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf
        <div>
            <label for="client_id">Client :</label>
            <select name="client_id" class="form-control" required>
                <option value="">Sélectionnez un client</option>
                @foreach($clients as $clientOption)
                    <option value="{{ $clientOption->id }}" {{ isset($client) && $client->id == $clientOption->id ? 'selected' : '' }}>
                        {{ $clientOption->nom }} {{ $clientOption->prenom }}
                    </option>
                @endforeach
            </select>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
@endsection