<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class item
 * @package App\Models
 * @version October 25, 2019, 6:21 am UTC
 *
 * @property \App\Models\Case iCase
 * @property \App\Models\ItemType iType
 * @property string i_content
 * @property integer i_case
 * @property integer i_type
 */
class item extends Model
{
    public $table = 'Item';

    //protected $dates = false;

    public $timestamps = false;

    public $fillable = [
        'i_content',
        'i_case',
        'i_type',
        'order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'iid' => 'integer',
        'i_content' => 'string',
        'i_case' => 'integer',
        'i_type' => 'integer',
        'order' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'i_content' => 'required',
        'i_case' => 'required',
        'i_type' => 'required',
        'order' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function iCase()
    {
        return $this->belongsTo(\App\Models\Case_study::class, 'i_case');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function iType()
    {
        return $this->belongsTo(\App\Models\ItemType::class, 'i_type');
    }
}
