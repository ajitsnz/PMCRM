<?php

namespace App\Repositories;

use App\Models\PaymentMode;

/**
 * Class PaymentModeRepository
 * @package App\Repositories
 * @version April 6, 2020, 9:55 am UTC
*/

class PaymentModeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'active',
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
        return PaymentMode::class;
    }
}
