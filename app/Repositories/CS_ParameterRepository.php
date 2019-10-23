<?php

namespace App\Repositories;

use App\Models\CS_Parameter;
use App\Repositories\BaseRepository;

/**
 * Class CS_ParameterRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:58 pm UTC
*/

class CS_ParameterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'csp_name'
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
        return CS_Parameter::class;
    }
}
