<?php

namespace App\Repositories\Clients;

use App\Models\Customer;
use Exception;

/**
 * Class CustomerRepository
 */
class CustomerRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_name',
        'vat_number',
        'phone',
        'website',
        'currency',
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
        return Customer::class;
    }

    /**
     * @param  array  $input
     *
     * @param  Customer  $customer
     *
     * @throws Exception
     *
     * @return bool
     */
    public function update($input, $customer)
    {
        $input['phone'] = preparePhoneNumber($input, 'phone');
        $customer->update($input);

        return true;
    }
}
