<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable =['name','project_id','prevision_finish_date','isCompleted'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(){
        return $this->hasOne( 'App\Projects', 'project_id', 'project_id' );
    }
}


