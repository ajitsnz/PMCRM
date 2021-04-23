<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Exception;
use Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Redirect;
use View;

class SettingController extends AppBaseController
{
    /** @var  SettingRepository */
    private $settingRepository;

    public function __construct(SettingRepository $settingRepo)
    {
        $this->settingRepository = $settingRepo;
    }

    /**
     * Display the specified Setting.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return View
     */
    public function show(Request $request)
    {
        $groupName = $request->get('group', 'general');
        $settings = $this->settingRepository->getSyncList($groupName);

        return View::make('settings.show', compact('settings', 'groupName'));
    }

    /**
     * Update the specified Setting in storage.
     *
     * @param  UpdateSettingRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function update(UpdateSettingRequest $request)
    {
        if ($request->get('group') == Setting::COMPANY_INFORMATION) {
            $request['phone'] = preparePhoneNumber($request, 'phone');
        }
        $this->settingRepository->updateSetting($request->all());

        Flash::success('Setting updated successfully.');

        return Redirect::back();
    }
}
