<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Action_Type
 * @package App\Models
 * @version October 23, 2019, 10:57 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string act_name
 */
class Action_Type extends Model
{
    use SoftDeletes;

    public $table = 'action_type';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'act_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'act_id' => 'integer',
        'act_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'act_name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'action');
    }
}
