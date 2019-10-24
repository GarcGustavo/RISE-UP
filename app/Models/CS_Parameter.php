<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CS_Parameter
 * @package App\Models
 * @version October 23, 2019, 10:58 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection caseParameters
 * @property \Illuminate\Database\Eloquent\Collection options
 * @property string csp_name
 */
class CS_Parameter extends Model
{
    use SoftDeletes;

    public $table = 'cs_parameter';

    protected $dates = ['deleted_at'];



    public $fillable = [
        'csp_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'csp_id' => 'integer',
        'csp_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'csp_name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function caseParameters()
    {
        return $this->hasMany(\App\Models\CaseParameter::class, 'csp_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function options()
    {
        return $this->hasMany(\App\Models\Option::class, 'o_parameter');
    }
}
