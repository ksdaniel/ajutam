<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'neighborhood',
        'city',
        'county'
    ];

    public function solicitation()
    {
        return $this->hasMany(Solicitation::class);
    }
}
