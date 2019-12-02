<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Option
 * @package App\Models
 * @version October 23, 2019, 10:59 pm UTC
 *
 * @property \App\Models\CsParameter oParameter
 * @property string o_content
 * @property integer o_parameter
 * @property boolean is_default
 */
class Option extends Model
{
    public $table = 'Option';
    
    protected  $primaryKey = 'oid';

    //protected $dates = false;

    public $timestamps = false;

    public $fillable = [
        'o_content',
        'o_parameter',
        'is_default'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'oid' => 'integer',
        'o_content' => 'string',
        'o_parameter' => 'integer', 
        'is_default' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'o_content' => 'required',
        'o_parameter' => 'required',
        'is_default' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function oParameter()
    {
        return $this->belongsTo(\App\Models\CsParameter::class, 'o_parameter');
    }
}
