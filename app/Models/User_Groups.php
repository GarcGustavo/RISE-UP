<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class user_groups
 * @package App\Models
 * @version October 25, 2019, 6:23 am UTC
 *
 * @property \App\Models\Group gid
 * @property \App\Models\User uid
 * @property integer gid
 * @property integer uid
 */
class user_groups extends Model
{

    public $table = 'User_Groups';

    protected $primaryKey = 'gid';

    public $timestamps = false;

    public $fillable = [
        'gid',
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
        'gid' => 'required',
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
