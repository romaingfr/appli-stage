<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'client_id',
        'site_id',
        'nom',           // Ajout de ce champ
        'configuration',
        'lignes',
        'services',      // Ajout de ce champ
    ];

    protected $casts = [
        'configuration' => 'array',
        'lignes' => 'array',
        'services' => 'array', // Ajout de ce cast
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
