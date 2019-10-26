<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class case
 * @package App\Models
 * @version October 25, 2019, 6:15 am UTC
 *
 * @property \App\Models\Group cGroup
 * @property \App\Models\User cOwner
 * @property \Illuminate\Database\Eloquent\Collection csParameters
 * @property \Illuminate\Database\Eloquent\Collection itemTypes
 * @property string c_title
 * @property string c_description
 * @property string c_thumbnail
 * @property string c_status
 * @property string c_date
 * @property integer c_owner
 * @property integer c_group
 */
class case extends Model
{
    use SoftDeletes;

    public $table = 'case';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'c_title',
        'c_description',
        'c_thumbnail',
        'c_status',
        'c_date',
        'c_owner',
        'c_group'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'cid' => 'integer',
        'c_title' => 'string',
        'c_description' => 'string',
        'c_thumbnail' => 'string',
        'c_status' => 'string',
        'c_date' => 'date',
        'c_owner' => 'integer',
        'c_group' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'c_title' => 'required',
        'c_description' => 'required',
        'c_thumbnail' => 'required',
        'c_status' => 'required',
        'c_date' => 'required',
        'c_owner' => 'required',
        'c_group' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cGroup()
    {
        return $this->belongsTo(\App\Models\Group::class, 'c_group');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cOwner()
    {
        return $this->belongsTo(\App\Models\User::class, 'c_owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function csParameters()
    {
        return $this->belongsToMany(\App\Models\CsParameter::class, 'case_parameters');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function itemTypes()
    {
        return $this->belongsToMany(\App\Models\ItemType::class, 'item');
    }
}
