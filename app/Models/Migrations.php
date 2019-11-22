<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Migrations
 * @package App\Models
 * @version October 23, 2019, 10:49 pm UTC
 *
 * @property string migration
 * @property integer batch
 */
class Migrations extends Model
{
    public $table = 'migrations';

<<<<<<< HEAD
    protected $dates = ['deleted_at'];
=======
    protected $dates = false;
>>>>>>> Gustavo

    public $timestamps = false;

    public $fillable = [
        'migration',
        'batch'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'migration' => 'string',
        'batch' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'migration' => 'required',
        'batch' => 'required'
    ];


}
