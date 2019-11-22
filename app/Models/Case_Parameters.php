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
<<<<<<< HEAD
    use SoftDeletes;

    public $table = 'Case_Parameters';

    protected $dates = ['deleted_at'];
=======
    public $table = 'Case_Parameters';
    protected  $primaryKey = 'cid';

    //protected $dates = false;
>>>>>>> Gustavo

    public $timestamps = false;

    public $fillable = [
        'cid',
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
        'opt_selected' => 'required'
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
<<<<<<< HEAD
        return $this->belongsTo(\App\Models\case_study::class, 'c_owner');
=======
        return $this->belongsTo(\App\Models\option::class, 'oid');
>>>>>>> Gustavo
    }
}
