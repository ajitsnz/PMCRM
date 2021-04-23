<?php

namespace App\Repositories;

use App\Exceptions\ApiOperationFailedException;
use App\Models\Contact;
use App\Models\Role;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Throwable;

/**
 * Class ContactRepository
 * @package App\Repositories
 * @version April 10, 2020, 6:43 am UTC
 */
class ContactRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'position',
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
        return Contact::class;
    }

    /**
     * @param  array  $input
     *
     * @throws Throwable
     *
     * @return bool
     */
    public function store($input)
    {

        try {
            DB::beginTransaction();

            $input['password'] = Hash::make($input['password']);
            $input['phone'] = preparePhoneNumber($input, 'phone');
            $user = User::create(Arr::only($input, (new User())->getFillable()));

            if (isset($input['send_welcome_email']) && ! empty($input['send_welcome_email'])) {
                $user->sendEmailVerificationNotification();
            }

            $roles = Role::whereName('client')->first()->id;

            $user->roles()->sync($roles);

            if (isset($input['primary_contact']) && $input['primary_contact']) {
                Contact::whereCustomerId($input['customer_id'])->update(['primary_contact' => true]);
            }

            $input['send_welcome_email'] = isset($input['send_welcome_email']) ? 1 : 0;
            $input['send_password_email'] = isset($input['send_password_email']) ? 1 : 0;

            if (! empty($input['image']) && $input['image']) {
                $user->addMedia($input['image'])->toMediaCollection(User::COLLECTION_PROFILE_PICTURES,
                    config('app.media_disc'));
            }

            /** @var Contact $contact */
            $contact = Contact::create(Arr::only($input, (new Contact())->getFillable()));

            activity()->performedOn($contact)->causedBy(getLoggedInUser())
                ->useLog('New Contact created.')
                ->log($user->first_name.' Contact created.');

            if (! empty($input['notifications'])) {
                $contact->emailNotifications()->sync($input['notifications']);
            }

            if (! empty($input['permissions'])) {
                $user->permissions()->sync($input['permissions']);
            }

            $user->update(['owner_id' => $contact->id, 'owner_type' => Contact::class]);
            $contact->update(['user_id' => $user->id]);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new ApiOperationFailedException($e->getMessage());
        }
    }

    /**
     * @param  array  $input
     *
     * @param  Contact  $contact
     *
     * @throws Throwable
     *
     * @return bool
     */
    public function update($input, $contact)
    {
        try {
            DB::beginTransaction();

            $user = User::find($contact->user->id);
            $input['phone'] = preparePhoneNumber($input, 'phone');

            $contact->user->update($input);

            $roles = Role::whereName('client')->first()->id;

            $user->roles()->sync($roles);

            if (! empty($input['primary_contact'])) {
                $contact->update(['primary_contact' => true]);
            }

            $input['send_welcome_email'] = isset($input['send_welcome_email']) ? 1 : 0;
            $input['send_password_email'] = isset($input['send_password_email']) ? 1 : 0;

            if (! empty($input['image']) && $input['image']) {
                $user->clearMediaCollection(User::COLLECTION_PROFILE_PICTURES);
                $user->addMedia($input['image'])->toMediaCollection(User::COLLECTION_PROFILE_PICTURES,
                    config('app.media_disc'));
            }

            $contact->update($input);

            activity()->performedOn($contact)->causedBy(getLoggedInUser())
                ->useLog('Contact updated.')
                ->log($user->first_name.' Contact updated.');

            if (! empty($input['notifications'])) {
                $contact->emailNotifications()->sync($input['notifications']);
            }

            if (! empty($input['permissions'])) {
                $user->permissions()->sync($input['permissions']);
            }

            DB::commit();

            return true;

        } catch (Exception $e) {
            DB::rollBack();
            throw new ApiOperationFailedException($e->getMessage());
        }
    }
}
