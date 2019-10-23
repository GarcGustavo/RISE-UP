<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Action
 * @package App\Models
 * @version October 23, 2019, 10:57 pm UTC
 *
 * @property \App\Models\User aUser
 * @property \App\Models\ActionType aType
 * @property string a_date
 * @property integer a_user
 * @property integer a_type
 */
class Action extends Model
{
    use SoftDeletes;

    public $table = 'action';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'a_date',
        'a_user',
        'a_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'aid' => 'integer',
        'a_date' => 'date',
        'a_user' => 'integer',
        'a_type' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'a_date' => 'required',
        'a_user' => 'required',
        'a_type' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function aUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'a_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function aType()
    {
        return $this->belongsTo(\App\Models\ActionType::class, 'a_type');
    }
}
