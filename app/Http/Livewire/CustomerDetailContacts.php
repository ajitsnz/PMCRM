<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CustomerDetailContacts extends SearchableComponent
{
    public $paginate = 12;

    public $contactId = '';
    public $contactStatusValue = '';

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $contacts = $this->searchCustomer();

        return view('livewire.customer-detail-contacts', compact('contacts'));
    }

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'deleteContact',
        'contactStatus',
    ];

    /**
     * @param $status
     */
    function contactStatus($status)
    {
        $this->contactStatusValue = $status;
    }

    /**
     * @param $id
     */
    public function deleteContact($id)
    {
        $contact = Contact::find($id);
        if ($contact->email == Auth::user()->email) {
            $this->dispatchBrowserEvent('manageError', 'Login contact can\'t deleted.');
            $this->searchCustomer();
        } else {

            activity()->performedOn($contact)->causedBy(getLoggedInUser())
                ->useLog('Contact deleted.')
                ->log($contact->user->first_name.' Contact deleted.');

            $contact->user()->delete();
            $contact->projectContacts()->detach();

            $contact->delete();
            $this->dispatchBrowserEvent('deleted');
            $this->searchCustomer();
        }
    }

    /**
     * @return LengthAwarePaginator
     */
    public function searchCustomer()
    {
        $this->setQuery($this->getQuery()->with(['customer', 'user.media', 'user.permissions']));

        $this->getQuery()->where(function (Builder $query) {
            $this->filterResults();
        });

        $this->getQuery()->when(! empty($this->contactId != ''), function (Builder $query) {
            $query->where('customer_id', $this->contactId);
        });

        $this->getQuery()->when($this->contactStatusValue != '', function (Builder $q) {
            $q->WhereHas('user', function (Builder $q) {
                $q->where('is_enable', $this->contactStatusValue);
            });
        });

        return $this->paginate();
    }

    /**
     * @return string
     */
    function model()
    {
        return Contact::class;
    }

    /**
     * @return string[]
     */
    function searchableFields()
    {
        return [
            'user.first_name',
            'user.last_name',
            'user.email',
        ];
    }

    /**
     * @return Builder
     */
    public function filterResults()
    {
        $searchableFields = $this->searchableFields();
        $search = $this->search;

        $this->getQuery()->when(! empty($search), function (Builder $q) use ($search, $searchableFields) {
            $this->getQuery()->where(function (Builder $q) use ($search, $searchableFields) {
                $searchString = '%'.$search.'%';
                foreach ($searchableFields as $field) {
                    if (Str::contains($field, '.')) {
                        $field = explode('.', $field);
                        $q->orWhereHas($field[0], function (Builder $query) use ($field, $searchString) {
                            $query->whereRaw("lower($field[1]) like ?", $searchString);
                        });
                    } else {
                        $q->orWhereRaw("lower($field) like ?", $searchString);
                    }
                }
            });

        });

        return $this->getQuery();
    }
}
