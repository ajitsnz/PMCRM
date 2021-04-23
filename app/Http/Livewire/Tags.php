<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Console\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class Tags extends SearchableComponent
{

    public $searchByTag = '';

    public $paginate = 15;

    /**
     * @var string[]
     */
    protected $listeners = [
        'refresh' => '$refresh',
        'deleteTag',
    ];

    /**
     *
     * @return string[]
     */
    function searchableFields()
    {
        return ['name'];
    }

    /**
     *
     * @return string
     */
    function model()
    {
        return Tag::class;
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        $tags = $this->searchTags();

        return view('livewire.tags', compact('tags'));
    }

    /**
     *
     * @return LengthAwarePaginator
     */
    public function searchTags()
    {
        $query = $this->getQuery();

        $query->when(! empty($this->searchByTag != ''), function (Builder $query) {
            $query->where('name', 'like', '%'.strtolower($this->searchByTag).'%');
        });

        return $this->paginate();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * @param $tagId
     *
     */
    public function deleteTag($tagId)
    {
        $tag = Tag::find($tagId);
        activity()->performedOn($tag)->causedBy(getLoggedInUser())
            ->useLog('Tag deleted.')->log($tag->name.' Tag deleted.');
        $tag->delete();
        $this->dispatchBrowserEvent('deleted');
        $this->searchTags();
    }
}
