<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\CustomerGroup;
use App\Models\CustomerToCustomerGroup;
use App\Models\Lead;
use App\Models\Note;
use App\Models\Permission;
use App\Models\Reminder;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

/**
 * Class CustomerRepository
 * @package App\Repositories
 * @version April 3, 2020, 6:37 am UTC
 */
class CustomerRepository extends BaseRepository
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
     * @return array
     */
    public function getSyncList()
    {
        $data = [];
        $data['customerGroups'] = CustomerGroup::all()->pluck('name', 'id');
        $data['currencies'] = Customer::CURRENCIES;
        $data['languages'] = Customer::LANGUAGES;
        $data['countries'] = Customer::COUNTRIES;

        return $data;
    }

    /**
     * @param  array  $input
     *
     * @return bool|Model
     */
    public function create($input)
    {
        $addressInputArray = Arr::only($input, ['street', 'city', 'state', 'zip', 'country']);
        $addressArray = Address::prepareInputForAddress($addressInputArray);
        $input['phone'] = preparePhoneNumber($input, 'phone');
        $customer = Customer::create(Arr::only(array_merge($input, $addressArray[0]), (new Customer())->getFillable()));

        activity()->performedOn($customer)->causedBy(getLoggedInUser())
            ->useLog('New Customer created.')->log($customer->company_name.' Customer created.');

        if (isset($input['groups']) && ! empty(array_filter($input['groups']))) {
            foreach ($input['groups'] as $group) {
                CustomerToCustomerGroup::create([
                    'customer_id'       => $customer->id,
                    'customer_group_id' => $group,
                ]);
            }
        }

        $isBillingAddressEmpty = Address::containsOnlyNull($addressArray[1]);
        $isShippingAddressEmpty = Address::containsOnlyNull($addressArray[2]);

        if (! $isBillingAddressEmpty) {
            self::createAddress($customer->id, $addressArray[1], Address::ADDRESS_TYPES[1]);
        }

        if (! $isShippingAddressEmpty) {
            self::createAddress($customer->id, $addressArray[2], Address::ADDRESS_TYPES[2]);
        }

        return true;
    }

    /**
     * @param  Customer  $customer
     *
     * @param  bool  $isEdit
     *
     * @return array
     */
    public function prepareAddress($customer, $isEdit = false)
    {
        $query = Address::whereOwnerType(Customer::class)->whereOwnerId($customer->id)->get();
        $billingAddress = $query->where('type', '=', Address::ADDRESS_TYPES[1])->first();

        if ($billingAddress != null && ! $isEdit) {
            $billingAddress->country = $billingAddress->country != null ? Customer::COUNTRIES[$billingAddress->country] : null;
        }

        $shippingAddress = $query->where('type', '=', Address::ADDRESS_TYPES[2])->first();

        if ($shippingAddress != null && ! $isEdit) {
            $shippingAddress->country = $shippingAddress->country != null ? Customer::COUNTRIES[$shippingAddress->country] : null;
        }

        return [$billingAddress, $shippingAddress];
    }

    /**
     * @param  Customer  $customer
     *
     * @return Customer
     */
    public function prepareCustomerData($customer)
    {
        $customer->currency = $customer->currency != null ? Customer::CURRENCIES[$customer->currency] : null;
        $customer->default_language = $customer->default_language != null ? Customer::LANGUAGES[$customer->default_language] : null;
        $customer->country = $customer->country != null ? Customer::COUNTRIES[$customer->country] : null;

        return $customer;
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
        $addressInputArray = Arr::only($input, ['street', 'city', 'state', 'zip', 'country']);
        $addressArray = Address::prepareInputForAddress($addressInputArray);
        $input['phone'] = preparePhoneNumber($input, 'phone');
        $customer->update(array_merge($input, $addressArray[0]));

        activity()->performedOn($customer)->causedBy(getLoggedInUser())
            ->useLog('Customer updated.')->log($customer->company_name.' Customer updated.');

        if (! empty($input['groups'])) {
            $customer->customerGroups()->sync($input['groups']);
        }

        $isBillingAddressEmpty = Address::containsOnlyNull($addressArray[1]);
        $isShippingAddressEmpty = Address::containsOnlyNull($addressArray[2]);

        if (! empty($customer->billingAddress())) {
            $billingAddress = $isBillingAddressEmpty ?
                $customer->billingAddress()->delete() : $customer->billingAddress()->update($addressArray[1]);
        } else {
            if (! $isBillingAddressEmpty) {
                self::createAddress($customer->id, $addressArray[1], Address::ADDRESS_TYPES[1]);
            }
        }

        if (! empty($customer->shippingAddress())) {
            $shippingAddress = $isShippingAddressEmpty ?
                $customer->shippingAddress()->delete() : $customer->shippingAddress()->update($addressArray[2]);
        } else {
            if (! $isShippingAddressEmpty) {
                self::createAddress($customer->id, $addressArray[2], Address::ADDRESS_TYPES[2]);
            }
        }

        return true;
    }

    /**
     * @param  int  $customerId
     *
     * @param  array  $address
     *
     * @param $addressType
     *
     * @return bool
     */
    public function createAddress($customerId, $address, $addressType)
    {
        $ownerId = $customerId;
        $ownerType = Customer::class;
        Address::create(array_merge($address,
            ['owner_id' => $ownerId, 'owner_type' => $ownerType, 'type' => $addressType]));

        return true;
    }

    /**
     *
     * @return int
     */
    public function customerCount()
    {
        return Customer::selectRaw('count(*) as total_customers')->first();
    }

    /**
     * @param  int  $id
     *
     * @param  string  $class
     *
     * @return array
     */
    public function getReminderData($id, $class)
    {
        $data = [];
        $data['reminderTo'] = Contact::whereCustomerId($id)->with('user')->get()->where('user.is_enable', '=',
            true)->pluck('user.full_name', 'id');
        $data['ownerId'] = $id;

        foreach (Reminder::REMINDER_MODULES as $key => $value) {
            if ($value == $class) {
                $data['moduleId'] = $key;
                break;
            }
        }

        return $data;
    }

    /**
     * @param $customer
     *
     * @return mixed
     */
    public function getNoteData($customer)
    {
        return Note::with('user.media')->where('owner_id', '=', $customer->id)
            ->where('owner_type', '=', Customer::class)->orderByDesc('created_at')->get();
    }

    /**
     * @param $searchData
     *
     * @return mixed
     */
    public function searchCustomerData($searchData)
    {
        return Customer::where('company_name', 'LIKE', '%'.$searchData.'%')->get();
    }

    /**
     * @param $input
     *
     */
    public function addCustomerAddress($input)
    {
        $addressInputArray = Arr::only($input, ['street', 'city', 'state', 'zip', 'country']);
        $addressArray = Address::prepareInputForAddress($addressInputArray);
        $isBillingAddressEmpty = Address::containsOnlyNull($addressArray[1]);
        $isShippingAddressEmpty = Address::containsOnlyNull($addressArray[2]);
        $ownerId = $input['customer_id'];
        
        if (! $isBillingAddressEmpty) {
            $this->createAddress($ownerId, $addressArray[1], Address::ADDRESS_TYPES[1]);
        }

        if (! $isShippingAddressEmpty) {
            $this->createAddress($ownerId, $addressArray[2], Address::ADDRESS_TYPES[2]);
        }
        
        return true;
    }

    /**
     * @param $input
     *
     * @return bool
     */
    public function leadConvertToCustomer($input)
    {
        $leadConvertCustomerUpdate = Lead::whereId($input['lead_id'])->update([
            'lead_convert_customer' => true, 'lead_convert_date' => Carbon::now()->format('Y-m-d'),
        ]);
        $customer = Customer::create($input);
        $input['password'] = Hash::make($input['password']);
        
        if (isset($input['groups']) && ! empty(array_filter($input['groups']))) {
            foreach ($input['groups'] as $group) {
                CustomerToCustomerGroup::create([
                    'customer_id'       => $customer->id,
                    'customer_group_id' => $group,
                ]);
            }
        }

        /* @var  User $user */
        $user = User::create([
            'first_name' => $input['company_name'],
            'email'      => $input['email'],
            'password'   => $input['password'],
        ]);
        
        $roles = Role::whereName('client')->first()->id;
        $user->roles()->sync($roles);


        /** @var Contact $contact */
        $contact = Contact::create([
            'customer_id' => $customer->id,
            'user_id' => $user->id,
            ]);

        Contact::whereCustomerId($customer->id)->update(['primary_contact' => true]);
        
        $permissions = Permission::whereType('Contacts')->get();
        $user->permissions()->sync($permissions);        

        $user->update(['owner_id' => $contact->id, 'owner_type' => Contact::class]);
        $contact->update(['user_id' => $user->id]);
        
        return true;
    }
}
