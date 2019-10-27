<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class group
 * @package App\Models
 * @version October 25, 2019, 6:21 am UTC
 *
 * @property \App\Models\User gOwner
 * @property \Illuminate\Database\Eloquent\Collection user1s
 * @property \Illuminate\Database\Eloquent\Collection user2s
 * @property string g_name
 * @property string g_status
 * @property string g_creation_date
 * @property integer g_owner
 */
class group extends Model
{
    use SoftDeletes;

    public $table = 'group';
    
<<<<<<< HEAD
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


=======
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
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
<<<<<<< HEAD
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function user1s()
    {
        return $this->belongsToMany(\App\Models\User::class, 'case');
=======
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function case()
    {
        return $this->hasMany(\App\Models\Case::class, 'case');
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
<<<<<<< HEAD
    public function user2s()
=======
    public function users()
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_groups');
    }
}
