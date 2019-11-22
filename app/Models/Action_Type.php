<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class action_type
 * @package App\Models
 * @version October 25, 2019, 6:18 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string act_name
 */
class action_type extends Model
{
<<<<<<< HEAD
    use SoftDeletes;

    public $table = 'Action_Type';

    protected $dates = ['deleted_at'];
=======
    public $table = 'Action_Type';

    protected $dates = false;
>>>>>>> Gustavo

    public $timestamps = false;

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'action');
    }
}
