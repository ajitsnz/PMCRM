<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiOperationFailedException;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Permission;
use App\Models\Task;
use App\Models\User;
use App\Repositories\DepartmentRepository;
use App\Repositories\MemberRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;

class MemberController extends AppBaseController
{
    /**
     * @var MemberRepository
     */
    private $memberRepository;

    /** @var DepartmentRepository $departmentRepo */
    private $departmentRepo;

    /**
     * MemberController constructor.
     *
     * @param  MemberRepository  $memberRepo
     *
     * @param  DepartmentRepository  $departmentRepository
     */
    public function __construct(MemberRepository $memberRepo, DepartmentRepository $departmentRepository)
    {
        $this->memberRepository = $memberRepo;
        $this->departmentRepo = $departmentRepository;
    }

    /**
     * Display a listing of the Member.
     *
     * @throws Exception
     * @return Factory|View
     */
    public function index()
    {
        $departments = $this->departmentRepo->getDepartmentsList();
        $memberStatus = User::STATUS_ARR;

        return view('members.index', compact('departments', 'memberStatus'));
    }

    /**
     * Show the form for creating a new Member.
     *
     * @return Factory|View
     */
    public function create()
    {
        $data = $this->memberRepository->getLanguageList();
        $departments = $this->departmentRepo->getDepartmentsList();
        $permissionsArr = Permission::where('type', '!=', 'Contacts')->get()->groupBy('type');

        return view('members.create', compact('data', 'departments', 'permissionsArr'));
    }

    /**
     * Store a newly created Member in storage.
     *
     * @param  CreateUserRequest  $request
     *
     * @throws ApiOperationFailedException
     *
     * @throws Throwable
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();
        $input['send_welcome_email'] = (isset($input['send_welcome_email']) && ! empty($input['send_welcome_email'])) ? 1 : 0;
        $input['staff_member'] = (isset($input['staff_member']) && ! empty($input['staff_member'])) ? 1 : 0;
        $this->memberRepository->store($input);

        Flash::success('Member saved successfully.');

        return redirect(route('members.index'));
    }

    /**
     * Display the specified Member.
     *
     * @param  User  $member
     *
     * @return Factory|View
     */
    public function show(User $member)
    {
        $groupName = (request('group') === null) ? 'member_details' : request('group');
        $data['groupName'] = $groupName;

        $member = $this->memberRepository->prepareCustomerData($member);
        $memberPermissions = $member->permissions()->get()->groupBy('type');

        $data['status'] = Task::STATUS;
        $data['priorities'] = Task::PRIORITY;

        return view("members.views.$groupName", compact('member', 'memberPermissions'))->with($data);
    }

    /**
     * Show the form for editing the specified Member.
     *
     * @param  int  $id
     *
     * @return Factory|View
     */
    public function edit($id)
    {
        $member = User::with('media')->findOrFail($id);
        $data = $this->memberRepository->getLanguageList();
        $departments = $this->departmentRepo->getDepartmentsList();
        $permissionsArr = Permission::where('type', '!=', 'Contacts')->get()->groupBy('type');
        $memberPermissions = $member->permissions()->pluck('id')->toArray();

        return view('members.edit', compact('member', 'data', 'departments', 'permissionsArr', 'memberPermissions'));
    }

    /**
     * Update the specified Member in storage.
     *
     * @param  UpdateUserRequest  $request
     *
     * @param  User  $member
     *
     * @throws Throwable
     *
     * @return RedirectResponse|Redirector
     */
    public function update(UpdateUserRequest $request, User $member)
    {
        $input = $request->all();
        $input['send_welcome_email'] = (isset($input['send_welcome_email']) && ! empty($input['send_welcome_email'])) ? 1 : 0;
        $input['staff_member'] = (isset($input['staff_member']) && ! empty($input['staff_member'])) ? 1 : 0;
        $this->memberRepository->updateMember($member->id, $input);

        Flash::success('Member updated successfully.');

        return redirect(route('members.index'));
    }

    /**
     * Remove the specified Member from storage.
     *
     * @param  User  $member
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(User $member)
    {
        if ($member->email == Auth::user()->email) {
            return $this->sendError('Login member can\'t deleted.');
        }

        $member->proposal()->delete();
        $member->goals()->detach();
        $member->projects()->delete();
        $member->delete();

        activity()->performedOn($member)->causedBy(getLoggedInUser())
            ->useLog('Member deleted.')->log($member->full_name.' Member deleted.');

        return $this->sendSuccess('Member deleted successfully.');
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function activeDeActiveAdministrator($id)
    {
        $member = User::find($id);
        $member->update(['is_enable' => ! $member->is_enable]);

        return $this->sendSuccess('member updated successfully.');
    }

    /**
     * @param  User  $member
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function resendEmailVerification(User $member)
    {
        $member->sendEmailVerificationNotification();

        return $this->sendSuccess('Verification email has been sent successfully.');
    }
}
