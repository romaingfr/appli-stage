<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'name_boite',
        'forme_juridique',
        'adresse_siege',
        'code_postal',
        'localite',
        'code_insee',
        'siret',
        'code_naf',
        'nom_client',
        'prenom_client',
        'numero_telephone',
        'numero_mobile',
        'email',
        'nom_facturation',
        'prenom_facturation',
        'telephone_facturation',
        'adresse_facturation',
        'code_postal_facturation',
        'ville_facturation'
    ];

    /**
     * @return HasMany<Site>
     */
    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    /**
     * @param string|null $value
     */
    public function setNumeroTelephoneAttribute(?string $value): void
    {
        if ($value) {
            $value = preg_replace('/[^0-9]/', '', $value);
            $this->attributes['numero_telephone'] = trim(chunk_split($value, 2, ' '));
        }
    }

    /**
     * @param string|null $value
     */
    public function setNumeroMobileAttribute(?string $value): void
    {
        if ($value) {
            $value = preg_replace('/[^0-9]/', '', $value);
            $this->attributes['numero_mobile'] = trim(chunk_split($value, 2, ' '));
        }
    }

    /**
     * @param string|null $value
     */
    public function setTelephoneFacturationAttribute(?string $value): void
    {
        if ($value) {
            $value = preg_replace('/[^0-9]/', '', $value);
            $this->attributes['telephone_facturation'] = trim(chunk_split($value, 2, ' '));
        }
    }
}
