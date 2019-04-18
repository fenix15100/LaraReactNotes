<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, String $project_id)
 */
class Projects extends Model
{
    protected $fillable = [
        'project_id', 
        'name', 
        'description', 
        'start_date',
        'finish_date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getTasks(){
        return $this->hasMany( 'App\Task', 'project_id', 'project_id' );
    }



}
