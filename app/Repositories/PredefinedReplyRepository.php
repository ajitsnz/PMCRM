<?php

namespace App\Repositories;

use App\Models\PredefinedReply;

/**
 * Class PredefinedReplyRepository
 * @package App\Repositories
 * @version April 3, 2020, 4:54 am UTC
*/

class PredefinedReplyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'reply_name',
        'body'
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
        return PredefinedReply::class;
    }
}
