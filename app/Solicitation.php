<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitation extends Model
{
    protected $fillable = [

        "beneficiary_id",
        "volunteer_id",
        "coordonator_id",
        "categories",
        "emergency",
        "status",
        "additional_responses",
        "observations",
        "finish_date",
        "created_by",
        "payment_type",
        "payment_status",
        "payment_value",
        "code",
        "delivery_observation",
        "volunteer_confirmation",
        "delivery_period",

    ];

    protected $casts = [

        "additional_responses" => "json"
    ];

    public function volunteer()
    {

        return $this->belongsTo(Volunteer::class,"volunteer_id","id");
    }

    public function beneficiary()
    {

        return $this->belongsTo(Beneficiary::class);
    }

    public function creator()
    {

        return $this->belongsTo(User::class,"created_by");
    }

    public function coordinator()
    {

        return $this->belongsTo(Volunteer::class,"coordonator_id", "id");
    }
}
