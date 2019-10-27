<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
<<<<<<< HEAD
 * Class option
 * @package App\Models
 * @version October 25, 2019, 6:22 am UTC
 *
 * @property \App\Models\CsParameter oParameter
 * @property integer o_parameter
 * @property string o_content
 */
class option extends Model
=======
 * Class Option
 * @package App\Models
 * @version October 23, 2019, 10:59 pm UTC
 *
 * @property \App\Models\CsParameter oParameter
 * @property string o_content
 * @property integer o_parameter
 */
class Option extends Model
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
{
    use SoftDeletes;

    public $table = 'option';
    
<<<<<<< HEAD
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'o_parameter',
        'o_content'
=======
    protected $dates = ['deleted_at'];

 

    public $fillable = [
        'o_content',
        'o_parameter'
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'oid' => 'integer',
<<<<<<< HEAD
        'o_parameter' => 'integer',
        'o_content' => 'string'
=======
        'o_content' => 'string',
        'o_parameter' => 'integer'
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
<<<<<<< HEAD
        'o_parameter' => 'required',
        'o_content' => 'required'
=======
        'o_content' => 'required',
        'o_parameter' => 'required'
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function oParameter()
    {
        return $this->belongsTo(\App\Models\CsParameter::class, 'o_parameter');
    }
}
