<?php

namespace App\Repositories;

use App\Models\Action;
use App\Repositories\BaseRepository;

/**
 * Class ActionRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:57 pm UTC
*/

class ActionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'a_date',
        'a_user',
        'a_type'
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
        return Action::class;
    }
}
