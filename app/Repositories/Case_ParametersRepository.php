<?php

namespace App\Repositories;

use App\Models\Case_Parameters;
use App\Repositories\BaseRepository;

/**
 * Class Case_ParametersRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:57 pm UTC
*/

class Case_ParametersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'opt_selected',
        'csp_id'
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
        return Case_Parameters::class;
    }
}
