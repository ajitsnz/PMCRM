<?php

namespace App\Repositories;

use App\Models\EmailTemplate;

/**
 * Class EmailTemplateRepository
 * @package App\Repositories
 * @version April 24, 2020, 5:40 am UTC
 */
class EmailTemplateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subject',
        'email_message',
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
        return EmailTemplate::class;
    }
}
