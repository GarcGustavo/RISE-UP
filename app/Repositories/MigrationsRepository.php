<?php

namespace App\Repositories;

use App\Models\Migrations;
use App\Repositories\BaseRepository;

/**
 * Class MigrationsRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:49 pm UTC
*/

class MigrationsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'migration',
        'batch'
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
        return Migrations::class;
    }
}
