<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class action_type
 * @package App\Models
 * @version October 25, 2019, 6:18 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string act_name
 */
class action_type extends Model
{
    use SoftDeletes;

    public $table = 'action_type';
    
<<<<<<< HEAD
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


=======
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    protected $dates = ['deleted_at'];



    public $fillable = [
        'act_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'act_id' => 'integer',
        'act_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'act_name' => 'required'
    ];

    /**
<<<<<<< HEAD
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'action');
=======
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function users()
    {
        return $this->hasMany(\App\Models\User::class, 'action');
>>>>>>> 93c98cde80fa31a70778edd8fe36cbf288ce96a1
    }
}
