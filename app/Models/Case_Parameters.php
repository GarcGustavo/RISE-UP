<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class case_parameters
 * @package App\Models
 * @version October 25, 2019, 6:19 am UTC
 *
 * @property \App\Models\CsParameter cGroup
 * @property \App\Models\Case_Study cOwner
 * @property integer c_owner
 * @property integer c_group
 */
class case_parameters extends Model
{
    public $table = 'Case_Parameters';

    protected $dates = false;

    public $timestamps = false;

    public $fillable = [
        'c_owner',
        'c_group'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'c_owner' => 'integer',
        'c_group' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'c_owner' => 'required',
        'c_group' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cGroup()
    {
        return $this->belongsTo(\App\Models\CsParameter::class, 'c_group');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cOwner()
    {
        return $this->belongsTo(\App\Models\case_study::class, 'c_owner');
    }
}
