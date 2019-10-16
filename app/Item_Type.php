<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_Type extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Item_Type';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'riseup';

    public function Item(){

        return $this->belongsTo('App\Item');
    }
}
