<?php

namespace App\Http\Livewire;

use App\Models\PredefinedReply;
use Illuminate\Database\Eloquent\Builder;

class PredefinedReplies extends SearchableComponent
{
    public $search = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'deletePredefinedReply',
    ];

    /**
     *
     * @return string[]
     */
    function searchableFields()
    {
        return ['reply_name'];
    }

    /**
     *
     * @return string
     */
    public function model()
    {
        return PredefinedReply::class;
    }

    public function render()
    {
        $predefinedReplies = $this->search();

        return view('livewire.predefined-replies', compact('predefinedReplies'));
    }

    public function search()
    {
        $query = $this->getQuery();

        $query->when(! empty($this->search != ''), function (Builder $q) {
            $q->where('reply_name', 'like', '%'.strtolower($this->search).'%');
        });

        return $this->paginate();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * @param  int  $predefinedReplyId
     */
    public function deletePredefinedReply($predefinedReplyId)
    {
        $predefinedReply = PredefinedReply::find($predefinedReplyId);
        activity()->performedOn($predefinedReply)->causedBy(getLoggedInUser())
            ->useLog('Predefined Reply deleted.')->log($predefinedReply->name.' Predefined Reply deleted.');
        $predefinedReply->delete();
        $this->dispatchBrowserEvent('deleted');
        $this->search();
    }
}
