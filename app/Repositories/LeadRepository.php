<?php

namespace App\Repositories;

use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\LeadStatus;
use App\Models\Note;
use App\Models\Reminder;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class LeadRepository
 * @package App\Repositories
 * @version April 20, 2020, 12:43 pm UTC
 */
class LeadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'position',
        'email',
        'website',
        'phone',
        'company',
        'description',
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
        return Lead::class;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        $data['status'] = LeadStatus::all()->pluck('name', 'id');
        $data['sources'] = LeadSource::all()->pluck('name', 'id');
        $data['assigned'] = User::whereIsEnable(true)->user()->get()->pluck('full_name', 'id');
        $data['countries'] = Lead::COUNTRIES;
        $data['languages'] = Lead::LANGUAGES;
        $data['tags'] = Tag::all()->pluck('name', 'id');

        return $data;
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
        $data['reminderTo'] = User::whereIsEnable(true)->user()->get()->pluck('full_name', 'id');
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
     * @param  array  $input
     *
     * @return bool
     */
    public function store($input)
    {
        $input['public'] = isset($input['public']) ? 1 : 0;

        if (isset($input['contacted_today'])) {
            $input['contacted_today'] = 1;
            $input['date_contacted'] = Carbon::now()->toDateTimeString();
        }

        $input['phone'] = preparePhoneNumber($input, 'phone');
        $input['estimate_budget'] = removeCommaFromNumbers($input['estimate_budget']);
        $lead = Lead::create($input);

        activity()->performedOn($lead)->causedBy(getLoggedInUser())
            ->useLog('New Lead created.')->log($lead->name.' Lead created.');

        if (isset($input['tags']) && ! empty($input['tags'])) {
            $lead->tags()->sync($input['tags']);
        }

        return true;
    }

    /**
     * @param  array  $input
     *
     * @param  Lead  $lead
     *
     * @throws Exception
     *
     * @return bool
     */
    public function update($input, $lead)
    {
        $input['public'] = isset($input['public']) ? 1 : 0;

        if (isset($input['contacted_today']) && empty($lead->date_contacted)) {
            $input['contacted_today'] = 1;
            $input['date_contacted'] = Carbon::now()->toDateTimeString();
        }

        $input['phone'] = preparePhoneNumber($input, 'phone');
        $input['estimate_budget'] = removeCommaFromNumbers($input['estimate_budget']);
        $lead->update($input);

        activity()->performedOn($lead)->causedBy(getLoggedInUser())
            ->useLog('Lead updated.')->log($lead->name.' Lead updated.');

        if (isset($input['tags']) && ! empty($input['tags'])) {
            $lead->tags()->sync($input['tags']);
        }

        return true;
    }

    /**
     * @param $lead
     *
     * @return Builder[]|Collection
     */
    public function getNoteData($lead)
    {
        return Note::with('user.media')->where('owner_id', '=', $lead->id)
            ->where('owner_type', '=', Lead::class)->orderByDesc('created_at')->get();
    }

    /**
     * @return mixed
     */
    public function getLeadStatusCounts()
    {
        $data = LeadStatus::withCount('leads')->get();

        return $data;
    }
}
