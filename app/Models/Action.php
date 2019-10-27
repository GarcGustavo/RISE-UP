<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class action
 * @package App\Models
 * @version October 25, 2019, 6:18 am UTC
 *
 * @property \App\Models\ActionType aType
 * @property \App\Models\User aUser
 * @property string a_date
 * @property integer a_type
 * @property integer a_user
 */
class action extends Model
{
    use SoftDeletes;

    public $table = 'action';
    protected $dates = ['deleted_at'];



    public $fillable = [
        'a_date',
        'a_type',
        'a_user'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'aid' => 'integer',
        'a_date' => 'date',
        'a_type' => 'integer',
        'a_user' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'a_date' => 'required',
        'a_type' => 'required',
        'a_user' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function aType()
    {
        return $this->belongsTo(\App\Models\ActionType::class, 'a_type');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function aUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'a_user');
    }
}
