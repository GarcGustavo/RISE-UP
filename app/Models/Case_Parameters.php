<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Case_Parameters
 * @package App\Models
 * @version October 23, 2019, 10:57 pm UTC
 *
 * @property \App\Models\Case cid
 * @property \App\Models\CsParameter csp
 * @property string opt_selected
 * @property integer csp_id
 */
class Case_Parameters extends Model
{
    use SoftDeletes;

    public $table = 'case_parameters';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'opt_selected',
        'csp_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'opt_selected' => 'string',
        'cid' => 'integer',
        'csp_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'opt_selected' => 'required',
        'csp_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cid()
    {
        return $this->belongsTo(\App\Models\Case::class, 'cid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function csp()
    {
        return $this->belongsTo(\App\Models\CsParameter::class, 'csp_id');
    }
}
