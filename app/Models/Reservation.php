<?php

// Reservation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'statut',
    ];

    // Relation avec le modèle Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}