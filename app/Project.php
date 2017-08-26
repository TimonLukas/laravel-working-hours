<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Project
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read mixed $cost
 * @property-read mixed $hours
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Work[] $works
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Project whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
        return $this->belongsToMany(User::class, 'user_projects');
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
