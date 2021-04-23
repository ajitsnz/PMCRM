<?php

namespace App\Repositories;

use App\Exceptions\ApiOperationFailedException;
use App\Models\Role;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Support\Facades\Hash;
use Throwable;

/**
 * Class CustomerGroupRepository
 */
class MemberRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'image',
        'language_id',
    ];

    /**
     * @return array
     */
    public function getLanguageList()
    {
        $data = [];
        $data['languages'] = User::LANGUAGES;

        return $data;
    }

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
        return User::class;
    }

    /**
     * @param  User  $member
     *
     * @return User
     */
    public function prepareCustomerData($member)
    {
        $member->default_language = $member->default_language != null ? User::LANGUAGES[$member->default_language] : null;

        return $member;
    }

    /**
     * @param  array  $input
     *
     * @throws ApiOperationFailedException
     *
     * @throws Exception
     *
     * @throws Throwable
     *
     * @return mixed
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();
            $input['password'] = Hash::make($input['password']);
            $input['phone'] = preparePhoneNumber($input, 'phone');
            $member = User::create($input);

            activity()->performedOn($member)->causedBy(getLoggedInUser())
                ->useLog('New Member created.')->log($member->full_name.' Member created.');

            if (isset($input['send_welcome_email']) && ! empty($input['send_welcome_email'])) {
                $member->sendEmailVerificationNotification();
            }

            if ((isset($input['image']))) {
                $member->addMedia($input['image'])
                    ->toMediaCollection(User::COLLECTION_PROFILE_PICTURES, config('app.media_disc'));
            }

            $roles = Role::whereName('staff_member')->first()->id;
            $member->roles()->sync($roles);

            if (isset($input['permissions']) && $input['permissions']) {
                $member->permissions()->sync($input['permissions']);
            }

            DB::commit();

            return $member;
        } catch (Exception $e) {
            DB::rollBack();
            throw new ApiOperationFailedException($e->getMessage());
        }
    }

    /**
     * @param  int  $userId
     *
     * @param  array  $input
     *
     * @throws Throwable
     *
     * @return bool
     */
    public function updateMember($userId, $input)
    {
        $input['phone'] = preparePhoneNumber($input, 'phone');

        /** @var User $member */
        $member = User::find($userId);

        $this->update($input, $userId);

        activity()->performedOn($member)->causedBy(getLoggedInUser())
            ->useLog('Member updated.')->log($member->full_name.' Member updated.');

        $roles = Role::whereName('staff_member')->first()->id;
        $member->roles()->sync($roles);

        if (isset($input['permissions']) && $input['permissions']) {
            $member->permissions()->sync($input['permissions']);
        }

        if ((isset($input['image']))) {
            $member->clearMediaCollection(User::COLLECTION_PROFILE_PICTURES);
            $member->addMedia($input['image'])
                ->toMediaCollection(User::COLLECTION_PROFILE_PICTURES, config('app.media_disc'));
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function memberCount()
    {
        return User::selectRaw('count(case when is_enable = 1 then 1 end) as active_members')
            ->selectRaw('count(case when is_enable = 0 then 1 end) as deactive_members')
            ->selectRaw('count(*) as total_members')
            ->where('owner_id', '=', null)->where('owner_type', '=', null)->first();
    }
}
