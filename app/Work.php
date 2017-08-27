<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Work
 *
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @property string $start
 * @property float $hours
 * @property string $work_done
 * @property float $rate
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Project $project
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Work whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Work whereHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Work whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Work whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Work whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Work whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Work whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Work whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Work whereWorkDone($value)
 * @mixin \Eloquent
 */
class Work extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'user_id',
        'project_id',
        'start',
        'hours',
        'work_done',
        'rate'
    ];

    protected $dates = ['start'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
