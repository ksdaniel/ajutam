<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable = [
        "user_id",
        "name",
        "email",
        "phone",
        "city",
        "county",
        "address",
        "neighborhood",
        "activation_area",
        "involvement_type",
        "availability",
        "availability_details",
        "observations",
        "geojson",
        "ci",
        "cnp",
        "loc_domiciliu",
        "str_domiciliu",
        "nr_domiciliu",
        "ap_domiciliu",
        "ip_acord",
        "data_acord",
        "involvement_direction",
    ];

    protected $casts = [

        "geojson" => "json"
    ];

    public function user()
    {

        return $this->belongsTo(User::class);
    }
}
