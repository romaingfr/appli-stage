<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'nom',
        'adresse',
        'principal',
        'services',
        'client_id',
        'name_boite',
        'forme_juridique',
        'adresse_siege',
        'code_postal',
        'localite',
        'code_insee',
        'siret',
        'code_naf',
        'mobile'

    ];
    protected $casts = [
        'services' => 'array',
        'principal' => 'boolean',
        'svi' => 'boolean',
        'cloud' => 'boolean',
        'is_principal' => 'boolean',
        'channel_count' => 'integer',
        'access_links' => 'array',
        'mobile_lines' => 'array'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
