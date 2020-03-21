<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitation extends Model
{
    protected $fillable = [

        "beneficiary_id",
        "volunteer_id",
        "categories",
        "emergency",
        "status",
        "additional_responses",
        "observations",
        "finish_date",
    ];

    protected $casts = [

        "additional_responses" => "json"
    ];

    public function volunteer()
    {

        return $this->belongsTo(User::class);
    }

    public function beneficiary()
    {

        return $this->belongsTo(Beneficiary::class);
    }
}
