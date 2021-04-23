<?php

namespace App\Repositories;

use App\Models\TaxRate;

/**
 * Class TaxRateRepository
 * @package App\Repositories
 * @version April 6, 2020, 6:48 am UTC
*/

class TaxRateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'tax_rate'
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
        return TaxRate::class;
    }
}
