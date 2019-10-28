<?php

namespace App\Repositories;

use App\Models\User_Groups;
use App\Repositories\BaseRepository;

/**
 * Class User_GroupsRepository
 * @package App\Repositories
 * @version October 23, 2019, 11:00 pm UTC
*/

class User_GroupsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'uid'
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
        return User_Groups::class;
    }
}
