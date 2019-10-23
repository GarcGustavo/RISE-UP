<?php

namespace App\Repositories;

use App\Models\Action_Type;
use App\Repositories\BaseRepository;

/**
 * Class Action_TypeRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:57 pm UTC
*/

class Action_TypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'act_name'
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
        return Action_Type::class;
    }
}
