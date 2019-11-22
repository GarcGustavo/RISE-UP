<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class user
 * @package App\Models
 * @version October 25, 2019, 6:18 am UTC
 *
 * @property \App\Models\Role uRole
 * @property \Illuminate\Database\Eloquent\Collection actionTypes
 * @property \Illuminate\Database\Eloquent\Collection groups
 * @property \Illuminate\Database\Eloquent\Collection group1s
 * @property \Illuminate\Database\Eloquent\Collection group2s
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string contact_email
 * @property string u_creation_date
 * @property boolean u_ban_status
 * @property string current_edit_cid
 * @property integer u_role
 */
class user extends Model
{
<<<<<<< HEAD
    use SoftDeletes;

    public $table = 'User';

    protected $dates = ['deleted_at'];
=======
    public $table = 'User';

    //protected $dates = false;
>>>>>>> Gustavo

    public $timestamps = false;

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
        'u_ban_status' => 'boolean',
        'current_edit_cid' => 'string',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function actions()
    {
        return $this->belongsTo(\App\Models\ActionType::class, 'action');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function groups()
    {
        return $this->belongsToMany(\App\Models\Group::class, 'gid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function groupsOwned()
    {
        return $this->hasMany(\App\Models\Group::class, 'g_owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function userGroups()
    {
        return $this->belongsToMany(\App\Models\Group::class, 'user_groups');
    }
}
