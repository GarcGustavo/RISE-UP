<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\BaseRepository;

/**
 * Class PostRepository
 * @package App\Repositories
 * @version October 23, 2019, 10:32 pm UTC
*/

class PostRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
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
        return Post::class;
    }
}
