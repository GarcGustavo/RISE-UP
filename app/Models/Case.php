<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Case
 * @package App\Models
 * @version October 23, 2019, 10:57 pm UTC
 *
 * @property \App\Models\User cOwner
 * @property \App\Models\Group cGroup
 * @property \App\Models\CaseParameter caseParameter
 * @property \Illuminate\Database\Eloquent\Collection itemTypes
 * @property string c_title
 * @property string c_description
 * @property string c_thumbnail
 * @property string c_status
 * @property string c_date
 * @property integer c_owner
 * @property integer c_group
 */
class Case extends Model
{
    use SoftDeletes;

    public $table = 'case';

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
        'c_status' => 'required',
        'c_date' => 'required',
        'c_owner' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cOwner()
    {
        return $this->belongsTo(\App\Models\User::class, 'c_owner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function cGroup()
    {
        return $this->belongsTo(\App\Models\Group::class, 'c_group');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function caseParameter()
    {
        return $this->hasOne(\App\Models\CaseParameter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function itemTypes()
    {
        return $this->belongsToMany(\App\Models\ItemType::class, 'item');
    }
}
