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
    //use SoftDeletes;
    public $table = 'Case_Parameters';

    protected  $primaryKey = 'cid';

    //protected $dates = ['deleted_at'];

    //protected $dates = false;

    public $timestamps = false;

    public $fillable = [
        'csp_id',
        'opt_selected'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cid' => 'integer',
        'csp_id' => 'integer',
        'opt_selected' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'csp_id' => 'required',
        'opt_selected' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cCase()
    {
        return $this->belongsTo(\App\Models\case_study::class, 'cid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cParameter()
    {
        return $this->belongsTo(\App\Models\cs_parameter::class, 'csp_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cOption()
    {
        return $this->belongsTo(\App\Models\Option::class, 'oid');
    }
}
