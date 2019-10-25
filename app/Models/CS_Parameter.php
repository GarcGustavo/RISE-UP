<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class cs_parameter
 * @package App\Models
 * @version October 25, 2019, 6:19 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection cases
 * @property \Illuminate\Database\Eloquent\Collection options
 * @property string csp_name
 */
class cs_parameter extends Model
{
    use SoftDeletes;

    public $table = 'cs_parameter';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function cases()
    {
        return $this->belongsToMany(\App\Models\Case::class, 'case_parameters');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function options()
    {
        return $this->hasMany(\App\Models\Option::class, 'o_parameter');
    }
}
