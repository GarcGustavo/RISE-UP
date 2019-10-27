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
    use SoftDeletes;

    public $table = 'user';
    
<<<<<<< HEAD
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


=======
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
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
<<<<<<< HEAD
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function actionTypes()
    {
        return $this->belongsToMany(\App\Models\ActionType::class, 'action');
=======
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function actions()
    {
        return $this->belongsTo(\App\Models\ActionType::class, 'action');
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function groups()
    {
<<<<<<< HEAD
        return $this->belongsToMany(\App\Models\Group::class, 'case');
=======
        return $this->belongsToMany(\App\Models\Group::class, 'gid');
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
<<<<<<< HEAD
    public function group1s()
=======
    public function groupsOwned()
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    {
        return $this->hasMany(\App\Models\Group::class, 'g_owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
<<<<<<< HEAD
    public function group2s()
=======
    public function userGroups()
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    {
        return $this->belongsToMany(\App\Models\Group::class, 'user_groups');
    }
}
