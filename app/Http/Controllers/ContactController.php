<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Permission;
use App\Models\User;
use App\Queries\ContactDataTable;
use App\Repositories\ContactRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;
use Yajra\DataTables\DataTables;

class ContactController extends AppBaseController
{
    /** @var  ContactRepository */
    private $contactRepository;

    public function __construct(ContactRepository $contactsRepo)
    {
        $this->contactRepository = $contactsRepo;
    }

    /**
     * Display a listing of the Contacts.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new ContactDataTable())
                ->get($request->only(['customer_id', 'is_enable'])))
                ->make(true);
        }

        return view('contacts.index');
    }

    /**
     * Show the form for creating a new Contacts.
     *
     * @param  null  $customerId
     *
     * @return Factory|View
     */
    public function create($customerId = null)
    {
        $customers = Customer::all()->pluck('company_name', 'id');
        $permissions = Permission::whereType(Contact::TYPE)->pluck('name', 'id')->toArray();

        return view('contacts.create', compact('customers', 'permissions', 'customerId'));
    }

    /**
     * Store a newly created Contacts in storage.
     *
     * @param  CreateContactRequest  $request
     *
     * @throws Throwable
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateContactRequest $request)
    {
        $input = $request->all();

        $this->contactRepository->store($input);

        Flash::success('Contact saved successfully.');

        return redirect($request->get('url'));
    }

    /**
     * Display the specified Contacts.
     *
     * @param  Contact  $contact
     *
     * @return Factory|View
     */
    public function show(Contact $contact)
    {
        $contact->direction = isset($contact->direction) ? Contact::DIRECTIONS[$contact->direction] : null;
        $permissions = Permission::whereType(Contact::TYPE)->pluck('name', 'id')->toArray();
        $contactPermissions = $contact->user->permissions->pluck('id')->toArray();

        return view('contacts.show',
            compact('contact', 'permissions', 'contactPermissions'));
    }

    /**
     * Show the form for editing the specified Contacts.
     *
     * @param  Contact  $contact
     *
     * @return Factory|View
     */
    public function edit(Contact $contact)
    {
        $customers = Customer::all()->pluck('company_name', 'id');
        $permissions = Permission::whereType(Contact::TYPE)->pluck('name', 'id')->toArray();
        $contactPermissions = $contact->user->permissions->pluck('id')->toArray();

        return view('contacts.edit', compact('contact', 'contactPermissions', 'customers', 'permissions'));
    }

    /**
     * Update the specified Contacts in storage.
     *
     * @param  Contact  $contact
     *
     * @param  UpdateContactRequest  $request
     *
     * @throws Throwable
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Contact $contact, UpdateContactRequest $request)
    {
        $this->contactRepository->update($request->all(), $contact);

        Flash::success('Contact updated successfully.');

        return redirect($request->get('url'));
    }

    /**
     * Remove the specified Contacts from storage.
     *
     * @param  Contact  $contact
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Contact $contact)
    {
        if ($contact->email == Auth::user()->email) {
            return $this->sendError('Login contact can\'t deleted.');
        }

        $contact->user()->delete();
        $contact->projectContacts()->detach();

        $contact->delete();

        return $this->sendSuccess('Contact deleted successfully');
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function activeDeActiveContact($id)
    {
        $contact = User::find($id);
        $contact->update(['is_enable' => ! $contact->is_enable]);

        return $this->sendSuccess('contact updated successfully.');
    }
}
