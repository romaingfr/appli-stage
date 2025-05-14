<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'client_id',
        'site_id',
        'configuration',
        'lignes',
    ];

    protected $casts = [
        'configuration' => 'array',
        'lignes' => 'array',
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
