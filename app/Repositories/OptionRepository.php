<?php

namespace App\Repositories;

use App\Models\Option;
use App\Repositories\BaseRepository;

/**
 * Class OptionRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:59 pm UTC
*/

class OptionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'o_content',
        'o_parameter'
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
        return Option::class;
    }
}
