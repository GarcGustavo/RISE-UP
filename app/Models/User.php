<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App\Models
 * @version October 23, 2019, 10:54 pm UTC
 *
 * @property \App\Models\Role uRole
 * @property \Illuminate\Database\Eloquent\Collection actionTypes
 * @property \Illuminate\Database\Eloquent\Collection groups
 * @property \Illuminate\Database\Eloquent\Collection group1s
 * @property \Illuminate\Database\Eloquent\Collection userGroups
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string contact_email
 * @property string u_creation_date
 * @property string u_ban_status
 * @property integer current_edit_cid
 * @property integer u_role
 */
class User extends Model
{
    use SoftDeletes;

    public $table = 'user';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_email',
        'u_creation_date',
        'u_ban_status',
        'current_edit_cid',
        'u_role'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'uid' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'contact_email' => 'string',
        'u_creation_date' => 'date',
        'u_ban_status' => 'string',
        'current_edit_cid' => 'integer',
        'u_role' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required',
        'contact_email' => 'required',
        'u_creation_date' => 'required',
        'u_ban_status' => 'required',
        'current_edit_cid' => 'required',
        'u_role' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function uRole()
    {
        return $this->belongsTo(\App\Models\Role::class, 'u_role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function actionTypes()
    {
        return $this->belongsToMany(\App\Models\ActionType::class, 'action');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function groups()
    {
        return $this->belongsToMany(\App\Models\Group::class, 'case');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function group1s()
    {
        return $this->hasMany(\App\Models\Group::class, 'g_owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userGroups()
    {
        return $this->hasMany(\App\Models\UserGroup::class, 'uid');
    }
}
