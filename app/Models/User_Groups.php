<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User_Groups
 * @package App\Models
 * @version October 23, 2019, 11:00 pm UTC
 *
 * @property \App\Models\Group gid
 * @property \App\Models\User uid
 * @property integer uid
 */
class User_Groups extends Model
{
    use SoftDeletes;

    public $table = 'user_groups';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'uid'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'gid' => 'integer',
        'uid' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'uid' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function gid()
    {
        return $this->belongsTo(\App\Models\Group::class, 'gid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function uid()
    {
        return $this->belongsTo(\App\Models\User::class, 'uid');
    }
}
