<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class role
 * @package App\Models
 * @version October 25, 2019, 6:22 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string r_creation_date
 * @property string r_name
 */
class role extends Model
{
    protected $dates = false;

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    public $fillable = [
        'r_creation_date',
        'r_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'rid' => 'integer',
        'r_creation_date' => 'date',
        'r_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'r_creation_date' => 'required',
        'r_name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'u_role');
    }
}
