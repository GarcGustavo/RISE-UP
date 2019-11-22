<?php

namespace App\Repositories;

use App\Models\Case;
use App\Repositories\BaseRepository;

/**
 * Class CaseRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:57 pm UTC
*/

class CaseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'c_title',
        'c_description',
        'c_thumbnail',
        'c_status',
        'c_date',
        'c_owner',
        'c_group'
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
        return Case::class;
    }
}
