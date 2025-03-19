<?php

// Client.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'type_document',
        'numero_document',
        'PNR',
        'type_voyage',
        'date_voyage_aller',
        'date_voyage_retour',
        'date_annulation',
        'numero_client',
        'prix_billet',
        'nom_agent',
    ];

    // Relation avec le modèle Reservation
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}