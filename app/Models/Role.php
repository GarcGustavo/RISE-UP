<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 * @package App\Models
 * @version October 23, 2019, 10:59 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string r_name
 * @property string r_creation_date
 */
class Role extends Model
{
    use SoftDeletes;

    public $table = 'role';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'r_name',
        'r_creation_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'rid' => 'integer',
        'r_name' => 'string',
        'r_creation_date' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'r_name' => 'required',
        'r_creation_date' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'u_role');
    }
}
