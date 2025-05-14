<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneTerminal extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'terminal_type',
        'serial_number',
        'is_available',
        'notes'
    ];
}
