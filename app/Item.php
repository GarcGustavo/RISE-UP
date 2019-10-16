<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Item';

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

    public function Item_type(){

        return $this->hasMany('App\Item_Type','i_type');
    }
}

