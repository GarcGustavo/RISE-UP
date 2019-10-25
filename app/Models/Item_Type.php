<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class item_type
 * @package App\Models
 * @version October 25, 2019, 6:21 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection cases
 * @property string itt_name
 */
class item_type extends Model
{
    use SoftDeletes;

    public $table = 'item_type';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'itt_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'itt_id' => 'integer',
        'itt_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'itt_name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function cases()
    {
        return $this->belongsToMany(\App\Models\Case::class, 'item');
    }
}
