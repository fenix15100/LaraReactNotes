<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable =['name','project_id','prevision_finish_date','isCompleted'];
}


