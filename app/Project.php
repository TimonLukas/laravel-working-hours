<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name'
    ];

    public function works()
    {
        return $this->hasMany(Work::class, 'project_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'works');
    }

    public function getHoursAttribute()
    {
        return $this->works->reduce(function ($carry, $work) {
            return $carry + $work->hours;
        }) ?: 0;
    }

    public function getCostAttribute()
    {
        return $this->works->reduce(function ($carry, $work) {
            return $carry + $work->hours * $work->rate;
        }) ?: 0;
    }
}
