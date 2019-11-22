<?php

namespace App\Repositories;

use App\Models\Item_Type;
use App\Repositories\BaseRepository;

/**
 * Class Item_TypeRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:59 pm UTC
*/

class Item_TypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'itt_name'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Item_Type::class;
    }
}
