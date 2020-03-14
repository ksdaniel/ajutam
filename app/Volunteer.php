<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable=[
        "user_id",
        "name",
        "email",
        "phone",
        "city",
        "address",
        "address",
        "neighborhood",
        "activation_area",
        "involvement_type",
        "availability",
        "availability_details",
        "observations",
        "geojson",
    ];
}
