<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $fillable = [
        'project_id', 
        'name', 
        'description', 
        'start_date',
        'finish_date',
    ];

    
}
