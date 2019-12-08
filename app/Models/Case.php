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
class case_study extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'cid';

    public $table = 'Case';

    protected $dates = ['deleted_at'];

    public $timestamps = false;

    public $fillable = [
        'c_title',
        'c_description',
        'c_thumbnail',
        'c_incident_date',
        'c_group',
        'times_updated'
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
        'c_date' => 'date:Y-m-d',
        'c_incident_date' => 'date:Y-m-d',
        'c_owner' => 'integer',
        'c_group' => 'integer',
        'times_updated' => 'integer'
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'c_title' => 'required',
        'c_description' => 'required',
        'c_thumbnail' => 'nullable',
        'c_status' => 'required',
        'c_date' => 'required',
        'c_incident_date' => 'nullable',
        'c_owner' => 'required',
        'c_group' => 'nullable',
        'c_group' => 'required',
        'times_updated' => 'required'
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
    public function item()
    {
        return $this->belongsToMany(\App\Models\Item::class, 'item');
    }
}
