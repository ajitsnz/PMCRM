<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\UserRepository;
use Exception;
use Flash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;

/**
 * Class UserController
 */
class UserController extends AppBaseController
{
    /** @var  UserRepository $userRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * @param  ChangePasswordRequest  $request
     *
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $input = $request->all();

        try {
            $this->userRepository->changePassword($input);

            return $this->sendSuccess('Password updated successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }

    /**
     * @return mixed
     */
    public function editProfile()
    {
        try {
            $user = Auth::user();

            return view('user_profile.edit', compact('user'));
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * @param  UpdateUserProfileRequest  $request
     *
     * @return RedirectResponse|Redirect
     */
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        try {
            $user = Auth::user();
            if (empty($user)) {
                Flash::error('User not found');

                return redirect(route('members.index'));
            }

            $input = $request->all();
            $this->userRepository->profileUpdate($input);

            Flash::success('Profile updated successfully.');

            if (Auth::user()->hasRole(['client'])) {
                return Redirect::to(RouteServiceProvider::CLIENT_HOME);
            } else {
                return Redirect::to(RouteServiceProvider::ADMIN_HOME);
            }
        } catch (Exception $e) {
            return Redirect::back()->withErrors([$e->getMessage()])->withInput($request->all());
        }
    }

    /**
     * @param  Request  $request
     *
     * @return mixed
     */
    public function changeLanguage(Request $request)
    {
        $defaultLanguage = $request->get('default_language');

        try {
            $user = Auth::user();
            $user->update(['default_language' => $defaultLanguage]);

            return $this->sendSuccess('Language updated successfully.');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }
}
