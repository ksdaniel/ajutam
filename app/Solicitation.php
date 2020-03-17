<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitation extends Model
{
    protected $fillable=[
        "name",
        "last_name",
        "phone",
        "city",
        "address",
        "neighborhood",
        "county",
        "categories",
        "emergency",
        "status",
        "additional_responses",
        "observations",
        "finish_date",
        "volunteer_id",
    ];

    protected $casts=[

        "additional_responses"=>"json"
    ];
}
