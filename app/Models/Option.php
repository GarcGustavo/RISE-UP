<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class option
 * @package App\Models
 * @version October 25, 2019, 6:22 am UTC
 *
 * @property \App\Models\CsParameter oParameter
 * @property integer o_parameter
 * @property string o_content
 */
class option extends Model
{
    use SoftDeletes;

    public $table = 'option';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'o_parameter',
        'o_content'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'oid' => 'integer',
        'o_parameter' => 'integer',
        'o_content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'o_parameter' => 'required',
        'o_content' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function oParameter()
    {
        return $this->belongsTo(\App\Models\CsParameter::class, 'o_parameter');
    }
}
