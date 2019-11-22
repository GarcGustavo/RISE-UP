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
    public $table = 'CS_Parameter';
    protected  $primaryKey = 'csp_id';
    protected $dates = ['deleted_at'];

    //protected $dates = false;

    public $timestamps = false;

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
<<<<<<< HEAD
        return $this->belongsToMany(\App\Models\case_study::class, 'case_parameters');
=======
        return $this->belongsToMany(\App\Models\Case_study::class, 'case_parameters');
>>>>>>> Gustavo
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function options()
    {
        return $this->hasMany(\App\Models\Option::class, 'o_parameter');
    }
}
