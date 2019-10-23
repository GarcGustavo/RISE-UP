<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Group
 * @package App\Models
 * @version October 23, 2019, 10:58 pm UTC
 *
 * @property \App\Models\User gOwner
 * @property \Illuminate\Database\Eloquent\Collection user1s
 * @property \App\Models\UserGroup userGroup
 * @property string g_name
 * @property string g_status
 * @property string g_creation_date
 * @property integer g_owner
 */
class Group extends Model
{
    use SoftDeletes;

    public $table = 'group';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'g_name',
        'g_status',
        'g_creation_date',
        'g_owner'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'gid' => 'integer',
        'g_name' => 'string',
        'g_status' => 'string',
        'g_creation_date' => 'date',
        'g_owner' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'g_name' => 'required',
        'g_status' => 'required',
        'g_creation_date' => 'required',
        'g_owner' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function gOwner()
    {
        return $this->belongsTo(\App\Models\User::class, 'g_owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function user1s()
    {
        return $this->belongsToMany(\App\Models\User::class, 'case');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function userGroup()
    {
        return $this->hasOne(\App\Models\UserGroup::class);
    }
}
