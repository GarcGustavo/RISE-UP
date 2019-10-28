<?php

namespace App\Repositories;

use App\Models\Group;
use App\Repositories\BaseRepository;

/**
 * Class GroupRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:58 pm UTC
*/

class GroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'g_name',
        'g_status',
        'g_creation_date',
        'g_owner'
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
        return Group::class;
    }
}
