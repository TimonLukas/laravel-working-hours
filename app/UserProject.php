<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserProject
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $project_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserProject whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserProject whereUserId($value)
 */
class UserProject extends Model
{

    protected $fillable = [
        'user_id',
        'project_id',
    ];
}
