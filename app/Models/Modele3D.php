<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modele3D extends Model
{
    use HasFactory;

    protected $table = 'modele3ds';

    protected $fillable = [
        'nom_fichier',
        'format',
        'taille_originale',
        'chemin_stockage',
        'est_compresse',
        'url_hebergement',
    ];
}