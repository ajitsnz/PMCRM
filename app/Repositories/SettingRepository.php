<?php

namespace App\Repositories;

use App\Models\Setting;
use Arr;

/**
 * Class SettingRepository
 * @package App\Repositories
 * @version April 23, 2020, 1:45 pm UTC
 */
class SettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_main_domain',
        'company_name',
        'note',
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
        return Setting::class;
    }

    /**
     * @param  string  $groupName
     *
     * @return array
     */
    public function getSyncList($groupName)
    {
        return Setting::whereGroup(Setting::GROUP_ARRAY[$groupName])->pluck('value', 'key')->toArray();
    }

    /**
     * @param  array  $input
     *
     * @return bool
     */
    public function updateSetting($input)
    {
        $inputArr = Arr::except($input, ['_token']);

        foreach ($inputArr as $key => $value) {

            /** @var Setting $setting */
            $setting = Setting::where('key', $key)->first();

            if (! $setting) {
                continue;
            }

            if (in_array($key, ['logo', 'favicon']) && ! empty($value)) {
                $this->fileUpload($setting, $value);
                continue;
            }

            $setting->update(['value' => $value]);
        }

        return true;
    }

    /**
     * @param  Setting  $setting
     *
     * @param $file
     *
     * @return Setting
     */
    public function fileUpload($setting, $file)
    {
        $setting->clearMediaCollection(Setting::PATH);
        $media = $setting->addMedia($file)->toMediaCollection(Setting::PATH, config('app.media_disc'));

        $setting->update(['value' => $media->getFullUrl()]);

        return $setting;
    }
}
